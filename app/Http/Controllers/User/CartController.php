<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Rental;
use App\Models\RentalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('user.cart.index', compact('cart'));
    }

    public function addToCart(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);
        $cart = Session::get('cart', []);

        if(isset($cart[$id])) {
            if($cart[$id]['quantity'] + 1 > $asset->stock_qty) {
                return redirect()->back()->with('error', 'Cannot add more items than available in stock ('. $asset->stock_qty . ' available).');
            }
            $cart[$id]['quantity']++;
        } else {
            if(1 > $asset->stock_qty) {
                return redirect()->back()->with('error', 'This item is currently out of stock.');
            }
            $cart[$id] = [
                "name" => $asset->name,
                "quantity" => 1,
                "price" => $asset->price_per_day,
                "image" => $asset->main_image_path,
                "duration" => 3 // Default duration
            ];
        }

        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $asset = Asset::find($request->id);
            if($asset && $request->quantity > $asset->stock_qty) {
                session()->flash('error', 'Cannot update quantity beyond available stock ('. $asset->stock_qty . ' available).');
                return;
            }
            
            $cart = Session::get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            Session::put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = Session::get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                Session::put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
    
    public function checkout(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isKtpVerified()) {
            return redirect()->route('user.cart.index')->with('error', 'Anda harus memverifikasi KTP terlebih dahulu di halaman profil sebelum melakukan pemesanan.');
        }

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $cart = Session::get('cart');

        if (!is_array($cart) || count($cart) == 0) {
            return redirect()->route('user.cart.index')->with('error', 'Keranjang kosong.');
        }

        // Calculate duration
        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate   = \Carbon\Carbon::parse($request->end_date);
        $days      = $startDate->diffInDays($endDate) + 1; // inclusive

        // Validate stock availability for all items first
        foreach ($cart as $id => $details) {
            $asset = Asset::find($id);
            if (!$asset) {
                return redirect()->route('user.cart.index')->with('error', 'Item tidak ditemukan.');
            }
            if ($asset->stock_qty < $details['quantity']) {
                return redirect()->route('user.cart.index')->with('error',
                    'Stok ' . $asset->name . ' tidak mencukupi (' . $asset->stock_qty . ' tersedia).'
                );
            }
        }

        DB::beginTransaction();
        try {
            $totalPrice = 0;
            foreach ($cart as $id => $details) {
                $totalPrice += $details['price'] * $details['quantity'] * $days;
            }

            $rental = Rental::create([
                'user_id'     => Auth::id(),
                'status'      => 'pending',
                'start_date'  => $startDate,
                'end_date'    => $endDate,
                'total_price' => $totalPrice,
            ]);

            foreach ($cart as $id => $details) {
                $asset = Asset::find($id);
                $asset->decrement('stock_qty', $details['quantity']);

                RentalItem::create([
                    'rental_id'    => $rental->id,
                    'asset_id'     => $id,
                    'qty'          => $details['quantity'],
                    'price_per_day' => $details['price'],
                    'days'         => $days,
                ]);
            }

            DB::commit();
            Session::forget('cart');
            return redirect()->route('user.rentals.index')
                ->with('success', 'Pesanan berhasil dibuat! Silakan upload KTP untuk konfirmasi.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal checkout: ' . $e->getMessage());
        }
    }
}
