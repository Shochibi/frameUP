<div id="uploadModal" class="fixed inset-0 z-50 items-center justify-center hidden px-4 bg-black/60 backdrop-blur-sm">
    <div class="relative w-full max-w-md overflow-hidden bg-white shadow-2xl rounded-2xl">
        
        {{-- Header Gradient (Hanya Class) --}}
        <div class="flex items-center h-16 px-6 bg-gradient-to-r from-blue-600 to-purple-500">
            <h2 class="text-lg font-bold text-white">Upload Postingan</h2>
            <button onclick="closeModal()" class="ml-auto transition text-white/80 hover:text-white">
                <i class="text-xl fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="p-6">
            <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Input Title --}}
                <input type="text" name="title" placeholder="Judul" autofocus
                    class="w-full px-4 py-2 transition-all border border-gray-200 outline-none rounded-xl focus:ring-2 focus:ring-blue-500" required>

                {{-- Textarea Description --}}
                <textarea name="description" placeholder="Deskripsi" rows="3"
                    class="w-full px-4 py-2 transition-all border border-gray-200 outline-none resize-none rounded-xl focus:ring-2 focus:ring-blue-500"></textarea>

                {{-- Input File --}}
                <input type="file" name="file" 
                    class="w-full px-3 py-2 text-sm border border-gray-200 cursor-pointer rounded-xl file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100" required>

                {{-- Submit Button --}}
                <button type="submit"
                    class="w-full py-3 font-bold text-white transition-all bg-blue-600 shadow-lg rounded-xl hover:bg-blue-700 active:scale-95 shadow-blue-200">
                    Post
                </button>
            </form>
        </div>

    </div>
</div>

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