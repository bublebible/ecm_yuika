<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        MidtransConfig::$serverKey    = config('midtrans.server_key');
        MidtransConfig::$isProduction = config('midtrans.is_production');
        MidtransConfig::$isSanitized  = config('midtrans.is_sanitized');
        MidtransConfig::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Generate Midtrans Snap token for a rental.
     * Only allowed when rental is approved & unpaid.
     */
    public function createSnap(Rental $rental)
    {
        // Authorization: must own the rental
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        // Guard: only approved rentals can be paid
        if ($rental->status !== 'approved') {
            return back()->with('error', 'Pembayaran hanya bisa dilakukan untuk sewa yang sudah disetujui.');
        }

        // Guard: already paid
        if ($rental->payment_status === 'paid') {
            return back()->with('error', 'Pesanan ini sudah dibayar.');
        }

        // Generate unique order ID per attempt (reuse if snap_token still valid)
        $orderId = $rental->midtrans_order_id ?? 'ECM-' . $rental->id . '-' . time();

        $user = Auth::user();

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $rental->total_price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
                'phone'      => $user->phone ?? '',
            ],
            'item_details' => $rental->items->map(function ($item) use ($rental) {
                // Calculate the total daily cost for all items in the rental
                $totalDailyCost = $rental->items->sum(function ($i) {
                    return $i->qty * ($i->asset->price_per_day ?? 0);
                });

                // Derive the number of days from total_price to support both historic and new orders correctly
                $days = $totalDailyCost > 0 
                    ? (int) round($rental->total_price / $totalDailyCost)
                    : ($rental->start_date->diffInDays($rental->end_date) + 1);

                if ($days <= 0) {
                    $days = 1;
                }

                $price = $item->asset->price_per_day ?? 0;
                return [
                    'id'       => 'ITEM-' . $item->asset_id,
                    'price'    => (int) ($price * $days),
                    'quantity' => $item->qty,
                    'name'     => ($item->asset->name ?? 'Kostum #' . $item->asset_id) . ' (' . $days . ' hari)',
                ];
            })->toArray(),
            'callbacks' => [
                'finish' => route('payment.finish'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // Save token & order ID to rental
            $rental->update([
                'snap_token'        => $snapToken,
                'midtrans_order_id' => $orderId,
                'payment_status'    => 'pending',
            ]);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id'   => $orderId,
            ]);

        } catch (\Exception $e) {
            Log::error('Midtrans Snap Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menghubungi payment gateway. Coba lagi.'], 500);
        }
    }

    /**
     * Handle Midtrans webhook / payment notification.
     * This endpoint must be registered in Midtrans dashboard.
     * No auth middleware — Midtrans server calls this directly.
     */
    public function notification(Request $request)
    {
        try {
            $notif       = new Notification();
            $orderId     = $notif->order_id;
            $statusCode  = $notif->status_code;
            $grossAmount = $notif->gross_amount;

            // Verify signature
            $serverKey    = config('midtrans.server_key');
            $signature    = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
            $signatureKey = $notif->signature_key ?? '';

            if ($signature !== $signatureKey) {
                Log::warning('Midtrans: Invalid signature for order ' . $orderId);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $rental = Rental::where('midtrans_order_id', $orderId)->first();

            if (!$rental) {
                return response()->json(['message' => 'Rental not found'], 404);
            }

            $transactionStatus = $notif->transaction_status;
            $paymentType       = $notif->payment_type;
            $fraudStatus       = $notif->fraud_status ?? null;

            // Determine payment status
            if ($transactionStatus === 'capture') {
                $paymentStatus = ($fraudStatus === 'accept') ? 'paid' : 'failed';
            } elseif ($transactionStatus === 'settlement') {
                $paymentStatus = 'paid';
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                $paymentStatus = 'failed';
            } elseif ($transactionStatus === 'pending') {
                $paymentStatus = 'pending';
            } else {
                $paymentStatus = 'failed';
            }

            $updateData = ['payment_status' => $paymentStatus];
            if ($paymentStatus === 'paid') {
                $updateData['paid_at'] = now();
            }

            $rental->update($updateData);

            Log::info("Midtrans: Order {$orderId} → {$paymentStatus}");
            return response()->json(['message' => 'OK']);

        } catch (\Exception $e) {
            Log::error('Midtrans notification error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    /**
     * Landing page after payment (redirect from Snap).
     */
    public function finish(Request $request)
    {
        return redirect()->route('user.history.index')
            ->with('success', 'Pembayaran berhasil diproses! Status akan diperbarui dalam beberapa saat.');
    }

    /**
     * User cancel the rental (only when pending or approved & unpaid).
     */
    public function cancel(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        // Only cancel if not yet active/completed
        if (!in_array($rental->status, ['pending', 'approved'])) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan pada status saat ini.');
        }

        if ($rental->payment_status === 'paid') {
            return back()->with('error', 'Pesanan yang sudah dibayar tidak dapat dibatalkan langsung. Hubungi admin.');
        }

        // Restore stock
        foreach ($rental->items as $item) {
            if ($item->asset) {
                $item->asset->increment('stock_qty', $item->qty);
            }
        }

        $rental->update([
            'status'         => 'cancelled',
            'payment_status' => 'cancelled',
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan. Stok kostum telah dikembalikan.');
    }

    /**
     * Update payment status directly from frontend success callback (useful for local development without ngrok).
     * Only allowed in sandbox/non-production mode.
     */
    public function successLocal(Rental $rental)
    {
        if (config('midtrans.is_production')) {
            return response()->json(['error' => 'Not allowed in production mode.'], 403);
        }

        if ($rental->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $rental->update([
            'payment_status' => 'paid',
            'paid_at'        => now(),
        ]);

        return response()->json(['message' => 'Status pembayaran berhasil diperbarui secara lokal!']);
    }
}
