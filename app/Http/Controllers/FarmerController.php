<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function dashboard()
    {
        $totalProducts = auth()->user()->products()->count();
        $approvedProducts = auth()->user()->products()->where('অবস্থা', 'অনুমোদিত')->count();
        $pendingProducts = auth()->user()->products()->where('অবস্থা', 'অপেক্ষমান')->count();
        $rejectedProducts = auth()->user()->products()->where('অবস্থা', 'নিরস্ত করা')->count();
        
        $totalSales = auth()->user()->sales()->where('অবস্থা', 'ডেলিভার_করা')->count();
        $totalRevenue = auth()->user()->sales()->where('অবস্থা', 'ডেলিভার_করা')->sum('মোট_মূল্য');

        return view('farmer.dashboard', compact(
            'totalProducts',
            'approvedProducts',
            'pendingProducts',
            'rejectedProducts',
            'totalSales',
            'totalRevenue'
        ));
    }

    public function myProducts()
    {
        $products = auth()->user()->products()->paginate(15);
        return view('farmer.products.index', compact('products'));
    }

    public function addProductForm()
    {
        return view('farmer.products.add');
    }

    public function addProduct(Request $request)
    {
        $validated = $request->validate([
            'নাম' => 'required|string|max:255',
            'বর্ণনা' => 'nullable|string',
            'মূল্য' => 'required|numeric|min:0',
            'পরিমাণ' => 'required|integer|min:1',
            'এককরণ' => 'required|string',
            'বিভাগ' => 'required|in:শাকসবজি,ফল,শস্য,দুগ্ধ,মাছ,অন্যান্য',
            'ছবি' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = new Product($validated);
        $product->কৃষক_আইডি = auth()->id();
        
        if ($request->hasFile('ছবি')) {
            $product->ছবি = $request->file('ছবি')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('farmer.products')->with('সাফল্য', 'পণ্য সফলভাবে যোগ করা হয়েছে! অনুমোদনের জন্য অপেক্ষা করুন।');
    }

    public function editProductForm($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('update', $product);
        return view('farmer.products.edit', compact('product'));
    }

    public function editProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('update', $product);

        $validated = $request->validate([
            'নাম' => 'required|string|max:255',
            'বর্ণনা' => 'nullable|string',
            'মূল্য' => 'required|numeric|min:0',
            'পরিমাণ' => 'required|integer|min:1',
            'এককরণ' => 'required|string',
            'বিভাগ' => 'required|in:শাকসবজি,ফল,শস্য,দুগ্ধ,মাছ,অন্যান্য',
            'ছবি' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product->update($validated);

        if ($request->hasFile('ছবি')) {
            $product->ছবি = $request->file('ছবি')->store('products', 'public');
            $product->save();
        }

        return redirect()->route('farmer.products')->with('সাফল্য', 'পণ্য সফলভাবে আপডেট করা হয়েছে!');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product);
        $product->delete();
        return redirect()->back()->with('সাফল্য', 'পণ্য সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
