<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <div class="mb-10">
            <a href="/">
                <img src="/images/logodua.png" alt="Logo" class="w-52 h-full mb-6 mx-auto object-cover">
            </a>
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-center mb-2">Reset Password</h2>
            <p class="text-center text-gray-600">Masukkan password baru Anda.</p>
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

        <form wire:submit.prevent="resetPassword">
            <input type="hidden" wire:model="token">

            <div class="relative mt-6">
                <input type="email" id="email" wire:model="email" readonly
                    class="block w-full px-3 py-2 md:py-3 border border-gray-300 bg-gray-100 rounded-md focus:outline-none sm:text-sm peer cursor-not-allowed"
                    placeholder=" " required />
                <label for="email"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">
                    Email
                </label>
            </div>

            <div class="relative mt-6">
                <input type="password" id="password" wire:model="password"
                    class="block w-full px-3 py-2 md:py-3 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm peer"
                    placeholder=" " required />
                <label for="password"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-primary peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">
                    Password Baru
                </label>
                <button type="button" id="togglePassword"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-eye" id="eyeIconPassword"></i>
                </button>
            </div>
            @error('password')
                <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
            @enderror

            <div class="relative mt-6">
                <input type="password" id="password_confirmation" wire:model="password_confirmation"
                    class="block w-full px-3 py-2 md:py-3 border @error('password_confirmation') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm peer"
                    placeholder=" " required />
                <label for="password_confirmation"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-primary peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">
                    Konfirmasi Password Baru
                </label>
                <button type="button" id="togglePasswordConfirmation"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-eye" id="eyeIconPasswordConfirmation"></i>
                </button>
            </div>
            @error('password_confirmation')
                <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
            @enderror

            <button type="submit"
                class="mt-8 w-full py-2.5 px-4 bg-primary text-white font-semibold rounded-md hover:bg-light-primary focus:outline-none active:scale-95 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled">
                <span wire:loading.remove>
                    <i class="fas fa-key mr-2"></i>
                    Reset Password
                </span>
                <span wire:loading>
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Memproses...
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const eyeIconPassword = document.getElementById('eyeIconPassword');

        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            eyeIconPassword.classList.toggle('fa-eye');
            eyeIconPassword.classList.toggle('fa-eye-slash');
        });

        const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
        const passwordConfirmationField = document.getElementById('password_confirmation');
        const eyeIconPasswordConfirmation = document.getElementById('eyeIconPasswordConfirmation');

        togglePasswordConfirmation.addEventListener('click', function() {
            const type = passwordConfirmationField.getAttribute('type') === 'password' ? 'text' :
                'password';
            passwordConfirmationField.setAttribute('type', type);
            eyeIconPasswordConfirmation.classList.toggle('fa-eye');
            eyeIconPasswordConfirmation.classList.toggle('fa-eye-slash');
        });
    });
</script>
