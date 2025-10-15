<div class="flex items-center justify-center ">
    <div class="w-full max-w-xl p-8">
        <div class="mb-10 lg:mb-14">
            <a href="/"
                class="mb-3 mx-auto w-24 h-24 bg-gray-300 flex items-center justify-center rounded-full p-1">
                {{-- <img src="{{ asset('logo.png') }}" alt="Logo" class="w-full h-full object-cover"> --}}
            </a>
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-center mb-2">Hai Teman Kopi!</h2>
            <p class="text-center text-warna-300">Mau dapetin promo menarik? Ayo mulai daftar sekarang!</p>
        </div>
        @if (session()->has('success'))
            <div class="mb-7 py-2 px-4 bg-green-100 border-l-2 border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="mb-4 py-2 px-4 bg-red-100 border-l-2 border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="register">
            <x-g-input id="name" label="Nama Lengkap" wireModel="name" type="text" />
            @error('name')
                <span class="text-warna-900 text-xs">{{ $message }}</span>
            @enderror

            <x-g-input id="phone" label="Phone" wireModel="phone" class="mt-4 md:mt-5" type="number" />
            @error('phone')
                <span class="text-warna-900 text-xs">{{ $message }}</span>
            @enderror


            <x-g-input id="email" label="Email" wireModel="email" class="mt-4 md:mt-5" type="email" />
            @error('email')
                <span class="text-warna-900 text-xs">{{ $message }}</span>
            @enderror


            <div class="relative mt-6">
                <input type="password" id="password" name="password" wire:model="password"
                    class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer"
                    placeholder=" " required />
                <label for="password"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Password</label>
                <button type="button" onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 px-3 py-2 text-gray-500 focus:outline-none">
                    <span id="eyeIcon"><i class="fa-solid fa-eye"></i></span>
                </button>
            </div>
            @error('password')
                <span class="text-warna-900 text-xs">{{ $message }}</span>
            @enderror


            <button type="submit" wire:loading.attr="disabled" wire:target="register"
                class="mt-10 w-full py-2 px-4 bg-primary text-white font-semibold rounded-md hover:bg-light-primary focus:outline-none active:scale-95 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed ">

                <i wire:loading wire:target="register" class="fas fa-spinner fa-spin mr-2"></i>

                <span wire:loading.remove wire:target="register">Register</span>
                <span wire:loading wire:target="register">Mendaftar...</span>
            </button>

            <p class="mt-4 text-sm">Sudah punya akun?
                <a href="{{ route('login') }}" class="text-warna-400 hover:underline">Masuk</a>
            </p>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<i class="fa-solid fa-eye"></i>';
            }
        }
    </script>

</div>
