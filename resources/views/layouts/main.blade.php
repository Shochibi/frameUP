<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>FrameUP @yield('title')</title>
  <link rel="icon" type="image/ico" href="{{ asset('images/logo2.ico') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
  .chat-box {
    height:400px;
    overflow-y:scroll;
    display:flex;
    flex-direction:column;
}

.chat-message {
    max-width:60%;
    padding:10px;
    margin:5px;
    border-radius:15px;
}

.me {
    background:#0095f6;
    color:white;
    align-self:flex-end;
}

.friend {
    background:#eee;
    align-self:flex-start;
}
</style>
@include('upload')

<body>
  @auth
    <div id="notifModal" style="
          display:none;
          position:fixed;
          top:0;
          left:0;
          width:100%;
          height:100%;
          background:rgba(0,0,0,0.4);
          justify-content:center;
          align-items:center;
          z-index:999;
      ">

      <div style="
              background:white;
              width:400px;
              max-height:500px;
              overflow-y:auto;
              border-radius:12px;
              padding:20px;
              box-shadow:0 10px 30px rgba(0,0,0,0.2);
          ">

        <div style="display:flex; justify-content:space-between; align-items:center;">
          <h3 style="margin:0;">Permintaan Pertemanan</h3>
          <button onclick="closeNotifModal()"
            style="border:none; background:none; font-size:18px; cursor:pointer;">✖</button>
        </div>

        <hr style="margin:15px 0;">

        @forelse(auth()->user()->friendRequests as $request)
            <div style="
                              display:flex;
                              justify-content:space-between;
                              align-items:center;
                              margin-bottom:15px;
                              padding:10px;
                              border-radius:8px;
                              background:#f5f5f5;
                          ">

              <div>
                <strong>{{ $request->username }}</strong>
              </div>

              <div style="display:flex; gap:8px;">

                {{-- TERIMA --}}
                <form action="{{ route('friend.accept', $request->id) }}" method="POST">
                  @csrf
                  <button type="submit" style="
                    background:#4CAF50;
                    color:white;
                    border:none;
                    padding:6px 12px;
                    border-radius:6px;
                    cursor:pointer;
          ">
                    Terima
                  </button>
                </form>

                {{-- TOLAK --}}
                <form action="{{ route('friend.reject', $request->id) }}" method="POST">
                  @csrf
                  <button type="submit" style="
                      background:#f44336;
                      color:white;
                      border:none;
                      padding:6px 12px;
                      border-radius:6px;
                      cursor:pointer;
                  ">
                    Tolak
                  </button>
                </form>

              </div>
            </div>
        @empty
          <p style="text-align:center; color:gray;">Tidak ada permintaan</p>
        @endforelse

      </div>
    </div>
  @endauth

  <script>
    function openNotifModal() {
      document.getElementById('notifModal').style.display = 'flex';
    }

    function closeNotifModal() {
      document.getElementById('notifModal').style.display = 'none';
    }

    // klik luar modal buat nutup
    window.onclick = function (event) {
      const modal = document.getElementById('notifModal');
      if (event.target === modal) {
        modal.style.display = "none";
      }
    }
  </script>

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