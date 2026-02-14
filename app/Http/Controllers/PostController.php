<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {

public function index()
{
    $posts = Post::with(['user', 'comments.user', 'comments.replies.user'])->get();
    return view('home', compact('posts'));
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'file' => 'required|mimes:jpg,jpeg,png,mp4,mov|max:20480'
    ]);

    $file = $request->file('file');
    $path = $file->store('posts', 'public');

    $type = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';

    Post::create([
    'user_id' => Auth::id(),
    'title' => $request->title,
    'description' => $request->description,
    'file_path' => $path,
    'file_type' => $type,
]);

    return back()->with('success', 'Post berhasil dibuat!');
}

public function destroy($id)
{
    $post = Post::findOrFail($id);

    // hapus file dari storage
    if (Storage::disk('public')->exists($post->file_path)) {
        Storage::disk('public')->delete($post->file_path);
    }

    $post->delete();

    return back()->with('success', 'Post berhasil dihapus');
}

public function show(Post $post)
{
    $post->load(['user', 'comments.user', 'comments.replies.user']);

    return view('post.show', compact('post'));
}

}