  <div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-xl p-6 relative">

        <button onclick="closeModal()" 
            class="absolute top-3 right-3 text-gray-500 hover:text-black">
            ✕
        </button>

        <h2 class="text-xl font-bold mb-4">Upload Postingan</h2>

        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="text" name="title" placeholder="Judul"
                class="w-full border p-2 rounded mb-3" required>

            <textarea name="description" placeholder="Deskripsi"
                class="w-full border p-2 rounded mb-3"></textarea>

            <input type="file" name="file"
                class="w-full border p-2 rounded mb-3" required>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Post
            </button>
        </form>

    </div>
</div>

{{-- ### SCRIPT ### --}}
<script>
function openModal() {
    document.getElementById('uploadModal').classList.remove('hidden');
    document.getElementById('uploadModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('uploadModal').classList.add('hidden');
    document.getElementById('uploadModal').classList.remove('flex');
}
</script>
