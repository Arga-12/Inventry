<div x-data="{ sidebarOpen: false }" class="relative">
    {{-- Burger button untuk mobile --}}
    <div class="lg:hidden fixed top-4 left-4 transition-[z-index]" :class="sidebarOpen ? 'z-30' : 'z-50'">
        <button @click="sidebarOpen = !sidebarOpen"
            class="flex items-center justify-center h-14 w-14 rounded-full bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none" />
                <path fill="currentColor"
                    d="M4 6a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H5a1 1 0 0 1-1-1m0 6a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H5a1 1 0 0 1-1-1m1 5a1 1 0 1 0 0 2h14a1 1 0 1 0 0-2z" />
            </svg>
        </button>
    </div>

    {{-- Sidebar untuk desktop --}}
    <div class="hidden lg:block h-screen sticky left-0 top-0 bg-[#F5F5F5] border-r border-gray-300 w-80 shrink-0 z-20">
        <div class="flex flex-col h-full">
            {{-- Header sidebar --}}
            <div class="flex h-20 bg-[#ededed] items-center gap-3 px-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#363062]" viewBox="0 0 48 48">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        d="M5.5 5.5h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zm9.75 0h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75zM5.5 15.25h7.75V23H5.5zm19.5 0h7.75V23H25zm9.75 0h7.75V23h-7.75zM5.5 25h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zM25 25h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75zM5.5 34.75h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zm9.75 0h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75z"
                        stroke-width="1" />
                </svg>
                <div class="flex flex-col">
                    <h1 class="font-semibold text-[15px] text-[#363062] leading-none">Inventry</h1>
                    <h2 class="text-[13px] font-medium text-[#4D4C7D] leading-none mt-1">Lending Platform</h2>
                </div>
            </div>

            {{-- Peminjam --}}
            @if(auth()->user()->role === 'peminjam')
                <nav class="flex-1 px-4 mt-4 overflow-y-auto scrollbar-hide">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('peminjam-home') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('peminjam-home') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M13 8V4q0-.425.288-.712T14 3h6q.425 0 .713.288T21 4v4q0 .425-.288.713T20 9h-6q-.425 0-.712-.288T13 8M3 12V4q0-.425.288-.712T4 3h6q.425 0 .713.288T11 4v8q0 .425-.288.713T10 13H4q-.425 0-.712-.288T3 12m10 8v-8q0-.425.288-.712T14 11h6q.425 0 .713.288T21 12v8q0 .425-.288.713T20 21h-6q-.425 0-.712-.288T13 20M3 20v-4q0-.425.288-.712T4 15h6q.425 0 .713.288T11 16v4q0 .425-.288.713T10 21H4q-.425 0-.712-.288T3 20m2-9h4V5H5zm10 8h4v-6h-4zm0-12h4V5h-4zM5 19h4v-2H5zm4-2" />
                                </svg>
                                <span class="text-[15px] font-semibold">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('peminjam-alat') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('peminjam-alat') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 16 16">
                                    <path fill="currentColor"
                                        d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5a1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562A.5.5 0 0 0 1.884 9h12.234a.5.5 0 0 0 .496-.438zM3.809.563A1.5 1.5 0 0 1 4.981 0h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5a1.5 1.5 0 0 0 3 0a.5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393zm.941.83l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438l.32-2.562H10.45a2.5 2.5 0 0 1-4.9 0z" />
                                </svg>
                                <span class="text-[15px] font-semibold">Peminjaman Alat & Barang</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('peminjam-peminjaman') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('peminjam-peminjaman') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2">
                                        <path
                                            d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                        <path
                                            d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12m5.466 3.996l1.408 1.407a.53.53 0 0 0 .757 0l2.835-2.836" />
                                    </g>
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Peminjaman</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('peminjam-pengembalian') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('peminjam-pengembalian') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                        <path stroke-linejoin="round"
                                            d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                        <path stroke-linejoin="round" d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12" />
                                        <path stroke-miterlimit="10" d="M17.409 16.47h5" />
                                    </g>
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Pengembalian</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('profil-edit') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('profil-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 16 16">
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M7.199 2H8.8a.2.2 0 0 1 .2.2c0 1.808 1.958 2.939 3.524 2.034a.2.2 0 0 1 .271.073l.802 1.388a.2.2 0 0 1-.073.272c-1.566.904-1.566 3.164 0 4.069a.2.2 0 0 1 .073.271l-.802 1.388a.2.2 0 0 1-.271.073C10.958 10.863 9 11.993 9 13.8a.2.2 0 0 1-.199.2H7.2a.2.2 0 0 1-.2-.2c0-1.808-1.958-2.938-3.524-2.034a.2.2 0 0 1-.272-.073l-.8-1.388a.2.2 0 0 1 .072-.271c1.566-.905 1.566-3.165 0-4.07a.2.2 0 0 1-.073-.27l.801-1.389a.2.2 0 0 1 .272-.072C5.042 5.138 7 4.007 7 2.199c0-.11.089-.199.199-.199M5.5 2.2c0-.94.76-1.7 1.699-1.7H8.8c.94 0 1.7.76 1.7 1.7a.85.85 0 0 0 1.274.735a1.7 1.7 0 0 1 2.32.622l.802 1.388c.469.813.19 1.851-.622 2.32a.85.85 0 0 0 0 1.472a1.7 1.7 0 0 1 .622 2.32l-.802 1.388a1.7 1.7 0 0 1-2.32.622a.85.85 0 0 0-1.274.735c0 .939-.76 1.7-1.699 1.7H7.2a1.7 1.7 0 0 1-1.699-1.7a.85.85 0 0 0-1.274-.735a1.7 1.7 0 0 1-2.32-.622l-.802-1.388a1.7 1.7 0 0 1 .622-2.32a.85.85 0 0 0 0-1.471a1.7 1.7 0 0 1-.622-2.32l.801-1.389a1.7 1.7 0 0 1 2.32-.622A.85.85 0 0 0 5.5 2.2m4 5.8a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0M11 8a3 3 0 1 1-6 0a3 3 0 0 1 6 0"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-[15px] font-semibold">Pengaturan & Preferensi</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            @endif

            {{-- Petugas --}}
            @if(auth()->user()->role === 'petugas')
                <nav class="flex-1 px-4 mt-4 overflow-y-auto scrollbar-hide">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('petugas-home') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('petugas-home') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M13 8V4q0-.425.288-.712T14 3h6q.425 0 .713.288T21 4v4q0 .425-.288.713T20 9h-6q-.425 0-.712-.288T13 8M3 12V4q0-.425.288-.712T4 3h6q.425 0 .713.288T11 4v8q0 .425-.288.713T10 13H4q-.425 0-.712-.288T3 12m10 8v-8q0-.425.288-.712T14 11h6q.425 0 .713.288T21 12v8q0 .425-.288.713T20 21h-6q-.425 0-.712-.288T13 20M3 20v-4q0-.425.288-.712T4 15h6q.425 0 .713.288T11 16v4q0 .425-.288.713T10 21H4q-.425 0-.712-.288T3 20m2-9h4V5H5zm10 8h4v-6h-4zm0-12h4V5h-4zM5 19h4v-2H5zm4-2" />
                                </svg>
                                <span class="text-[15px] font-semibold">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('petugas-peminjaman') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('petugas-peminjaman') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2">
                                        <path
                                            d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                        <path
                                            d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12m5.466 3.996l1.408 1.407a.53.53 0 0 0 .757 0l2.835-2.836" />
                                    </g>
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Peminjaman</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('petugas-pengembalian') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('petugas-pengembalian') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                        <path stroke-linejoin="round"
                                            d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                        <path stroke-linejoin="round" d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12" />
                                        <path stroke-miterlimit="10" d="M17.409 16.47h5" />
                                    </g>
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Pengembalian</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('petugas-laporan') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('petugas-laporan') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-[22px] h-[22px]">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                <span class="text-[15px] font-semibold">Laporan Peminjaman</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('profil-edit') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('profil-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 16 16">
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M7.199 2H8.8a.2.2 0 0 1 .2.2c0 1.808 1.958 2.939 3.524 2.034a.2.2 0 0 1 .271.073l.802 1.388a.2.2 0 0 1-.073.272c-1.566.904-1.566 3.164 0 4.069a.2.2 0 0 1 .073.271l-.802 1.388a.2.2 0 0 1-.271.073C10.958 10.863 9 11.993 9 13.8a.2.2 0 0 1-.199.2H7.2a.2.2 0 0 1-.2-.2c0-1.808-1.958-2.938-3.524-2.034a.2.2 0 0 1-.272-.073l-.8-1.388a.2.2 0 0 1 .072-.271c1.566-.905 1.566-3.165 0-4.07a.2.2 0 0 1-.073-.27l.801-1.389a.2.2 0 0 1 .272-.072C5.042 5.138 7 4.007 7 2.199c0-.11.089-.199.199-.199M5.5 2.2c0-.94.76-1.7 1.699-1.7H8.8c.94 0 1.7.76 1.7 1.7a.85.85 0 0 0 1.274.735a1.7 1.7 0 0 1 2.32.622l.802 1.388c.469.813.19 1.851-.622 2.32a.85.85 0 0 0 0 1.472a1.7 1.7 0 0 1 .622 2.32l-.802 1.388a1.7 1.7 0 0 1-2.32.622a.85.85 0 0 0-1.274.735c0 .939-.76 1.7-1.699 1.7H7.2a1.7 1.7 0 0 1-1.699-1.7a.85.85 0 0 0-1.274-.735a1.7 1.7 0 0 1-2.32-.622l-.802-1.388a1.7 1.7 0 0 1 .622-2.32a.85.85 0 0 0 0-1.471a1.7 1.7 0 0 1-.622-2.32l.801-1.389a1.7 1.7 0 0 1 2.32-.622A.85.85 0 0 0 5.5 2.2m4 5.8a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0M11 8a3 3 0 1 1-6 0a3 3 0 0 1 6 0"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-[15px] font-semibold">Pengaturan & Preferensi</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            @endif

            {{-- Admin --}}
            @if(auth()->user()->role === 'admin')
                <nav class="flex-1 px-4 mt-4 overflow-y-auto scrollbar-hide">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('admin-home') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('admin-home') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M13 8V4q0-.425.288-.712T14 3h6q.425 0 .713.288T21 4v4q0 .425-.288.713T20 9h-6q-.425 0-.712-.288T13 8M3 12V4q0-.425.288-.712T4 3h6q.425 0 .713.288T11 4v8q0 .425-.288.713T10 13H4q-.425 0-.712-.288T3 12m10 8v-8q0-.425.288-.712T14 11h6q.425 0 .713.288T21 12v8q0 .425-.288.713T20 21h-6q-.425 0-.712-.288T13 20M3 20v-4q0-.425.288-.712T4 15h6q.425 0 .713.288T11 16v4q0 .425-.288.713T10 21H4q-.425 0-.712-.288T3 20m2-9h4V5H5zm10 8h4v-6h-4zm0-12h4V5h-4zM5 19h4v-2H5zm4-2" />
                                </svg>
                                <span class="text-[15px] font-semibold">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin-alat') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('admin-alat', 'admin-alat-create', 'admin-alat-edit', 'admin-kategori', 'admin-kategori-create', 'admin-kategori-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 16 16">
                                    <path fill="currentColor"
                                        d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5a1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562A.5.5 0 0 0 1.884 9h12.234a.5.5 0 0 0 .496-.438zM3.809.563A1.5 1.5 0 0 1 4.981 0h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5a1.5 1.5 0 0 0 3 0a.5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393zm.941.83l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438l.32-2.562H10.45a2.5 2.5 0 0 1-4.9 0z" />
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Alat & Barang</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin-peminjaman') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('admin-peminjaman', 'admin-peminjaman-create', 'admin-peminjaman-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2">
                                        <path
                                            d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                        <path
                                            d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12m5.466 3.996l1.408 1.407a.53.53 0 0 0 .757 0l2.835-2.836" />
                                    </g>
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Peminjaman</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin-pengembalian') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('admin-pengembalian', 'admin-pengembalian-create', 'admin-pengembalian-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                        <path stroke-linejoin="round"
                                            d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                        <path stroke-linejoin="round" d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12" />
                                        <path stroke-miterlimit="10" d="M17.409 16.47h5" />
                                    </g>
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Pengembalian</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin-pengguna') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('admin-pengguna', 'admin-pengguna-create', 'admin-pengguna-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M13.07 10.41a5 5 0 0 0 0-5.82A3.4 3.4 0 0 1 15 4a3.5 3.5 0 0 1 0 7a3.4 3.4 0 0 1-1.93-.59M5.5 7.5A3.5 3.5 0 1 1 9 11a3.5 3.5 0 0 1-3.5-3.5m2 0A1.5 1.5 0 1 0 9 6a1.5 1.5 0 0 0-1.5 1.5M16 17v2H2v-2s0-4 7-4s7 4 7 4m-2 0c-.14-.78-1.33-2-5-2s-4.93 1.31-5 2m11.95-4A5.32 5.32 0 0 1 18 17v2h4v-2s0-3.63-6.06-4Z" />
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Users</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin-log') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('admin-log') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-[22px] h-[22px]">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                <span class="text-[15px] font-semibold">Log Aktivitas</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('profil-edit') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('profil-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 16 16">
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M7.199 2H8.8a.2.2 0 0 1 .2.2c0 1.808 1.958 2.939 3.524 2.034a.2.2 0 0 1 .271.073l.802 1.388a.2.2 0 0 1-.073.272c-1.566.904-1.566 3.164 0 4.069a.2.2 0 0 1 .073.271l-.802 1.388a.2.2 0 0 1-.271.073C10.958 10.863 9 11.993 9 13.8a.2.2 0 0 1-.199.2H7.2a.2.2 0 0 1-.2-.2c0-1.808-1.958-2.938-3.524-2.034a.2.2 0 0 1-.272-.073l-.8-1.388a.2.2 0 0 1 .072-.271c1.566-.905 1.566-3.165 0-4.07a.2.2 0 0 1-.073-.27l.801-1.389a.2.2 0 0 1 .272-.072C5.042 5.138 7 4.007 7 2.199c0-.11.089-.199.199-.199M5.5 2.2c0-.94.76-1.7 1.699-1.7H8.8c.94 0 1.7.76 1.7 1.7a.85.85 0 0 0 1.274.735a1.7 1.7 0 0 1 2.32.622l.802 1.388c.469.813.19 1.851-.622 2.32a.85.85 0 0 0 0 1.472a1.7 1.7 0 0 1 .622 2.32l-.802 1.388a1.7 1.7 0 0 1-2.32.622a.85.85 0 0 0-1.274.735c0 .939-.76 1.7-1.699 1.7H7.2a1.7 1.7 0 0 1-1.699-1.7a.85.85 0 0 0-1.274-.735a1.7 1.7 0 0 1-2.32-.622l-.802-1.388a1.7 1.7 0 0 1 .622-2.32a.85.85 0 0 0 0-1.471a1.7 1.7 0 0 1-.622-2.32l.801-1.389a1.7 1.7 0 0 1 2.32-.622A.85.85 0 0 0 5.5 2.2m4 5.8a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0M11 8a3 3 0 1 1-6 0a3 3 0 0 1 6 0"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-[15px] font-semibold">Pengaturan & Preferensi</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            @endif

            <div class="mt-auto p-4">
                <div class="flex flex-col gap-1">
                    <p class="text-[15px] font-semibold text-[#4D4C7D] uppercase tracking-widest">
                        © 2026 Inventry
                    </p>
                    <p class="text-[13px] text-gray-500 font-semibold leading-tight">
                        By 4rgandull the prawncracker. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar untuk mobile (slide-in) --}}
    <div class="fixed inset-0 z-40 lg:hidden pointer-events-none">

        {{-- Overlay gelap --}}
        <div x-show="sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="absolute inset-0 bg-black/50 pointer-events-auto"
            @click="sidebarOpen = false"></div>

        {{-- Sidebar panel --}}
        <div x-show="sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="relative h-full w-80 bg-[#F5F5F5] border-r border-gray-300 shadow-xl flex flex-col pointer-events-auto">
            {{-- Header sidebar mobile --}}
            <div class="flex h-20 bg-[#ededed] items-center justify-between gap-3 px-6">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#363062]" viewBox="0 0 48 48">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            d="M5.5 5.5h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zm9.75 0h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75zM5.5 15.25h7.75V23H5.5zm19.5 0h7.75V23H25zm9.75 0h7.75V23h-7.75zM5.5 25h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zM25 25h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75zM5.5 34.75h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zm9.75 0h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75z"
                            stroke-width="1" />
                    </svg>
                    <div class="flex flex-col">
                        <h1 class="font-semibold text-[15px] text-[#363062] leading-none">Inventry</h1>
                        <h2 class="text-xs font-normal text-[#4D4C7D] leading-none mt-1">Lending Platform</h2>
                    </div>
                </div>

                {{-- Tombol close --}}
                <button @click="sidebarOpen = false" class="p-2 rounded-full hover:bg-gray-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#363062]" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z" />
                    </svg>
                </button>
            </div>

            {{-- Peminjam --}}
            @if(auth()->user()->role === 'peminjam')
                <nav class="flex-1 px-4 mt-4 overflow-y-auto scrollbar-hide">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('peminjam-home') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('peminjam-home') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M13 8V4q0-.425.288-.712T14 3h6q.425 0 .713.288T21 4v4q0 .425-.288.713T20 9h-6q-.425 0-.712-.288T13 8M3 12V4q0-.425.288-.712T4 3h6q.425 0 .713.288T11 4v8q0 .425-.288.713T10 13H4q-.425 0-.712-.288T3 12m10 8v-8q0-.425.288-.712T14 11h6q.425 0 .713.288T21 12v8q0 .425-.288.713T20 21h-6q-.425 0-.712-.288T13 20M3 20v-4q0-.425.288-.712T4 15h6q.425 0 .713.288T11 16v4q0 .425-.288.713T10 21H4q-.425 0-.712-.288T3 20m2-9h4V5H5zm10 8h4v-6h-4zm0-12h4V5h-4zM5 19h4v-2H5zm4-2" />
                                </svg>
                                <span class="text-[15px] font-semibold">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('peminjam-alat') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('peminjam-alat') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 16 16">
                                    <path fill="currentColor"
                                        d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5a1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562A.5.5 0 0 0 1.884 9h12.234a.5.5 0 0 0 .496-.438zM3.809.563A1.5 1.5 0 0 1 4.981 0h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5a1.5 1.5 0 0 0 3 0a.5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393zm.941.83l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438l.32-2.562H10.45a2.5 2.5 0 0 1-4.9 0z" />
                                </svg>
                                <span class="text-[15px] font-semibold">Peminjaman Alat & Barang</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('peminjam-peminjaman') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('peminjam-peminjaman') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2">
                                        <path
                                            d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                        <path
                                            d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12m5.466 3.996l1.408 1.407a.53.53 0 0 0 .757 0l2.835-2.836" />
                                    </g>
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Peminjaman</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('peminjam-pengembalian') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('peminjam-pengembalian') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                        <path stroke-linejoin="round"
                                            d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                        <path stroke-linejoin="round" d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12" />
                                        <path stroke-miterlimit="10" d="M17.409 16.47h5" />
                                    </g>
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Pengembalian</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('profil-edit') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('profil-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 16 16">
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M7.199 2H8.8a.2.2 0 0 1 .2.2c0 1.808 1.958 2.939 3.524 2.034a.2.2 0 0 1 .271.073l.802 1.388a.2.2 0 0 1-.073.272c-1.566.904-1.566 3.164 0 4.069a.2.2 0 0 1 .073.271l-.802 1.388a.2.2 0 0 1-.271.073C10.958 10.863 9 11.993 9 13.8a.2.2 0 0 1-.199.2H7.2a.2.2 0 0 1-.2-.2c0-1.808-1.958-2.938-3.524-2.034a.2.2 0 0 1-.272-.073l-.8-1.388a.2.2 0 0 1 .072-.271c1.566-.905 1.566-3.165 0-4.07a.2.2 0 0 1-.073-.27l.801-1.389a.2.2 0 0 1 .272-.072C5.042 5.138 7 4.007 7 2.199c0-.11.089-.199.199-.199M5.5 2.2c0-.94.76-1.7 1.699-1.7H8.8c.94 0 1.7.76 1.7 1.7a.85.85 0 0 0 1.274.735a1.7 1.7 0 0 1 2.32.622l.802 1.388c.469.813.19 1.851-.622 2.32a.85.85 0 0 0 0 1.472a1.7 1.7 0 0 1 .622 2.32l-.802 1.388a1.7 1.7 0 0 1-2.32.622a.85.85 0 0 0-1.274.735c0 .939-.76 1.7-1.699 1.7H7.2a1.7 1.7 0 0 1-1.699-1.7a.85.85 0 0 0-1.274-.735a1.7 1.7 0 0 1-2.32-.622l-.802-1.388a1.7 1.7 0 0 1 .622-2.32a.85.85 0 0 0 0-1.471a1.7 1.7 0 0 1-.622-2.32l.801-1.389a1.7 1.7 0 0 1 2.32-.622A.85.85 0 0 0 5.5 2.2m4 5.8a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0M11 8a3 3 0 1 1-6 0a3 3 0 0 1 6 0"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-[15px] font-semibold">Pengaturan & Preferensi</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            @endif

            {{-- Petugas --}}
            @if(auth()->user()->role === 'petugas')
                <nav class="flex-1 px-4 mt-4 overflow-y-auto scrollbar-hide">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('petugas-home') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('petugas-home') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M13 8V4q0-.425.288-.712T14 3h6q.425 0 .713.288T21 4v4q0 .425-.288.713T20 9h-6q-.425 0-.712-.288T13 8M3 12V4q0-.425.288-.712T4 3h6q.425 0 .713.288T11 4v8q0 .425-.288.713T10 13H4q-.425 0-.712-.288T3 12m10 8v-8q0-.425.288-.712T14 11h6q.425 0 .713.288T21 12v8q0 .425-.288.713T20 21h-6q-.425 0-.712-.288T13 20M3 20v-4q0-.425.288-.712T4 15h6q.425 0 .713.288T11 16v4q0 .425-.288.713T10 21H4q-.425 0-.712-.288T3 20m2-9h4V5H5zm10 8h4v-6h-4zm0-12h4V5h-4zM5 19h4v-2H5zm4-2" />
                                </svg>
                                <span class="text-[15px] font-semibold">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('petugas-peminjaman') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('petugas-peminjaman') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2">
                                        <path
                                            d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                        <path
                                            d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12m5.466 3.996l1.408 1.407a.53.53 0 0 0 .757 0l2.835-2.836" />
                                    </g>
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Peminjaman</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('petugas-pengembalian') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('petugas-pengembalian') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                        <path stroke-linejoin="round"
                                            d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                        <path stroke-linejoin="round" d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12" />
                                        <path stroke-miterlimit="10" d="M17.409 16.47h5" />
                                    </g>
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Pengembalian</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('petugas-laporan') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('petugas-laporan') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-[22px] h-[22px]">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                <span class="text-[15px] font-semibold">Laporan Peminjaman</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('profil-edit') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('profil-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 16 16">
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M7.199 2H8.8a.2.2 0 0 1 .2.2c0 1.808 1.958 2.939 3.524 2.034a.2.2 0 0 1 .271.073l.802 1.388a.2.2 0 0 1-.073.272c-1.566.904-1.566 3.164 0 4.069a.2.2 0 0 1 .073.271l-.802 1.388a.2.2 0 0 1-.271.073C10.958 10.863 9 11.993 9 13.8a.2.2 0 0 1-.199.2H7.2a.2.2 0 0 1-.2-.2c0-1.808-1.958-2.938-3.524-2.034a.2.2 0 0 1-.272-.073l-.8-1.388a.2.2 0 0 1 .072-.271c1.566-.905 1.566-3.165 0-4.07a.2.2 0 0 1-.073-.27l.801-1.389a.2.2 0 0 1 .272-.072C5.042 5.138 7 4.007 7 2.199c0-.11.089-.199.199-.199M5.5 2.2c0-.94.76-1.7 1.699-1.7H8.8c.94 0 1.7.76 1.7 1.7a.85.85 0 0 0 1.274.735a1.7 1.7 0 0 1 2.32.622l.802 1.388c.469.813.19 1.851-.622 2.32a.85.85 0 0 0 0 1.472a1.7 1.7 0 0 1 .622 2.32l-.802 1.388a1.7 1.7 0 0 1-2.32.622a.85.85 0 0 0-1.274.735c0 .939-.76 1.7-1.699 1.7H7.2a1.7 1.7 0 0 1-1.699-1.7a.85.85 0 0 0-1.274-.735a1.7 1.7 0 0 1-2.32-.622l-.802-1.388a1.7 1.7 0 0 1 .622-2.32a.85.85 0 0 0 0-1.471a1.7 1.7 0 0 1-.622-2.32l.801-1.389a1.7 1.7 0 0 1 2.32-.622A.85.85 0 0 0 5.5 2.2m4 5.8a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0M11 8a3 3 0 1 1-6 0a3 3 0 0 1 6 0"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-[15px] font-semibold">Pengaturan & Preferensi</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            @endif

            {{-- Admin --}}
            @if(auth()->user()->role === 'admin')
                <nav class="flex-1 px-4 mt-4 overflow-y-auto scrollbar-hide">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('admin-home') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('admin-home') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M13 8V4q0-.425.288-.712T14 3h6q.425 0 .713.288T21 4v4q0 .425-.288.713T20 9h-6q-.425 0-.712-.288T13 8M3 12V4q0-.425.288-.712T4 3h6q.425 0 .713.288T11 4v8q0 .425-.288.713T10 13H4q-.425 0-.712-.288T3 12m10 8v-8q0-.425.288-.712T14 11h6q.425 0 .713.288T21 12v8q0 .425-.288.713T20 21h-6q-.425 0-.712-.288T13 20M3 20v-4q0-.425.288-.712T4 15h6q.425 0 .713.288T11 16v4q0 .425-.288.713T10 21H4q-.425 0-.712-.288T3 20m2-9h4V5H5zm10 8h4v-6h-4zm0-12h4V5h-4zM5 19h4v-2H5zm4-2" />
                                </svg>
                                <span class="text-[15px] font-semibold">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin-alat') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('admin-alat', 'admin-alat-create', 'admin-alat-edit', 'admin-kategori', 'admin-kategori-create', 'admin-kategori-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 16 16">
                                    <path fill="currentColor"
                                        d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5a1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562A.5.5 0 0 0 1.884 9h12.234a.5.5 0 0 0 .496-.438zM3.809.563A1.5 1.5 0 0 1 4.981 0h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5a1.5 1.5 0 0 0 3 0a.5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393zm.941.83l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438l.32-2.562H10.45a2.5 2.5 0 0 1-4.9 0z" />
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Alat & Barang</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin-peminjaman') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('admin-peminjaman', 'admin-peminjaman-create', 'admin-peminjaman-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2">
                                        <path
                                            d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                        <path
                                            d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12m5.466 3.996l1.408 1.407a.53.53 0 0 0 .757 0l2.835-2.836" />
                                    </g>
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Peminjaman</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin-pengembalian') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('admin-pengembalian', 'admin-pengembalian-create', 'admin-pengembalian-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                        <path stroke-linejoin="round"
                                            d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                        <path stroke-linejoin="round" d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12" />
                                        <path stroke-miterlimit="10" d="M17.409 16.47h5" />
                                    </g>
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Pengembalian</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin-pengguna') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('admin-pengguna', 'admin-pengguna-create', 'admin-pengguna-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M13.07 10.41a5 5 0 0 0 0-5.82A3.4 3.4 0 0 1 15 4a3.5 3.5 0 0 1 0 7a3.4 3.4 0 0 1-1.93-.59M5.5 7.5A3.5 3.5 0 1 1 9 11a3.5 3.5 0 0 1-3.5-3.5m2 0A1.5 1.5 0 1 0 9 6a1.5 1.5 0 0 0-1.5 1.5M16 17v2H2v-2s0-4 7-4s7 4 7 4m-2 0c-.14-.78-1.33-2-5-2s-4.93 1.31-5 2m11.95-4A5.32 5.32 0 0 1 18 17v2h4v-2s0-3.63-6.06-4Z" />
                                </svg>
                                <span class="text-[15px] font-semibold">Manajemen Users</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin-log') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('admin-log') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-[22px] h-[22px]">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                <span class="text-[15px] font-semibold">Log Aktivitas</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('profil-edit') }}"
                                class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent transition-all {{ request()->routeIs('profil-edit') ? 'bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white shadow-lg transition-all duration-300' : 'text-[#4D4C7D] hover:bg-gradient-to-r hover:from-gray-300/40 hover:to-gray-200/40 hover:backdrop-blur-md hover:text-[#363062] hover:shadow-md hover:border-white/20 transition-all duration-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 16 16">
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M7.199 2H8.8a.2.2 0 0 1 .2.2c0 1.808 1.958 2.939 3.524 2.034a.2.2 0 0 1 .271.073l.802 1.388a.2.2 0 0 1-.073.272c-1.566.904-1.566 3.164 0 4.069a.2.2 0 0 1 .073.271l-.802 1.388a.2.2 0 0 1-.271.073C10.958 10.863 9 11.993 9 13.8a.2.2 0 0 1-.199.2H7.2a.2.2 0 0 1-.2-.2c0-1.808-1.958-2.938-3.524-2.034a.2.2 0 0 1-.272-.073l-.8-1.388a.2.2 0 0 1 .072-.271c1.566-.905 1.566-3.165 0-4.07a.2.2 0 0 1-.073-.27l.801-1.389a.2.2 0 0 1 .272-.072C5.042 5.138 7 4.007 7 2.199c0-.11.089-.199.199-.199M5.5 2.2c0-.94.76-1.7 1.699-1.7H8.8c.94 0 1.7.76 1.7 1.7a.85.85 0 0 0 1.274.735a1.7 1.7 0 0 1 2.32.622l.802 1.388c.469.813.19 1.851-.622 2.32a.85.85 0 0 0 0 1.472a1.7 1.7 0 0 1 .622 2.32l-.802 1.388a1.7 1.7 0 0 1-2.32.622a.85.85 0 0 0-1.274.735c0 .939-.76 1.7-1.699 1.7H7.2a1.7 1.7 0 0 1-1.699-1.7a.85.85 0 0 0-1.274-.735a1.7 1.7 0 0 1-2.32-.622l-.802-1.388a1.7 1.7 0 0 1 .622-2.32a.85.85 0 0 0 0-1.471a1.7 1.7 0 0 1-.622-2.32l.801-1.389a1.7 1.7 0 0 1 2.32-.622A.85.85 0 0 0 5.5 2.2m4 5.8a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0M11 8a3 3 0 1 1-6 0a3 3 0 0 1 6 0"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-[15px] font-semibold">Pengaturan & Preferensi</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </div>
</div>