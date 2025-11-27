<div class="flex items-center justify-center ">
    <div class="w-full lg:min-w-xl p-8 bg-white rounded-lg shadow-lg">
        <div class="mb-10 lg:mb-14">
            <a href="/">
                <img src="/images/logodua.png" alt="Logo" class="w-52 h-full mb-6 mx-auto object-cover">
            </a>
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-center mb-2">Hai Teman Kopi!</h2>
            <p class="text-center text-warna-300">Mau dapetin promo menarik? Ayo mulai daftar sekarang!</p>
        </div>
        @if (session()->has('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 px-4 py-2 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-light-primary/10 p-3 rounded-lg w-max space-x-2">
            <a href="{{ route('login') }}"
                class="{{ Route::currentRouteName() === 'login' ? 'bg-light-primary text-white ' : 'bg-white text-gray-800 hover:text-light-primary' }} py-2 px-7  transition-all duration-200 rounded-lg">Login</a>
            <button
                class="bg-light-primary text-white py-2 px-7  transition-all duration-200 rounded-lg">Register</button>
        </div>
        <form wire:submit.prevent="register" class="mt-6">
            <x-g-input id="name" label="Nama Lengkap" wireModel="name" type="text" />
            @error('name')
                <span class="text-danger text-xs">{{ $message }}</span>
            @enderror

            <x-g-input id="phone" label="Phone" wireModel="phone" class="mt-4 md:mt-5" type="number" />
            @error('phone')
                <span class="text-danger text-xs">{{ $message }}</span>
            @enderror


            <x-g-input id="email" label="Email" wireModel="email" class="mt-4 md:mt-5" type="email" />
            @error('email')
                <span class="text-danger text-xs">{{ $message }}</span>
            @enderror


            <div class="relative mt-6">
                <input type="password" id="password" name="password" wire:model="password"
                    class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer"
                    placeholder=" " required />
                <label for="password"
                    class="absolute text-sm text-primary duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Password</label>
                <button type="button" onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 px-3 py-2 text-gray-500 focus:outline-none">
                    <span id="eyeIcon"><i class="fa-solid fa-eye"></i></span>
                </button>
            </div>
            @error('password')
                <span class="text-danger text-xs">{{ $message }}</span>
            @enderror


            <button type="submit" wire:loading.attr="disabled" wire:target="register"
                class="mt-10 w-full py-2 px-4 bg-primary text-white font-semibold rounded-md hover:bg-light-primary focus:outline-none active:scale-95 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed ">

                <i wire:loading wire:target="register" class="fas fa-spinner fa-spin mr-2"></i>

                <span wire:loading.remove wire:target="register">Register</span>
                <span wire:loading wire:target="register">Mendaftar...</span>
            </button>


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
