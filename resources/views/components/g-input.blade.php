@props([
    'name' => '',
    'label' => '',
    'type' => 'text',
    'wireModel' => null,
    'error' => null,
    'message' => '',
    'id' => null,
    'class' => '',
    'options' => [],
    'size' => 'w-full',
    'rows' => 3,
    // Props tambahan untuk searchable select
    'placeholder' => '',
    'searchPlaceholder' => 'Cari...',
    'displayKey' => 'name',
    'valueKey' => 'id',
    'searchKeys' => ['name'],
    'noResultsText' => 'Tidak ada hasil ditemukan',
])

@if($type === 'textarea')
    <div class="relative {{ $size ?? 'w-full' }}">
        <textarea
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer {{ $class }}"
            placeholder=" "
            wire:model="{{ $wireModel ?? $name }}"
            {{ $attributes }}
            rows="{{ $rows }}"
        ></textarea>
        <label
            for="{{ $id ?? $name }}"
            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3"
        >
            {{ $label }}
        </label>
    </div>

@elseif($type === 'searchable-select')
    <!-- Alpine.js Searchable Select -->
    <div x-data="{
        open: false,
        search: '',
        selected: @entangle($wireModel ?? $name),
        selectedText: '{{ $placeholder ?: "Pilih " . $label }}',
        options: {{ is_array($options) ? collect($options)->toJson() : $options->toJson() }},
        displayKey: '{{ $displayKey }}',
        valueKey: '{{ $valueKey }}',
        searchKeys: {{ collect($searchKeys)->toJson() }},
        
        get filteredOptions() {
            if (this.search === '') return this.options;
            return this.options.filter(option => {
                return this.searchKeys.some(key => {
                    const value = this.getNestedValue(option, key);
                    return value && value.toString().toLowerCase().includes(this.search.toLowerCase());
                });
            });
        },
        
        getNestedValue(obj, key) {
            return key.split('.').reduce((o, k) => (o || {})[k], obj);
        },
        
        getDisplayValue(option) {
            return this.getNestedValue(option, this.displayKey) || option;
        },
        
        getOptionValue(option) {
            return this.getNestedValue(option, this.valueKey) || option;
        },
        
        selectOption(option) {
            const value = this.getOptionValue(option);
            this.selected = value;
            this.selectedText = this.getDisplayValue(option);
            this.open = false;
            this.search = '';

            // Trigger Livewire update
            @this.set('{{ $wireModel ?? $name }}', value);
        },
        
        clearSelection() {
            this.selected = null;
            this.selectedText = '{{ $placeholder ?: "Pilih " . $label }}';
            this.search = '';

            // Trigger Livewire update
            @this.set('{{ $wireModel ?? $name }}', null);
        },
        
        init() {
            // Watch for changes from Livewire
            this.$watch('selected', value => {
                if (value) {
                    const option = this.options.find(opt => this.getOptionValue(opt) == value);
                    if (option) {
                        this.selectedText = this.getDisplayValue(option);
                    }
                } else {
                    this.selectedText = '{{ $placeholder ?: "Pilih " . $label }}';
                }
            });
            
            // Set initial value if selected exists
            if (this.selected) {
                const option = this.options.find(opt => this.getOptionValue(opt) == this.selected);
                if (option) {
                    this.selectedText = this.getDisplayValue(option);
                }
            }
        }
    }" 
    class="relative {{ $size }}" 
    @click.away="open = false">
    
        <input type="hidden" 
               name="{{ $name }}" 
               :value="selected" 
               wire:model="{{ $wireModel ?? $name }}" />

        <!-- Input Display Button -->
        <button @click="open = !open" 
                type="button"
                class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer text-left {{ $class }}"
                :class="selected ? 'text-gray-900' : 'text-gray-500'">
            <span x-text="selectedText" class="block truncate pr-8"></span>
            
            <!-- Dropdown Arrow -->
            <span class="absolute inset-y-0 right-0 flex items-center pr-3">
                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200" 
                   :class="{'rotate-180': open}"></i>
            </span>
            
            <!-- Clear Button (when selected) -->
            <button x-show="selected" 
                    x-cloak
                    @click.stop="clearSelection()"
                    type="button"
                    class="absolute inset-y-0 right-8 flex items-center pr-2 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-sm"></i>
            </button>
        </button>
        
        <!-- Floating Label -->
        <label
            for="{{ $id ?? $name }}"
            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 left-3"
            :class="open || selected ? 'scale-75 -translate-y-6 text-warna-400' : 'scale-100 translate-y-0'"
        >
            {{ $label }}
        </label>

        <!-- Dropdown Menu -->
        <div x-show="open" 
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-1"
             class="absolute z-50 mt-1 w-full bg-white shadow-lg max-h-64 rounded-md border border-gray-300 overflow-hidden">
            
            <!-- Search Input -->
            <div class="p-3 border-b border-gray-200 bg-gray-50">
                <div class="relative">
                    <input x-model="search" 
                           x-ref="searchInput"
                           @keydown.escape="open = false"
                           placeholder="{{ $searchPlaceholder }}"
                           class="w-full px-3 py-2 pl-9 border border-gray-300 rounded-md focus:ring-2 focus:ring-warna-400 focus:border-warna-400 text-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Options List -->
            <div class="max-h-48 overflow-y-auto">
                <template x-for="option in filteredOptions" :key="getOptionValue(option)">
                    <div @click="selectOption(option)"
                         class="cursor-pointer select-none relative py-3 px-4 hover:bg-warna-50 hover:text-warna-900 transition-colors"
                         :class="selected == getOptionValue(option) ? 'bg-warna-100 text-warna-900' : 'text-gray-900'">
                        
                        <!-- Option Content -->
                         <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div x-text="getDisplayValue(option)" class="font-medium text-sm truncate"></div>
                                
                                <!-- Email -->
                                <template x-if="option.email && displayKey === 'name'">
                                    <div class="text-xs text-gray-500 mt-1" x-text="option.email"></div>
                                </template>
                            </div>
                            
                            <!-- Status Badge -->
                            <template x-if="option.status && displayKey === 'name'">
                                <div class="ml-2 flex-shrink-0">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                        :class="{
                                            'bg-green-100 text-green-800': option.status === 'active',
                                            'bg-yellow-100 text-yellow-800': option.status === 'inactive',
                                            'bg-red-100 text-red-800': option.status === 'suspended',
                                            'bg-gray-100 text-gray-800': !['active', 'inactive', 'suspended'].includes(option.status)
                                        }"
                                        x-text="option.status.charAt(0).toUpperCase() + option.status.slice(1).replace(/_/g, ' ')">
                                    </span>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Selected Indicator -->
                        <span x-show="selected == getOptionValue(option)" 
                              class="absolute inset-y-0 right-0 flex items-center pr-4 text-warna-600">
                            <i class="fas fa-check text-sm"></i>
                        </span>
                    </div>
                </template>
                
                <!-- No Results -->
                <div x-show="filteredOptions.length === 0" 
                     class="px-4 py-6 text-sm text-gray-500 text-center">
                    <i class="fas fa-search text-gray-300 text-2xl mb-2"></i>
                    <p>{{ $noResultsText }}</p>
                </div>
            </div>
        </div>
    </div>

@elseif($type === 'select')
    <div class="relative {{ $size }}">
        <select
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            wire:model="{{ $wireModel ?? $name }}"
            class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  {{ $class }}"
            {{ $attributes }}
        >
            <option value="" disabled selected>Pilih {{ $label }}</option>
            @foreach($options ?? [] as $optionValue => $optionLabel)
                <option class="py-3" value="{{ $optionValue }}">{{ $optionLabel }}</option>
            @endforeach
        </select>
        <label
            for="{{ $id ?? $name }}"
            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 left-3"
        >
            {{ $label }}
        </label>    
    </div>

@elseif($type === 'date')
    <div class="relative {{ $size ?? 'w-full' }}">
        <input
            type="date"
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer {{ $class }}"
            wire:model="{{ $wireModel ?? $name }}"
            {{ $attributes }}
        />
        <label
            for="{{ $id ?? $name }}"
            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3"
        >
            {{ $label }}
        </label>
    </div>

@elseif($type === 'password')
    <div class="relative {{ $size ?? 'w-full' }}" x-data="{ showPassword: false }">
        <input
            :type="showPassword ? 'text' : 'password'"
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            class="block w-full px-3 py-2 md:py-3 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer {{ $class }}"
            placeholder=" "
            wire:model="{{ $wireModel ?? $name }}"
            {{ $attributes }}
        />
        <label
            for="{{ $id ?? $name }}"
             class="absolute text-sm text-secondary duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-secondary peer-focus:dark:text-accent  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3"
        >
            {{ $label }}
        </label>
        <button
            type="button"
            class="absolute inset-y-0 right-0 pr-3 flex items-center"
            @click="showPassword = !showPassword"
        >
            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-gray-400 hover:text-gray-600"></i>
        </button>
    </div>

@else
    <div class="relative {{ $size ?? 'w-full' }}">
        <input
            type="{{ $type }}"
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer {{ $class }}"
            placeholder=" "
            wire:model="{{ $wireModel ?? $name }}"
            {{ $attributes }}
        />
        <label
            for="{{ $id ?? $name }}"
            class="absolute text-sm text-secondary duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-secondary peer-focus:dark:text-accent  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3"
        >
            {{ $label }}
        </label>
    </div>
@endif

@if($error)
    <p class=" text-warna-900 text-xs">{{ $message }}</p>
@endif