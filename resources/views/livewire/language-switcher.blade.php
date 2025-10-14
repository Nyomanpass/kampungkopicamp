<div class="relative inline-block text-left">
    <!-- Tombol toggle -->
    <button wire:click="toggle"
            class="inline-flex justify-between items-center w-20 px-4 py-2 bg-gray-200 text-gray-900 font-medium rounded-lg shadow hover:bg-gray-200 transition">
        {{ $lang == 'id' ? 'ID 🇮🇩' : 'EN 🇺🇸' }}
       
    </button>

    <!-- Dropdown -->
    @if($open)
        <div class="absolute right-0 mt-2 w-36 bg-white shadow-lg rounded-lg z-50 ring-1 ring-black ring-opacity-5 transition duration-200">
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
