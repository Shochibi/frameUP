<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;

// Redirect ke Login jika buka root
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes (Hanya untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

// Auth Routes (Harus Login)
Route::middleware('auth')->group(function () {

    // Navigasi Utama
    Route::get('/home', [PostController::class, 'index'])->name('home');
    Route::get('/friend', function () {
        return view('friend');
    })->name('friend');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update-profile', [ProfileController::class, 'updateProfile'])->name('profile.updateProfile');
    Route::post('/profile/verify-password', [ProfileController::class, 'verifyPassword'])->name('profile.verifyPassword');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
// Postingan
Route::post('/post', [PostController::class, 'store'])->name('post.store');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])
    ->name('posts.destroy')
    ->middleware('auth');
Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show')
    ->middleware('auth');

// COMMENT
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->name('comments.store')
    ->middleware('auth');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->name('comments.destroy')
    ->middleware('auth');

//JELAJAHI 
Route::get('/explore', [PostController::class, 'explore'])
    ->name('posts.explore')
    ->middleware('auth');

// FRIEND
Route::middleware('auth')->group(function () {

    Route::get('/friend', [FriendsController::class, 'index'])->name('friend');
    Route::post('/add-friend/{id}', [FriendsController::class, 'send']);
    Route::post('/accept-friend/{id}', [FriendsController::class, 'accept']);
    Route::post('/remove-friend/{id}', [FriendsController::class, 'remove']);

    // CHAT
    Route::get('/chat/{id}', [FriendsController::class, 'chat'])
        ->middleware('auth')
        ->name('chat');

    // Postingan
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy')
        ->middleware('auth');
    Route::get('/posts/{post}', [PostController::class, 'show'])
        ->name('posts.show')
        ->middleware('auth');

    // COMMENT
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store')
        ->middleware('auth');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy')
        ->middleware('auth');

    //JELAJAHI 
    Route::get('/explore', [PostController::class, 'explore'])
        ->name('posts.explore')
        ->middleware('auth');
    // CRUD POSTINGAN
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('post.delete');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

    // CRUD KOMENTAR
    // Gunakan POST untuk simpan, DELETE untuk hapus
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/like/toggle', [LikeController::class, 'toggle'])->name('like.toggle')->middleware('auth');
});
