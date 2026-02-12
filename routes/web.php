<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

// Halaman Form Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

// Halaman Form Register
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

//Pendaftaran
Route::middleware('auth')->group(function () {
    Route::get('/home', [PostController::class, 'index'])->name('home');
    Route::get('/friend', function () {
        return view('friend');
    })->name('friend');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Postingan
Route::post('/post', [PostController::class, 'store'])->name('post.store');
Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('post.delete');
