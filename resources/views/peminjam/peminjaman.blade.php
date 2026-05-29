@extends('layouts.app')

@section('content')
    <div class="mx-auto pt-20 pb-8 lg:py-8 px-4">

        <div class="flex flex-col gap-8">

        <div class="flex flex-col">
            <h1 class="text-2xl sm:text-4xl font-bold">Peminjaman Saya</h1>
            <p class="text-gray-500">Kelola dan pantau status peminjaman alat & barang Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- SECTION MENUNGGU --}}
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-lg sm:text-2xl font-bold">Menunggu Persetujuan</h2>
                    <div class="flex items-center gap-2">
                        <div class="h-1.5 w-1.5 sm:h-2 sm:w-2 bg-yellow-500 rounded-full"></div>
                        <span class="text-xs sm:text-sm text-gray-500">{{ $menunggu->count() }} Peminjaman</span>
                    </div>
                </div>

                {{-- TOP BAR MENUNGGU --}}
                <form method="GET" action="{{ route('peminjam-peminjaman') }}" class="mb-2">
                    <div class="flex flex-wrap items-center gap-2">
                        {{-- SEARCH MENUNGGU --}}
                        <div class="relative flex-1 min-w-[180px]">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/>
                                </svg>
                            </div>
                            <input type="text" name="search_menunggu" value="{{ request('search_menunggu') }}"
                                   placeholder="Cari peminjaman..." 
                                   onchange="this.form.submit()"
                                   class="w-full h-11 pl-10 pr-4 py-2 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
                        </div>

                        {{-- FILTER DURASI MENUNGGU --}}
                        <div x-data="{ open: false, dropdownStyle: '', toggle(btn) { if (!this.open) { const r = btn.getBoundingClientRect(); const w = 192; let left = r.right - w; if (left < 8) left = 8; this.dropdownStyle = 'top:' + (r.bottom + 8) + 'px;left:' + left + 'px;'; } this.open = !this.open; } }" class="relative inline-block text-left">
                            <button type="button" @click="toggle($el)" class="flex-shrink-0 w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/>
                                </svg>
                            </button>

                            <template x-teleport="body">
                                <div x-show="open" @click.outside="open = false" x-cloak x-transition.opacity
                                    :style="dropdownStyle"
                                    class="fixed z-[9999] w-48 max-h-[70vh] rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 overflow-y-auto border border-gray-100">
                                    <div class="py-2">
                                        <p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Durasi</p>
                                        <label class="flex items-center px-4 py-2 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                            <input type="radio" name="durasi_menunggu" value="" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ !request('durasi_menunggu') ? 'checked' : '' }}>
                                            Semua Durasi
                                        </label>
                                        @foreach($formattedDurasiList as $durasi)
                                            <label class="flex items-center px-4 py-2 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                                <input type="radio" name="durasi_menunggu" value="{{ $durasi['value'] }}" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_menunggu') == $durasi['value'] ? 'checked' : '' }}>
                                                {{ $durasi['label'] }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- HIDDEN FIELDS RESET FILTER LAIN --}}
                        <input type="hidden" name="search_dipinjam" value="">
                        <input type="hidden" name="durasi_dipinjam" value="">
                        <input type="hidden" name="status_dipinjam" value="">
                        <input type="hidden" name="search_riwayat" value="">
                        <input type="hidden" name="durasi_riwayat" value="">
                        <input type="hidden" name="status_riwayat" value="">

                        {{-- RESET BUTTON MENUNGGU --}}
                        @if(request('search_menunggu') || request('durasi_menunggu'))
                            <a href="{{ route('peminjam-peminjaman') }}" class="px-4 py-2 text-sm text-[#363062]/90 hover:text-[#363062] border border-[#363062] rounded-full transition font-semibold">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                {{-- LIST MENUNGGU --}}
                <div class="max-h-[500px] overflow-y-auto -mx-4 px-4 py-3 flex flex-col gap-4">
                    @forelse($menunggu as $item)
                        <x-card-peminjam :peminjaman="$item" />
                    @empty
                        <div class="lg:col-span-2 flex flex-col gap-3 items-center justify-center bg-white border border-gray-300 rounded-[20px] p-6 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="currentColor" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34M15 14H9l-.117.007a1 1 0 0 0 0 1.986L9 16h6l.117-.007a1 1 0 0 0 0-1.986zM9.01 9l-.127.007a1 1 0 0 0 0 1.986L9 11l.127-.007a1 1 0 0 0 0-1.986zm6 0l-.127.007a1 1 0 0 0 0 1.986L15 11l.127-.007a1 1 0 0 0 0-1.986z" />
                            </svg>
                            Tidak ada data peminjaman.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- SECTION DIPINJAM --}}
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-lg sm:text-2xl font-bold">Sedang Dipinjam</h2>
                    <div class="flex items-center gap-2">
                        <div class="h-1.5 w-1.5 sm:h-2 sm:w-2 bg-blue-500 rounded-full"></div>
                        <span class="text-xs sm:text-sm text-gray-500">{{ $dipinjam->count() }} Peminjaman</span>
                    </div>
                </div>

                {{-- TOP BAR DIPINJAM --}}
                <form method="GET" action="{{ route('peminjam-peminjaman') }}" class="mb-2">
                    <div class="flex flex-wrap items-center gap-2">
                        {{-- SEARCH DIPINJAM --}}
                        <div class="relative flex-1 min-w-[180px]">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/>
                                </svg>
                            </div>
                            <input type="text" name="search_dipinjam" value="{{ request('search_dipinjam') }}"
                                placeholder="Cari peminjaman..." 
                                onchange="this.form.submit()"
                                class="w-full h-11 pl-10 pr-4 py-2 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
                        </div>

                        {{-- FILTER DROPDOWN (STATUS + DURASI) --}}
                        <div x-data="{ open: false, dropdownStyle: '', toggle(btn) { if (!this.open) { const r = btn.getBoundingClientRect(); const w = 224; let left = r.right - w; if (left < 8) left = 8; this.dropdownStyle = 'top:' + (r.bottom + 8) + 'px;left:' + left + 'px;'; } this.open = !this.open; } }" class="relative inline-block text-left">
                            <button type="button" @click="toggle($el)" class="flex-shrink-0 w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/>
                                </svg>
                            </button>

                            <template x-teleport="body">
                                <div x-show="open" @click.outside="open = false" x-cloak x-transition.opacity
                                    :style="dropdownStyle"
                                    class="fixed z-[9999] w-56 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 max-h-[70vh] overflow-y-auto border border-gray-100">
                                    <div class="py-2">

                                        {{-- FILTER STATUS --}}
                                        <p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Status</p>

                                        <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                            <input type="radio" name="status_dipinjam" value="" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_dipinjam') == '' ? 'checked' : '' }}>
                                            Semua Status
                                        </label>
                                        <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                            <input type="radio" name="status_dipinjam" value="dipinjam" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_dipinjam') == 'dipinjam' ? 'checked' : '' }}>
                                            Dipinjam
                                        </label>
                                        <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                            <input type="radio" name="status_dipinjam" value="jatuh_tempo" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_dipinjam') == 'jatuh_tempo' ? 'checked' : '' }}>
                                            Jatuh Tempo
                                        </label>
                                        <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                            <input type="radio" name="status_dipinjam" value="terlambat" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_dipinjam') == 'terlambat' ? 'checked' : '' }}>
                                            Terlambat
                                        </label>

                                        <div class="border-t border-gray-100 my-1 mx-4"></div>

                                        {{-- FILTER DURASI --}}
                                        <p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Durasi</p>

                                        <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                            <input type="radio" name="durasi_dipinjam" value="" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_dipinjam') == '' ? 'checked' : '' }}>
                                            Semua Durasi
                                        </label>

                                        @foreach($formattedDurasiList as $durasi)
                                            <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                                <input type="radio" name="durasi_dipinjam" value="{{ $durasi['value'] }}" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_dipinjam') == $durasi['value'] ? 'checked' : '' }}>
                                                {{ $durasi['label'] }}
                                            </label>
                                        @endforeach

                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- HIDDEN FIELDS --}}
                        <input type="hidden" name="search_menunggu" value="">
                        <input type="hidden" name="durasi_menunggu" value="">
                        <input type="hidden" name="search_riwayat" value="">
                        <input type="hidden" name="durasi_riwayat" value="">
                        <input type="hidden" name="status_riwayat" value="">

                        {{-- RESET BUTTON --}}
                        @if(request('search_dipinjam') || request('durasi_dipinjam') || request('status_dipinjam'))
                            <a href="{{ route('peminjam-peminjaman') }}" class="px-4 h-11 py-2 flex items-center justify-center text-sm text-[#363062]/90 hover:text-[#363062] border border-[#363062] rounded-full transition font-semibold">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                {{-- LIST DIPINJAM --}}
                <div class="max-h-[500px] overflow-y-auto -mx-4 px-4 py-3 flex flex-col gap-4">
                    @forelse($dipinjam as $item)
                        <x-card-peminjam :peminjaman="$item" />
                    @empty
                        <div class="lg:col-span-2 flex flex-col gap-3 items-center justify-center bg-white border border-gray-300 rounded-[20px] p-6 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="currentColor" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34M15 14H9l-.117.007a1 1 0 0 0 0 1.986L9 16h6l.117-.007a1 1 0 0 0 0-1.986zM9.01 9l-.127.007a1 1 0 0 0 0 1.986L9 11l.127-.007a1 1 0 0 0 0-1.986zm6 0l-.127.007a1 1 0 0 0 0 1.986L15 11l.127-.007a1 1 0 0 0 0-1.986z" />
                            </svg>
                            Belum ada data Peminjaman yang sedang diproses.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- SECTION RIWAYAT SELESAI & DITOLAK --}}
        @if($riwayat->count() > 0)
            <div class="mt-8" id="riwayat">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg sm:text-2xl font-bold">Riwayat Selesai & Ditolak</h2>
                    <div class="flex items-center gap-2">
                        <div class="h-1.5 w-1.5 sm:h-2 sm:w-2 bg-green-500 rounded-full"></div>
                        <span class="text-xs sm:text-sm text-gray-500">{{ $riwayat->total() }} Peminjaman</span>
                    </div>
                </div>

                {{-- TOP BAR RIWAYAT --}}
                <form method="GET" action="{{ route('peminjam-peminjaman') }}" class="mb-4 relative">
                    <div class="flex flex-wrap items-center gap-2">
                        {{-- SEARCH RIWAYAT --}}
                        <div class="relative flex-1 min-w-[180px]">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/>
                                </svg>
                            </div>
                            <input type="text" name="search_riwayat" value="{{ request('search_riwayat') }}"
                                placeholder="Cari kode atau nama alat..." 
                                onchange="this.form.submit()"
                                class="w-full h-11 pl-10 pr-4 py-2 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
                        </div>

                        {{-- FILTER DROPDOWN (STATUS + DURASI UNTUK RIWAYAT) --}}
                        <div x-data="{ open: false, dropdownStyle: '', toggle(btn) { if (!this.open) { const r = btn.getBoundingClientRect(); const w = 224; let left = r.right - w; if (left < 8) left = 8; this.dropdownStyle = 'top:' + (r.bottom + 8) + 'px;left:' + left + 'px;'; } this.open = !this.open; } }" class="relative inline-block text-left">
                            <button type="button" @click="toggle($el)" class="flex-shrink-0 w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/>
                                </svg>
                            </button>

                            <template x-teleport="body">
                                <div x-show="open" @click.outside="open = false" x-cloak x-transition.opacity
                                    :style="dropdownStyle"
                                    class="fixed z-[9999] w-56 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 max-h-[70vh] overflow-y-auto border border-gray-100">
                                    <div class="py-2">
                                        <p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Status</p>
                                        <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                            <input type="radio" name="status_riwayat" value="" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_riwayat') == '' ? 'checked' : '' }}>
                                            Semua Status
                                        </label>
                                        <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                            <input type="radio" name="status_riwayat" value="selesai" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_riwayat') == 'selesai' ? 'checked' : '' }}>
                                            Selesai
                                        </label>
                                        <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                            <input type="radio" name="status_riwayat" value="ditolak" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_riwayat') == 'ditolak' ? 'checked' : '' }}>
                                            Ditolak
                                        </label>

                                        <div class="border-t border-gray-100 my-1 mx-4"></div>

                                        <p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Durasi</p>
                                        <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                            <input type="radio" name="durasi_riwayat" value="" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_riwayat') == '' ? 'checked' : '' }}>
                                            Semua Durasi
                                        </label>
                                        @foreach($formattedDurasiList as $durasi)
                                            <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                                <input type="radio" name="durasi_riwayat" value="{{ $durasi['value'] }}" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_riwayat') == $durasi['value'] ? 'checked' : '' }}>
                                                {{ $durasi['label'] }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- HIDDEN FIELDS --}}
                        <input type="hidden" name="search_menunggu" value="">
                        <input type="hidden" name="durasi_menunggu" value="">
                        <input type="hidden" name="search_dipinjam" value="">
                        <input type="hidden" name="durasi_dipinjam" value="">
                        <input type="hidden" name="status_dipinjam" value="">

                        {{-- RESET BUTTON --}}
                        @if(request('search_riwayat') || request('durasi_riwayat') || request('status_riwayat'))
                            <a href="{{ route('peminjam-peminjaman') }}" class="h-11 px-5 py-0 inline-flex items-center text-sm text-[#363062]/90 hover:text-[#363062] border border-[#363062] rounded-full transition font-semibold">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                {{-- LIST RIWAYAT --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($riwayat as $item)
                        <x-card-peminjam :peminjaman="$item" />
                    @endforeach
                </div>

                {{-- PAGINATION RIWAYAT --}}
                @if($riwayat->hasPages())
                    <div class="mt-6">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            {{-- Keterangan Data --}}
                            <div class="text-sm text-gray-500 order-2 sm:order-1 text-center sm:text-left">
                                Menampilkan {{ $riwayat->firstItem() }} sampai {{ $riwayat->lastItem() }} dari {{ $riwayat->total() }} riwayat
                            </div>

                            {{-- Navigasi Tombol --}}
                            <div class="flex items-center gap-2 order-1 sm:order-2">
                                {{-- Tombol Previous --}}
                                @if($riwayat->onFirstPage())
                                    <button type="button" disabled class="p-3 rounded-full border text-sm flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
                                            <defs><path id="riwayat_prev" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs>
                                            <use fill-rule="evenodd" href="#riwayat_prev" transform="rotate(-180 5.02 9.505)"/>
                                        </svg>
                                    </button>
                                @else
                                    <a href="{{ $riwayat->appends(request()->query())->previousPageUrl() }}#riwayat" class="p-3 rounded-full border bg-white text-sm flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
                                            <defs><path id="riwayat_prev" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs>
                                            <use fill-rule="evenodd" href="#riwayat_prev" transform="rotate(-180 5.02 9.505)"/>
                                        </svg>
                                    </a>
                                @endif

                                {{-- Nomor Halaman --}}
                                <div class="flex items-center gap-1 bg-gray-100 p-1.5 sm:p-2 rounded-full shadow-inner">
                                    @php
                                        $currentPage = $riwayat->currentPage();
                                        $lastPage = $riwayat->lastPage();
                                        $start = max(1, $currentPage - 1);
                                        $end = min($lastPage, $currentPage + 1);

                                        if ($start > 1) {
                                            $cls = (1 == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
                                            echo '<a href="' . $riwayat->appends(request()->query())->url(1) . '#riwayat" class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition ' . $cls . '">1</a>';
                                            if ($start > 2)
                                                echo '<span class="px-1 text-gray-400 text-xs">...</span>';
                                        }

                                        for ($i = $start; $i <= $end; $i++) {
                                            $cls = ($i == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
                                            echo '<a href="' . $riwayat->appends(request()->query())->url($i) . '#riwayat" class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition ' . $cls . '">' . $i . '</a>';
                                        }

                                        if ($end < $lastPage) {
                                            if ($end < $lastPage - 1)
                                                echo '<span class="px-1 text-gray-400 text-xs">...</span>';
                                            $cls = ($lastPage == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
                                            echo '<a href="' . $riwayat->appends(request()->query())->url($lastPage) . '#riwayat" class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition ' . $cls . '">' . $lastPage . '</a>';
                                        }
                                    @endphp
                                </div>

                                {{-- Tombol Next --}}
                                @if($riwayat->hasMorePages())
                                    <a href="{{ $riwayat->appends(request()->query())->nextPageUrl() }}#riwayat" class="p-3 rounded-full border bg-white text-sm flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
                                            <defs><path id="riwayat_next" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs>
                                            <use fill-rule="evenodd" href="#riwayat_next" transform="rotate(-180 5.02 9.505)"/>
                                        </svg>
                                    </a>
                                @else
                                    <button type="button" disabled class="p-3 rounded-full border text-sm flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
                                            <defs><path id="riwayat_next" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs>
                                            <use fill-rule="evenodd" href="#riwayat_next" transform="rotate(-180 5.02 9.505)"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

    </div>
@endsection

<style>
    [x-cloak] {
        display: none !important;
    }
</style>