@extends('layouts.app')

@section('content')
<div class="mx-auto pt-20 pb-8 lg:py-8 px-4">

    <div class="flex flex-col gap-8">

        <div class="flex flex-col">
            <h1 class="text-2xl sm:text-4xl font-bold">Peminjaman Alat & Barang</h1>
            <p class="text-gray-500">Lakukan peminjaman alat & barang yang telah disediakan oleh Inventry</p>
        </div>

        <div class="h-auto w-full bg-white flex flex-shrink-0 flex-col items-stretch justify-between gap-4 p-6 shadow-lg rounded-[20px] relative z-10">
    
            {{-- Baris 1: Input pencarian + Tombol filter --}}
            <div class="flex items-center gap-3">
                <div class="relative flex-1 h-full">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/>
                        </svg>
                    </div>
                    <form action="{{ route('peminjam-alat') }}" method="GET" id="searchForm">
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}" id="kategoriInput">
                        <input type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari alat..." 
                            class="w-full h-full pl-10 pr-4 py-3 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow bg-white"
                            onchange="this.form.submit()">
                    </form>
                </div>

                {{-- Dropdown Filter --}}
                <div x-data="filter()" class="relative">
                    <button id="filterBtn" @click="toggle($el)" class="w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/></svg>
                    </button>

                    <template x-teleport="body">
                        <div x-show="open"
                             x-cloak
                             @click.outside="open = false"
                             :style="dropdownStyle"
                             class="fixed z-[9999] w-72 bg-white rounded-[20px] shadow-xl border border-gray-100 max-h-[70vh] overflow-y-auto">
                            <div class="p-3">
                                <p class="px-3 py-2 text-xs font-bold text-gray-500">Kategori</p>
                                <template x-for="kat in kategoris" :key="kat.id">
                                    <div class="flex items-center justify-between px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer"
                                        @click="toggleKategori(kat.id)">
                                        <span class="text-sm text-[#363062]" x-text="kat.nama_kategori"></span>
                                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all duration-200"
                                            :class="kategoriIds.includes(kat.id) ? 'border-[#363062] bg-[#363062] scale-110' : 'border-gray-300 scale-100'">
                                            <svg x-show="kategoriIds.includes(kat.id)"
                                                x-transition:enter="transition ease-out duration-150"
                                                x-transition:enter-start="opacity-0 scale-50"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                <path d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </template>

                                <div class="border-t my-2"></div>

                                <p class="px-3 py-2 text-xs font-bold text-gray-500">Durasi</p>
                                <template x-for="dur in durasiList" :key="dur.value">
                                    <div class="flex items-center justify-between px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer"
                                        @click="toggleDurasi(dur.value)">
                                        <span class="text-sm text-[#363062]" x-text="dur.label"></span>
                                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all duration-200"
                                            :class="durasiIds.includes(dur.value) ? 'border-[#363062] bg-[#363062] scale-110' : 'border-gray-300 scale-100'">
                                            <svg x-show="durasiIds.includes(dur.value)"
                                                x-transition:enter="transition ease-out duration-150"
                                                x-transition:enter-start="opacity-0 scale-50"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                <path d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </template>

                                <div class="flex gap-2 mt-3 pt-2 border-t">
                                    <button @click="apply()" class="flex-1 py-2 text-sm text-white bg-[#363062] rounded-full hover:bg-[#4D4C7D]">Terapkan</button>
                                    <button @click="reset()" class="flex-1 py-2 text-sm text-[#363062] bg-gray-100 rounded-full hover:bg-gray-200">Reset</button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Active Filters Chips --}}
            <div class="flex items-center gap-2 flex-wrap" x-data="chips()" x-init="init()">
                <template x-for="kat in activeKategori" :key="kat.id">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 text-sm bg-[#363062]/10 text-[#363062] rounded-full">
                        Kategori: <span x-text="kat.nama_kategori"></span>
                        <button @click="removeKategori(kat.id)" class="hover:text-red-500">✕</button>
                    </span>
                </template>
                <template x-for="dur in activeDurasi" :key="dur.value">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 text-sm bg-[#363062]/10 text-[#363062] rounded-full">
                        Durasi: <span x-text="dur.label"></span>
                        <button @click="removeDurasi(dur.value)" class="hover:text-red-500">✕</button>
                    </span>
                </template>
                <template x-if="searchQuery">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 text-sm bg-[#363062]/10 text-[#363062] rounded-full">
                        Pencarian: "<span x-text="searchQuery"></span>"
                        <button @click="clearSearch()" class="hover:text-red-500">✕</button>
                    </span>
                </template>
            </div>
        </div>
    
        {{-- Card Alat --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @forelse($alat as $item)
                <x-card-alat :alat="$item" />
            @empty
                <div class="col-span-3 text-center py-12 text-gray-500">
                    <svg class="h-16 w-16 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-lg font-medium">Tidak ada alat ditemukan</p>
                </div>
            @endforelse
        </div>
        
        {{-- Pagination --}}
        <div class="col-span-3 mt-6">
            @if($alat->hasPages())
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    {{-- Keterangan Data --}}
                    <div class="text-sm text-gray-500 order-2 sm:order-1 text-center sm:text-left">
                        Menampilkan {{ $alat->firstItem() }} sampai {{ $alat->lastItem() }} dari {{ $alat->total() }} alat
                    </div>

                    {{-- Navigasi Tombol --}}
                    <div class="flex items-center gap-2 order-1 sm:order-2">
                        {{-- Tombol Previous --}}
                        @if($alat->onFirstPage())
                        <button type="button" disabled class="p-3 rounded-full border text-sm flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
                                <defs><path id="SVG1pzpbdYY_prev" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs>
                                <use fill-rule="evenodd" href="#SVG1pzpbdYY_prev" transform="rotate(-180 5.02 9.505)"/>
                            </svg>
                        </button>
                        @else
                        <a href="{{ $alat->appends(request()->query())->previousPageUrl() }}" class="p-3 rounded-full border bg-white text-sm flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
                                <defs><path id="SVG1pzpbdYY_prev" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs>
                                <use fill-rule="evenodd" href="#SVG1pzpbdYY_prev" transform="rotate(-180 5.02 9.505)"/>
                            </svg>
                        </a>
                        @endif

                        {{-- Nomor Halaman --}}
                        <div class="flex items-center gap-1 bg-gray-100 p-1.5 sm:p-2 rounded-full shadow-inner">
                            @php
                                $currentPage = $alat->currentPage();
                                $lastPage = $alat->lastPage();
                                $start = max(1, $currentPage - 1); // Di mobile disempitkan jangkauannya agar tidak kepanjangan
                                $end = min($lastPage, $currentPage + 1);
                                
                                if ($start > 1) {
                                    $activeClassFirst = (1 == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
                                    echo '<a href="' . $alat->appends(request()->query())->url(1) . '" class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition ' . $activeClassFirst . '">1</a>';
                                    if ($start > 2) {
                                        echo '<span class="px-1 text-gray-400 text-xs">...</span>';
                                    }
                                }
                                
                                for ($i = $start; $i <= $end; $i++) {
                                    $activeClass = ($i == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
                                    echo '<a href="' . $alat->appends(request()->query())->url($i) . '" class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition ' . $activeClass . '">' . $i . '</a>';
                                }
                                
                                if ($end < $lastPage) {
                                    if ($end < $lastPage - 1) {
                                        echo '<span class="px-1 text-gray-400 text-xs">...</span>';
                                    }
                                    $activeClassLast = ($lastPage == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
                                    echo '<a href="' . $alat->appends(request()->query())->url($lastPage) . '" class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition ' . $activeClassLast . '">' . $lastPage . '</a>';
                                }
                            @endphp
                        </div>

                        {{-- Tombol Next --}}
                        @if($alat->hasMorePages())
                        <a href="{{ $alat->appends(request()->query())->nextPageUrl() }}" class="p-3 rounded-full border bg-white text-sm flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
                                <defs><path id="SVG1pzpbdYY_next" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs>
                                <use fill-rule="evenodd" href="#SVG1pzpbdYY_next" transform="rotate(-180 5.02 9.505)"/>
                            </svg>
                        </a>
                        @else
                        <button type="button" disabled class="p-3 rounded-full border text-sm flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
                                <defs><path id="SVG1pzpbdYY_next" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs>
                                <use fill-rule="evenodd" href="#SVG1pzpbdYY_next" transform="rotate(-180 5.02 9.505)"/>
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        
    </div>
</div>

@push('scripts')
<script>
    function filter() {
        return {
            open: false,
            dropdownStyle: '',
            kategoris: @json($kategori),
            durasiList: @json($durasiList),
            kategoriIds: [],
            durasiIds: [],
            
            init() {
                const url = new URL(window.location.href);
                const kategori = url.searchParams.get('kategori');
                const durasi = url.searchParams.get('durasi_filter');
                if (kategori) this.kategoriIds = kategori.split(',').map(Number);
                if (durasi) this.durasiIds = durasi.split(',').map(Number);
            },

            toggleKategori(id) {
                if (this.kategoriIds.includes(id)) {
                    this.kategoriIds = this.kategoriIds.filter(i => i !== id);
                } else {
                    this.kategoriIds.push(id);
                }
            },

            toggleDurasi(value) {
                if (this.durasiIds.includes(value)) {
                    this.durasiIds = this.durasiIds.filter(v => v !== value);
                } else {
                    this.durasiIds.push(value);
                }
            },

            toggle(btn) {
                if (!this.open) {
                    const rect = btn.getBoundingClientRect();
                    const dropdownWidth = 288; // w-72 = 18rem = 288px
                    const gap = 8;
                    let left = rect.right - dropdownWidth;
                    if (left < 8) left = 8;
                    this.dropdownStyle = `top: ${rect.bottom + gap}px; left: ${left}px;`;
                }
                this.open = !this.open;
            },
            
            apply() {
                const url = new URL(window.location.href);
                if (this.kategoriIds.length) url.searchParams.set('kategori', this.kategoriIds.join(','));
                else url.searchParams.delete('kategori');
                if (this.durasiIds.length) url.searchParams.set('durasi_filter', this.durasiIds.join(','));
                else url.searchParams.delete('durasi_filter');
                window.location.href = url.toString();
            },
            
            reset() {
                this.kategoriIds = [];
                this.durasiIds = [];
                this.apply();
            }
        }
    }
    
    function chips() {
        return {
            activeKategori: [],
            activeDurasi: [],
            searchQuery: '{{ request('search') }}',
            
            init() {
                const url = new URL(window.location.href);
                const kategori = url.searchParams.get('kategori');
                const durasi = url.searchParams.get('durasi_filter');
                if (kategori) {
                    const ids = kategori.split(',').map(Number);
                    this.activeKategori = @json($kategori).filter(k => ids.includes(k.id));
                }
                if (durasi) {
                    const ids = durasi.split(',').map(Number);
                    this.activeDurasi = @json($durasiList).filter(d => ids.includes(d.value));
                }
            },
            
            removeKategori(id) {
                const url = new URL(window.location.href);
                let ids = url.searchParams.get('kategori')?.split(',').map(Number).filter(i => i !== id) || [];
                if (ids.length) url.searchParams.set('kategori', ids.join(','));
                else url.searchParams.delete('kategori');
                window.location.href = url.toString();
            },
            
            removeDurasi(value) {
                const url = new URL(window.location.href);
                let ids = url.searchParams.get('durasi_filter')?.split(',').map(Number).filter(v => v !== value) || [];
                if (ids.length) url.searchParams.set('durasi_filter', ids.join(','));
                else url.searchParams.delete('durasi_filter');
                window.location.href = url.toString();
            },
            
            clearSearch() {
                const url = new URL(window.location.href);
                url.searchParams.delete('search');
                window.location.href = url.toString();
            }
        }
    }
</script>
<style>[x-cloak] { display: none !important; }</style>
@endpush

@endsection

