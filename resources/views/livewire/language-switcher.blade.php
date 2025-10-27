<div class="relative w-full lg:w-auto"> <button wire:click="toggle"
            class="w-full lg:w-20 inline-flex justify-between items-center px-4 py-2 bg-gray-200 text-gray-900 font-medium rounded-lg shadow hover:bg-gray-200 transition">
        {{ $lang == 'id' ? 'ID 🇮🇩' : 'EN 🇺🇸' }}
    </button>

    @if($open)
        <div class="absolute left-0 lg:right-0 lg:left-auto mt-2 w-full lg:w-36 bg-white shadow-lg rounded-lg z-50 ring-1 ring-black ring-opacity-5 transition duration-200">
            <button wire:click="setLang('id')" class="w-full px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                <span>🇮🇩</span>
                <span>Indonesia</span>
            </button>
            <button wire:click="setLang('en')" class="w-full px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                <span>🇺🇸</span>
                <span>English</span>
            </button>
        </div>
    @endif
</div>