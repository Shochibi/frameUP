<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;


class CommentController extends Controller
{
    public function store(Request $request, $postId)
{
    $request->validate([
        'comment' => 'required'
    ]);

    Comment::create([
        'user_id' => auth::id(),
        'post_id' => $postId,
        'comment' => $request->comment,
        'parent_id' => $request->parent_id
    ]);

    return back();
}

public function destroy(Comment $comment)
{
    if ($comment->user_id !== Auth::id()) {
        abort(403);
    }

    $comment->delete();

    return back();
}

}
