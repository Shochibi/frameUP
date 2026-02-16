<style>
    .modal-active { overflow: hidden; }
    .error-message { animation: fadeIn 0.3s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity bg-gray-900/60 backdrop-blur-sm">
  <div class="w-full max-w-md p-8 mx-4 transition-all transform bg-white shadow-2xl rounded-2xl">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Profil</h2>
        <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600"><i class="text-xl fa-solid fa-xmark"></i></button>
    </div>

    <form onsubmit="submitEditForm(event)" class="space-y-5">
      @csrf
      <div>
        <label for="editUsername" class="block mb-1.5 text-sm font-semibold text-gray-700">Username</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fa-solid fa-at"></i></span>
            <input type="text" id="editUsername" name="username" value="{{ auth()->user()->username }}"
              class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
        </div>
        <span class="text-xs font-medium text-red-500 error-message" id="usernameError"></span>
      </div>

      <div>
        <label for="editEmail" class="block mb-1.5 text-sm font-semibold text-gray-700">Email</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" id="editEmail" name="email" value="{{ auth()->user()->email }}"
              class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
        </div>
        <span class="text-xs font-medium text-red-500 error-message" id="emailError"></span>
      </div>

      <div class="flex gap-3 pt-2">
        <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
          Batal
        </button>
        <button type="submit" id="saveProfileBtn" class="flex-1 px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all active:scale-95">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

<div id="verifyPasswordModal" class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity bg-gray-900/60 backdrop-blur-sm">
  <div class="w-full max-w-md p-8 mx-4 bg-white shadow-2xl rounded-2xl">
    <div class="mb-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 mb-4 text-purple-600 bg-purple-100 rounded-full">
            <i class="text-2xl fa-solid fa-shield-check"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Verifikasi Keamanan</h2>
        <p class="mt-2 text-sm text-gray-500">Masukkan password lama Anda untuk melanjutkan.</p>
    </div>

    <form onsubmit="verifyOldPassword(event)" class="space-y-5">
      @csrf
      <div>
        <label for="oldPassword" class="block mb-1.5 text-sm font-semibold text-gray-700 text-left">Password Lama</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fa-solid fa-lock"></i></span>
            <input type="password" id="oldPassword" name="old_password" placeholder="••••••••"
              class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all outline-none">
        </div>
        <span class="text-xs font-medium text-red-500 error-message" id="oldPasswordError"></span>
      </div>

      <div class="flex gap-3 pt-2">
        <button type="button" onclick="closePasswordModal()" class="flex-1 px-4 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
          Batal
        </button>
        <button type="submit" id="verifyBtn" class="flex-1 px-4 py-2.5 text-sm font-bold text-white bg-purple-600 rounded-xl hover:bg-purple-700 shadow-lg shadow-purple-200 transition-all active:scale-95">
          Verifikasi
        </button>
      </div>
    </form>
  </div>
</div>

<div id="changePasswordModal" class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity bg-gray-900/60 backdrop-blur-sm">
  <div class="w-full max-w-md p-8 mx-4 bg-white shadow-2xl rounded-2xl">
    <div class="flex items-center gap-3 mb-6">
        <i class="text-xl text-purple-600 fa-solid fa-key"></i>
        <h2 class="text-2xl font-bold text-gray-800">Password Baru</h2>
    </div>

    <form onsubmit="submitPasswordForm(event)" class="space-y-5">
      @csrf
      <div>
        <label for="newPassword" class="block mb-1.5 text-sm font-semibold text-gray-700">Password Baru</label>
        <input type="password" id="newPassword" name="password" placeholder="Minimal 5 karakter"
          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all outline-none">
        <span class="text-xs font-medium text-red-500 error-message" id="newPasswordError"></span>
      </div>

      <div>
        <label for="confirmPassword" class="block mb-1.5 text-sm font-semibold text-gray-700">Konfirmasi Password</label>
        <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Ulangi password baru"
          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all outline-none">
        <span class="text-xs font-medium text-red-500 error-message" id="confirmPasswordError"></span>
      </div>

      <div class="flex gap-3 pt-2">
        <button type="button" onclick="resetPasswordModals()" class="flex-1 px-4 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
          Batal
        </button>
        <button type="submit" id="savePasswordBtn" class="flex-1 px-4 py-2.5 text-sm font-bold text-white bg-purple-600 rounded-xl hover:bg-purple-700 shadow-lg shadow-purple-200 transition-all active:scale-95">
          Ubah Password
        </button>
      </div>
    </form>
  </div>
</div>