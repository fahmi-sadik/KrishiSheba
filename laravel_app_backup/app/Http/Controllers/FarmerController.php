<?php

namespace App\Http\Controllers;

use App\Models\AdviceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FarmerController extends Controller
{
    public function createIssue(): View
    {
        return view('farmer.issue-create');
    }

    public function storeIssue(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required|string|min:10',
        ]);

        AdviceRequest::create([
            'farmer_id' => Auth::id(),
            'question' => $validated['question'],
            'status' => 'pending',
        ]);

        return back()->with('status', 'Issue submitted for expert review.');
    }
}
