@extends('layouts.main')

{{-- Isi bagian title --}}
@section('title', 'Login')

{{-- Isi bagian content --}}
@section('content')
<div class="fixed inset-0 z-50 flex items-center justify-center py-10 overflow-y-auto bg-gray-50/50 backdrop-blur-sm">
    <div class="w-full max-w-md my-auto overflow-hidden transition-all duration-300 bg-white shadow-2xl rounded-2xl hover:shadow-blue-100">
        
        {{-- Header Gradient (Warna Biru untuk Login agar beda dengan Register) --}}
        <div class="relative h-24 bg-gradient-to-r from-blue-500 to-indigo-600">
            <div class="absolute inset-x-0 flex justify-center -bottom-10">
                <div class="p-1 bg-white rounded-full shadow-lg">
                    <img src="{{ asset('images/logo2.png') }}" alt="Logo" class="object-contain w-20 h-20">
                </div>
            </div>
        </div>

        <div class="px-8 pb-8 pt-14">
            <div class="mb-6 text-center">
                <h1 class="text-2xl italic font-extrabold tracking-tight text-gray-800">FrameUP</h1>
                <p class="text-sm text-gray-500">Selamat datang kembali! Silakan masuk.</p>
            </div>

            {{-- Alert Login Error --}}
            @if(session()->has('loginError'))
            <div class="p-3 mb-4 text-xs font-medium text-red-600 bg-red-100 border border-red-200 rounded-xl">
                <i class="mr-1 fa-solid fa-circle-exclamation"></i> {{ session('loginError') }}
            </div>
            @endif

            <form action="/login" method="POST" class="space-y-4">
                @csrf 

                {{-- Username Field --}}
                <div>
                    <label class="block mb-1 text-sm font-semibold text-gray-700">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" name="username" class="w-full py-2 pl-10 pr-4 transition-all border border-gray-200 outline-none rounded-xl focus:ring-2 focus:ring-blue-500" placeholder="Username kamu" required autofocus>
                    </div>
                </div>

                {{-- Password Field --}}
                <div>
                    <label class="block mb-1 text-sm font-semibold text-gray-700">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" class="w-full py-2 pl-10 pr-4 transition-all border border-gray-200 outline-none rounded-xl focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 mt-2 font-bold text-white transition-all bg-blue-600 shadow-lg rounded-xl hover:bg-blue-700 active:scale-95 shadow-blue-200">
                    Masuk Sekarang
                </button>

                <div class="text-center">
                    <a href="{{ route('register') }}" class="text-sm text-gray-500 transition hover:text-blue-600">
                        Belum punya akun? <span class="font-bold text-blue-600">Daftar di sini</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection