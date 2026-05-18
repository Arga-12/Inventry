@if (session('success'))
    <!-- Wrapper Alpine.js -->
    <div x-data="{ show: false }"
         x-init="setTimeout(() => show = true, 10); setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="translate-y-[150%] opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-[150%] opacity-0"
         class="fixed bottom-10 left-1/2 transform -translate-x-1/2 z-[100]"
         style="display: none;">
         
        <div class="px-6 py-4 bg-green-100 border border-green-400 text-green-700 rounded-full shadow-2xl flex items-center gap-3">
            
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" viewBox="0 0 48 48"><g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"><path d="M24 44a19.94 19.94 0 0 0 14.142-5.858A19.94 19.94 0 0 0 44 24a19.94 19.94 0 0 0-5.858-14.142A19.94 19.94 0 0 0 24 4A19.94 19.94 0 0 0 9.858 9.858A19.94 19.94 0 0 0 4 24a19.94 19.94 0 0 0 5.858 14.142A19.94 19.94 0 0 0 24 44Z"/><path stroke-linecap="round" d="m16 24l6 6l12-12"/></g></svg>
            
            <span class="font-medium whitespace-nowrap">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if ($errors->any() || session('error'))
    <div x-data="{ show: false }"
         x-init="setTimeout(() => show = true, 10); setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="translate-y-[150%] opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-[150%] opacity-0"
         class="fixed bottom-10 left-1/2 transform -translate-x-1/2 z-[100]"
         style="display: none;">
         
        <div class="px-6 py-4 bg-red-100 border border-red-400 text-red-700 rounded-full shadow-2xl flex items-center gap-3">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 32 32">
                <path d="M0 0h32v32H0z" fill="none" />
                <path fill="currentColor" d="M16 3C8.832 3 3 8.832 3 16s5.832 13 13 13s13-5.832 13-13S23.168 3 16 3m0 2c6.087 0 11 4.913 11 11s-4.913 11-11 11S5 22.087 5 16S9.913 5 16 5m-3.78 5.78l-1.44 1.44L14.564 16l-3.782 3.78l1.44 1.44L16 17.437l3.78 3.78l1.44-1.437L17.437 16l3.78-3.78l-1.437-1.44L16 14.564l-3.78-3.782z" />
            </svg>

            
            <span class="font-medium whitespace-nowrap">{{ $errors->any() ? $errors->first() : session('error') }}</span>
        </div>
    </div>
@endif