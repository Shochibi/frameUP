<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>FrameUP @yield('title')</title>
  <link rel="icon" type="image/ico" href="{{ asset('images/logo2.ico') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  @vite('resources/css/app.css')
</head>

@include('upload')

<body class="bg-gray-100">

@if (!request()->routeIs('posts.show'))
    @include('partials.navbar')
@endif

<main class="flex justify-center min-h-screen">
    {{-- Jika halaman detail post, jangan kasih max-w-xl agar bisa full screen --}}
    <div class="{{ request()->routeIs('posts.show') ? 'w-full' : 'w-full max-w-xl py-8 px-4' }}">
        @yield('content')
    </div>
</main>

<script src="//unpkg.com/alpinejs" defer></script>

{{-- Footer opsional, biasanya dihilangkan saat mode modal/detail --}}
@if (!request()->routeIs('posts.show'))
<footer class="py-4 text-center text-gray-400">
    <p>&copy; 2026 Belajar Laravel</p>
</footer>
@endif

</body>
</html>