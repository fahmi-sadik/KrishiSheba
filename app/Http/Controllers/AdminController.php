<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalFarmers = User::where('ভূমিকা', 'কৃষক')->count();
        $totalBuyers = User::where('ভূমিকা', 'ক্রেতা')->count();
        $totalExperts = User::where('ভূমিকা', 'বিশেষজ্ঞ')->count();
        
        // Monthly sales summary
        $monthlyRevenue = Sale::where('অবস্থা', 'ডেলিভার_করা')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('মোট_মূল্য');

        $monthlyOrders = Sale::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Sales by month
        $salesByMonth = Sale::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(মোট_মূল্য) as total')
            ->where('অবস্থা', 'ডেলিভার_করা')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->get();

        $pendingProducts = Product::where('অবস্থা', 'অপেক্ষমান')->count();
        $pendingUsers = User::where('অনুমোদিত', false)->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalFarmers',
            'totalBuyers',
            'totalExperts',
            'monthlyRevenue',
            'monthlyOrders',
            'salesByMonth',
            'pendingProducts',
            'pendingUsers'
        ));
    }

    // User Management
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function viewUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->isFarmer()) {
            $products = $user->products()->paginate(10);
            $sales = Sale::where('বিক্রেতা_আইডি', $id)
                ->with('product', 'buyer')
                ->paginate(10);
        } elseif ($user->isBuyer()) {
            $purchases = Sale::where('ক্রেতা_আইডি', $id)
                ->with('product', 'seller')
                ->paginate(10);
            $products = null;
            $sales = null;
        } else {
            $products = null;
            $sales = null;
            $purchases = null;
        }

        return view('admin.users.view', compact('user', 'products', 'sales', 'purchases'));
    }

    public function addUserForm()
    {
        return view('admin.users.add');
    }

    public function addUser(Request $request)
    {
        $validated = $request->validate([
            'নাম' => 'required|string|max:255',
            'ইমেইল' => 'required|string|email|max:255|unique:users',
            'ফোন' => 'required|string|max:20',
            'ঠিকানা' => 'required|string|max:500',
            'ভূমিকা' => 'required|in:প্রশাসক,কৃষক,ক্রেতা,বিশেষজ্ঞ',
            'পাসওয়ার্ড' => 'required|string|min:6',
        ]);

        $user = User::create([
            'নাম' => $validated['নাম'],
            'ইমেইল' => $validated['ইমেইল'],
            'ফোন' => $validated['ফোন'],
            'ঠিকানা' => $validated['ঠিকানা'],
            'ভূমিকা' => $validated['ভূমিকা'],
            'পাসওয়ার্ড' => Hash::make($validated['পাসওয়ার্ড']),
            'অনুমোদিত' => true,
        ]);

        return redirect()->route('admin.users')->with('সাফল্য', 'ব্যবহারকারী সফলভাবে যোগ করা হয়েছে!');
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['অনুমোদিত' => true]);
        return redirect()->back()->with('সাফল্য', 'ব্যবহারকারী অনুমোদিত হয়েছে!');
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('সাফল্য', 'ব্যবহারকারী প্রত্যাখ্যান করা হয়েছে!');
    }

    // Product Approval
    public function approveProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'অবস্থা' => 'অনুমোদিত',
            'প্রশাসক_আইডি' => auth()->id(),
        ]);
        return redirect()->back()->with('সাফল্য', 'পণ্য অনুমোদিত হয়েছে!');
    }

    public function rejectProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'প্রত্যাখ্যানের_কারণ' => 'required|string|max:1000',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'অবস্থা' => 'নিরস্ত করা',
            'প্রত্যাখ্যানের_কারণ' => $validated['প্রত্যাখ্যানের_কারণ'],
            'প্রশাসক_আইডি' => auth()->id(),
        ]);
        return redirect()->back()->with('সাফল্য', 'পণ্য প্রত্যাখ্যান করা হয়েছে!');
    }

    // Sales Report
    public function salesReport()
    {
        $fromDate = request('থেকে_তারিখ') ? Carbon::parse(request('থেকে_তারিখ')) : now()->startOfMonth();
        $toDate = request('পর্যন্ত_তারিখ') ? Carbon::parse(request('পর্যন্ত_তারিখ')) : now()->endOfMonth();

        $sales = Sale::where('অবস্থা', 'ডেলিভার_করা')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->with('product', 'buyer', 'seller')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $totalRevenue = Sale::where('অবস্থা', 'ডেলিভার_করা')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->sum('মোট_মূল্য');

        $totalOrders = Sale::where('অবস্থা', 'ডেলিভার_করা')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->count();

        return view('admin.reports.sales', compact('sales', 'totalRevenue', 'totalOrders', 'fromDate', 'toDate'));
    }
}
