<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendsController;

// Halaman Form Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

// Halaman Form Register
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

//Pendaftaran
Route::middleware('auth')->group(function () {
    Route::get('/home', [PostController::class, 'index'])->name('home');
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

});
