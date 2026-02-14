@extends('layouts.komen')

@section('title', 'Detail Post')

@section('content')

        <button onclick="history.back()" class="fixed top-6 left-24 lg:left-10 
                   bg-white shadow px-4 py-2 
                   rounded-lg text-sm 
                   hover:bg-gray-100 z-50">
            ← Kembali
        </button>

<div>

        <div class="bg-white p-4 rounded-xl shadow mt-6">

            {{-- USER --}}
            <div class="font-semibold text-sm mb-8">
                {{ $post->user->username }}
            </div>

            {{-- FILE --}}
            @if($post->file_type == 'image')
                <img src="{{ asset('storage/' . $post->file_path) }}" class="w-full max-h-96 rounded-lg object-contain">
            @else
                <video controls class="w-full max-h-96 rounded-lg object-contain">
                    <source src="{{ asset('storage/' . $post->file_path) }}">
                </video>
            @endif

            {{-- TITLE --}}
            <h2 class="font-bold text-lg mt-5">{{ $post->title }}</h2>

            {{-- DESCRIPTION --}}
            <p class="text-gray-600 mb-5">{{ $post->description }}</p>

            <hr class="my-4">

            {{-- FORM COMMENT --}}
            <div class="fixed bottom-0 left-0 right-0 
                flex justify-center 
                bg-white border-t py-3 z-50">

                <div class="w-full max-w-xl px-4">
                    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="comment" placeholder="Tulis komentar..."
                            class="flex-1 border rounded-lg px-3 py-2 text-sm" required>
                        <button class="bg-blue-500 text-white px-4 rounded-lg text-sm">
                            Kirim
                        </button>
                    </form>
                </div>
            </div>



            {{-- LIST COMMENT --}}
            <div class="mt-4 space-y-3  ">
                <h3 class="font-bold text-center">💬 KOLOM KOMENTAR</h3>

                @foreach($post->comments->whereNull('parent_id') as $comment)
                    <div class="bg-gray-100 p-3 rounded-lg">

                        <strong>{{ $comment->user->username }}</strong>
                        <p class="text-sm text-gray-700">
                            {{ $comment->comment }}
                        </p>

                        {{-- Replies --}}
                        @foreach($comment->replies as $reply)
                            <div class="ml-6 mt-2 bg-gray-200 p-2 rounded-lg">
                                <strong>{{ $reply->user->username }}</strong>
                                <p class="text-sm">{{ $reply->comment }}</p>
                            </div>
                        @endforeach

                    </div>
                @endforeach

            </div>

        </div>

    </div>

@endsection