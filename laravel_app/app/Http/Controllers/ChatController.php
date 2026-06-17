<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index($userId = null)
    {
        $users = User::where('id', '!=', Auth::id())
                     ->whereIn('role', ['farmer', 'expert'])
                     ->get();
                     
        $messages = [];
        $activeUser = null;

        if ($userId) {
            $activeUser = User::findOrFail($userId);
            $messages = Message::where(function($q) use ($userId) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $userId);
            })->orWhere(function($q) use ($userId) {
                $q->where('sender_id', $userId)->where('receiver_id', Auth::id());
            })->orderBy('created_at', 'asc')->get();
        }

        return view('chat.index', compact('users', 'messages', 'activeUser'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        return back();
    }
}
