@extends('layouts.main')

@section('content')
    <div class="flex justify-end mb-6">
        <a href="{{ url('home') }}"
            class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-700 transition bg-gray-100 rounded-xl hover:bg-gray-200">
            <i class="fa-solid fa-arrow-left"></i>
            Beranda
        </a>
    </div>

    <div class="p-6 bg-white shadow rounded-xl">
        <h2 class="text-2xl font-bold">{{ $user->username }}</h2>
        <p class="text-gray-500">{{ $user->posts->count() }} Postingan</p>
    </div>

    <div class="grid grid-cols-3 gap-3 mt-6">

        @forelse($user->posts as $post)
            <a href="{{ route('posts.show', $post->id) }}"
                class="relative overflow-hidden bg-gray-200 aspect-square rounded-xl group">

                <img src="{{ asset('storage/' . $post->file_path) }}"
                    class="object-cover w-full h-full transition duration-300 group-hover:scale-110">

                <div
                    class="absolute inset-0 flex items-center justify-center text-white transition bg-black opacity-0 bg-opacity-40 group-hover:opacity-100">
                    <i class="text-xl fa-solid fa-eye"></i>
                </div>
            </a>

        @empty
            <div class="col-span-3 p-6 text-center text-gray-500 bg-white shadow rounded-xl">
                Belum ada postingan.
            </div>
        @endforelse

    </div>
@endsection