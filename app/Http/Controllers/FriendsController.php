<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $search = $request->search;

    // Teman accepted
    $friends = $user->friends()
        ->when($search, function($q) use ($search){
            $q->where('username', 'like', "%$search%");
        })
        ->get();

    // Rekomendasi user
    $recommended = User::where('id', '!=', $user->id)
        ->when($search, function($q) use ($search){
            $q->where('username', 'like', "%$search%");
        })
        ->get();

    return view('friend', compact('friends', 'recommended', 'search'));
}

// Kirim request
    public function send($id)
{
    $user = Auth::user();

    if ($user->id === $id) {
        return back()->with('error', 'Tidak bisa add diri sendiri');
    }

    $existing = \DB::table('friendships')
        ->where(function ($q) use ($user, $id) {
            $q->where('user_id', $user->id)
              ->where('friend_id', $id);
        })
        ->orWhere(function ($q) use ($user, $id) {
            $q->where('user_id', $id)
              ->where('friend_id', $user->id);
        })
        ->exists();

    if ($existing) {
        return back()->with('error', 'Sudah ada request atau sudah berteman');
    }

    $user->friends()->attach($id, [
        'status' => 'pending'
    ]);

    return back()->with('success', 'Request terkirim');
}

    // Terima request
    public function accept($id)
    {
        $user = Auth::user();

        $user->friendRequests()->updateExistingPivot($id, [
            'status' => 'accepted'
        ]);

        return back()->with('success', 'Request diterima');
    }

    // Hapus teman
    public function remove($id)
    {
        $user = Auth::user();

        $user->friends()->detach($id);

        return back()->with('success', 'Teman dihapus');
    }

    // CHAT 
    public function chat($id)
{
    $user = Auth::user();

    // Pastikan sudah berteman
    $isFriend = $user->friends()->where('friend_id', $id)->exists();

    if(!$isFriend){
        abort(403);
    }

    $friend = User::findOrFail($id);

    return view('friends.chat', compact('friend'));
}

}
