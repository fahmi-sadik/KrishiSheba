<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $buyerId = Auth::id();
        $cartItems = Cart::where('buyer_id', $buyerId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'আপনার কার্ট খালি!');
        }

        $totalPrice = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        $deliveryFee = 50;
        $totalAmount = $totalPrice + $deliveryFee;

        DB::transaction(function () use ($buyerId, $cartItems, $totalAmount) {
            $order = Order::create([
                'buyer_id' => $buyerId,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $item->product_name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'image_url' => $item->image_url,
                ]);
            }

            Cart::where('buyer_id', $buyerId)->delete();
        });

        return redirect()->route('buyer.order.success');
    }

    public function success()
    {
        return view('buyer.order_success');
    }
}
