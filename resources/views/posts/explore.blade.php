@extends('layouts.main')

@section('title', 'Jelajahi')

@section('content')

<h1 class="text-2xl font-bold mb-6">🔍 Jelajahi</h1>

{{-- SEARCH BAR --}}
<form method="GET" action="{{ route('posts.explore') }}" class="mb-6">
    <div class="flex gap-2 max-w-xl">
        <input type="text" 
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari yang Anda butuhkan ..."
               class="flex-1 border rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

        <button class="bg-blue-500 text-white px-5 rounded-full text-sm">
            Cari
        </button>
    </div>
</form>

{{-- GRID POSTINGAN --}}
<div class="grid grid-cols-2 md:grid-cols-3 gap-2">
    @foreach($posts as $post)
        <a href="{{ route('posts.show', $post->id) }}"
           class="relative group aspect-square overflow-hidden rounded-lg">

            @if($post->file_type == 'image')
                <img src="{{ asset('storage/' . $post->file_path) }}"
                     class="w-full h-full object-cover 
                            group-hover:scale-105 
                            transition duration-300">
            @else
                <video class="w-full h-full object-cover" muted>
                    <source src="{{ asset('storage/' . $post->file_path) }}">
                </video>
            @endif

            {{-- Hover Overlay --}}
            <div class="absolute inset-0 
                        bg-black bg-opacity-0 
                        group-hover:bg-opacity-40 
                        transition 
                        flex items-center justify-center 
                        opacity-0 group-hover:opacity-100">

                <div class="text-white font-semibold text-sm">
                    💬 {{ $post->comments->count() }}
                </div>
            </div>

        </a>
    @endforeach
</div>

<div class="mt-6">
    {{ $posts->links() }}
</div>

@endsection
