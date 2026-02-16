<div class="flex">
  <aside
    class="fixed left-0 top-0 h-screen lg:w-64 border-r border-gray-200 bg-white flex flex-col p-3 transition-all duration-300">

    <a href="{{ route('home') }}" class="mb-10 px-2 mt-4 flex items-center group">
      <img src="{{ asset('images/logo2.png') }}" alt="logo FrameUP"
        class="w-20 h-20 object-contain transition-transform group-hover:scale-105">
      <h1 class="text-xl font-bold hidden lg:block italic">FrameUP</h1>
    </a>

    <nav class="flex-1 space-y-2">
      <a href="{{ route('home') }}" class="flex items-center p-3 hover:bg-gray-100 rounded-lg group transition">
        <i class="fa-solid fa-house text-xl"></i>
        <span class="ml-4 hidden lg:block font-medium">Beranda</span>
      </a>

      <a href="{{ route('friend') }}" class="flex items-center p-3 hover:bg-gray-100 rounded-lg group transition">
        <i class="fa-solid fa-user-group text-xl"></i>
        <span class="ml-4 hidden lg:block">Teman</span>
      </a>

      <a href="{{ route('posts.explore') }}" class="flex items-center p-3 hover:bg-gray-100 rounded-lg group transition">
        <i class="fa-solid fa-compass text-xl"></i>
        <span class="ml-4 hidden lg:block">Jelajahi</span>
      </a>

      <button onclick="openModal()" class="w-full flex items-center p-3 hover:bg-gray-100 rounded-lg group transition">
        <i class="fa-solid fa-plus-square text-xl"></i>
        <span class="ml-4 hidden lg:block">Upload</span>
      </button>
    </nav>

    <div class="mt-auto">
      @auth
      <form action="/logout" method="POST">
        @csrf
        <button type="submit"  class="bg-blue-600 p-3 rounded-10 hover:bg-blue-950 text-white">Logout</button>
      </form>
      @endauth
      <a href="#" class="flex items-center p-3 hover:bg-gray-100 rounded-lg group transition">
        <i class="fa-regular fa-circle-user text-xl"></i>
        <span class="ml-4 hidden lg:block">Profile</span>
      </a>
      <a href="#" class="flex items-center p-3 hover:bg-gray-100 rounded-lg group transition">
        <i class="fa-solid fa-gear text-xl"></i>
        <span class="ml-4 hidden lg:block">Setting</span>
      </a>
    </div>
  </aside>

</div>