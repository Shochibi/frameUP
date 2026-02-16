@extends('layouts.main')

@section('title', 'Jelajahi')

@section('content')

<h1 class="mb-6 text-2xl font-bold">🔍 Jelajahi</h1>

{{-- SEARCH BAR --}}
<form method="GET" action="{{ route('posts.explore') }}" class="mb-6">
    <div class="flex max-w-xl gap-2">
        <input type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari yang Anda butuhkan ..."
            class="flex-1 px-4 py-2 text-sm border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-400">

        <button class="px-5 text-sm text-white bg-blue-500 rounded-full">
            Cari
        </button>
    </div>
</form>

{{-- GRID POSTINGAN --}}
<div class="grid grid-cols-2 gap-2 md:grid-cols-3">
    @foreach($posts as $post)
    <a href="{{ route('posts.show', $post->id) }}"
        class="relative overflow-hidden rounded-lg group aspect-square">

        @if($post->file_type == 'image')
        <img src="{{ asset('storage/' . $post->file_path) }}"
            class="object-cover w-full h-full transition duration-300 group-hover:scale-105">
        @else
        <video class="object-cover w-full h-full" muted>
            <source src="{{ asset('storage/' . $post->file_path) }}">
        </video>
        @endif

        {{-- Hover Overlay --}}
        <div class="absolute inset-0 flex items-center justify-center transition bg-black bg-opacity-0 opacity-0 group-hover:bg-opacity-40 group-hover:opacity-100">

            <div class="flex items-center gap-6 text-white">
                {{-- Jumlah Like --}}
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-heart"></i>
                    <span class="font-bold">{{ $post->likes->count() }}</span>
                </div>
                {{-- Jumlah Komentar --}}
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-comment"></i>
                    <span class="font-bold">{{ $post->comments->count() }}</span>
                </div>
            </div>
        </div>

    </a>
    @endforeach
</div>

<div class="mt-6">
    {{ $posts->links() }}
</div>

@endsection