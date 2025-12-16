<div class="relative">
    <a href="{{ route('chat') }}" class="text-gray-700 hover:text-gray-900 relative flex items-center">
        @if ($unreadCount > 0)
            <span class="absolute -top-1 -right-2 bg-red-600 text-white text-[10px] font-bold rounded-full px-1.5">
                {{ $unreadCount }}
            </span>
        @endif
    </a>
    <div wire:poll.2s="loadUnread"></div>
</div>
