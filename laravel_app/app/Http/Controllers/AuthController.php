<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nid' => 'required|string|max:20',
            'role' => 'required|in:farmer,buyer,expert',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nid' => $request->nid,
            'role' => $request->role,
            'image' => $imagePath,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'আপনার নিবন্ধন সফল হয়েছে! এখন লগইন করুন।');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'role' => 'required|in:farmer,buyer,expert,admin',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'role' => $credentials['role']])) {
            $request->session()->regenerate();
            
            $role = Auth::user()->role;
            if ($role === 'admin') return redirect()->route('admin.dashboard');
            if ($role === 'buyer') return redirect()->route('buyer.dashboard');
            if ($role === 'farmer') return redirect()->route('farmer.dashboard');
            if ($role === 'expert') return redirect()->route('expert.dashboard');
            
            return redirect()->route('home')->with('success', 'লগইন সফল হয়েছে!');
        }

        return back()->with('error', 'ভুল ইমেইল, পাসওয়ার্ড বা লগইন ধরন!')->onlyInput('email', 'role');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'লগআউট সফল হয়েছে!');
    }
}
