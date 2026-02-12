<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'username' => 'required|min:3|max:255|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
        ]);

        // 1. Enkripsi password sebelum masuk database
        $validatedData['password'] = Hash::make($validatedData['password']);

        // 2. Simpan data ke tabel users
        User::create($validatedData);

        // 3. Redirect ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
