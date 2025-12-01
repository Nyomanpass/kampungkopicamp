<div x-data="{ open: false }" class="relative" x-cloak>
    {{-- Notification Bell Button --}}
    <button @click="open = !open; $wire.loadNotifications()"
        class="size-10 flex justify-center items-center rounded-lg hover:bg-gray-100 transition-all relative">
        <i class="fa-solid fa-bell text-xl text-light-primary"></i>

        {{-- Unread Badge --}}
        @if ($unreadCount > 0)
            <span
                class="absolute -top-1 -right-1 bg-danger text-white text-xs font-bold rounded-full size-5 flex items-center justify-center animate-pulse">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    {{-- Overlay --}}
    <div x-show="open" @click="open = false" x-transition.opacity
        class="fixed inset-0 bg-black/40 z-40">
    </div>

    {{-- Notification Sidebar --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 h-full w-80 md:w-96 bg-white shadow-2xl z-50 overflow-y-auto">

        {{-- Header --}}
        <div class="p-4 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white z-10">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Notifikasi</h3>
                @if ($unreadCount > 0)
                    <p class="text-xs text-gray-500">{{ $unreadCount }} belum dibaca</p>
                @endif
            </div>
            <div class="flex items-center gap-2">
                @if ($unreadCount > 0)
                    <button wire:click="markAllAsRead"
                        class="text-xs text-primary hover:text-primary-dark transition-all px-2 py-1 rounded hover:bg-light-primary/10"
                        title="Tandai semua dibaca">
                        <i class="fas fa-check-double mr-1"></i> Tandai Semua
                    </button>
                @endif
                <button @click="open = false" class="text-gray-500 hover:text-gray-700 ml-2">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
        </div>

        {{-- Notification List --}}
        <div class="divide-y divide-gray-100">
            @forelse ($notifications as $notification)
                <div wire:key="notification-{{ $notification->id }}"
                    class="p-4 transition-all cursor-pointer {{ $notification->is_read ? 'bg-white hover:bg-gray-50' : 'bg-blue-50 hover:bg-blue-100' }}"
                    @click="window.location.href = '{{ $notification->action_url }}'">

                    <div class="flex items-start gap-3">
                        {{-- Icon (Dynamic based on type) --}}
                        <div
                            class="flex-shrink-0 size-10 rounded-full {{ $notification->icon_bg_class }} flex items-center justify-center">
                            <i class="fas {{ $notification->icon }} {{ $notification->icon_color_class }}"></i>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <p
                                class="text-sm text-gray-800 {{ !$notification->is_read ? 'font-bold' : 'font-medium' }}">
                                {{ $notification->title }}
                            </p>
                            <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ $notification->message }}</p>
                            <p class="text-xs text-gray-400 mt-2">
                                <i class="far fa-clock"></i> {{ $notification->time_ago }}
                            </p>
                        </div>

                        {{-- Actions --}}
                        <div class="flex-shrink-0 flex flex-col gap-2">
                            @if (!$notification->is_read)
                                <button wire:click.stop="markAsRead({{ $notification->id }})"
                                    class="text-primary hover:text-primary-dark text-sm" title="Tandai dibaca">
                                    <i class="fas fa-check"></i>
                                </button>
                            @endif
                            <button wire:click.stop="deleteNotification({{ $notification->id }})"
                                class="text-gray-400 hover:text-danger text-sm" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Optional: Show badge for unread --}}
                    @if (!$notification->is_read)
                        <div class="absolute top-4 right-4">
                            <span class="size-2 bg-blue-500 rounded-full animate-pulse"></span>
                        </div>
                    @endif
                </div>
            @empty
                {{-- Empty State --}}
                <div class="text-center py-16">
                    <i class="fa-solid fa-bell-slash text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-sm font-medium">Tidak ada notifikasi</p>
                    <p class="text-gray-400 text-xs mt-1">Notifikasi baru akan muncul di sini</p>
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        @if (count($notifications) > 0)
            <div class="p-4 border-t border-gray-200 sticky bottom-0 bg-white">
                <button wire:click="loadNotifications"
                    class="text-sm text-primary hover:text-primary-dark font-medium text-center block w-full">
                    <i class="fas fa-sync-alt mr-1"></i> Refresh Notifikasi
                </button>
            </div>
        @endif
    </div>
</div>
