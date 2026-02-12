{{-- 1. Panggil Master Layout-nya --}}
@extends('layouts.main')

{{-- 2. Isi bagian title --}}
@section('title', 'Halaman Beranda')

{{-- 3. Isi bagian content --}}
@section('content')
<h1 class="text-3xl font-bold text-red-500 text-center">Selamat Meniknati Postingan</h1>
@foreach($posts as $post)
<div class="bg-white p-4 rounded-xl shadow mb-6 max-w-xl mx-auto">

    <h3 class="font-bold text-lg">{{ $post->title }}</h3>
    <p class="text-gray-600 mb-2">{{ $post->description }}</p>

    @if($post->file_type == 'image')
        <img src="{{ asset('storage/'.$post->file_path) }}" 
             class="w-400 h-50 rounded-lg object-contain">
    @else
        <video controls class="w-400 h-50 rounded-lg object-contain">
            <source src="{{ asset('storage/'.$post->file_path) }}">
        </video>
    @endif
        <form action="{{ route('post.delete', $post->id) }}" 
      method="POST" 
      onsubmit="return confirm('Yakin mau hapus?')">

    @csrf
    @method('DELETE')

    <button class="mt-2 text-red-500 hover:text-red-700">
        Hapus
    </button>
</form>

</div>
@endforeach

@endsection