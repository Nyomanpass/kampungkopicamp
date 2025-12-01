<div class="space-y-5 p-6 bg-white rounded-lg shadow">
    {{-- Header --}}

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center gap-2">
                User Management
            </h1>
            <p class="text-xs md:text-sm text-gray-600 mt-1">Kelola aun dan izin pengguna</p>
        </div>
        <button wire:click="switchToCreate"
            class="bg-primary hover:bg-light-primary text-white px-4 md:px-6 py-2 md:py-3 rounded-lg font-semibold transition-all flex items-center justify-center gap-2 shadow-sm text-sm md:text-base">
            <i class="fas fa-plus"></i>
            <span>Tambah</span>
        </button>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">


        {{-- Active --}}
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active</p>
                    <p class="text-2xl font-bold text-light-primary">{{ $stats['active'] }}</p>
                </div>
                <div class="bg-light-primary/20 p-3 rounded-lg">
                    <i class="fas fa-check-circle text-light-primary text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Inactive --}}
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Inactive</p>
                    <p class="text-2xl font-bold text-warning">{{ $stats['inactive'] }}</p>
                </div>
                <div class="bg-warning/20 p-3 rounded-lg">
                    <i class="fas fa-pause-circle text-warning text-xl"></i>
                </div>
            </div>
        </div>


        {{-- Deleted --}}
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Deleted</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['deleted'] }}</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-trash text-gray-600 text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Filters & Search --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex flex-col md:flex-row gap-3">
            {{-- Search --}}
            <div class="flex-1">
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="Search by name, email, or phone...">
                </div>
            </div>

            {{-- Role Filter --}}
            <div class="w-full md:w-48">
                <select wire:model.live="roleFilter"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            {{-- Status Filter --}}
            <div class="w-full md:w-48">
                <select wire:model.live="statusFilter"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="deleted">Deleted</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Users List --}}
    <div class="space-y-3 md:space-y-0">
        @forelse ($users as $user)
            @if ($loop->first)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">User</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Contact</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Role</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Bookings</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Joined</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
            @endif

            <tr class="hover:bg-gray-50 transition-colors">
                {{-- User --}}
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full {{ $user->is_admin ? 'bg-secondary/70' : 'bg-light-primary/30' }} flex items-center justify-center flex-shrink-0">
                            <i
                                class="fas {{ $user->is_admin ? 'fa-user-shield text-white' : 'fa-user text-primary' }}"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900 text-sm truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 truncate">ID: {{ $user->id }}</p>
                        </div>
                    </div>
                </td>

                {{-- Contact --}}
                <td class="px-4 py-3">
                    <div class="text-xs">
                        <p class="text-gray-900 font-medium truncate max-w-[180px]">{{ $user->email }}</p>
                        @if ($user->phone)
                            <p class="text-gray-500">{{ $user->phone }}</p>
                        @endif
                    </div>
                </td>

                {{-- Role --}}
                <td class="px-4 py-3">
                    <span
                        class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $user->is_admin ? 'bg-secondary/70 text-white' : 'bg-light-primary/30 text-primary' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>

                {{-- Bookings --}}
                <td class="px-4 py-3">
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar-check text-gray-400 text-xs"></i>
                        <span class="text-sm font-semibold text-gray-900">{{ $user->bookings_count }}</span>
                    </div>
                </td>

                {{-- Joined Date --}}
                <td class="px-4 py-3">
                    <p class="text-xs text-gray-900 font-medium">{{ $user->created_at->format('d M Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                </td>

                {{-- Status --}}
                <td class="px-4 py-3">
                    <span
                        class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $user->getStatusBadgeColor() === 'green' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $user->getStatusBadgeColor() === 'red' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $user->getStatusBadgeColor() === 'gray' ? 'bg-gray-100 text-gray-800' : '' }}">
                        {{ $user->getStatusLabel() }}
                    </span>
                </td>

                {{-- Actions --}}
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        @if (!$user->trashed())
                            <button wire:click="switchToDetail({{ $user->id }})"
                                class="w-8 h-8 flex items-center justify-center text-blue-600 hover:bg-blue-100 rounded-lg transition-all"
                                title="View Details">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        @endif

                        @if ($user->trashed())
                            <button wire:click="restoreUser({{ $user->id }})"
                                class="w-8 h-8 flex items-center justify-center text-success hover:bg-success/20 rounded-lg transition-all"
                                title="Restore User">
                                <i class="fas fa-undo text-sm"></i>
                            </button>
                            <button
                                class="w-8 h-8 flex items-center justify-center text-danger hover:bg-danger/20 rounded-lg transition-all"
                                title="Remove User Permanently"
                                wire:click="removeUserPermanently({{ $user->id }})">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        @else
                            <button wire:click="toggleStatus({{ $user->id }})"
                                class="w-8 h-8 flex items-center justify-center text-{{ $user->is_active ? 'danger' : 'success' }} hover:bg-{{ $user->is_active ? 'danger' : 'success' }}/20 rounded-lg transition-all"
                                title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }} text-sm"></i>
                            </button>
                        @endif

                        @if (!$user->trashed())
                            @if ($user->canBeDeleted())
                                <button wire:click="deleteUser({{ $user->id }})"
                                    onclick="return confirm('Delete {{ $user->name }}?')"
                                    class="w-8 h-8 flex items-center justify-center text-danger hover:bg-danger/20 rounded-lg transition-all"
                                    title="Delete">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            @endif
                        @endif
                    </div>
                </td>
            </tr>

            @if ($loop->last)
                </tbody>
                </table>
            @endif
    </div>
@empty
    {{-- Empty State --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 md:p-12 text-center">
        <div class="flex flex-col items-center justify-center text-gray-400">
            <i class="fas fa-users text-5xl md:text-6xl mb-4"></i>
            <p class="text-base md:text-lg font-semibold text-gray-600">User tidak ditemukan</p>
            <p class="text-xs md:text-sm text-gray-500 mt-1">Coba sesuaikan filter Anda</p>
        </div>
    </div>
    @endforelse
</div>

</div>
{{-- Pagination --}}
@if ($users->hasPages())
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        {{ $users->links() }}
    </div>
@endif
