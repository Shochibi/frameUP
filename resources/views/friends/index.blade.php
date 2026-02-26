@extends('layouts.main')

@section('content')
<h2>Daftar User</h2>

@foreach($users as $user)
    <a href="{{ route('friends.show', $user->id) }}">
        {{ $user->username }}
    </a><br>
@endforeach

@endsection