<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Rental;
use App\Models\RentalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['items.asset', 'documents'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.rentals.index', compact('rentals'));
    }

    public function create(Request $request)
    {
        $asset = null;
        if ($request->has('asset_id')) {
            $asset = Asset::find($request->asset_id);
        }
        return view('user.rentals.create', compact('asset'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'qty' => 'required|integer|min:1',
        ]);

        $asset = Asset::find($request->asset_id);
        
        // Simple stock check (naive)
        if ($asset->stock_qty < $request->qty) {
            return back()->withErrors(['qty' => 'Stok tidak mencukupi via online.']);
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $days = $startDate->diffInDays($endDate) + 1; // Minimum 1 day
        $totalPrice = $asset->price_per_day * $days * $request->qty;

        $rental = Rental::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice,
        ]);

        RentalItem::create([
            'rental_id' => $rental->id,
            'asset_id' => $asset->id,
            'qty' => $request->qty,
        ]);

        return redirect()->route('user.rentals.index')->with('success', 'Permintaan sewa berhasil dibuat. Silakan upload identitas.');
    }

    public function edit(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }
        return view('user.rentals.edit', compact('rental'));
    }

    public function update(Request $request, Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        if ($request->hasFile('identity_card')) {
            $request->validate(['identity_card' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048']);
            $path = $request->file('identity_card')->store('documents', 'public');
            
            $rental->documents()->create([
                'type' => 'identity_card',
                'file_path' => $path,
                'status' => 'pending',
            ]);
            
            return back()->with('success', 'Identitas berhasil diupload, menunggu validasi admin.');
        }

        if ($request->hasFile('return_proof')) {
            $request->validate(['return_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048']);
            $path = $request->file('return_proof')->store('documents', 'public');
            
            $rental->documents()->create([
                'type' => 'return_proof',
                'file_path' => $path,
                'status' => 'pending',
            ]);

            $rental->update(['status' => 'returned']); // Or 'return_pending'
            
            return back()->with('success', 'Bukti retur berhasil diupload.');
        }

        return back()->with('error', 'Tidak ada file yang diupload.');
    }

    public function downloadContract(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }
        if (!in_array($rental->status, ['approved', 'active', 'returned', 'completed'])) {
            abort(404);
        }
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdfs.contract', compact('rental'));
        return $pdf->download('contract-'.$rental->id.'.pdf');
    }
    public function returnItem(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }
        
        if ($rental->status !== 'active') {
            return back()->with('error', 'Hanya rental aktif yang bisa dikembalikan.');
        }

        $rental->update(['status' => 'returned']);
        
        return back()->with('success', 'Berhasil melakukan pengembalian. Menunggu verifikasi admin.');
    }
}
