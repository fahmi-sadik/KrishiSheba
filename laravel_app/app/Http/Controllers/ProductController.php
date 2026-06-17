<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'image_url' => 'required|string'
        ]);

        Product::create([
            'farmer_id' => Auth::id(),
            'name' => $request->name,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'image_url' => $request->image_url,
            'status' => 'pending'
        ]);

        return back()->with('success', 'পণ্য সফলভাবে যোগ করা হয়েছে এবং অনুমোদনের অপেক্ষায় আছে।');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->farmer_id != Auth::id()) {
            return back()->with('error', 'আপনার এই পণ্যটি মুছে ফেলার অনুমতি নেই।');
        }
        
        $product->delete();
        return back()->with('success', 'পণ্যটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
