<div class="px-4" x-data="{ showCopied: false }" @copied.window="showCopied = true; setTimeout(() => showCopied = false, 2000)">
    {{-- Copy Success Toast --}}
    <div x-show="showCopied" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2"
        style="display: none;">
        <i class="fas fa-check-circle"></i>
        <span>Kode voucher berhasil disalin!</span>
    </div>

    {{-- Flash Messages --}}
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
            }" x-show="show"
                x-cloak x-transition:enter="transform ease-out duration-300"
                x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transform ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
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
                    <div class="h-full bg-green-500 transition-all ease-linear" :style="`width: ${progress}%`"></div>
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
                x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transform ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
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

    <header class="py-5 border-b border-gray-300 mb-5 flex items-center justify-center">
        <p class="font-semibold text-lg">Reward & Vouchers</p>
    </header>

    {{-- Dashboard Vouchers Section --}}
    @if ($dashboardVouchers->count() > 0)
        <div class="mb-20">
            <h3 class="font-semibold text-gray-900 mb-4">Voucher untuk Kamu</h3>
            <div class="space-y-5">
                @foreach ($dashboardVouchers as $voucher)
                    <div>
                        <div
                            class="bg-white rounded-lg border border-gray-100 p-4 flex flex-col items-center gap-2 shadow-sm hover:shadow-md transition">
                            <div class="flex gap-4  items-center justify-between w-full">
                                <div class="flex gap-4 w-full">

                                    <div class="flex-none ">
                                        <div
                                            class="w-16 h-16 rounded-lg bg-secondary text-white flex items-center justify-center font-semibold text-lg">
                                            @if ($voucher->type === 'percentage')
                                                <i class="fas fa-percent"></i>
                                            @else
                                                <i class="fas fa-tag"></i>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="min-w-0">
                                                <p class="font-medium text-gray-900 truncate">{{ $voucher->name }}</p>
                                                <p class="text-xs text-gray-500 mt-1">{{ $voucher->description }}</p>
                                            </div>
                                        </div>

                                        <div class="mt-3 flex items-center gap-3 flex-wrap">
                                            <div
                                                class="bg-light-secondary text-gray-800 px-3 py-1 rounded-md text-sm font-mono">
                                                KODE: {{ $voucher->code }}
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div class="flex flex-col items-end gap-2">
                                    @php
                                        $hasRedeemed = $this->hasUserRedeemed($voucher);
                                    @endphp

                                    @if ($hasRedeemed)
                                        <button disabled
                                            class="inline-flex items-center justify-center px-4 py-4 rounded-md bg-gray-300 text-gray-500 cursor-not-allowed text-sm font-medium"
                                            type="button" title="Anda sudah menggunakan voucher ini">
                                            <i class="fas fa-check lg:mr-2"></i>
                                            <span class="hidden lg:inline">Sudah Digunakan</span>
                                        </button>
                                    @else
                                        <button
                                            @click="
                                            const code = '{{ $voucher->code }}';
                                            if (navigator.clipboard && navigator.clipboard.writeText) {
                                                navigator.clipboard.writeText(code).then(() => {
                                                    $dispatch('copied');
                                                }).catch(err => {
                                                    console.error('Failed to copy:', err);
                                                });
                                            } else {
                                                // Fallback method for older browsers or non-secure contexts
                                                const textarea = document.createElement('textarea');
                                                textarea.value = code;
                                                textarea.style.position = 'fixed';
                                                textarea.style.opacity = '0';
                                                document.body.appendChild(textarea);
                                                textarea.select();
                                                try {
                                                    document.execCommand('copy');
                                                    $dispatch('copied');
                                                } catch (err) {
                                                    console.error('Fallback copy failed:', err);
                                                    alert('Gagal menyalin kode voucher');
                                                }
                                                document.body.removeChild(textarea);
                                            }
                                        "
                                            class="inline-flex items-center justify-center px-4 py-4 rounded-md bg-light-primary text-white hover:bg-light-primary/90 transition text-sm font-medium"
                                            type="button">
                                            <i class="fas fa-copy lg:mr-2"></i>
                                            <span class="hidden lg:inline">Salin Kode</span>
                                        </button>
                                    @endif
                                </div>

                            </div>
                            <div class="w-full">
                                {{-- Progress bar --}}
                                @php
                                    $remaining = $this->getRemainingUses($voucher);
                                    $percentage = $this->getProgressPercentage($voucher);
                                @endphp
                                @if (!is_null($remaining))
                                    <div class="mt-3">
                                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                            <div class="bg-light-primary h-2 rounded-full transition-all"
                                                style="width: {{ $percentage }}%;"></div>
                                        </div>
                                        <div class="flex justify-between mt-1">

                                            @if ($voucher->type === 'percentage')
                                                <span class="text-xs font-semibold text-primary">Diskon
                                                    {{ $voucher->value }}%</span>
                                            @else
                                                <span class="text-xs font-semibold text-primary">Diskon Rp
                                                    {{ number_format($voucher->value, 0, ',', '.') }}</span>
                                            @endif

                                            <p class="text-xs text-gray-500 ">{{ $remaining }} voucher tersisa
                                            </p>

                                        </div>
                                    </div>
                                @else
                                    <div class="mt-3">
                                        <p class="text-xs text-gray-500">Tidak terbatas</p>

                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="flex gap-1 mt-2 flex-wrap">
                            @if ($voucher->end_date)
                                <div class="text-xs text-gray-500 px-2 py-0.5 rounded-md border border-gray-100">
                                    Exp: {{ \Carbon\Carbon::parse($voucher->end_date)->format('d M Y') }}
                                </div>
                            @endif

                            @if ($voucher->min_order)
                                <div class="text-xs text-gray-500 px-2 py-0.5 rounded-md border border-gray-100">
                                    Min. Pembelian Rp {{ number_format($voucher->min_purchase, 0, ',', '.') }}
                                </div>
                            @endif

                            @if ($voucher->max_discount)
                                <div class="text-xs text-gray-500 px-2 py-0.5 rounded-md border border-gray-100">
                                    Max. Diskon Rp {{ number_format($voucher->max_discount, 0, ',', '.') }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Empty State --}}
    @if ($dashboardVouchers->count() === 0)
        <div class="bg-white rounded-xl px-6 py-12 text-center border border-gray-200">
            <div class="flex flex-col items-center gap-3">
                <i class="fas fa-ticket text-gray-300 text-5xl"></i>
                <p class="font-semibold text-gray-600">Belum ada voucher tersedia</p>
                <p class="text-sm text-gray-500">Temukan voucher tersembunyi yang menarik di media sosial kami!</p>
            </div>
        </div>
    @endif

</div>
