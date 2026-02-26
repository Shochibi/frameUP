@extends('layouts.main')

@section('title', 'Chat')

@section('content')

    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl flex flex-col h-[80vh]">

        {{-- Header --}}
        <div class="p-4 border-b font-semibold text-lg">
            Chat dengan {{ $friend->username }}
        </div>

        {{-- Chat Area --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50">
            {{-- BUBBLE --}}
            @foreach($messages as $msg)

                @if($msg->sender_id == auth()->id())
                    <div class="flex flex-col items-end group">

                        {{-- Bubble --}}
                        <div class="bg-blue-500 text-white px-4 py-2 rounded-2xl max-w-xs">
                            {{ $msg->message }}
                        </div>

                        {{-- Action Buttons (hidden by default) --}}
                        <div class="hidden group-hover:flex gap-2 mt-1 text-xs">

                            {{-- Edit --}}
                            <button onclick="editMessage('{{ $msg->id }}', '{{ $msg->message }}')"
                                class="bg-yellow-400 px-2 py-1 rounded">
                                Edit
                            </button>

                            {{-- Delete --}}
                            <form action="{{ route('friends.destroy', $msg->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-2 py-1 rounded">
                                    Hapus
                                </button>
                            </form>

                        </div>

                    </div>
                @else
                    <div class="flex justify-start">
                        <div class="bg-gray-300 px-4 py-2 rounded-2xl max-w-xs">
                            {{ $msg->message }}
                        </div>
                    </div>
                @endif

            @endforeach

        </div>

        {{-- Form --}}
        <form action="{{ route('friends.send', $friend->id) }}" method="POST" class="p-4 border-t flex gap-2">
            @csrf
            <input type="text" name="message" placeholder="Ketik pesan..."
                class="flex-1 border rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            <button class="bg-blue-500 text-white px-5 rounded-full">
                Kirim
            </button>
        </form>

    </div>

    <script>
        function editMessage(id, oldMessage) {
            let newMessage = prompt("Edit pesan:", oldMessage);

            if (newMessage) {
                fetch(`/chat/${id}`, {
                    method: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        message: newMessage
                    })
                }).then(() => location.reload());
            }
        }
    </script>

@endsection