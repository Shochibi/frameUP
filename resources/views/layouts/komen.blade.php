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
@if (!request()->routeIs('posts.show'))
    @include('partials.navbar')
@endif

  <main class="flex justify-center bg-white min-h-screen">
    <div class="w-full max-w-xl py-8 px-4">
        @yield('content')
    </div>
</main>

  <script src="//unpkg.com/alpinejs" defer></script>

  <footer>
    <p>&copy; 2026 Belajar Laravel</p>
  </footer>

  
<script>
function goBack() {
    fetch("/")
        .then(response => response.text())
        .then(html => {

            // Ambil isi main-content dari halaman home
            let parser = new DOMParser();
            let doc = parser.parseFromString(html, 'text/html');
            let newContent = doc.querySelector('#main-content').innerHTML;

            // Ganti isi halaman sekarang
            document.querySelector('#main-content').innerHTML = newContent;

            // Update URL tanpa reload
            window.history.pushState({}, "", "/");
        });
}
</script>

</body>

</html>