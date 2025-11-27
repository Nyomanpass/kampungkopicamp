<div class="flex items-center justify-center ">
    <div class="w-full lg:min-w-xl p-8 bg-white rounded-lg shadow-lg">
        <div class="mb-10 lg:mb-14">
            <a href="/">
                <img src="/images/logodua.png" alt="Logo" class="w-52 h-full mb-6 mx-auto object-cover">
            </a>
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-center mb-2">Selamat Datang Kembali!</h2>
            <p class="text-center text-warna-300">Silahkan login untuk mendapatkan promo menarik Kampung Kopi.</p>
        </div>

        <div class="fixed top-4 right-4 z-50 w-96 max-w-[calc(100vw-2rem)] space-y-3">
            @if (session()->has('success'))
                <div wire:key="success-{{ md5(session('success') . microtime()) }}" x-data="{
                    show: false,
                    progress: 100,
                    duration: 4000,
                    init() {
                        this.$nextTick(() => { this.show = true; });
                        const step = 100 / (this.duration / 50);
                        const interval = setInterval(() => {
                            this.progress = Math.max(0, this.progress - step);
                            if (this.progress <= 0) {
                                clearInterval(interval);
                                this.close();
                            }
                        }, 50);
                    },
                    close() {
                        this.show = false;
                        setTimeout(() => this.$el.remove(), 300);
                    }
                }"
                    x-show="show" x-cloak x-transition:enter="transform ease-out duration-300"
                    x-transition:enter-start="translate-x-full opacity-0"
                    x-transition:enter-end="translate-x-0 opacity-100"
                    x-transition:leave="transform ease-in duration-200"
                    x-transition:leave-start="translate-x-0 opacity-100"
                    x-transition:leave-end="translate-x-full opacity-0"
                    class="relative rounded-xl border border-green-200 bg-gradient-to-br from-green-50 to-white text-green-800 shadow-lg ring-1 ring-green-100">
                    <div class="flex items-start gap-3 p-4">
                        <i class="fas fa-check-circle text-2xl text-green-500"></i>
                        <div class="flex-1">
                            <p class="font-medium">Success</p>
                            <p class="text-sm opacity-90">{{ session('success') }}</p>
                        </div>
                        <button @click="close()" class="p-1.5 rounded-md text-green-700 hover:bg-green-100/60">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="absolute left-0 bottom-0 h-1 bg-green-200/60 w-full overflow-hidden rounded-b-xl">
                        <div class="h-full bg-green-500 transition-all ease-linear" :style="`width: ${progress}%`">
                        </div>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div wire:key="error-{{ md5(session('error') . microtime()) }}" x-data="{
                    show: false,
                    progress: 100,
                    duration: 5000,
                    init() {
                        this.$nextTick(() => { this.show = true; });
                        const step = 100 / (this.duration / 50);
                        const interval = setInterval(() => {
                            this.progress = Math.max(0, this.progress - step);
                            if (this.progress <= 0) {
                                clearInterval(interval);
                                this.close();
                            }
                        }, 50);
                    },
                    close() {
                        this.show = false;
                        setTimeout(() => this.$el.remove(), 300);
                    }
                }" x-show="show"
                    x-cloak x-transition:enter="transform ease-out duration-300"
                    x-transition:enter-start="translate-x-full opacity-0"
                    x-transition:enter-end="translate-x-0 opacity-100"
                    x-transition:leave="transform ease-in duration-200"
                    x-transition:leave-start="translate-x-0 opacity-100"
                    x-transition:leave-end="translate-x-full opacity-0"
                    class="relative rounded-xl border border-red-200 bg-gradient-to-br from-red-50 to-white text-red-800 shadow-lg ring-1 ring-red-100">
                    <div class="flex items-start gap-3 p-4">
                        <i class="fas fa-exclamation-circle text-2xl text-red-500"></i>
                        <div class="flex-1">
                            <p class="font-medium">Error</p>
                            <p class="text-sm opacity-90">{{ session('error') }}</p>
                        </div>
                        <button @click="close()" class="p-1.5 rounded-md text-red-700 hover:bg-red-100/60">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="absolute left-0 bottom-0 h-1 bg-red-200/60 w-full overflow-hidden rounded-b-xl">
                        <div class="h-full bg-red-500 transition-all ease-linear" :style="`width: ${progress}%`"></div>
                    </div>
                </div>
            @endif
        </div>


        <div class="bg-light-primary/10 p-3 rounded-lg w-max space-x-2">
            <button
                class="bg-light-primary text-white py-2 px-7 hover:bg-warna-400 hover:text-white transition-all duration-200 rounded-lg">Login</button>
            <a href="{{ route('register') }}"
                class="{{ Route::currentRouteName() === 'register' ? 'bg-light-primary text-white' : 'bg-white text-gray-800 hover:bg-warna-400 hover:text-light-primary' }} py-2 px-7  transition-all duration-200 rounded-lg">Register</a>
        </div>

        <form wire:submit.prevent="login">
            <div class="relative mt-6">
                <input type="text" id="email" name="email" wire:model="email"
                    class="block w-full px-3 py-2 md:py-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-accent focus:border-accent sm:text-sm peer"
                    placeholder=" " required />
                <label for="email"
                    class="absolute text-sm text-primary duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Email</label>
            </div>
            @error('email')
                <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
            @enderror

            <div class="relative mt-6">
                <input type="password" id="password" name="password" wire:model="password"
                    class="block w-full px-3 py-2 md:py-3 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-accent focus:border-accent sm:text-sm peer"
                    placeholder=" " required />
                <label for="password"
                    class="absolute text-sm text-primary duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-secondary  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Password</label>
                <button type="button" onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 px-3 py-2 text-gray-500 focus:outline-none">
                    <span id="eyeIcon"><i class="fa-solid fa-eye"></i></span>
                </button>
            </div>
            @error('password')
                <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
            @enderror


            <button type="submit"
                class="mt-10 w-full py-2 px-4 bg-primary text-white font-semibold rounded-md hover:bg-light-primary focus:outline-none active:scale-95 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled">
                <span wire:loading.remove>Login</span>
                <div wire:loading class="">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                </div>
            </button>

            <div class="mt-4 text-center">
                <a href="{{ route('forgot-password') }}" class="text-sm text-primary hover:underline">Lupa Password?</a>
            </div>


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
