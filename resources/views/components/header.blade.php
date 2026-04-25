<header class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-black/10 to-transparent flex items-start pt-4 pr-4 justify-end z-50 pointer-events-none">
    <div class="pointer-events-auto h-16 w-52 bg-[#F5F5F5] p-2 rounded-full flex items-center justify-between gap-2 shadow-lg">

        {{-- foto profil --}}
        <div class="flex items-center gap-2">
            <div class="h-12 w-12 rounded-full flex items-center justify-center overflow-hidden">
                <img src={{ asset('images/mygw.jpeg') }} class="w-full h-full object-cover">
            </div>

            <div class="flex flex-col">
                <h2 class="text-sm font-semibold text-[#363062]">Argandull</h2>
                <div class="h-4 w-full flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M12 6c1.654 0 3 1.346 3 3s-1.346 3-3 3s-3-1.346-3-3s1.346-3 3-3m0-2C9.236 4 7 6.238 7 9s2.236 5 5 5s5-2.238 5-5s-2.236-5-5-5m0 13c2.021 0 3.301.771 3.783 1.445c-.683.26-1.969.555-3.783.555c-1.984 0-3.206-.305-3.818-.542C8.641 17.743 9.959 17 12 17m0-2c-3.75 0-6 2-6 4c0 1 2.25 2 6 2c3.518 0 6-1 6-2c0-2-2.354-4-6-4"/></svg>
                    <p class="text-xs text-[#363062] font-light">Peminjam</p>
                </div>
            </div>
        </div>

        {{-- dropdown menu --}}
        <div x-data="{ open: false }" class="relative inline-block text-left mr-2">  
            <button @click="open = !open" @click.away="open = false" class="flex items-center focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" 
                class="h-5 w-5 text-[#363062] transition-transform duration-200 rotate-180" 
                :class="open ? 'rotate-0' : 'rotate-180'" 
                viewBox="0 0 1024 1024">
                <path fill="currentColor" d="M488.8 344.3L149 701a32 32 0 0 0 0 44.2l.4.3a29.4 29.4 0 0 0 42.7 0l320-335.8l319.8 335.8a29.4 29.4 0 0 0 42.7 0l.4-.3a32 32 0 0 0 0-44.2L535.2 344.3a32 32 0 0 0-46.4 0"/>
            </svg>
        </button>

        <div x-show="open" class="absolute right-0 mt-6 w-48 rounded-xl bg-white border border-gray-200 shadow-lg py-1">
            <a href="#" class="block px-4 py-2 text-xs font-medium text-[#363062] hover:bg-gray-50">Profil Saya</a>
            <div class="border-t border-gray-100 my-1"></div>
            <a href="#" class="block px-4 py-2 text-xs font-bold text-red-500 hover:bg-red-50">Keluar</a>
        </div>
    </div>
</div>
</header>