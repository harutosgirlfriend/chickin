<div class="flex h-[90vh] chat-container max-w-7xl mx-auto shadow-xl rounded-lg overflow-hidden mt-2">

    <div id="contact-list" class="w-1/2 bg-white border-r border-gray-200">
        <div class="p-4 text-lg font-semibold border-b border-gray-200">
            Pesan
        </div>
        <div class="overflow-y-auto h-full pb-16">
            @foreach ($this->getChatUsers() as $pengirim)
                <div wire:click="openChat({{ $pengirim->id }})"
                    class="flex items-center p-3 hover:bg-gray-50 border-l-4 
                     {{ $selectedUser->id === $pengirim->id ? 'border-green-500 bg-gray-50' : 'border-transparent' }}">

                    <div
                        class="w-12 h-12 flex items-center justify-center rounded-full bg-[#a01800] text-white text-lg font-semibold">
                        {{ strtoupper(substr($pengirim->nama ?? 'U', 0, 1)) }}
                    </div>
                    <div class="mx-2 flex-1">
                        <p class="font-semibold text-sm">{{ $pengirim->nama }}</p>
                        <p class="text-xs text-gray-500 italic">{{ $pengirim->email }}</p>
                    </div>
                    @if ($pengirim->unreadCount > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ $pengirim->unreadCount }}
                        </span>
                    @else
                        <span class="ml-auto text-xs text-gray-400">5m ago</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Chat window -->
    <div id="chat-window" class="w-1/2 flex flex-col bg-white">

        <!-- Header chat -->
        <div class="p-4 border-b border-gray-200 flex items-center gap-2">
            <div
                class="w-12 h-12 flex items-center justify-center rounded-full bg-[#a01800] text-white text-lg font-semibold">
                {{ strtoupper(substr($selectedUser->nama ?? 'A', 0, 1)) }}
            </div>
            <p class="font-semibold text-lg">{{ $selectedUser->nama ?? 'Admin' }}</p>
        </div>

        <!-- Messages -->
        <div wire:poll.2s="loadMessages" class="flex-grow p-6 overflow-y-auto space-y-4 bg-gray-50">
            @foreach ($messages as $message)
                <div class="flex {{ $message->id_pengirim == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="bg-gray-200 p-3 rounded-lg max-w-sm shadow-md">
                        @if ($message->gambar)
                            <img src="{{ asset('storage/' . $message->gambar) }}" class="rounded mb-2 max-h-48">
                        @endif

                        @if ($message->pesan)
                            <p>{{ $message->pesan }}</p>
                        @endif

                        <span class="block text-right text-xs text-gray-500 mt-1">
                            {{ $message->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Input chat -->
        <div class="p-4 border-t border-gray-200 bg-white">
            <form wire:submit.prevent="submit" class="flex items-center gap-2 p-4 max-w-4xl mx-auto">
                <input wire:model.defer="newMessage" type="text" placeholder="Ketik pesan..."
                    class="flex-1 px-5 py-3 w-100 rounded-full text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="file" wire:model="photo" class="hidden" id="photo">

                <label for="photo" class="cursor-pointer bg-gray-200 px-4 py-3 rounded-full text-sm">
                    📷
                </label>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-full text-sm">
                    Kirim
                </button>
            </form>
        </div>

    </div>

</div>
