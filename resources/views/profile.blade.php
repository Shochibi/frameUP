@extends('layouts.main')

@section('title', 'Profil Saya')

@section('content')
<style>
    .modal-active { overflow: hidden; }
    .error-message { animation: fadeIn 0.3s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="min-h-[80vh] flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-xl overflow-hidden transition-all duration-300 bg-white shadow-2xl rounded-2xl hover:shadow-blue-100">
        
        {{-- Header Section --}}
        <div class="relative h-32 bg-gradient-to-r from-blue-500 to-purple-600">
            <div class="absolute inset-x-0 flex justify-center -bottom-12">
                <div class="p-1 bg-white rounded-full shadow-lg">
                    <div class="flex items-center justify-center w-24 h-24 text-4xl text-white rounded-full bg-gradient-to-br from-blue-400 to-blue-600">
                        <i class="fa-solid fa-user-astronaut"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-8 pt-16 pb-8">
            {{-- Alert Success --}}
            @if(session('success'))
            <div id="successAlert" class="flex items-center p-4 mb-6 text-green-800 border-l-4 border-green-500 bg-green-50 rounded-xl">
                <i class="mr-3 fa-solid fa-circle-check"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
            @endif

            {{-- User Info Header --}}
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-800">{{ auth()->user()->username }}</h1>
                <p class="text-gray-500">{{ auth()->user()->email }}</p>
                <span class="inline-block px-3 py-1 mt-2 text-xs font-semibold text-blue-600 uppercase rounded-full bg-blue-50">
                    ID: #{{ auth()->user()->id }}
                </span>
            </div>

            {{-- Info Details Card --}}
            <div class="p-4 mb-8 space-y-3 bg-gray-50 rounded-2xl">
                <div class="flex items-center justify-between p-2 border-b border-gray-200">
                    <span class="text-sm font-medium text-gray-500 uppercase">Username</span>
                    <span class="font-bold text-gray-700">{{ auth()->user()->username }}</span>
                </div>
                <div class="flex items-center justify-between p-2">
                    <span class="text-sm font-medium text-gray-500 uppercase">Email Terdaftar</span>
                    <span class="font-bold text-gray-700">{{ auth()->user()->email }}</span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="grid grid-cols-1 gap-4">
                <button type="button" onclick="openEditModal()" class="flex items-center justify-center py-3 font-bold text-white transition-all bg-blue-600 shadow-lg rounded-xl hover:bg-blue-700 active:scale-95 shadow-blue-200">
                    <i class="mr-2 fa-solid fa-user-pen"></i> Edit Profile
                </button>
                {{-- <button type="button" onclick="openPasswordModal()" class="flex items-center justify-center px-6 py-3 font-bold text-white transition-all bg-purple-600 shadow-lg rounded-xl hover:bg-purple-700 active:scale-95 shadow-purple-200">
                    <i class="mr-2 fa-solid fa-shield-halved"></i> Ganti Password
                </button> --}}
            </div>

            {{-- Logout --}}
            {{-- <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="w-full px-6 py-3 font-bold text-red-600 transition-all border-2 border-red-100 rounded-xl hover:bg-red-50 active:scale-95">
                    <i class="mr-2 fa-solid fa-power-off"></i> Logout
                </button>
            </form> --}}
        </div>
    </div>
</div>

@include('partials.profile-modal')

<script>
    let passwordVerified = false;

    // --- MODAL CONTROL ---
    function openEditModal() {
        document.getElementById('editModal').classList.remove('hidden');
        document.body.classList.add('modal-active');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.classList.remove('modal-active');
        clearErrors();
    }

    function openPasswordModal() {
        passwordVerified = false;
        document.getElementById('verifyPasswordModal').classList.remove('hidden');
        document.body.classList.add('modal-active');
    }

    function closePasswordModal() {
        document.getElementById('verifyPasswordModal').classList.add('hidden');
        document.getElementById('changePasswordModal').classList.add('hidden');
        document.body.classList.remove('modal-active');
        clearErrors();
    }

    function resetPasswordModals() {
        closePasswordModal();
    }

    function clearErrors() {
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    }

    // --- FORM SUBMISSION ---

    // 1. Update Profile
    function submitEditForm(event) {
        event.preventDefault();
        clearErrors();
        const btn = document.getElementById('saveProfileBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="mr-2 fa-solid fa-spinner fa-spin"></i>...';

        const formData = new FormData(event.target);

        fetch('{{ route("profile.updateProfile") }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                btn.disabled = false;
                btn.textContent = 'Simpan Perubahan';
                if (data.errors) {
                    if (data.errors.username) document.getElementById('usernameError').textContent = data.errors.username[0];
                    if (data.errors.email) document.getElementById('emailError').textContent = data.errors.email[0];
                }
            }
        })
        .catch(err => {
            btn.disabled = false;
            console.error(err);
        });
    }

    // 2. Verify Old Password
    function verifyOldPassword(event) {
        event.preventDefault();
        clearErrors();
        const btn = document.getElementById('verifyBtn');
        btn.disabled = true;
        btn.textContent = 'Memverifikasi...';

        const formData = new FormData(event.target);

        fetch('{{ route("profile.verifyPassword") }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.textContent = 'Verifikasi';
            if (data.success) {
                passwordVerified = true;
                document.getElementById('verifyPasswordModal').classList.add('hidden');
                document.getElementById('changePasswordModal').classList.remove('hidden');
            } else {
                document.getElementById('oldPasswordError').textContent = data.message;
            }
        })
        .catch(err => {
            btn.disabled = false;
            console.error(err);
        });
    }

    // 3. Submit New Password
    function submitPasswordForm(event) {
        event.preventDefault();
        clearErrors();
        
        const btn = document.getElementById('savePasswordBtn');
        const newPass = document.getElementById('newPassword').value;
        const confirmPass = document.getElementById('confirmPassword').value;

        if (newPass !== confirmPass) {
            document.getElementById('confirmPasswordError').textContent = 'Konfirmasi password tidak cocok!';
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        const formData = new FormData(event.target);

        fetch('{{ route("profile.updatePassword") }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                btn.disabled = false;
                btn.textContent = 'Ubah Password';
                if (data.errors && data.errors.password) {
                    document.getElementById('newPasswordError').textContent = data.errors.password[0];
                }
            }
        })
        .catch(err => {
            btn.disabled = false;
            console.error(err);
        });
    }

    // Auto hide success alert
    setTimeout(() => {
        const alert = document.getElementById('successAlert');
        if(alert) alert.style.display = 'none';
    }, 4000);
</script>
@endsection