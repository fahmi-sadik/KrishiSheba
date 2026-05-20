<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('buyer_id', Auth::id())->get();
        $cartCount = $cartItems->sum('quantity');
        $totalPrice = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        return view('buyer.cart', compact('cartItems', 'cartCount', 'totalPrice'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'price' => 'required|numeric',
            'image_url' => 'nullable|string',
        ]);

        $buyerId = Auth::id();

        $cartItem = Cart::where('buyer_id', $buyerId)
                        ->where('product_name', $request->product_name)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'buyer_id' => $buyerId,
                'product_name' => $request->product_name,
                'price' => $request->price,
                'quantity' => 1,
                'image_url' => $request->image_url,
            ]);
        }

        return back()->with('success', "{$request->product_name} সফলভাবে কার্টে যোগ করা হয়েছে!");
    }
    
    public function update(Request $request, $id)
    {
        $cartItem = Cart::where('id', $id)->where('buyer_id', Auth::id())->firstOrFail();
        
        if ($request->action === 'increase') {
            $cartItem->increment('quantity');
        } elseif ($request->action === 'decrease' && $cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        }

        return back();
    }
    
    public function remove($id)
    {
        Cart::where('id', $id)->where('buyer_id', Auth::id())->delete();
        return back()->with('success', 'পণ্যটি কার্ট থেকে সরানো হয়েছে।');
    }
}
