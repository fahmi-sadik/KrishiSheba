<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    public function users()
    {
        $users = \App\Models\User::all();
        return view('admin.users', compact('users'));
    }

    public function products()
    {
        $products = Product::with('farmer')->get();
        return view('admin.products', compact('products'));
    }

    public function approveProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => 'approved']);
        return back()->with('success', "{$product->name} অনুমোদিত হয়েছে।");
    }

    public function rejectProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => 'rejected']);
        return back()->with('success', "{$product->name} বাতিল করা হয়েছে।");
    }
}
