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
<body>

  {{-- navbar --}}
  @include('partials.navbar')

  <main class="flex-1 min-h-screen ml-20 bg-white lg:ml-64">
    <div class="max-w-2xl py-8 mx-auto">
      @yield('content')
    </div>
  </main>
  <script src="//unpkg.com/alpinejs" defer></script>

  <footer>
    <p>&copy; 2026 Belajar Laravel</p>
  </footer>

</body>

</html>