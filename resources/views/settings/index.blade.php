@extends('layouts.main')

@section('title', 'Settings')

@section('content')
    <style>
        .modal-active {
            overflow: hidden;
        }

        .error-message {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div>
        <button onclick="toggleSection()" class="w-full text-left font-bold shadow rounded-xl p-6">
            Account Settings ▼
        </button>

        <div id="accountSection" class="hidden">
            {{-- Security Section --}}
            <div class="bg-white shadow rounded-xl p-3 border border-red-200">

                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Security</h2>

                    <button type="button" onclick="openPasswordModal()"
                        class="px-4 py-2 font-bold text-white transition-all bg-purple-600 rounded-xl hover:bg-purple-700 active:scale-95">
                        <i class="mr-2 fa-solid fa-shield-halved"></i>
                        Ganti Password
                    </button>
                </div>

            </div>

            {{-- Danger Zone --}}
            <div class="bg-white shadow rounded-xl p-3 border border-red-200">

                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-red-600">
                        Danger Zone
                    </h2>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-6 py-2 font-bold text-red-600 transition-all border-2 border-red-100 rounded-xl hover:bg-red-50 active:scale-95">
                            <i class="mr-2 fa-solid fa-power-off"></i> Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @include('partials.profile-modal')

    <script>
        let passwordVerified = false;

        // --- DROP DOWN ---
        function toggleSection() {
            const section = document.getElementById('accountSection');
            section.classList.toggle('hidden');
        }

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
            if (alert) alert.style.display = 'none';
        }, 4000);
    </script>
@endsection