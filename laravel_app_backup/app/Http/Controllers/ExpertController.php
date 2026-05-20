<?php

namespace App\Http\Controllers;

use App\Models\AdviceRequest;
use App\Models\ExpertArticle;
use App\Models\ExpertGuide;
use App\Models\Payout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExpertController extends Controller
{
    public function dashboard(): View
    {
        $expertId = Auth::id();

        $pendingIssues = AdviceRequest::where('status', 'pending')->latest()->get();
        $answeredCount = AdviceRequest::where('expert_id', $expertId)->where('status', 'answered')->count();
        $earnings = Payout::where('expert_id', $expertId)->sum('amount');

        return view('expert.dashboard', compact('pendingIssues', 'answeredCount', 'earnings'));
    }

    public function answerIssue(Request $request, AdviceRequest $issue): RedirectResponse
    {
        $validated = $request->validate([
            'answer' => 'required|string|min:10',
        ]);

        $issue->update([
            'expert_id' => Auth::id(),
            'answer' => $validated['answer'],
            'status' => 'answered',
        ]);

        // Every answered solution generates a payable record from ad revenue pool.
        Payout::create([
            'expert_id' => Auth::id(),
            'advice_request_id' => $issue->id,
            'amount' => 50.00,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Solution submitted. Payout entry created.');
    }

    public function storeGuide(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'body' => 'required|string|min:50',
        ]);

        ExpertGuide::create($validated + ['expert_id' => Auth::id()]);

        return back()->with('status', 'Guide uploaded.');
    }

    public function storeArticle(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'body' => 'required|string|min:50',
        ]);

        ExpertArticle::create($validated + ['expert_id' => Auth::id()]);

        return back()->with('status', 'Article published.');
    }
}
