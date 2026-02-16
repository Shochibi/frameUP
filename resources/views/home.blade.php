{{-- 1. Panggil Master Layout-nya --}}
@extends('layouts.main')

{{-- 2. Isi bagian title --}}
@section('title', 'Halaman Beranda')

{{-- 3. Isi bagian content --}}
@section('content')
  <h1 class="text-center text-5xl font-bold mt-10 mb-10">Selamat Datang, {{ auth()->user()->username }}!</h1>
  <h1 class="text-3xl font-bold text-red-500 text-center mb-5">Selamat Menikmati Postingan</h1>
  @foreach($posts as $post)
    <div x-data="{ open:false, modal:false }" class="bg-white p-4 rounded-xl shadow mb-6 max-w-xl mx-auto relative">

      {{-- Tombol Titik 3 --}}
      <div class="absolute top-3 right-3">
        <button @click="open = !open" class="text-gray-600 hover:text-black text-xl">
          ⋮
        </button>

        {{-- Dropdown --}}
        <div x-show="open" @click.away="open = false"
          class="absolute right-0 mt-2 w-32 bg-white border rounded-lg shadow-lg z-10">
          {{-- SHARE --}}
          <button onclick="navigator.share ? navigator.share({ url: window.location.href }) : alert('Copy URL manual ya')"
            class="flex items-center gap-3 w-full px-4 py-2 hover:bg-gray-100 text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
              class="w-5 h-5 text-current">
              <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H9M17 7V15" />
            </svg>

            <span>Share</span>
          </button>

          {{-- DELETE --}}
          @if($post->user_id === auth()->id())
    <button @click="modal = true; open=false"
        class="flex items-center gap-3 w-full px-4 py-2 hover:bg-gray-100 text-red-500">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5 text-current">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M6 7h12M9 7V4h6v3m-7 4v6m4-6v6m4-6v6M5 7h14l-1 12H6L5 7z" />
        </svg>

        <span>Delete</span>
    </button>
@endif


        </div>
      </div>

      {{-- Konten Post --}}
      <div class="flex items-center gap-2 mb-8 ">
        <span class=" font-semibold text-sm text-gray-800">
          {{ $post->user->username }}
        </span>
      </div>

      @if($post->file_type == 'image')
        <img src="{{ asset('storage/' . $post->file_path) }}" class="w-full max-h-96 rounded-lg object-contain">
      @else
        <video controls class="w-full max-h-96 rounded-lg object-contain">
          <source src="{{ asset('storage/' . $post->file_path) }}">
        </video>
      @endif

      <h3 class="font-bold text-lg mt-5">{{ $post->title }}</h3>

      <p class="text-gray-600 mb-10">{{ $post->description }}</p>

        {{-- KOMEN --}}
      <a href="{{ route('posts.show', $post->id) }}" class="flex items-center gap-1 text-gray-600 hover:text-black mt-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M8.625 9h6.75M8.625 12h4.5m-7.5 8.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
        </svg>

        <span>{{ $post->comments->count() }}</span>
      </a>

      {{-- Modal Delete --}}
      <div x-show="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-xl w-80">
          <h2 class="text-lg font-bold mb-3">Hapus Postingan?</h2>
          <p class="text-gray-600 mb-4">Yakin mau hapus postingan ini?</p>

          <div class="flex justify-end gap-3">
            <button @click="modal=false" class="px-4 py-2 bg-gray-200 rounded-lg">
              Batal
            </button>

            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
              @csrf
              @method('DELETE')

              <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                Hapus
              </button>
            </form>

          </div>
        </div>
      </div>

    </div>
  @endforeach

@endsection