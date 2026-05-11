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

@if (session('error'))
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

            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 48 48"><g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"><path d="M24 44a19.94 19.94 0 0 0 14.142-5.858A19.94 19.94 0 0 0 44 24a19.94 19.94 0 0 0-5.858-14.142A19.94 19.94 0 0 0 24 4A19.94 19.94 0 0 0 9.858 9.858A19.94 19.94 0 0 0 4 24a19.94 19.94 0 0 0 5.858 14.142A19.94 19.94 0 0 0 24 44Z"/><path stroke-linecap="round" d="m16 24l6 6l12-12"/></g></svg>
            
            <span class="font-medium whitespace-nowrap">{{ session('error') }}</span>
        </div>
    </div>
@endif