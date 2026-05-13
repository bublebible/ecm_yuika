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
        $cart = Session::get('cart');
        
        if(!$cart || count($cart) == 0) {
            return redirect()->route('user.cart.index')->with('error', 'Cart is empty');
        }

        // Logic to create rental from cart
        // For simplicity, we create one rental per item or group them. 
        // Current DB structure might favor one rental per transaction.
        
        DB::beginTransaction();
        try {
            $rental = new Rental();
            $rental->user_id = Auth::id();
            // Default dates for now (User should pick in cart, but let's assume +3 days)
            $rental->start_date = now(); 
            $rental->end_date = now()->addDays(3);
            $rental->status = 'pending';
            
            $totalPrice = 0;
            foreach($cart as $id => $details) {
                $totalPrice += $details['price'] * $details['quantity'] * 3; // 3 days default
            }
            $rental->total_price = $totalPrice;
            $rental->save();

            foreach($cart as $id => $details) {
                RentalItem::create([
                    'rental_id' => $rental->id,
                    'asset_id' => $id,
                    'qty' => $details['quantity'],
                    'price_per_day' => $details['price'],
                    'days' => 3 
                ]);
            }

            DB::commit();
            Session::forget('cart');
            return redirect()->route('user.rentals.index')->with('success', 'Order placed successfully!');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error processing checkout: ' . $e->getMessage());
        }
    }
}
