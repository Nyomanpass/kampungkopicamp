{{-- Header --}}
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-user-plus text-primary text-lg md:text-xl"></i>
                Create New User
            </h2>
            <p class="text-xs md:text-sm text-gray-600 mt-1">Add a new user or admin account</p>
        </div>
        <button wire:click="switchToList" class="text-gray-600 hover:text-gray-900 transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
</div>

{{-- Form --}}
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
    <form wire:submit.prevent="createUser" class="space-y-6">
        {{-- Basic Information --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-user text-primary"></i>
                Basic Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Full Name --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="name"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('name') border-red-500 @enderror"
                        placeholder="Enter full name">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-envelope text-sm"></i>
                        </span>
                        <input type="email" wire:model="email"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('email') border-red-500 @enderror"
                            placeholder="user@example.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Phone Number
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-phone text-sm"></i>
                        </span>
                        <input type="text" wire:model="phone"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('phone') border-red-500 @enderror"
                            placeholder="+62 812 3456 7890">
                    </div>
                    @error('phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Account Settings --}}
        <div class="pt-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-cog text-primary"></i>
                Account Settings
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-lock text-sm"></i>
                        </span>
                        <input :type="show ? 'text' : 'password'" wire:model="password"
                            class="w-full pl-10 pr-12 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('password') border-red-500 @enderror"
                            placeholder="Min. 8 characters">
                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-lock text-sm"></i>
                        </span>
                        <input :type="show ? 'text' : 'password'" wire:model="password_confirmation"
                            class="w-full pl-10 pr-12 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            placeholder="Confirm password">
                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                {{-- Role --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        User Role <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="role"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('role') border-red-500 @enderror">
                        <option value="user">Regular User</option>
                        <option value="admin">Administrator</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle"></i>
                        Admins have full access to management features
                    </p>
                </div>

                {{-- Active Status --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Account Status
                    </label>
                    <div class="flex items-center gap-3 mt-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="is_active" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-700">
                                {{ $is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle"></i>
                        Inactive users cannot login to their account
                    </p>
                </div>
            </div>
        </div>

        {{-- Role Description --}}
        @if ($role === 'admin')
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <i class="fas fa-shield-alt text-purple-600 text-xl mt-0.5"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-purple-900 mb-1">Administrator Privileges</h4>
                        <ul class="text-sm text-purple-800 space-y-1">
                            <li><i class="fas fa-check text-xs"></i> Full access to user management</li>
                            <li><i class="fas fa-check text-xs"></i> Manage bookings and vouchers</li>
                            <li><i class="fas fa-check text-xs"></i> View all statistics and reports</li>
                            <li><i class="fas fa-check text-xs"></i> Configure system settings</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form Actions --}}
        <div class="flex flex-col md:flex-row gap-3 pt-6 border-t border-gray-200">
            <button type="submit"
                class="flex-1 bg-primary hover:bg-light-primary text-white px-6 py-3 rounded-lg font-semibold transition-all shadow-sm flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                Create User
            </button>
            <button type="button" wire:click="switchToList"
                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold transition-all flex items-center justify-center gap-2">
                <i class="fas fa-times"></i>
                Cancel
            </button>
        </div>
    </form>
</div>
