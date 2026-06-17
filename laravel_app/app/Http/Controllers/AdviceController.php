<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdviceRequest;
use Illuminate\Support\Facades\Auth;

class AdviceController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'expert_id' => 'required|exists:users,id',
            'question' => 'required|string',
            'trx_id' => 'required|string|min:8'
        ]);

        $farmerId = Auth::id();

        \App\Models\Payment::create([
            'farmer_id' => $farmerId,
            'expert_id' => $request->expert_id,
            'amount' => 100, 
            'status' => 'completed' 
        ]);

        AdviceRequest::create([
            'farmer_id' => $farmerId,
            'expert_id' => $request->expert_id,
            'question' => $request->question,
            'status' => 'pending'
        ]);

        return back()->with('success', 'পেমেন্ট সফল হয়েছে এবং আপনার প্রশ্নটি বিশেষজ্ঞের কাছে পাঠানো হয়েছে!');
    }

    public function answer(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required|string'
        ]);

        $adviceRequest = AdviceRequest::findOrFail($id);
        $adviceRequest->update([
            'answer' => $request->answer,
            'expert_id' => Auth::id(),
            'status' => 'answered'
        ]);

        return back()->with('success', 'আপনার উত্তর সফলভাবে জমা দেওয়া হয়েছে।');
    }
}
