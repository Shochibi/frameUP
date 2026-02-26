<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('friends.index', compact('users'));
    }

    public function show($id)
    {
        $friend = User::findOrFail($id);

        $messages = Message::where(function($q) use ($id) {
                $q->where('sender_id', auth()->id())
                  ->where('receiver_id', $id);
            })
            ->orWhere(function($q) use ($id) {
                $q->where('sender_id', $id)
                  ->where('receiver_id', auth()->id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('friends.chat', compact('friend', 'messages'));
    }

    public function send(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $id,
            'message' => $request->message
        ]);

        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $msg = Message::findOrFail($id);

        if ($msg->sender_id !== auth()->id()) {
            abort(403);
        }

        $msg->update([
            'message' => $request->message
        ]);

        return back();
    }

    public function destroy($id)
    {
        $msg = Message::findOrFail($id);

        if ($msg->sender_id !== auth()->id()) {
            abort(403);
        }

        $msg->delete();

        return back();
    }
}