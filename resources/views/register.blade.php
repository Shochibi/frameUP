@extends('layouts.main')

@section('title', 'Register')

@section('content')
<div class="fixed inset-0 z-50 flex items-center justify-center py-10 overflow-y-auto bg-gray-50/50 backdrop-blur-sm">
    <div class="w-full max-w-md my-auto overflow-hidden transition-all duration-300 bg-white shadow-2xl rounded-2xl hover:shadow-purple-100">
        
        {{-- Header Gradient --}}
        <div class="relative h-24 bg-gradient-to-r from-purple-500 to-blue-600">
            <div class="absolute inset-x-0 flex justify-center -bottom-10">
                <div class="p-1 bg-white rounded-full shadow-lg">
                    <img src="{{ asset('images/logo2.png') }}" alt="Logo" class="object-contain w-20 h-20">
                </div>
            </div>
        </div>

        <div class="px-8 pb-8 pt-14">
            <div class="mb-6 text-center">
                <h1 class="text-2xl italic font-extrabold tracking-tight text-gray-800">Gabung FrameUP</h1>
                <p class="text-sm text-gray-500">Buat akun untuk mulai berbagi momen.</p>
            </div>

            <form action="/register" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block mb-1 text-sm font-semibold text-gray-700">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-at"></i>
                        </span>
                        {{-- Atribut autofocus ditambahkan di bawah ini --}}
                        <input type="text" name="username" autofocus class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 transition-all outline-none @error('username') border-red-500 @enderror" value="{{ old('username') }}" placeholder="username_kamu" required>
                    </div>
                    @error('username') <span class="mt-1 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold text-gray-700">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 transition-all outline-none @error('email') border-red-500 @enderror" value="{{ old('email') }}" placeholder="nama@email.com" required>
                    </div>
                    @error('email') <span class="mt-1 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block mb-1 text-sm font-semibold text-gray-700">Password</label>
                        <input type="password" name="password" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 transition-all outline-none @error('password') border-red-500 @enderror" placeholder="••••••••" required>
                        @error('password') <span class="mt-1 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-semibold text-gray-700">Konfirmasi</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-2 transition-all border border-gray-200 outline-none rounded-xl focus:ring-2 focus:ring-purple-500" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 mt-2 font-bold text-white transition-all bg-purple-600 shadow-lg rounded-xl hover:bg-purple-700 active:scale-95 shadow-purple-200">
                    Daftar Sekarang
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 transition hover:text-purple-600">
                        Sudah punya akun? <span class="font-bold text-purple-600">Masuk</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection