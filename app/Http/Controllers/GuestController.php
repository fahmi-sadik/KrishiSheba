<?php

namespace App\Http\Controllers;

use App\Models\Product;

class GuestController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::where('অবস্থা', 'অনুমোদিত')
            ->latest()
            ->take(8)
            ->get();

        return view('guest.home', compact('featuredProducts'));
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

        return view('guest.products', compact('products', 'categories'));
    }

    public function viewProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('guest.product-detail', compact('product'));
    }
}
