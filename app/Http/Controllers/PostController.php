<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller {

public function index()
{
    $posts = Post::latest()->get();
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

}