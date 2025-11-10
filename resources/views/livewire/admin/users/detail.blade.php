@if ($selectedUser)
    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <button wire:click="switchToList"
                    class="w-10 h-10 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left text-gray-600"></i>
                </button>
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900">User Details</h2>
                    <p class="text-xs md:text-sm text-gray-600 mt-1">Complete user information and activity</p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="flex items-center gap-2">
                @if (!$selectedUser->trashed())
                    <button wire:click="toggleStatus({{ $selectedUser->id }})"
                        class="px-4 py-2 hover:bg-{{ $selectedUser->is_active ? 'danger' : 'success' }}/20 border border-{{ $selectedUser->is_active ? 'danger' : 'success' }} text-{{ $selectedUser->is_active ? 'danger' : 'success' }} rounded-lg font-semibold text-sm transition-all">
                        <i class="fas fa-{{ $selectedUser->is_active ? 'pause' : 'play' }}"></i>
                        {{ $selectedUser->is_active ? 'Deactivate' : 'Activate' }}
                    </button>

                    <button wire:click="resetPassword({{ $selectedUser->id }})"
                        onclick="return confirm('Reset password for {{ $selectedUser->name }}?')"
                        class="px-4 py-2 border border-light-primary hover:bg-light-primary/20 text-primary rounded-lg font-semibold text-sm transition-all">
                        <i class="fas fa-key"></i>
                        Reset Password
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- User Profile Card --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row gap-6">
            {{-- Avatar --}}
            <div class="flex-shrink-0">
                <div
                    class="w-24 h-24 rounded-full {{ $selectedUser->is_admin ? 'bg-purple-100' : 'bg-blue-100' }} flex items-center justify-center">
                    <i
                        class="fas {{ $selectedUser->is_admin ? 'fa-user-shield text-purple-600' : 'fa-user text-blue-600' }} text-4xl"></i>
                </div>
            </div>

            {{-- User Info --}}
            <div class="flex-1 space-y-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $selectedUser->name }}</h3>
                        <span
                            class="px-3 py-1 text-xs font-semibold rounded-full
                            {{ $selectedUser->is_admin ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($selectedUser->role) }}
                        </span>
                        <span
                            class="px-3 py-1 text-xs font-semibold rounded-full
                            {{ $selectedUser->getStatusBadgeColor() === 'green' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $selectedUser->getStatusBadgeColor() === 'red' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $selectedUser->getStatusBadgeColor() === 'gray' ? 'bg-gray-100 text-gray-800' : '' }}">
                            {{ $selectedUser->getStatusLabel() }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">User ID: #{{ $selectedUser->id }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Email --}}
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Email Address</p>
                        <p class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-envelope text-gray-400"></i>
                            {{ $selectedUser->email }}
                        </p>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Phone Number</p>
                        <p class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-phone text-gray-400"></i>
                            {{ $selectedUser->phone ?: 'Not provided' }}
                        </p>
                    </div>

                    {{-- Joined Date --}}
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Member Since</p>
                        <p class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-calendar text-gray-400"></i>
                            {{ $selectedUser->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        {{-- Total Bookings --}}
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Bookings</p>
                    <p class="text-2xl font-bold text-light-primary">{{ $selectedUser->bookings_count }}</p>
                </div>
                <div class="bg-light-primary/20 p-3 rounded-lg">
                    <i class="fas fa-calendar-check text-light-primary text-xl"></i>
                </div>
            </div>
        </div>


        {{-- Total Spent --}}
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Spent</p>
                    <p class="text-2xl font-bold text-light-primary">Rp
                        {{ number_format($selectedUser->total_spent / 1000) }}K</p>
                </div>
                <div class="bg-light-primary/20 p-3 rounded-lg">
                    <i class="fas fa-wallet text-light-primary text-xl"></i>
                </div>
            </div>
        </div>


        {{-- Vouchers Used --}}
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Vouchers Used</p>
                    <p class="text-2xl font-bold text-light-primary">{{ $selectedUser->voucherRedemptions()->count() }}
                    </p>
                </div>
                <div class="bg-light-primary/20 p-3 rounded-lg">
                    <i class="fas fa-ticket-alt text-light-primary text-xl"></i>
                </div>
            </div>
        </div>


        {{-- Last Booking --}}
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Last Booking</p>
                    <p class="text-2xl font-bold text-light-primary">{{ $selectedUser->last_booking_date ?: 'Never' }}
                    </p>
                </div>
                <div class="bg-light-primary/20 p-3 rounded-lg">
                    <i class="fas fa-clock text-light-primary text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Recent Bookings --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-history text-primary"></i>
                Recent Bookings
            </h3>
        </div>

        <div class="p-4">
            @forelse($selectedUser->bookings as $booking)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 text-sm">{{ $booking->package_name }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $booking->start_date->format('d M Y') }} - {{ $booking->end_date->format('d M Y') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-900 text-sm">Rp {{ number_format($booking->total_price) }}</p>
                        <span
                            class="px-2 py-0.5 text-xs font-semibold rounded-full
                            {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-inbox text-4xl mb-2"></i>
                    <p class="text-sm">No bookings yet</p>
                </div>
            @endforelse
        </div>
    </div>
@endif
