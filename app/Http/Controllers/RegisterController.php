<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'নাম' => 'required|string|max:255',
            'ইমেইল' => 'required|string|email|max:255|unique:users',
            'ফোন' => 'required|string|max:20',
            'ঠিকানা' => 'required|string|max:500',
            'ভূমিকা' => 'required|in:কৃষক,ক্রেতা,বিশেষজ্ঞ',
            'পাসওয়ার্ড' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'নাম' => $validated['নাম'],
            'ইমেইল' => $validated['ইমেইল'],
            'ফোন' => $validated['ফোন'],
            'ঠিকানা' => $validated['ঠিকানা'],
            'ভূমিকা' => $validated['ভূমিকা'],
            'পাসওয়ার্ড' => Hash::make($validated['পাসওয়ার্ড']),
            'অনুমোদিত' => false,
        ]);

        return redirect()->route('login')->with('সাফল্য', 'নিবন্ধন সফল! আপনার অ্যাকাউন্ট অনুমোদনের জন্য অপেক্ষা করুন।');
    }
}
