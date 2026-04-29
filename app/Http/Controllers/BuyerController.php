<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function dashboard()
    {
        $totalPurchases = auth()->user()->purchases()->count();
        $totalSpent = auth()->user()->purchases()->where('অবস্থা', 'ডেলিভার_করা')->sum('মোট_মূল্য');
        $pendingOrders = auth()->user()->purchases()->where('অবস্থা', 'অর্ডার_রাখা')->count();
        $deliveredOrders = auth()->user()->purchases()->where('অবস্থা', 'ডেলিভার_করা')->count();

        return view('buyer.dashboard', compact(
            'totalPurchases',
            'totalSpent',
            'pendingOrders',
            'deliveredOrders'
        ));
    }

    public function browseProducts()
    {
        $category = request('বিভাগ');
        $search = request('অনুসন্ধান');

        $query = Product::where('অবস্থা', 'অনুমোদিত');

        if ($category) {
            $query->where('বিভাগ', $category);
        }

        if ($search) {
            $query->where('নাম', 'like', '%' . $search . '%')
                  ->orWhere('বর্ণনা', 'like', '%' . $search . '%');
        }

        $products = $query->paginate(12);
        $categories = ['শাকসবজি', 'ফল', 'শস্য', 'দুগ্ধ', 'মাছ', 'অন্যান্য'];

        return view('buyer.products', compact('products', 'categories'));
    }

    public function viewProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('buyer.product-detail', compact('product'));
    }

    public function buyProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'পরিমাণ' => 'required|integer|min:1|max:' . $product->পরিমাণ,
            'ডেলিভারি_ঠিকানা' => 'required|string|max:500',
        ]);

        $totalPrice = $product->মূল্য * $validated['পরিমাণ'];

        $sale = Sale::create([
            'পণ্য_আইডি' => $product->id,
            'ক্রেতা_আইডি' => auth()->id(),
            'বিক্রেতা_আইডি' => $product->কৃষক_আইডি,
            'পরিমাণ' => $validated['পরিমাণ'],
            'মোট_মূল্য' => $totalPrice,
            'ডেলিভারি_ঠিকানা' => $validated['ডেলিভারি_ঠিকানা'],
        ]);

        // Update product quantity
        $product->update([
            'পরিমাণ' => $product->পরিমাণ - $validated['পরিমাণ']
        ]);

        return redirect()->route('buyer.orders')->with('সাফল্য', 'অর্ডার সফলভাবে স্থাপন করা হয়েছে!');
    }

    public function myOrders()
    {
        $orders = auth()->user()->purchases()->with('product', 'seller')->paginate(15);
        return view('buyer.orders', compact('orders'));
    }

    public function cancelOrder($id)
    {
        $sale = Sale::findOrFail($id);
        
        if ($sale->ক্রেতা_আইডি !== auth()->id()) {
            abort(403);
        }

        if ($sale->অবস্থা === 'অর্ডার_রাখা') {
            $sale->update(['অবস্থা' => 'বাতিল']);
            
            // Restore product quantity
            $product = $sale->product;
            $product->update(['পরিমাণ' => $product->পরিমাণ + $sale->পরিমাণ]);

            return redirect()->back()->with('সাফল্য', 'অর্ডার বাতিল করা হয়েছে!');
        }

        return redirect()->back()->with('ত্রুটি', 'এই অর্ডার বাতিল করা যায় না!');
    }
}
