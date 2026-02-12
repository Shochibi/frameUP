{{-- 1. Panggil Master Layout-nya --}}
@extends('layouts.main')

{{-- 2. Isi bagian title --}}
@section('title', 'Register')

{{-- 3. Isi bagian content --}}
@section('content')
<div class="fixed inset-0 bg-gray-50 flex items-center justify-center overflow-hidden z-50">
  <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md border border-gray-200">
    <div class="flex flex-col items-center mb-6">
      <img src="{{ asset('images/logo2.png') }}" alt="Logo" class="w-32 h-32 mb-2">
      <h1 class="text-2xl font-bold italic text-gray-800">Gabung FrameUP</h1>
    </div>

    <form action="/register" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" name="username" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none @error('username') border-red-500 @enderror" value="{{ old('username') }}" required>
        @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" name="password" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none @error('password') border-red-500 @enderror" required>
        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
        Daftar Sekarang
      </button>

      <a href="{{ route('login') }}" class="block text-center text-sm text-gray-500 hover:text-blue-600 mt-4 transition">
        Sudah punya akun? <span class="font-bold">Masuk</span>
      </a>
    </form>
  </div>
</div>
@endsection