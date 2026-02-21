<div class="flex">
  <aside
    class="fixed top-0 left-0 flex flex-col h-screen p-3 transition-all duration-300 bg-white border-r border-gray-200 lg:w-64">

    <a href="{{ route('home') }}" class="flex items-center px-2 mt-4 mb-10 group">
      <img src="{{ asset('images/logo2.png') }}" alt="logo FrameUP"
        class="object-contain w-20 h-20 transition-transform group-hover:scale-105">
      <h1 class="hidden text-xl italic font-bold lg:block">FrameUP</h1>
    </a>

    <nav class="flex-1 space-y-2">
      <a href="{{ route('home') }}" class="flex items-center p-3 transition rounded-lg hover:bg-gray-100 group">
        <i class="text-xl fa-solid fa-house"></i>
        <span class="hidden ml-4 font-medium lg:block">Beranda</span>
      </a>

      <a href="{{ route('friend') }}" class="flex items-center p-3 transition rounded-lg hover:bg-gray-100 group">
        <i class="text-xl fa-solid fa-user-group"></i>
        <span class="hidden ml-4 lg:block">Teman</span>
      </a>

      <a href="{{ route('posts.explore') }}" class="flex items-center p-3 transition rounded-lg hover:bg-gray-100 group">
        <i class="text-xl fa-solid fa-compass"></i>
        <span class="hidden ml-4 lg:block">Jelajahi</span>
      </a>

      <button onclick="openModal()" class="flex items-center w-full p-3 transition rounded-lg hover:bg-gray-100 group">
        <i class="text-xl fa-solid fa-plus-square"></i>
        <span class="hidden ml-4 lg:block">Upload</span>
      </button>
    </nav>

    <div class="mt-auto">
      <a href="{{ route('profile') }}" class="flex items-center p-3 transition rounded-lg hover:bg-gray-100 group">
        <i class="text-xl fa-regular fa-circle-user"></i>
        <span class="hidden ml-4 lg:block">Profile</span>
      </a>
      <a href="#" class="flex items-center p-3 transition rounded-lg hover:bg-gray-100 group">
        <i class="text-xl fa-solid fa-gear"></i>
        <span class="hidden ml-4 lg:block">Setting</span>
      </a>
    </div>
  </aside>
  
</div>