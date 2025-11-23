<div>

    <!-- Desktop Version (Dropdown) -->
    <div class="relative text-left hidden lg:inline-block">
        <!-- Toggle button -->
        <button wire:click="toggle"
                class="inline-flex justify-between items-center w-24 px-4 py-2 bg-gray-200 text-gray-900 font-medium rounded-lg shadow hover:bg-gray-300 transition">
            {{ $lang == 'id' ? 'ID 🇮🇩' : 'EN 🇺🇸' }}
        </button>

        <!-- Dropdown -->
        @if($open)
            <div class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-lg z-50 ring-1 ring-black ring-opacity-5 transition">
                <button wire:click="setLang('id')"
                        class="w-full px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                    <span>🇮🇩</span> <span>Indonesia</span>
                </button>
                <button wire:click="setLang('en')"
                        class="w-full px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                    <span>🇺🇸</span> <span>English</span>
                </button>
            </div>
        @endif
    </div>

    <!-- Mobile Version (Big buttons) -->
    <div class="flex lg:hidden gap-3 mt-4">
        <button wire:click="setLang('id')"
            class="flex-1 px-4 py-3 text-center font-semibold rounded-lg border
            {{ $lang == 'id' ? 'bg-primary text-white border-primary' : 'bg-gray-200 text-gray-700 border-gray-300' }}">
            🇮🇩 Indonesia
        </button>

        <button wire:click="setLang('en')"
            class="flex-1 px-4 py-3 text-center font-semibold rounded-lg border
            {{ $lang == 'en' ? 'bg-primary text-white border-primary' : 'bg-gray-200 text-gray-700 border-gray-300' }}">
            🇺🇸 English
        </button>
    </div>

</div>
