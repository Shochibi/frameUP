{{-- 1. Panggil Master Layout-nya --}}
@extends('layouts.main')

{{-- 2. Isi bagian title --}}
@section('title', 'Login')

{{-- 3. Isi bagian content --}}
@section('content')
<div class="fixed inset-0 bg-gray-50 flex items-center justify-center overflow-hidden z-50">

  <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md border border-gray-200">
    <div class="flex flex-col items-center mb-8">
      <img src="{{ asset('images/logo2.png') }}" alt="Logo" class="w-35 h-35 mb-2">
      <h1 class="text-2xl font-bold italic">FrameUP</h1>
    </div>

    @if(session()->has('loginError'))
    <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm">
      {{ session('loginError') }}
    </div>
    @endif

    <form action="/login" method="POST" class="space-y-4">
      @csrf <div>
        <label class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" name="username" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" name="password" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
        Masuk
      </button>
      <a href="{{ route('register') }}" class="block text-center text-sm text-gray-500 hover:text-blue-600 mt-4 transition">
        Belum punya akun? <span class="font-bold">Daftar di sini</span>
      </a>
    </form>
  </div>

</div>
@endsection