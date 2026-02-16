@extends('layouts.main')

@section('title', 'Friend')

@section('content')

<div style="max-width:900px; margin:auto;">

    <h2>Teman Saya</h2>

    <form method="GET" style="margin-bottom:20px;">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari teman..."
               style="padding:8px; width:60%;">
        <button type="submit">Cari</button>
    </form>

    <div style="display:flex; gap:20px;">

        {{-- KOLOM TEMAN --}}
        <div style="flex:1; border:1px solid #eee; padding:15px; border-radius:8px;">
            <h3>Daftar Teman</h3>

            @forelse($friends as $friend)

<div style="margin-bottom:10px; display:flex; justify-content:space-between; align-items:center;">
    <span>{{ $friend->username }}</span>

    <div style="display:flex; gap:5px;">
        <a href="{{ route('chat', $friend->id) }}">
            <button>Kirim Pesan</button>
        </a>

        <form action="{{ url('/remove-friend/'.$friend->id) }}" method="POST">
            @csrf
            <button type="submit" style="background:#ff4d4d; color:white;">
                Hapus
            </button>
        </form>
    </div>
</div>

@empty

                <p>Belum punya teman.</p>
            @endforelse
        </div>

        {{-- KOLOM REKOMENDASI --}}
        <div style="flex:1; border:1px solid #eee; padding:15px; border-radius:8px;">
            <h3>Rekomendasi</h3>

            @forelse($recommended as $user)

                <div style="margin-bottom:15px; display:flex; justify-content:space-between; align-items:center;">
                    <span>{{ $user->username }}</span>

                    @php
                        $status = auth()->user()->friendshipStatus($user->id);
                    @endphp

                    @if(!$status)
                        <form action="{{ url('/add-friend/'.$user->id) }}" method="POST">
                            @csrf
                            <button type="submit">Tambah</button>
                        </form>

                    @elseif($status === 'pending')
                        <button disabled>Menunggu</button>

                    @elseif($status === 'accepted')
                        <a href="{{ route('chat', $user->id) }}">
                            <button>Chat</button>
                        </a>
                    @endif
                </div>

            @empty
                <p>Tidak ada user.</p>
            @endforelse
        </div>

    </div>

    <hr style="margin:30px 0;">

    <h3>Permintaan Pertemanan</h3>

    @forelse(auth()->user()->friendRequests as $request)

        <div style="margin-bottom:10px; display:flex; justify-content:space-between;">
            <span>{{ $request->username }}</span>

            <form action="{{ url('/accept-friend/'.$request->id) }}" method="POST">
                @csrf
                <button type="submit">Terima</button>
            </form>
        </div>

    @empty
        <p>Tidak ada request masuk.</p>
    @endforelse

</div>

@endsection
