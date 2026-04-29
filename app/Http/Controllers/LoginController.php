<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'ইমেইল' => 'required|email',
            'পাসওয়ার্ড' => 'required',
        ]);

        if (Auth::attempt(['ইমেইল' => $credentials['ইমেইল'], 'পাসওয়ার্ড' => $credentials['পাসওয়ার্ড']])) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isFarmer()) {
                return redirect()->route('farmer.dashboard');
            } elseif ($user->isBuyer()) {
                return redirect()->route('buyer.dashboard');
            } elseif ($user->isExpert()) {
                return redirect()->route('expert.dashboard');
            }
        }

        return back()->withErrors([
            'ইমেইল' => 'প্রদত্ত শংসাপত্রগুলি আমাদের রেকর্ডের সাথে মেলে না।',
        ])->onlyInput('ইমেইল');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
