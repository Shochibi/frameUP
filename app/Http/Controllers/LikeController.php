<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $user = Auth::user();
        $id = $request->id;
        $type = $request->type;

        $model = ($type === 'post') ? Post::findOrFail($id) : Comment::findOrFail($id);

        $like = $model->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            return response()->json(['status' => 'unliked', 'count' => $model->likes()->count()]);
        }

        $model->likes()->create(['user_id' => $user->id]);
        return response()->json(['status' => 'liked', 'count' => $model->likes()->count()]);
    }
}
