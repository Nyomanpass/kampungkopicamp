<div class="min-h-screen bg-gray-50 py-12 md:py-13 lg:py-24">
    <div class="max-w-4xl mx-auto px-6 sm:px-6 lg:px-8">

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center gap-2">
                @foreach ([1 => 'Detail', 2 => 'Tanggal', 3 => 'Add-ons', 4 => 'Summary'] as $step => $label)
                    <div class="flex items-center">
                        <!-- Step Circle -->
                        <div class="flex flex-col items-center">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold transition-all
                                {{ $currentStep >= $step ? 'bg-primary text-white' : 'bg-gray-200 text-gray-400' }}">
                                {{ $step }}
                            </div>
                            <span
                                class="text-xs mt-1 hidden sm:block {{ $currentStep >= $step ? 'text-primary font-medium' : 'text-gray-400' }}">
                                {{ $label }}
                            </span>
                        </div>

                        <!-- Connector Line -->
                        @if ($step < 4)
                            <div
                                class="w-12 sm:w-16 h-0.5 mx-2 {{ $currentStep > $step ? 'bg-primary' : 'bg-gray-200' }}">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Card Container -->
        <div class="bg-white rounded-2xl md:shadow-lg py-6 md:p-6 lg:p-8">
            <!-- Product Header -->
            <div class="flex items-center gap-4 mb-6 pb-6 border-b">
                @if ($product->images && count($product->images) > 0)
                    <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}"
                        class="w-20 h-20 rounded-lg object-cover">
                @endif
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $product->name }}</h2>
                    <p class="text-gray-600">{{ ucfirst($product->type) }}</p>
                </div>
            </div>

            <!-- STEP 1: Input People & Nights -->
            @if ($currentStep === 1)
                <div>
                    <h3 class="text-2xl font-bold mb-6">Berapa orang dan berapa malam?</h3>

                    <form wire:submit.prevent="nextToCalendar" class="space-y-6">
                        <!-- People Count -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Orang
                            </label>
                            <input type="number" wire:model="peopleCount" min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            @error('peopleCount')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                            @if ($product->capacity_per_unit)
                                <p class="text-sm text-gray-500 mt-1">
                                    Kapasitas maksimal per unit: {{ $product->capacity_per_unit }} orang
                                </p>
                            @endif
                        </div>

                        <!-- Night Count -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Malam
                            </label>
                            <input type="number" wire:model="nightCount" min="1" max="30"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            @error('nightCount')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Estimated Units (if accommodation) -->
                        @if ($product->type === 'accommodation' && $product->capacity_per_unit)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-sm text-blue-800">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Estimasi unit yang dibutuhkan:
                                    <strong>
                                        {{ $peopleCount && $product->capacity_per_unit ? ceil($peopleCount / $product->capacity_per_unit) : 0 }}
                                        unit
                                    </strong>
                                </p>
                                <p class="text-xs text-blue-600 mt-1">
                                    Pembagian tamu per unit dapat diatur saat check-in
                                </p>
                            </div>
                        @endif

                        <div class="flex items-center justify-between mt-8 gap-4">
                            <a class="py-4 w-1/3 text-center hover:bg-gray-100 rounded-lg transition-all duration-200"
                                href="{{ Route('package.detail', $product->slug) }}">
                                Batal
                            </a>

                            <button type="submit" @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                                class="w-3/4 bg-primary hover:bg-light-primary text-white font-semibold py-4 rounded-lg transition-all duration-200 active:scale-95">
                                Lanjut Pilih Tanggal
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- STEP 2: Calendar -->
            @if ($currentStep === 2)
                <div>
                    <div class="flex items-center justify-center mb-6">

                        <h3 class="text-2xl font-bold">Pilih Tanggal</h3>
                    </div>

                    <!-- Selected Info -->
                    <div class="lg:w-[80%] mx-auto grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center">
                            <p class="text-sm text-gray-600">Jumlah Orang</p>
                            <p class="text-2xl font-bold text-primary">{{ $peopleCount }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center">
                            <p class="text-sm text-gray-600">Jumlah Malam</p>
                            <p class="text-2xl font-bold text-primary">{{ $nightCount }}</p>
                        </div>
                    </div>

                    @if ($requiredUnits > 0)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <p class="text-sm text-blue-800">
                                Unit yang dibutuhkan: <strong>{{ $requiredUnits }} unit</strong>
                            </p>
                        </div>
                    @endif

                    <!-- Calendar -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <!-- Month Navigation -->
                        <div class="flex items-center justify-between mb-4">
                            <button wire:click="previousMonth"
                                class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <h4 class="text-lg font-semibold">{{ $monthName }}</h4>
                            <button wire:click="nextMonth" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <!-- Day Headers -->
                        <div class="grid grid-cols-7 gap-2 mb-2">
                            @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                                <div class="text-center text-sm font-semibold text-gray-600 py-2">
                                    {{ $day }}
                                </div>
                            @endforeach
                        </div>

                        <!-- Calendar Days -->
                        <div class="grid grid-cols-7 gap-2">
                            @foreach ($calendarDays as $day)
                                @if ($day === null)
                                    <div class="aspect-square"></div>
                                @else
                                    @php
                                        $dateStr = $day->format('Y-m-d');
                                        $isPast = $day->isPast() && !$day->isToday();
                                        $isToday = $day->isToday();
                                        $isSelected = in_array($dateStr, $selectedDates);
                                        $isStartDate = $selectedStartDate === $dateStr;

                                        // Check availability
                                        $hasAvailability = isset($availabilityData[$dateStr]);
                                        $availableUnits = $hasAvailability
                                            ? $availabilityData[$dateStr]['available_unit']
                                            : 0;
                                        $availableSeats = $hasAvailability
                                            ? $availabilityData[$dateStr]['available_seat']
                                            : 0;

                                        $isAvailable = false;
                                        if ($product->type === 'touring') {
                                            $isAvailable = $availableSeats >= $peopleCount;
                                        } else {
                                            $isAvailable = $availableUnits >= $requiredUnits;
                                        }
                                    @endphp

                                    <button wire:click="selectDate('{{ $dateStr }}')"
                                        @if ($isPast || !$isAvailable) disabled @endif
                                        class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm transition-all
                                            @if ($isPast) bg-gray-100 text-gray-400 cursor-not-allowed
                                            @elseif(!$isAvailable)
                                                bg-red-50 text-red-400 cursor-not-allowed line-through
                                            @elseif($isStartDate)
                                                bg-primary text-white font-bold ring-2 ring-primary/50
                                            @elseif($isSelected)
                                                bg-primary/20 text-primary font-semibold
                                            @else
                                                bg-white hover:bg-primary/10 border border-gray-200 hover:border-primary @endif
                                            @if ($isToday) ring-2 ring-blue-500 @endif
                                        ">
                                        <span class="text-base">{{ $day->day }}</span>
                                        @if (!$isPast && $isAvailable)
                                            <span class="text-[10px] text-gray-500">
                                                {{ $product->type === 'touring' ? $availableSeats : $availableUnits }}
                                            </span>
                                        @endif
                                        @if ($isToday)
                                            <span class="absolute -bottom-1 w-1 h-1 bg-blue-500 rounded-full"></span>
                                        @endif
                                    </button>
                                @endif
                            @endforeach
                        </div>

                        <!-- Legend -->
                        <div class="flex items-center gap-4 mt-4 text-xs">
                            <div class="flex items-center gap-1">
                                <div class="w-4 h-4 bg-primary rounded"></div>
                                <span>Dipilih</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="w-4 h-4 bg-white border-2 border-blue-500 rounded"></div>
                                <span>Hari Ini</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="w-4 h-4 bg-red-50 border border-red-200 rounded"></div>
                                <span>Tidak tersedia</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="w-4 h-4 bg-gray-100 rounded"></div>
                                <span>Lewat</span>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Date Info -->
                    @if ($selectedStartDate)
                        <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                            <h4 class="font-semibold text-green-800 mb-2">Tanggal Terpilih:</h4>
                            <p class="text-sm text-green-700">
                                <i class="fas fa-calendar-check mr-2"></i>
                                Check-in: {{ Carbon\Carbon::parse($selectedStartDate)->format('d M Y') }}
                            </p>
                            <p class="text-sm text-green-700">
                                <i class="fas fa-calendar-times mr-2"></i>
                                Check-out:
                                {{ Carbon\Carbon::parse($selectedStartDate)->addDays((int) $nightCount)->format('d M Y') }}
                            </p>

                            @if ($estimatedPrice > 0)
                                <div class="mt-3 pt-3 border-t border-green-300">
                                    <p class="text-lg font-bold text-green-900">
                                        Estimasi Harga: Rp {{ number_format($estimatedPrice, 0, ',', '.') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="flex items-center justify-between mt-8 gap-4">
                        <a class="py-4 w-1/3 text-center hover:bg-gray-100 roudned-lg transition-all duration-200"
                            wire:click="goToStep(1)">
                            Kembali
                        </a>

                        <button wire:click="nextToAddons" @if (!$selectedStartDate) disabled @endif
                            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                            class="w-3/4 bg-primary hover:bg-light-primary text-white font-semibold py-4 rounded-lg transition-all duration-200 active:scale-95 disabled:bg-gray-300 disabled:cursor-not-allowed disabled:hover:bg-gray-300">
                            Lanjut ke Add-ons
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>



                    @if (session()->has('error'))
                        <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                            <p class="text-sm text-red-800">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ session('error') }}
                            </p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- STEP 3: Add-ons -->
            @if ($currentStep == 3)
                <div>
                    <h3 class="text-2xl font-bold mb-6">Pilih Add-ons (Opsional)</h3>

                    <!-- Add-ons List -->
                    @if ($addons->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-gray-500">Tidak ada add-ons tersedia</p>
                            <button wire:click="nextToSummary"
                                class="mt-4 bg-primary hover:bg-light-primary text-white font-semibold px-6 py-3 rounded-lg transition-all duration-200">
                                Lanjut ke Summary →
                            </button>
                        </div>
                    @else
                        <!-- Group by Pricing Type -->
                        @php
                            $groupedAddons = $addons->groupBy('pricing_type');
                            $pricingLabels = [
                                'per_booking' => 'Per Booking',
                                'per_person' => 'Per Orang',
                                'per_unit_per_night' => 'Per Unit Per Malam',
                                'per_hour' => 'Per Jam',
                                'per_slot' => 'Per Slot',
                            ];
                        @endphp

                        @foreach ($groupedAddons as $pricingType => $groupAddons)
                            <div class="mb-8">
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">
                                    {{ $pricingLabels[$pricingType] ?? $pricingType }}
                                </h4>

                                <div class="relative">
                                    <!-- Scroll Container -->
                                    <div
                                        class="overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                        <div class="flex gap-4 min-w-max px-1">
                                            @foreach ($groupAddons as $addon)
                                                @php
                                                    $isSelected = isset($selectedAddons[$addon->id]);
                                                    $addonData = $isSelected ? $selectedAddons[$addon->id] : null;
                                                @endphp

                                                <div
                                                    class="w-72 flex-shrink-0 border rounded-xl overflow-hidden transition-all duration-200 
                                                    {{ $isSelected ? 'border-primary shadow-md' : 'border-gray-200 hover:border-gray-300' }}">

                                                    <!-- Image -->
                                                    <div class="relative h-40 bg-gray-100">
                                                        @if ($addon->image)
                                                            <img src="{{ asset('storage/' . $addon->image) }}"
                                                                alt="{{ $addon->name }}"
                                                                class="w-full h-full object-cover">
                                                        @else
                                                            <div
                                                                class="w-full h-full flex items-center justify-center">
                                                                <svg class="w-12 h-12 text-gray-300" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                            </div>
                                                        @endif

                                                        @if ($isSelected)
                                                            <div
                                                                class="absolute top-2 right-2 bg-primary text-white px-2 py-1 rounded-full text-xs font-semibold">
                                                                ✓ Dipilih
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Content -->
                                                    <div class="p-4">
                                                        <h5 class="font-semibold text-gray-900 mb-2">
                                                            {{ $addon->name }}</h5>

                                                        <p class="text-primary font-bold text-lg mb-3">
                                                            Rp {{ number_format($addon->price, 0, ',', '.') }}
                                                            <span class="text-xs text-gray-500 font-normal">/
                                                                {{ $addon->getPricingLabel() }}</span>
                                                        </p>

                                                        <!-- Description Toggle -->
                                                        @if ($addon->description)
                                                            <div x-data="{ open: false }">
                                                                <button @click="open = !open"
                                                                    class="text-xs text-gray-500 hover:text-primary mb-3 flex items-center gap-1">
                                                                    <i class="fas fa-info-circle"></i>
                                                                    <span
                                                                        x-text="open ? 'Sembunyikan detail' : 'Lihat detail'"></span>
                                                                </button>

                                                                <div x-show="open" x-collapse
                                                                    class="text-xs text-gray-600 mb-3 bg-gray-50 p-2 rounded">
                                                                    {{ $addon->description }}
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <!-- Action Button or Controls -->
                                                        @if (!$isSelected)
                                                            <button wire:click="addAddon({{ $addon->id }})"
                                                                class="w-full py-2 bg-primary text-white rounded-lg hover:bg-light-primary transition-colors text-sm font-medium">
                                                                + Tambah
                                                            </button>
                                                        @else
                                                            <div class="space-y-3">
                                                                <!-- Qty Controls -->
                                                                @if (in_array($addon->pricing_type, ['per_booking', 'per_unit_per_night']))
                                                                    <div
                                                                        class="flex items-center justify-between bg-gray-50 rounded-lg p-2">
                                                                        <span
                                                                            class="text-xs text-gray-600">Jumlah:</span>
                                                                        <div class="flex items-center gap-2">
                                                                            <button
                                                                                wire:click="updateAddonQty({{ $addon->id }}, 'qty', {{ $addonData['qty'] - 1 }})"
                                                                                class="w-7 h-7 rounded border border-gray-300 hover:bg-white text-sm">-</button>
                                                                            <span
                                                                                class="w-8 text-center font-semibold">{{ $addonData['qty'] }}</span>
                                                                            <button
                                                                                wire:click="updateAddonQty({{ $addon->id }}, 'qty', {{ $addonData['qty'] + 1 }})"
                                                                                class="w-7 h-7 rounded border border-gray-300 hover:bg-white text-sm">+</button>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <!-- Hours Controls -->
                                                                @if ($addon->pricing_type === 'per_hour')
                                                                    <div
                                                                        class="flex items-center justify-between bg-gray-50 rounded-lg p-2">
                                                                        <span class="text-xs text-gray-600">Jam:</span>
                                                                        <div class="flex items-center gap-2">
                                                                            <button
                                                                                wire:click="updateAddonQty({{ $addon->id }}, 'hours', {{ $addonData['hours'] - 1 }})"
                                                                                class="w-7 h-7 rounded border border-gray-300 hover:bg-white text-sm">-</button>
                                                                            <span
                                                                                class="w-8 text-center font-semibold">{{ $addonData['hours'] }}</span>
                                                                            <button
                                                                                wire:click="updateAddonQty({{ $addon->id }}, 'hours', {{ $addonData['hours'] + 1 }})"
                                                                                class="w-7 h-7 rounded border border-gray-300 hover:bg-white text-sm">+</button>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <!-- Slots Controls -->
                                                                @if ($addon->pricing_type === 'per_slot')
                                                                    <div
                                                                        class="flex items-center justify-between bg-gray-50 rounded-lg p-2">
                                                                        <span
                                                                            class="text-xs text-gray-600">Slot:</span>
                                                                        <div class="flex items-center gap-2">
                                                                            <button
                                                                                wire:click="updateAddonQty({{ $addon->id }}, 'slots', {{ $addonData['slots'] - 1 }})"
                                                                                class="w-7 h-7 rounded border border-gray-300 hover:bg-white text-sm">-</button>
                                                                            <span
                                                                                class="w-8 text-center font-semibold">{{ $addonData['slots'] }}</span>
                                                                            <button
                                                                                wire:click="updateAddonQty({{ $addon->id }}, 'slots', {{ $addonData['slots'] + 1 }})"
                                                                                class="w-7 h-7 rounded border border-gray-300 hover:bg-white text-sm">+</button>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <!-- Per Person Info -->
                                                                @if ($addon->pricing_type === 'per_person')
                                                                    <div
                                                                        class="bg-gray-50 rounded-lg p-2 text-xs text-gray-600 text-center">
                                                                        {{ $peopleCount }} orang × Rp
                                                                        {{ number_format($addon->price, 0, ',', '.') }}
                                                                    </div>
                                                                @endif

                                                                <button wire:click="removeAddon({{ $addon->id }})"
                                                                    class="w-full py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors text-sm font-medium">
                                                                    Hapus
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Scroll Indicator (optional) -->
                                    <div class="text-center text-xs text-gray-500 mt-2">
                                        <i class="fas fa-arrows-alt-h"></i> Geser untuk melihat lebih banyak
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Add-ons Total (Only if addons selected) -->
                        @if ($addonsTotal > 0)
                            <div class="bg-primary/5 border border-primary/20 rounded-lg p-4 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">Total Add-ons:</span>
                                    <span class="text-xl font-bold text-primary">
                                        Rp {{ number_format($addonsTotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <!-- Action Button -->
                        <button wire:click="nextToSummary" @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                            class="w-full bg-primary hover:bg-light-primary text-white font-semibold py-4 rounded-lg transition-all duration-200 active:scale-95">
                            Lanjut ke Summary
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    @endif
                </div>
            @endif

            <!-- STEP 4: Summary & Customer Info -->
            @if ($currentStep === 4)
                <div>
                    <div class="flex items-center justify-left mb-6">
                        <button wire:click="goToStep(3)" class="text-primary hover:underline text-sm">
                            <i class="fas fa-angle-left mr-2"></i>
                        </button>
                        <h3 class="text-xl font-bold">Ringkasan Booking</h3>
                    </div>

                    @guest
                        <div class="bg-warning/10 border border-warning/40 rounded-lg p-4 mb-6">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-warning flex-shrink-0 mt-0.5" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-yellow-800">
                                    <p class="font-semibold mb-1">Perhatian</p>
                                    <p>Pastikan email dan nomor WhatsApp yang Anda masukkan benar. Anda tidak dapat membuat
                                        booking baru hingga booking ini selesai atau expired (2 jam).</p>
                                </div>
                            </div>
                        </div>
                    @endguest

                    <!-- Error message flash -->
                    @if (session()->has('error'))
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-red-800">
                                    {{ session('error') }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class=" space-y-6">
                        <!-- Left Column: Customer Info -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Customer Information Form -->

                            <!-- Booking Details -->
                            <div class="bg-white border border-gray-200 rounded-lg py-6 md:p-6">
                                <h4 class="font-semibold text-lg mb-4">Detail Booking</h4>

                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Produk:</span>
                                        <span class="font-medium">{{ $product->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tipe:</span>
                                        <span class="font-medium">{{ ucfirst($product->type) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Check-in:</span>
                                        <span
                                            class="font-medium">{{ Carbon\Carbon::parse($selectedStartDate)->format('d M Y') }}
                                            <span wire:click="goToStep(2)"><i
                                                    class="text-accent fa-solid fa-pen-to-square active:scale-95 transition-all cursor-pointer"></i></span>
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Durasi:</span>
                                        <span class="font-medium">
                                            {{ $nightCount }} malam
                                            <span wire:click="goToStep(1)"><i
                                                    class="text-accent fa-solid fa-pen-to-square active:scale-95 transition-all cursor-pointer"></i></span>
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Jumlah Orang:</span>
                                        <span class="font-medium">
                                            {{ $peopleCount }} orang
                                            <span wire:click="goToStep(1)"><i
                                                    class="text-accent fa-solid fa-pen-to-square active:scale-95 transition-all cursor-pointer"></i></span>
                                        </span>
                                    </div>
                                    @if ($requiredUnits > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Unit Dibutuhkan:</span>
                                            <span class="font-medium">{{ $requiredUnits }} unit</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Selected Add-ons -->
                            @if (!empty($selectedAddons))
                                <div class="bg-white border border-gray-200 rounded-lg py-6 md:p-6">
                                    <div class="flex  items-center justify-between  mb-4">
                                        <h4 class="font-semibold text-lg w-max">Add-ons Dipilih</h4>
                                        <button wire:click="goToStep(3)"><i
                                                class="text-accent fa-solid fa-pen-to-square active:scale-95 transition-all cursor-pointer"></i></button>
                                    </div>

                                    <div class="space-y-3">
                                        @foreach ($this->getSelectedAddonsDetails() as $item)
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="font-medium">{{ $item['addon']->name }}</p>
                                                    <p class="text-sm text-gray-600">
                                                        @if ($item['addon']->pricing_type === 'per_booking')
                                                            {{ $item['data']['qty'] }}x @ Rp
                                                            {{ number_format($item['addon']->price, 0, ',', '.') }}
                                                        @elseif($item['addon']->pricing_type === 'per_unit_per_night')
                                                            {{ $item['data']['qty'] }}x {{ $nightCount }} malam @ Rp
                                                            {{ number_format($item['addon']->price, 0, ',', '.') }}
                                                        @elseif($item['addon']->pricing_type === 'per_person')
                                                            {{ $peopleCount }} orang @ Rp
                                                            {{ number_format($item['addon']->price, 0, ',', '.') }}
                                                        @elseif($item['addon']->pricing_type === 'per_hour')
                                                            {{ $item['data']['hours'] }} jam @ Rp
                                                            {{ number_format($item['addon']->price, 0, ',', '.') }}
                                                        @elseif($item['addon']->pricing_type === 'per_slot')
                                                            {{ $item['data']['slots'] }} slot @ Rp
                                                            {{ number_format($item['addon']->price, 0, ',', '.') }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <span class="font-medium">Rp
                                                    {{ number_format($item['subtotal'], 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif



                            {{-- Price Summary with Discount --}}

                            <div class="bg-white border border-gray-200 rounded-lg py-6 md:p-6">
                                <h4 class="font-semibold text-lg mb-4">Informasi Pemesan</h4>

                                <form class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Nama Lengkap <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" wire:model="customerName"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                            placeholder="Masukkan nama lengkap">
                                        @error('customerName')
                                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="email" wire:model.live.debounce.500ms="customerEmail"
                                                @auth disabled @endauth
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed"
                                                placeholder="email@example.com">

                                            {{-- ✅ Loading indicator --}}
                                            <div wire:loading wire:target="customerEmail"
                                                class="absolute right-3 top-3">
                                                <i class="fas fa-spinner fa-spin text-gray-400"></i>
                                            </div>

                                            {{-- ✅ Email exists indicator --}}
                                            @if ($emailExists && !auth()->check())
                                                <div class="absolute right-3 top-3">
                                                    <i class="fas fa-user-check text-yellow-500"
                                                        title="Email sudah terdaftar"></i>
                                                </div>
                                            @endif
                                        </div>

                                        @error('customerEmail')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror

                                        {{-- ✅ Hint text jika email terdaftar --}}
                                        @if ($emailExists && !auth()->check())
                                            <p class="text-xs text-yellow-600 mt-1 flex items-center gap-1">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                Email ini sudah terdaftar.
                                                <button wire:click="switchToLoginFromEmail"
                                                    class="text-primary font-semibold hover:underline">
                                                    Login untuk gunakan voucher
                                                </button>
                                            </p>
                                        @endif
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            No. WhatsApp <span class="text-red-500">*</span>
                                        </label>
                                        <input type="tel" wire:model="customerPhone"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                            placeholder="08xxxxxxxxxx">
                                        @error('customerPhone')
                                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Permintaan Khusus (Opsional)
                                        </label>
                                        <textarea wire:model="specialRequest" rows="3"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                            placeholder="Contoh: alergi makanan, permintaan lokasi, dll."></textarea>
                                        @error('specialRequest')
                                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-ticket-alt text-primary mr-2"></i>
                                Voucher / Promo Code
                            </h3>

                            @if ($appliedVoucher)
                                {{-- Applied Voucher --}}
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                                <span
                                                    class="font-semibold text-green-800">{{ $appliedVoucher->code }}</span>
                                            </div>
                                            <p class="text-sm text-green-700 mt-1">{{ $voucherMessage }}</p>

                                            @if ($voucherBonusMeta)
                                                <div class="mt-3 space-y-2">
                                                    @foreach ($voucherBonusMeta as $bonus)
                                                        <div class="flex items-center text-sm bg-white rounded p-2">
                                                            <i class="fas fa-gift text-primary mr-2"></i>
                                                            <span class="font-medium">{{ $bonus['name'] }}</span>
                                                            <span
                                                                class="ml-2 text-gray-600">({{ $bonus['qty_total'] }}x)</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <button wire:click="removeVoucher"
                                            class="text-red-600 hover:text-red-800 ml-4">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @else
                                {{-- Voucher Input --}}
                                <div class="flex gap-2">
                                    <div class="flex-1">
                                        <input type="text" wire:model="voucherCode"
                                            placeholder="Masukkan kode voucher"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent uppercase"
                                            @keydown.enter="$wire.applyVoucher()">

                                        @if ($voucherError)
                                            <p class="text-sm text-red-600 mt-1">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $voucherError }}
                                            </p>
                                        @endif
                                    </div>
                                    <button wire:click="applyVoucher" @guest disabled @endguest
                                        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors whitespace-nowrap disabled:bg-gray-300 disabled:cursor-not-allowed disabled:hover:bg-gray-300 ">
                                        Gunakan
                                    </button>
                                </div>
                                @if (session()->has('success'))
                                    <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                                        <p class="text-sm text-green-800">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            {{ session('success') }}
                                        </p>
                                    </div>
                                @endif
                                @guest
                                    <div
                                        class="flex items-center justify-between px-6 py-3 bg-light-primary/40  rounded-lg mt-6">
                                        <div class="flex justify-center items-center gap-3">
                                            <div
                                                class="size-11 flex items-center justify-center rounded-full bg-light-primary">
                                                <i class="fa-solid fa-gift text-white text-lg"></i>
                                            </div>
                                            <p class="font-medium">Ayo Log in biar bisa redeem promonya!</p>
                                        </div>
                                        <button wire:click="openLoginModal"
                                            class="rounded-lg bg-light-primary text-white px-6 py-2 font-semibold hover:scale-105 active:scale-95 transition-all">Log
                                            in</button>
                                    </div>
                                @endguest
                            @endif
                        </div>


                        <!-- Right Column: Price Summary -->
                        <div class="col-span-1">
                            <div class="bg-primary/5 rounded-lg p-6 sticky top-24">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Rincian Harga</h3>

                                <div class="space-y-3">
                                    <div class="flex justify-between text-gray-700">
                                        <span>Subtotal Produk</span>
                                        <span>Rp {{ number_format($estimatedPrice, 0, ',', '.') }}</span>
                                    </div>

                                    @if ($addonsTotal > 0)
                                        <div class="flex justify-between text-gray-700">
                                            <span>Add-ons</span>
                                            <span>Rp {{ number_format($addonsTotal, 0, ',', '.') }}</span>
                                        </div>
                                    @endif

                                    @if ($voucherDiscount > 0)
                                        <div class="flex justify-between text-green-600">
                                            <span>
                                                <i class="fas fa-tag mr-1"></i>
                                                Diskon Voucher
                                            </span>
                                            <span>- Rp {{ number_format($voucherDiscount, 0, ',', '.') }}</span>
                                        </div>
                                    @endif

                                    <div class="border-t pt-3 flex justify-between text-xl font-bold text-primary">
                                        <span>Total</span>
                                        <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                                    </div>
                                </div>


                                <button wire:click="proceedToPayment" wire:loading.attr="disabled"
                                    @if (session()->has('error')) @click="window.scrollTo({ top: 0, behavior: 'smooth' })" @endif
                                    class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed mt-10">
                                    <span wire:loading.remove wire:target="proceedToPayment">
                                        Lanjutkan Pembayaran
                                    </span>
                                    <span wire:loading wire:target="proceedToPayment">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                        Memproses...
                                    </span>
                                </button>

                                <p class="text-xs text-gray-600 text-center mt-4">
                                    Dengan melanjutkan, Anda menyetujui <a href="#"
                                        class="text-primary hover:underline">Syarat & Ketentuan</a> kami
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <x-auth-modal :show="$showLoginModal" :view="$modalView" />

    <x-email-confirm-modal :show="$showEmailConfirmModal" :email="$existingUserEmail" />
</div>
