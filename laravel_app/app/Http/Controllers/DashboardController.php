<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        $usersCount = \App\Models\User::count();
        $pendingProducts = \App\Models\Product::with('farmer')->where('status', 'pending')->get();
        $todaySales = \App\Models\Order::whereDate('created_at', \Carbon\Carbon::today())->sum('total_amount');
        
        return view('admin.dashboard', compact('usersCount', 'pendingProducts', 'todaySales'));
    }

    public function buyer()
    {
        $products = \App\Models\Product::all();
        $cartCount = \App\Models\Cart::where('buyer_id', \Illuminate\Support\Facades\Auth::id())->sum('quantity');
        
        return view('buyer.dashboard', compact('products', 'cartCount'));
    }

    public function farmer()
    {
        $farmerId = \Illuminate\Support\Facades\Auth::id();
        $products = \App\Models\Product::where('farmer_id', $farmerId)->get();
        $todaySales = 0; // Placeholder for actual sales logic
        
        $experts = \App\Models\User::where('role', 'expert')->get();
        $pastQuestions = \App\Models\AdviceRequest::with('expert')->where('farmer_id', $farmerId)->orderBy('created_at', 'desc')->get();
        
        return view('farmer.dashboard', compact('products', 'todaySales', 'experts', 'pastQuestions'));
    }

    public function expert()
    {
        $pendingRequests = \App\Models\AdviceRequest::with('farmer')->where('status', 'pending')->get();
        return view('expert.dashboard', compact('pendingRequests'));
    }
}
