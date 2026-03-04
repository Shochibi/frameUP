{{-- 1. Master Layout --}}
@extends('layouts.main')

@section('title', 'Halaman Beranda')

@section('content')
  <div class="max-w-2xl py-10 mx-auto">
    <h1 class="mb-2 text-4xl font-extrabold text-center text-gray-800">Selamat Datang, {{ auth()->user()->username }}!
    </h1>
    <p class="mb-10 italic text-center text-gray-500">Selamat menikmati momen-momen terbaru</p>

    @foreach($posts as $post)
      <div x-data="{ 
                open: false, 
                modal: false, 
                postLiked: {{ $post->isLikedBy(auth()->user()) ? 'true' : 'false' }}, 
                likesCount: {{ $post->likes()->count() }} 
               }"
        class="relative max-w-xl mx-auto mb-10 overflow-hidden transition-all bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md">

        {{-- Header Post --}}
        <div class="flex items-center justify-between p-4">
          <div class="flex items-center gap-3">
            {{-- Inisial User --}}
            <div
              class="flex items-center justify-center w-10 h-10 text-sm font-bold text-white rounded-full shadow-sm bg-gradient-to-tr from-purple-500 to-blue-500">
              {{ strtoupper(substr($post->user->username, 0, 1)) }}
            </div>
            <a href="{{ route('profile.show', $post->user->username) }}"
              class="font-bold text-gray-800 cursor-pointer hover:underline">
              {{ $post->user->username }}
            </a>
          </div>

          {{-- Tombol Titik 3 --}}
          <div class="relative">
            <button @click="open = !open" class="p-2 text-gray-400 transition hover:text-black">
              <i class="fa-solid fa-ellipsis"></i>
            </button>

            {{-- Dropdown --}}
            <div x-show="open" @click.away="open = false" x-transition
              class="absolute right-0 z-20 w-40 py-1 mt-2 bg-white border border-gray-100 shadow-xl rounded-xl">
              {{-- SHARE --}}
              <button
                onclick="navigator.share ? navigator.share({ url: '{{ route('posts.show', $post->id) }}' }) : alert('URL disalin!')"
                class="flex items-center w-full gap-3 px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-50">
                <i class="fa-solid fa-share-nodes"></i>
                <span>Bagikan</span>
              </button>

              {{-- DELETE --}}
              @if($post->user_id === auth()->id())
                <hr class="my-1 border-gray-100">
                <button @click="modal = true; open = false"
                  class="flex items-center w-full gap-3 px-4 py-2 text-sm text-red-500 transition hover:bg-red-50">
                  <i class="fa-solid fa-trash-can"></i>
                  <span>Hapus Post</span>
                </button>
              @endif
            </div>
          </div>
        </div>

        {{-- Media Post --}}
        <div class="relative flex items-center justify-center overflow-hidden bg-black group aspect-square lg:aspect-video">
          @if($post->file_type == 'image')
            <img src="{{ asset('storage/' . $post->file_path) }}" class="object-contain w-full h-full">
          @else
            <video controls class="object-contain w-full h-full">
              <source src="{{ asset('storage/' . $post->file_path) }}">
            </video>
          @endif
        </div>

        {{-- Interaksi (Like & Komen) --}}
        <div class="p-4">
          <div class="flex items-center gap-4 mb-3">
            {{-- TOMBOL LIKE --}}
            <button
              @click="let res = await toggleLike('{{ $post->id }}', 'post'); postLiked = (res.status === 'liked'); likesCount = res.count;"
              class="text-2xl transition-all duration-300 active:scale-150"
              :class="postLiked ? 'text-red-500' : 'text-gray-700 hover:text-red-500'">
              <i :class="postLiked ? 'fa-solid fa-heart' : 'fa-regular fa-heart'"></i>
            </button>

            {{-- TOMBOL KOMEN (Link ke Detail) --}}
            <a href="{{ route('posts.show', $post->id) }}" class="text-2xl text-gray-700 transition hover:text-blue-500">
              <i class="fa-regular fa-comment"></i>
            </a>
          </div>

          {{-- Info Like & Judul --}}
          <div class="space-y-1">
            <p class="text-sm font-bold text-gray-800" x-text="likesCount.toLocaleString() + ' suka'"></p>
            <h3 class="text-sm font-bold">{{ $post->title }}</h3>
            <p class="text-sm text-gray-600 line-clamp-2">{{ $post->description }}</p>

            {{-- Link Lihat Semua Komentar --}}
            <a href="{{ route('posts.show', $post->id) }}" class="block mt-2 text-xs text-gray-400 hover:underline">
              Lihat semua {{ $post->comments->count() }} komentar
            </a>
            <span
              class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $post->created_at->diffForHumans() }}</span>
          </div>
        </div>

        {{-- Modal Delete --}}
        <div x-show="modal" x-transition.opacity
          class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
          <div class="w-full max-w-xs overflow-hidden bg-white shadow-2xl rounded-2xl">
            <div class="p-6 text-center">
              <h2 class="text-lg font-bold text-gray-800">Hapus Postingan?</h2>
              <p class="mt-2 text-sm text-gray-500">Tindakan ini tidak bisa dibatalkan.</p>
            </div>
            <div class="flex flex-col border-t border-gray-100">
              <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                @csrf @method('DELETE')
                <button class="w-full py-3 text-sm font-bold text-red-600 transition hover:bg-red-50">Hapus</button>
              </form>
              <button @click="modal=false"
                class="w-full py-3 text-sm text-gray-600 transition border-t border-gray-100 hover:bg-gray-50">Batal</button>
            </div>
          </div>
        </div>

      </div>
    @endforeach
  </div>

  {{-- Script AJAX Like yang sama dengan halaman detail --}}
  <script>
    async function toggleLike(id, type) {
      try {
        let response = await fetch("{{ route('like.toggle') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
          body: JSON.stringify({
            id: id,
            type: type
          })
        });
        return await response.json();
      } catch (error) {
        console.error("Gagal melakukan like:", error);
        return {
          status: 'error',
          count: 0
        };
      }
    }
  </script>
@endsection