<?php

namespace App\Http\Controllers;

use App\Models\ExpertDocument;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:farmer,buyer,expert',
            'delivery_address' => 'nullable|string|max:500',
            'experience_years' => 'nullable|integer|min:0|max:60',
            'certificate_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'paperwork_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $isExpert = $validated['role'] === 'expert';

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'delivery_address' => $validated['delivery_address'] ?? null,
            'experience_years' => $isExpert ? ($validated['experience_years'] ?? 0) : null,
            'is_approved' => $isExpert ? false : true,
        ]);

        if ($isExpert) {
            $certificatePath = $request->file('certificate_file')?->store('expert_docs', 'public');
            $paperworkPath = $request->file('paperwork_file')?->store('expert_docs', 'public');

            ExpertDocument::create([
                'user_id' => $user->id,
                'certificate_path' => $certificatePath,
                'paperwork_path' => $paperworkPath,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('login.show')->with(
            'status',
            $isExpert
                ? 'Registration successful. Please wait for admin approval.'
                : 'Registration successful. You can login now.'
        );
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        /** @var User $user */
        $user = Auth::user();
        if ($user->role === 'expert' && !$user->is_approved) {
            Auth::logout();

            return back()->withErrors(['email' => 'Your account is pending admin approval.'])->withInput();
        }

        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'expert') {
            return redirect()->route('expert.dashboard');
        }

        return redirect()->route('farmer.issue.create');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.show');
    }
}
