<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', [PostController::class, 'index'])->name('home');

Route::get('/friend', function () {
    return view('friend');
})->name('friend');

Route::post('/post', [PostController::class, 'store'])->name('post.store');
Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('post.delete');
