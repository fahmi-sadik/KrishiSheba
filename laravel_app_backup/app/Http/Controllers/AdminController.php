<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\ExpertDocument;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $pendingExperts = User::query()
            ->where('role', 'expert')
            ->where('is_approved', false)
            ->with('expertDocument')
            ->latest()
            ->get();

        $ads = Advertisement::latest()->limit(10)->get();

        return view('admin.dashboard', compact('pendingExperts', 'ads'));
    }

    public function approveExpert(User $user): RedirectResponse
    {
        if ($user->role !== 'expert') {
            return back()->withErrors(['expert' => 'Selected user is not an expert.']);
        }

        $user->update(['is_approved' => true]);
        ExpertDocument::where('user_id', $user->id)->update(['status' => 'approved']);

        return back()->with('status', 'Expert approved successfully.');
    }

    public function storeAd(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'content' => 'required|string|max:500',
            'target_url' => 'nullable|url',
        ]);

        Advertisement::create($validated + ['is_active' => true]);

        return back()->with('status', 'Ad published.');
    }
}
