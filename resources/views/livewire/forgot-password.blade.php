<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <div class="mb-10">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-center mb-2">Lupa Password?</h2>
            <p class="text-center text-gray-600">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.
            </p>
        </div>

        @if (session()->has('success'))
            <div
                class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-start gap-3">
                <i class="fas fa-check-circle text-xl mt-0.5"></i>
                <div>
                    <p class="font-medium">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-xl mt-0.5"></i>
                <div>
                    <p class="font-medium">Gagal!</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <form wire:submit.prevent="sendResetLink">
            <div class="relative mt-6">
                <input type="email" id="email" wire:model="email"
                    class="block w-full px-3 py-2 md:py-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm peer"
                    placeholder=" " required />
                <label for="email"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-primary peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">
                    Email
                </label>
            </div>
            @error('email')
                <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
            @enderror

            <button type="submit"
                class="mt-8 w-full py-2.5 px-4 bg-primary text-white font-semibold rounded-md hover:bg-light-primary focus:outline-none active:scale-95 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled">
                <span wire:loading.remove>
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Link Reset Password
                </span>
                <span wire:loading>
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Mengirim...
                </span>
            </button>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Sudah ingat password?
                    <a href="{{ route('login') }}" class="text-primary hover:underline font-medium">Login di sini</a>
                </p>
            </div>
        </form>
    </div>
</div>
