<header class="h-16 border-b border-[#363062] w-full bg-gray-100 flex items-center p-4 font-semibold justify-between">
    Header
    <div class="bg-[#363062] w-36 h-full rounded-full flex items-center justify-between gap-2 px-2 py-1">
        {{-- icon profil --}}
        <div class="h-6 w-6 rounded-full overflow-hidden">
            <img src="{{ asset('images/mygw.jpeg')}}" class="w-full h-full object-cover">
        </div>

        {{-- nama --}}
        <h1 class="font-normal text-sm text-white">4rgandull</h1>

        {{-- drop down --}}
        <div class="relative inline-block" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white mt-1" :class="{ 'rotate-180': !open }" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m17 14l-5-5l-5 5"/></svg>
            </button>
            <div 
                x-show="open" 
                class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white"
            >
                <div class="py-1">
                    <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                    <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                    
                    <hr class="my-1">
                    
                    <form method="POST" action="">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>