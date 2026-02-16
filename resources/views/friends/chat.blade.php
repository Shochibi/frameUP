@extends('layouts.main')

@section('title', 'Chat')

@section('content')

<h2>Chat dengan {{ $friend->username }}</h2>

<div style="border:1px solid #ddd; padding:15px; height:300px;">
    <p>Pesan akan tampil di sini...</p>
</div>

<form style="margin-top:15px;">
    <input type="text" placeholder="Ketik pesan..." style="width:80%;">
    <button type="submit">Kirim</button>
</form>

@endsection
