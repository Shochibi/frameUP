@extends('layouts.main')

@section('title', 'Friend')

@section('content')

    <div style="max-width:1100px; margin:auto; display:flex; border:2px solid #000; min-height:600px;">

        {{-- CONTENT --}}
        <div style="flex:1; padding:30px;">

            {{-- SEARCH BAR --}}
            <form method="GET" style="display:flex; gap:10px; margin-bottom:20px;">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari username 🔎"
                    style="flex:1; padding:10px; border-radius:20px; border:2px solid #000;">
                <button type="submit" style="padding:10px 20px; border:2px solid #000; background:white; cursor:pointer;">
                    Cari
                </button>
            </form>


            {{-- TAB HEADER --}}
            <div style="display:flex; gap:40px; margin-bottom:20px; font-size:20px; font-weight:bold;">

                <div id="tabFriends" onclick="switchTab('friends')"
                    style="cursor:pointer; border-bottom:4px solid red; padding-bottom:5px; color:red;">
                    Daftar Teman
                </div>

                <div id="tabRecommend" onclick="switchTab('recommend')"
                    style="cursor:pointer; border-bottom:4px solid transparent; padding-bottom:5px;">
                    Rekomendasi
                </div>

                @auth
                    <li style="position:relative; list-style:none; margin-left:auto;">

                        <button onclick="openNotifModal()"
                            style="background:none; border:none; cursor:pointer; font-size:22px;">
                            <i class="fa-solid fa-bell"
                                style="border:solid black 2px; padding:8px; font-size: 30px; color: #9400D3; background-color:rgba(15, 151, 255, 0.18)"></i>
                        </button>

                        @if(auth()->user()->friendRequests->count() > 0)
                            <span style="
                                            position:absolute;
                                            top:-5px;
                                            right:-8px;
                                            background:red;
                                            color:white;
                                            font-size:12px;
                                            padding:3px 6px;
                                            border-radius:50%;
                                        ">
                                {{ auth()->user()->friendRequests->count() }}
                            </span>
                        @endif

                    </li>
                @endauth

            </div>


            {{-- CONTENT TAB --}}
            <div>

                {{-- DAFTAR TEMAN --}}
                <div id="friendsContent">

                    @forelse($friends as $friend)
                        <div
                            style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #ccc;">
                            <span style="font-size:18px;">
                                {{ $friend->username }}
                            </span>

                            <div style="display:flex; gap:10px;">
                                <a href="{{ route('.friends.chat', $friend->id) }}">
                                    <button style="padding:6px 12px; cursor:pointer;">
                                        Kirim Pesan
                                    </button>
                                </a>

                                <form action="{{ url('/remove-friend/' . $friend->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        style="padding:6px 12px; background:#ff4d4d; color:white; border:none; cursor:pointer;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p style="margin-left: 250px; margin-top: 200px;">Belum punya teman.</p>
                    @endforelse

                </div>


                {{-- REKOMENDASI --}}
                <div id="recommendContent" style="display:none;">

                    @forelse($recommended as $user)

                        <div
                            style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #ccc;">

                            <span style="font-size:18px;">
                                {{ $user->username }}
                            </span>

                            @php
                                $status = auth()->user()->friendshipStatus($user->id);
                            @endphp

                            @if(!$status)
                                <form action="{{ url('/add-friend/' . $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="padding:6px 12px; cursor:pointer;">
                                        Tambah
                                    </button>
                                </form>

                            @elseif($status === 'pending')
                                <button disabled style="padding:6px 12px;">
                                    Menunggu
                                </button>

                            @elseif($status === 'accepted')
                                <a href="{{ route('chat', $user->id) }}">
                                    <button style="padding:6px 12px;">
                                        Chat
                                    </button>
                                </a>
                            @endif

                        </div>

                    @empty
                        <p style="margin-left: 250px; margin-top: 200px;">Tidak ada user.</p>
                    @endforelse

                </div>

            </div>

        </div>

    </div>

    <script>
        function switchTab(tab) {

            const friends = document.getElementById('friendsContent');
            const recommend = document.getElementById('recommendContent');

            const tabFriends = document.getElementById('tabFriends');
            const tabRecommend = document.getElementById('tabRecommend');

            if (tab === 'friends') {
                friends.style.display = 'block';
                recommend.style.display = 'none';

                tabFriends.style.borderBottom = '4px solid red';
                tabFriends.style.color = 'red';

                tabRecommend.style.borderBottom = '4px solid transparent';
                tabRecommend.style.color = 'black';
            } else {
                friends.style.display = 'none';
                recommend.style.display = 'block';

                tabRecommend.style.borderBottom = '4px solid red';
                tabRecommend.style.color = 'red';

                tabFriends.style.borderBottom = '4px solid transparent';
                tabFriends.style.color = 'black';
            }
        }
    </script>
@endsection