<div class="h-screen sticky left-0 top-0 bg-[#F5F5F5] border-r border-gray-300 w-80">
    <div class="flex flex-col h-screen">
        {{-- Header sidebar --}}
        <div class="flex h-20 bg-[#ededed] items-center gap-3 px-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#363062]" viewBox="0 0 48 48"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M5.5 5.5h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zm9.75 0h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75zM5.5 15.25h7.75V23H5.5zm19.5 0h7.75V23H25zm9.75 0h7.75V23h-7.75zM5.5 25h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zM25 25h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75zM5.5 34.75h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zm9.75 0h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75z" stroke-width="1"/></svg>
            <div class="flex flex-col">
                <h1 class="font-bold text-sm text-[#363062] leading-none">Inventry</h1>
                <h2 class="text-xs font-normal text-[#4D4C7D] leading-none mt-1">Lending Platform</h2>
            </div>
        </div>
        {{-- <nav>
            <ul class="space-y-3 p-3">
                <li>
                    <a class="w-full h-10 rounded-lg px-2 items-center flex gap-2 border border-transparent transition-all duration-200 hover:border-white" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24"><path fill="currentColor" d="M13 8V4q0-.425.288-.712T14 3h6q.425 0 .713.288T21 4v4q0 .425-.288.713T20 9h-6q-.425 0-.712-.288T13 8M3 12V4q0-.425.288-.712T4 3h6q.425 0 .713.288T11 4v8q0 .425-.288.713T10 13H4q-.425 0-.712-.288T3 12m10 8v-8q0-.425.288-.712T14 11h6q.425 0 .713.288T21 12v8q0 .425-.288.713T20 21h-6q-.425 0-.712-.288T13 20M3 20v-4q0-.425.288-.712T4 15h6q.425 0 .713.288T11 16v4q0 .425-.288.713T10 21H4q-.425 0-.712-.288T3 20m2-9h4V5H5zm10 8h4v-6h-4zm0-12h4V5h-4zM5 19h4v-2H5zm4-2"/></svg>
                    <p class="text-xs text-white">Dashboard</p>
                    </a>
                </li>
                <li>
                    <a class="w-full h-10 rounded-lg px-2 items-center flex gap-2 border border-transparent transition-all duration-200 hover:border-white" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4"/><path d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12m5.466 3.996l1.408 1.407a.53.53 0 0 0 .757 0l2.835-2.836"/></g></svg>
                    <p class="text-xs text-white">Peminjaman Alat & Barang</p>
                    </a>
                </li>
                <li>
                    <a class="w-full h-10 rounded-lg px-2 items-center flex gap-2 border border-transparent transition-all duration-200 hover:border-white" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"><path stroke-linejoin="round" d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4"/><path stroke-linejoin="round" d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12"/><path stroke-miterlimit="10" d="M17.409 16.47h5"/></g></svg>
                    <p class="text-xs text-white">Pengembalian Alat & Barang</p>
                    </a>
                </li>
                <li>
                    <a class="w-full h-10 rounded-lg px-2 items-center flex gap-2 border border-transparent transition-all duration-200 hover:border-white" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M7.199 2H8.8a.2.2 0 0 1 .2.2c0 1.808 1.958 2.939 3.524 2.034a.2.2 0 0 1 .271.073l.802 1.388a.2.2 0 0 1-.073.272c-1.566.904-1.566 3.164 0 4.069a.2.2 0 0 1 .073.271l-.802 1.388a.2.2 0 0 1-.271.073C10.958 10.863 9 11.993 9 13.8a.2.2 0 0 1-.199.2H7.2a.2.2 0 0 1-.2-.2c0-1.808-1.958-2.938-3.524-2.034a.2.2 0 0 1-.272-.073l-.8-1.388a.2.2 0 0 1 .072-.271c1.566-.905 1.566-3.165 0-4.07a.2.2 0 0 1-.073-.27l.801-1.389a.2.2 0 0 1 .272-.072C5.042 5.138 7 4.007 7 2.199c0-.11.089-.199.199-.199M5.5 2.2c0-.94.76-1.7 1.699-1.7H8.8c.94 0 1.7.76 1.7 1.7a.85.85 0 0 0 1.274.735a1.7 1.7 0 0 1 2.32.622l.802 1.388c.469.813.19 1.851-.622 2.32a.85.85 0 0 0 0 1.472a1.7 1.7 0 0 1 .622 2.32l-.802 1.388a1.7 1.7 0 0 1-2.32.622a.85.85 0 0 0-1.274.735c0 .939-.76 1.7-1.699 1.7H7.2a1.7 1.7 0 0 1-1.699-1.7a.85.85 0 0 0-1.274-.735a1.7 1.7 0 0 1-2.32-.622l-.802-1.388a1.7 1.7 0 0 1 .622-2.32a.85.85 0 0 0 0-1.471a1.7 1.7 0 0 1-.622-2.32l.801-1.389a1.7 1.7 0 0 1 2.32-.622A.85.85 0 0 0 5.5 2.2m4 5.8a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0M11 8a3 3 0 1 1-6 0a3 3 0 0 1 6 0" clip-rule="evenodd"/></svg>
                    <p class="text-xs text-white">Profil & Preferensi</p>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="mt-auto p-3 border-t border-white">
            
        </div> --}}
        <nav class="flex-1 px-4 mt-4">
            <ul class="space-y-2">
                <li>
                    <a href="#" class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent bg-[#363062] text-white transition-all shadow-md shadow-indigo-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"><path fill="currentColor" d="M13 8V4q0-.425.288-.712T14 3h6q.425 0 .713.288T21 4v4q0 .425-.288.713T20 9h-6q-.425 0-.712-.288T13 8M3 12V4q0-.425.288-.712T4 3h6q.425 0 .713.288T11 4v8q0 .425-.288.713T10 13H4q-.425 0-.712-.288T3 12m10 8v-8q0-.425.288-.712T14 11h6q.425 0 .713.288T21 12v8q0 .425-.288.713T20 21h-6q-.425 0-.712-.288T13 20M3 20v-4q0-.425.288-.712T4 15h6q.425 0 .713.288T11 16v4q0 .425-.288.713T10 21H4q-.425 0-.712-.288T3 20m2-9h4V5H5zm10 8h4v-6h-4zm0-12h4V5h-4zM5 19h4v-2H5zm4-2"/>
                        </svg>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent text-[#4D4C7D] hover:bg-white hover:text-[#363062] hover:shadow-sm hover:border-[#363062] transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-70" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4"/><path d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12m5.466 3.996l1.408 1.407a.53.53 0 0 0 .757 0l2.835-2.836"/></g>
                        </svg>
                        <span class="text-sm font-medium">Peminjaman Alat & Barang</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent text-[#4D4C7D] hover:bg-white hover:text-[#363062] hover:shadow-sm hover:border-[#363062] transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-70" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"><path stroke-linejoin="round" d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4"/><path stroke-linejoin="round" d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12"/><path stroke-miterlimit="10" d="M17.409 16.47h5"/></g>
                        </svg>
                        <span class="text-sm font-medium">Manajemen Peminjaman</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="group flex items-center gap-3 px-4 py-3 rounded-full border border-transparent text-[#4D4C7D] hover:bg-white hover:text-[#363062] hover:shadow-sm hover:border-[#363062] transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-70" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M7.199 2H8.8a.2.2 0 0 1 .2.2c0 1.808 1.958 2.939 3.524 2.034a.2.2 0 0 1 .271.073l.802 1.388a.2.2 0 0 1-.073.272c-1.566.904-1.566 3.164 0 4.069a.2.2 0 0 1 .073.271l-.802 1.388a.2.2 0 0 1-.271.073C10.958 10.863 9 11.993 9 13.8a.2.2 0 0 1-.199.2H7.2a.2.2 0 0 1-.2-.2c0-1.808-1.958-2.938-3.524-2.034a.2.2 0 0 1-.272-.073l-.8-1.388a.2.2 0 0 1 .072-.271c1.566-.905 1.566-3.165 0-4.07a.2.2 0 0 1-.073-.27l.801-1.389a.2.2 0 0 1 .272-.072C5.042 5.138 7 4.007 7 2.199c0-.11.089-.199.199-.199M5.5 2.2c0-.94.76-1.7 1.699-1.7H8.8c.94 0 1.7.76 1.7 1.7a.85.85 0 0 0 1.274.735a1.7 1.7 0 0 1 2.32.622l.802 1.388c.469.813.19 1.851-.622 2.32a.85.85 0 0 0 0 1.472a1.7 1.7 0 0 1 .622 2.32l-.802 1.388a1.7 1.7 0 0 1-2.32.622a.85.85 0 0 0-1.274.735c0 .939-.76 1.7-1.699 1.7H7.2a1.7 1.7 0 0 1-1.699-1.7a.85.85 0 0 0-1.274-.735a1.7 1.7 0 0 1-2.32-.622l-.802-1.388a1.7 1.7 0 0 1 .622-2.32a.85.85 0 0 0 0-1.471a1.7 1.7 0 0 1-.622-2.32l.801-1.389a1.7 1.7 0 0 1 2.32-.622A.85.85 0 0 0 5.5 2.2m4 5.8a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0M11 8a3 3 0 1 1-6 0a3 3 0 0 1 6 0" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium">Pengaturan</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="mt-auto p-4">
            <div class="flex flex-col gap-1">
                <p class="text-sm font-medium text-[#4D4C7D] uppercase tracking-widest">
                    © 2026 Inventry
                </p>
                <p class="text-xs text-gray-400 font-normal leading-tight">
                    By 4rgandull the prawncracker. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</div>