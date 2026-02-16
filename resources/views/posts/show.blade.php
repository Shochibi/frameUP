@extends('layouts.komen')

@section('title', 'Detail Post')

@section('content')
<div class="fixed inset-0 z-[999] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-lg" onclick="history.back()"></div>

    <div class="relative z-[1000] flex flex-col w-[95%] lg:w-[90%] max-w-6xl h-[90vh] bg-white shadow-2xl rounded-3xl overflow-hidden lg:flex-row border border-white/20">

        {{-- Sisi Kiri: Media --}}
        <div class="relative flex items-center justify-center w-full shadow-inner bg-neutral-950 h-1/2 lg:h-full lg:w-2/3">
            @if($post->file_type == 'image')
                <img src="{{ asset('storage/' . $post->file_path) }}" class="object-contain w-full h-full">
            @else
                <video controls class="object-contain w-full h-full shadow-2xl">
                    <source src="{{ asset('storage/' . $post->file_path) }}">
                </video>
            @endif
        </div>

        {{-- Sisi Kanan: Panel Interaksi --}}
        <div class="relative flex flex-col w-full bg-white h-1/2 lg:h-full lg:w-1/3" 
             x-data="{ 
                replyingTo: null, 
                replyName: '',
                postLiked: {{ $post->isLikedBy(auth()->user()) ? 'true' : 'false' }}, 
                likesCount: {{ $post->likes()->count() }} 
             }">

            {{-- 1. Header User --}}
            <div class="flex items-center p-5 bg-white border-b border-gray-100">
                <div class="flex items-center justify-center w-10 h-10 mr-3 text-sm font-bold text-white rounded-full shadow-md bg-gradient-to-tr from-blue-600 to-purple-500">
                    {{ strtoupper(substr($post->user->username, 0, 1)) }}
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-extrabold leading-none text-gray-900">{{ $post->user->username }}</span>
                    <span class="text-[10px] text-blue-500 font-medium mt-1 uppercase tracking-widest">Kontributor</span>
                </div>
                <button onclick="history.back()" class="flex items-center justify-center w-8 h-8 ml-auto text-gray-400 transition-all rounded-full hover:bg-gray-100 hover:text-red-500">
                    <i class="text-lg fa-solid fa-xmark"></i>
                </button>
            </div>

            {{-- 2. Area Scrollable --}}
            <div class="flex-1 p-5 overflow-y-auto bg-white pb-44 custom-scrollbar">
                {{-- Deskripsi Postingan --}}
                <div class="mb-6">
                    <div class="flex items-start gap-3">
                        <span class="text-sm font-black text-gray-900">{{ $post->user->username }}</span>
                        <p class="text-sm leading-relaxed text-gray-600">{{ $post->description }}</p>
                    </div>
                    <span class="text-[10px] text-gray-400 uppercase font-bold mt-2 block tracking-tight">{{ $post->created_at->diffForHumans() }}</span>
                </div>

                <div class="flex items-center gap-4 mb-6">
                    <hr class="flex-1 border-gray-100">
                    <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">Komentar</span>
                    <hr class="flex-1 border-gray-100">
                </div>

                {{-- List Komentar --}}
                <div class="space-y-8">
                    @foreach($post->comments->whereNull('parent_id')->sortByDesc('created_at') as $comment)
                        <div class="flex flex-col group" x-data="{ 
                            commentLiked: {{ $comment->isLikedBy(auth()->user()) ? 'true' : 'false' }}, 
                            commentLikesCount: {{ $comment->likes()->count() }},
                            openMenu: false 
                        }">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-sm font-bold text-gray-900">{{ $comment->user->username }}</span>
                                        <span class="text-[10px] text-gray-400 font-medium">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm leading-snug text-gray-700">{{ $comment->comment }}</p>

                                    <div class="flex items-center gap-5 mt-3">
                                        <div class="flex items-center gap-1.5">
                                            <button @click="let res = await toggleLike('{{ $comment->id }}', 'comment'); commentLiked = (res.status === 'liked'); commentLikesCount = res.count;"
                                                class="transition-all active:scale-150"
                                                :class="commentLiked ? 'text-red-500' : 'text-gray-300 hover:text-red-400'">
                                                <i :class="commentLiked ? 'fa-solid fa-heart' : 'fa-regular fa-heart'" class="text-[12px]"></i>
                                            </button>
                                            <span class="text-[11px] font-bold text-gray-400" x-text="commentLikesCount"></span>
                                        </div>

                                        <button @click="replyingTo = '{{ $comment->id }}'; replyName = '{{ $comment->user->username }}'; document.getElementById('commentInput').focus()"
                                            class="text-[11px] font-black text-blue-500 hover:text-blue-700 uppercase">
                                            Balas
                                        </button>
                                    </div>
                                </div>

                                {{-- FITUR TITIK TIGA KOMENTAR UTAMA --}}
                                <div class="relative">
                                    <button @click="openMenu = !openMenu" @click.away="openMenu = false" class="p-1 text-gray-300 transition-colors hover:text-gray-600">
                                        <i class="text-xs fa-solid fa-ellipsis-vertical"></i>
                                    </button>

                                    <div x-show="openMenu" x-transition class="absolute right-0 z-50 w-32 py-1 mt-1 bg-white border border-gray-100 shadow-xl rounded-xl">
                                        {{-- Tombol Share --}}
                                        <button onclick="copyToClipboard('{{ route('posts.show', $post->id) }}')" class="flex items-center w-full px-4 py-2 text-[11px] font-bold text-gray-700 hover:bg-gray-50">
                                            <i class="w-4 fa-solid fa-share-nodes mr-1.5"></i> Share
                                        </button>
                                        
                                        {{-- Tombol Hapus (Hanya untuk pemilik komen atau pemilik post) --}}
                                        @if(auth()->id() == $comment->user_id || auth()->id() == $post->user_id)
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="flex items-center w-full px-4 py-2 text-[11px] font-bold text-red-600 hover:bg-red-50">
                                                    <i class="w-4 fa-solid fa-trash-can mr-1.5"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Tampilan Balasan (Replies) --}}
                            <div class="pl-5 mt-4 ml-2 space-y-5 border-l-2 border-gray-50">
                                @foreach($comment->replies->sortBy('created_at') as $reply)
                                    <div class="flex flex-col group/reply" x-data="{ 
                                        replyLiked: {{ $reply->isLikedBy(auth()->user()) ? 'true' : 'false' }}, 
                                        replyLikesCount: {{ $reply->likes()->count() }},
                                        openReplyMenu: false 
                                    }">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-xs font-bold text-gray-900">{{ $reply->user->username }}</span>
                                                    <i class="fa-solid fa-caret-right text-[8px] text-gray-300"></i>
                                                    <span class="text-xs font-bold text-blue-400">{{ $comment->user->username }}</span>
                                                </div>
                                                <p class="text-xs leading-snug text-gray-600">{{ $reply->comment }}</p>

                                                <div class="flex items-center gap-4 mt-2">
                                                    <span class="text-[9px] text-gray-400 font-medium">{{ $reply->created_at->diffForHumans() }}</span>
                                                    <div class="flex items-center gap-1.5">
                                                        <button @click="let res = await toggleLike('{{ $reply->id }}', 'comment'); replyLiked = (res.status === 'liked'); replyLikesCount = res.count;"
                                                            class="transition-all active:scale-150"
                                                            :class="replyLiked ? 'text-red-500' : 'text-gray-300 hover:text-red-400'">
                                                            <i :class="replyLiked ? 'fa-solid fa-heart' : 'fa-regular fa-heart'" class="text-[10px]"></i>
                                                        </button>
                                                        <span class="text-[9px] font-bold text-gray-400" x-text="replyLikesCount"></span>
                                                    </div>
                                                    <button @click="replyingTo = '{{ $comment->id }}'; replyName = '{{ $reply->user->username }}'; document.getElementById('commentInput').focus()"
                                                        class="text-[9px] font-black text-blue-600 hover:text-blue-800 uppercase tracking-tighter">
                                                        Balas
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- FITUR TITIK TIGA BALASAN (REPLY) --}}
                                            <div class="relative">
                                                <button @click="openReplyMenu = !openReplyMenu" @click.away="openReplyMenu = false" class="p-1 text-gray-300 hover:text-gray-600">
                                                    <i class="text-[10px] fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <div x-show="openReplyMenu" x-transition class="absolute right-0 z-50 py-1 mt-1 bg-white border border-gray-100 shadow-xl w-28 rounded-xl">
                                                    {{-- Share Reply --}}
                                                    <button onclick="copyToClipboard('{{ route('posts.show', $post->id) }}')" class="flex items-center w-full px-3 py-2 text-[10px] font-bold text-gray-700 hover:bg-gray-50">
                                                        <i class="w-3 fa-solid fa-share mr-1.5"></i> Share
                                                    </button>
                                                    {{-- Hapus Reply --}}
                                                    @if(auth()->id() == $reply->user_id || auth()->id() == $post->user_id)
                                                        <form action="{{ route('comments.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Hapus balasan ini?')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="flex items-center w-full px-3 py-2 text-[10px] font-bold text-red-600 hover:bg-red-50">
                                                                <i class="w-3 fa-solid fa-trash-can mr-1.5"></i> Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- 3. Area Fixed Bottom (Action Panel) --}}
            <div class="absolute bottom-0 left-0 right-0 bg-white/80 backdrop-blur-md border-t border-gray-100 p-5 shadow-[0_-15px_30px_rgba(0,0,0,0.03)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-5">
                        <button @click="let res = await toggleLike('{{ $post->id }}', 'post'); postLiked = (res.status === 'liked'); likesCount = res.count;"
                            class="text-2xl transition-all duration-300 active:scale-150"
                            :class="postLiked ? 'text-red-500' : 'text-gray-700 hover:text-red-500'">
                            <i :class="postLiked ? 'fa-solid fa-heart' : 'fa-regular fa-heart'"></i>
                        </button>
                        <button class="text-2xl text-gray-700 hover:text-blue-500" onclick="document.getElementById('commentInput').focus()">
                            <i class="fa-regular fa-comment text-[22px]"></i>
                        </button>
                    </div>
                    <span class="text-sm font-black text-gray-900" x-text="likesCount.toLocaleString() + ' suka'"></span>
                </div>

                {{-- Indikator Membalas --}}
                <div x-show="replyingTo" x-transition class="flex items-center justify-between px-4 py-2 mb-3 bg-blue-600 shadow-lg rounded-xl">
                    <span class="text-[10px] text-white font-bold">
                        Membalas <span class="italic underline" x-text="replyName"></span>
                    </span>
                    <button @click="replyingTo = null; replyName = ''" class="text-white/80 hover:text-white">
                        <i class="text-sm fa-solid fa-circle-xmark"></i>
                    </button>
                </div>

                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="flex items-center gap-3">
                    @csrf
                    <input type="hidden" name="parent_id" :value="replyingTo">
                    <div class="relative flex-1 group">
                        <input type="text" id="commentInput" name="comment" placeholder="Tulis komentar..."
                            class="w-full px-5 py-3 text-sm transition-all bg-gray-100 border-none outline-none rounded-2xl focus:bg-white focus:ring-2 focus:ring-blue-500" 
                            required autofocus>
                    </div>
                    <button class="flex items-center justify-center text-white transition-all bg-blue-600 w-11 h-11 rounded-2xl hover:bg-blue-700 active:scale-90">
                        <i class="text-sm fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT COPY TO CLIPBOARD --}}
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Link postingan berhasil disalin!');
        });
    }

    async function toggleLike(id, type) {
        try {
            let response = await fetch("{{ route('like.toggle') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ id: id, type: type })
            });
            return await response.json();
        } catch (error) {
            console.error("Gagal melakukan like:", error);
            return { status: 'error', count: 0 };
        }
    }
</script>

<style>
    body { overflow: hidden !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 20px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #d1d5db; }
</style>
@endsection