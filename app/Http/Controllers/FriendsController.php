<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FriendsController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $search = $request->search;

    // Ambil semua teman (dua arah)
    $friends = User::whereIn('id', function($query) use ($user) {
            $query->select('friend_id')
                  ->from('friendships')
                  ->where('user_id', $user->id)
                  ->where('status', 'accepted');
        })
        ->orWhereIn('id', function($query) use ($user) {
            $query->select('user_id')
                  ->from('friendships')
                  ->where('friend_id', $user->id)
                  ->where('status', 'accepted');
        })
        ->get();

    // Ambil ID teman biar bisa di-exclude
    $friendIds = $friends->pluck('id')->toArray();

    // Tambahkan diri sendiri juga supaya tidak muncul
    $friendIds[] = $user->id;

    // Rekomendasi = user yang belum berteman
    $recommended = User::whereNotIn('id', $friendIds)
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
public function accept($senderId)
{
    DB::table('friendships')
        ->where('user_id', $senderId)
        ->where('friend_id', auth()->id())
        ->update([
            'status' => 'accepted'
        ]);

    return back();
}

    public function reject($senderId)
{
    DB::table('friendships')
        ->where('user_id', $senderId)
        ->where('friend_id', auth()->id())
        ->delete();

    return back();
}

    // Hapus teman
    public function remove($id)
{
    $user = Auth::user();

    \DB::table('friendships')
        ->where(function ($q) use ($user, $id) {
            $q->where('user_id', $user->id)
              ->where('friend_id', $id);
        })
        ->orWhere(function ($q) use ($user, $id) {
            $q->where('user_id', $id)
              ->where('friend_id', $user->id);
        })
        ->delete();

    return back()->with('success', 'Teman dihapus');
}

    // CHAT 
    public function chat($id)
{
    $user = Auth::user();

    $isFriend = \DB::table('friendships')
        ->where(function ($q) use ($user, $id) {
            $q->where('user_id', $user->id)
              ->where('friend_id', $id);
        })
        ->orWhere(function ($q) use ($user, $id) {
            $q->where('user_id', $id)
              ->where('friend_id', $user->id);
        })
        ->where('status', 'accepted')
        ->exists();

    if (!$isFriend) {
        abort(403);
    }

    $friend = User::findOrFail($id);

    return view('friends.chat', compact('friend'));
}


}
