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

  <main class="ml-20 lg:ml-64 flex-1 bg-white min-h-screen">
    <div class="max-w-2xl mx-auto py-8">
      @yield('content')
    </div>
  </main>

  <footer>
    <p>&copy; 2026 Belajar Laravel</p>
  </footer>

</body>

</html>