<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(): View
    {
        $expertList = User::where('role', 'expert')->where('is_approved', true)->get();
        $messages = ChatMessage::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->latest()
            ->limit(30)
            ->get()
            ->reverse();

        return view('chat.index', compact('messages', 'expertList'));
    }

    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        ChatMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => (int) $validated['receiver_id'],
            'message' => $validated['message'],
        ]);

        return back()->with('status', 'Message sent.');
    }
}
