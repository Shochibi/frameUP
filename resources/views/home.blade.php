{{-- 1. Panggil Master Layout-nya --}}
@extends('layouts.main')

{{-- 2. Isi bagian title --}}
@section('title', 'Halaman Beranda')

{{-- 3. Isi bagian content --}}
@section('content')
<h1 class="text-3xl font-bold text-red-500">Selamat Datang!</h1>
@endsection