@extends('layouts.app')

@section('content')
<div class="mx-auto pt-20 pb-8 lg:py-8 px-4">

    <div class="flex flex-col gap-8">

    <div class="flex flex-col">
        <h1 class="text-2xl sm:text-4xl font-bold text-gray-900">Pengembalian Saya</h1>
        <p class="text-gray-500">Pantau status pengembalian alat & barang Anda</p>
    </div>

    {{-- MENUNGGU VERIFIKASI --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg sm:text-2xl font-bold">Menunggu Verifikasi</h2>
            <div class="flex items-center gap-2">
                <div class="h-1.5 w-1.5 sm:h-2 sm:w-2 bg-yellow-500 rounded-full"></div>
                <span class="text-xs sm:text-sm text-gray-500">{{ $menunggu->count() }} Pengembalian</span>
            </div>
        </div>

        {{-- TOP BAR --}}
        <form method="GET" action="{{ route('peminjam-pengembalian') }}" class="mb-4">
            <div class="flex flex-wrap items-center gap-2">
                {{-- SEARCH MENUNGGU --}}
                <div class="relative flex-1 min-w-[200px]">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/>
                        </svg>
                    </div>
                    <input type="text" name="search_menunggu" value="{{ request('search_menunggu') }}"
                        placeholder="Cari kode pengembalian..." 
                        onchange="this.form.submit()"
                        class="w-full h-11 pl-10 pr-4 py-2 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
                </div>

                {{-- FILTER DROPDOWN MENUNGGU (DURASI) --}}
                <div x-data="{ open: false }" class="relative inline-block text-left">
                    <button type="button" @click="open = !open" class="flex-shrink-0 w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/>
                        </svg>
                    </button>

                    <div x-show="open" @click.outside="open = false" style="display:none" x-transition.opacity
                        class="absolute right-0 z-[100] mt-2 w-48 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 max-h-[70vh] overflow-y-auto border border-gray-100">
                        <div class="py-2">
                            <p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Durasi</p>
                            <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" name="durasi_menunggu" value="" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_menunggu') == '' ? 'checked' : '' }}>
                                Semua Durasi
                            </label>
                            @foreach($durasiList as $durasi)
                            <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" name="durasi_menunggu" value="{{ $durasi['value'] }}" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_menunggu') == $durasi['value'] ? 'checked' : '' }}>
                                {{ $durasi['label'] }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- HIDDEN FIELDS UNTUK RESET FILTER LAIN --}}
                <input type="hidden" name="search_selesai" value="">
                <input type="hidden" name="kondisi_selesai" value="">
                <input type="hidden" name="durasi_selesai" value="">

                {{-- RESET BUTTON MENUNGGU --}}
                @if(request('search_menunggu') || request('durasi_menunggu'))
                <a href="{{ route('peminjam-pengembalian') }}" class="h-11 px-5 py-0 inline-flex items-center text-sm text-[#363062]/90 hover:text-[#363062] border border-[#363062] rounded-full transition font-semibold">
                    Reset
                </a>
                @endif
            </div>
        </form>

        {{-- LIST MENUNGGU --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($menunggu as $item)
                <x-card-pengembalian :pengembalian="$item" />
            @empty
                <div class="lg:col-span-2 flex flex-col gap-3 items-center justify-center bg-white border border-gray-300 rounded-[20px] p-6 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="currentColor" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34M15 14H9l-.117.007a1 1 0 0 0 0 1.986L9 16h6l.117-.007a1 1 0 0 0 0-1.986zM9.01 9l-.127.007a1 1 0 0 0 0 1.986L9 11l.127-.007a1 1 0 0 0 0-1.986zm6 0l-.127.007a1 1 0 0 0 0 1.986L15 11l.127-.007a1 1 0 0 0 0-1.986z" />
                    </svg>
				    Belum ada data pengembalian yang sedang diproses.
			    </div>
            @endforelse
        </div>
    </div>

    {{-- SECTION SELESAI --}}
    @if($selesai->isNotEmpty())
    <div class="mt-8" id="selesai">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg sm:text-2xl font-bold">Selesai Dikembalikan</h2>
            <div class="flex items-center gap-2">
                <div class="h-1.5 w-1.5 sm:h-2 sm:w-2 bg-green-500 rounded-full"></div>
                <span class="text-xs sm:text-sm text-gray-500">{{ $selesai->total() }} Pengembalian</span>
            </div>
        </div>

        {{-- TOP BAR --}}
        <form method="GET" action="{{ route('peminjam-pengembalian') }}" class="mb-4">
            <div class="flex flex-wrap items-center gap-2">
                {{-- SEARCH SELESAI --}}
                <div class="relative flex-1 min-w-[200px]">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/>
                        </svg>
                    </div>
                    <input type="text" name="search_selesai" value="{{ request('search_selesai') }}"
                        placeholder="Cari kode pengembalian..." 
                        onchange="this.form.submit()"
                        class="w-full h-11 pl-10 pr-4 py-2 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
                </div>

                {{-- FILTER DROPDOWN (KONDISI) --}}
                <div x-data="{ open: false }" class="relative inline-block text-left">
                    <button type="button" @click="open = !open" class="flex-shrink-0 w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/>
                        </svg>
                    </button>

                    <div x-show="open" @click.outside="open = false" style="display:none" x-transition.opacity
                        class="absolute right-0 z-[100] mt-2 w-48 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 max-h-[70vh] overflow-y-auto border border-gray-100">
                        <div class="py-2">
                            <p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Kondisi</p>
                            <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" name="kondisi_selesai" value="" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('kondisi_selesai') == '' ? 'checked' : '' }}>
                                Semua Kondisi
                            </label>
                            <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" name="kondisi_selesai" value="lolos" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('kondisi_selesai') == 'lolos' ? 'checked' : '' }}>
                                Lolos
                            </label>
                            <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" name="kondisi_selesai" value="rusak" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('kondisi_selesai') == 'rusak' ? 'checked' : '' }}>
                                Rusak
                            </label>

                            <div class="border-t border-gray-100 my-1 mx-4"></div>

                            <p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Durasi</p>
                            <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" name="durasi_selesai" value="" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_selesai') == '' ? 'checked' : '' }}>
                                Semua Durasi
                            </label>
                            @foreach($durasiList as $durasi)
                            <label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" name="durasi_selesai" value="{{ $durasi['value'] }}" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_selesai') == $durasi['value'] ? 'checked' : '' }}>
                                {{ $durasi['label'] }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- HIDDEN FIELDS --}}
                <input type="hidden" name="search_menunggu" value="">
                <input type="hidden" name="durasi_menunggu" value="">

                {{-- RESET BUTTON SELESAI --}}
                @if(request('search_selesai') || request('kondisi_selesai') || request('durasi_selesai'))
                <a href="{{ route('peminjam-pengembalian') }}" class="h-11 px-5 py-0 inline-flex items-center text-sm text-[#363062]/90 hover:text-[#363062] border border-[#363062] rounded-full transition font-semibold">
                    Reset Filter
                </a>
                @endif
            </div>
        </form>

        {{-- LIST SELESAI --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($selesai as $item)
                <x-card-pengembalian :pengembalian="$item" />
            @empty
                <div class="lg:col-span-2 flex flex-col gap-3 items-center justify-center bg-white border border-gray-300 rounded-[20px] p-6 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="currentColor" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34M15 14H9l-.117.007a1 1 0 0 0 0 1.986L9 16h6l.117-.007a1 1 0 0 0 0-1.986zM9.01 9l-.127.007a1 1 0 0 0 0 1.986L9 11l.127-.007a1 1 0 0 0 0-1.986zm6 0l-.127.007a1 1 0 0 0 0 1.986L15 11l.127-.007a1 1 0 0 0 0-1.986z" />
                    </svg>
                    Belum ada data pengembalian yang selesai.
                </div>
            @endforelse
        </div>

        {{-- PAGINATION SELESAI --}}
        @if($selesai->hasPages())
        <div class="mt-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-500 order-2 sm:order-1 text-center sm:text-left">
                    Menampilkan {{ $selesai->firstItem() }} sampai {{ $selesai->lastItem() }} dari {{ $selesai->total() }} pengembalian
                </div>
                <div class="flex items-center gap-2 order-1 sm:order-2">
                    {{-- Prev --}}
                    @if($selesai->onFirstPage())
                    <button type="button" disabled class="p-3 rounded-full border text-sm flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
                            <defs><path id="sel_prev" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs>
                            <use fill-rule="evenodd" href="#sel_prev" transform="rotate(-180 5.02 9.505)"/>
                        </svg>
                    </button>
                    @else
                    <a href="{{ $selesai->appends(request()->query())->previousPageUrl() }}#selesai" class="p-3 rounded-full border bg-white text-sm flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
                            <defs><path id="sel_prev" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs>
                            <use fill-rule="evenodd" href="#sel_prev" transform="rotate(-180 5.02 9.505)"/>
                        </svg>
                    </a>
                    @endif

                    {{-- Nomor Halaman --}}
                    <div class="flex items-center gap-1 bg-gray-100 p-1.5 sm:p-2 rounded-full shadow-inner">
                        @php
                            $cp = $selesai->currentPage();
                            $lp = $selesai->lastPage();
                            $s  = max(1, $cp - 1);
                            $e  = min($lp, $cp + 1);

                            if ($s > 1) {
                                $cls = (1 == $cp) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
                                echo '<a href="' . $selesai->appends(request()->query())->url(1) . '#selesai" class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition ' . $cls . '">1</a>';
                                if ($s > 2) echo '<span class="px-1 text-gray-400 text-xs">...</span>';
                            }
                            for ($i = $s; $i <= $e; $i++) {
                                $cls = ($i == $cp) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
                                echo '<a href="' . $selesai->appends(request()->query())->url($i) . '#selesai" class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition ' . $cls . '">' . $i . '</a>';
                            }
                            if ($e < $lp) {
                                if ($e < $lp - 1) echo '<span class="px-1 text-gray-400 text-xs">...</span>';
                                $cls = ($lp == $cp) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
                                echo '<a href="' . $selesai->appends(request()->query())->url($lp) . '#selesai" class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition ' . $cls . '">' . $lp . '</a>';
                            }
                        @endphp
                    </div>

                    {{-- Next --}}
                    @if($selesai->hasMorePages())
                    <a href="{{ $selesai->appends(request()->query())->nextPageUrl() }}#selesai" class="p-3 rounded-full border bg-white text-sm flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
                            <defs><path id="sel_next" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs>
                            <use fill-rule="evenodd" href="#sel_next" transform="rotate(-180 5.02 9.505)"/>
                        </svg>
                    </a>
                    @else
                    <button type="button" disabled class="p-3 rounded-full border text-sm flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
                            <defs><path id="sel_next" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs>
                            <use fill-rule="evenodd" href="#sel_next" transform="rotate(-180 5.02 9.505)"/>
                        </svg>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    </div>{{-- end flex flex-col gap-8 --}}
</div>
@endsection

<style>
    [x-cloak] {
        display: none !important;
    }
</style>