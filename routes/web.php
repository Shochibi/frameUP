<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Redirect Root
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('login'));

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // HOME
    Route::get('/home', [PostController::class, 'index'])->name('home');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update-profile', [ProfileController::class, 'updateProfile'])->name('profile.updateProfile');
    Route::post('/profile/verify-password', [ProfileController::class, 'verifyPassword'])->name('profile.verifyPassword');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // LOGOUT
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | FRIEND SYSTEM
    |--------------------------------------------------------------------------
    */

    Route::get('/friend', [FriendsController::class, 'index'])->name('friend');
    Route::post('/add-friend/{id}', [FriendsController::class, 'send']);
    Route::post('/friend/accept/{id}', [FriendsController::class, 'accept'])->name('friend.accept');
    Route::post('/friend/reject/{id}', [FriendsController::class, 'reject'])->name('friend.reject');
    Route::post('/remove-friend/{id}', [FriendsController::class, 'remove']);

    /*
    |--------------------------------------------------------------------------
    | CHAT SYSTEM
    |--------------------------------------------------------------------------
    */

    Route::get('/chat', [ChatController::class, 'index'])->name('friends.index');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('friends.show');
    Route::post('/chat/{id}', [ChatController::class, 'send'])->name('friends.send');
    Route::put('/chat/{id}', [ChatController::class, 'update'])->name('friends.update');
    Route::delete('/chat/{id}', [ChatController::class, 'destroy'])->name('friends.destroy');

    /*
    |--------------------------------------------------------------------------
    | POST SYSTEM
    |--------------------------------------------------------------------------
    */

    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    // KLIK USERNAME DIPOSTINGAN UNTUK MELIHAT PROFILE 
    Route::get('/profile/{username}', [ProfileController::class, 'show'])->name('profile.show');

    /*
    |--------------------------------------------------------------------------
    | COMMENT SYSTEM
    |--------------------------------------------------------------------------
    */

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    /*
    |--------------------------------------------------------------------------
    | LIKE SYSTEM
    |--------------------------------------------------------------------------
    */

    Route::post('/like/toggle', [LikeController::class, 'toggle'])->name('like.toggle');

    /*
    |--------------------------------------------------------------------------
    | EXPLORE
    |--------------------------------------------------------------------------
    */

    Route::get('/explore', [PostController::class, 'explore'])->name('posts.explore');
});

    /*
    |--------------------------------------------------------------------------
    | SETTINGS
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth')->group(function () {
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings');
});
