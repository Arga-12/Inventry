@extends('layouts.app')

@section('content')
<div class="mx-auto pt-20 pb-8 lg:py-8 px-4">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-stretch">

        {{-- baris1 kolom1 --}}
        <div class="flex flex-col gap-8 h-full">
            <div class="flex-1 flex flex-col">
                <h1 class="text-2xl sm:text-4xl font-bold">Dashboard</h1>
                <p class="text-gray-500">Selamat datang, {{ $user->nama_lengkap }} di Inventry</p>
            </div>

            <div class="flex items-center justify-between gap-8">
                <div class="h-max w-full bg-white shadow-lg rounded-[20px] flex flex-col items-start p-6 gap-2">

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center w-full gap-4">
                        <div class="flex flex-col items-start">
                            <h2 class="font-bold text-xl sm:text-3xl">Total Peminjaman</h2>
                            <p class="text-sm font-light text-gray-500">Total peminjaman anda berdasarkan tiap kategori
                            </p>
                        </div>

                        <div class="flex items-baseline gap-1">
                            <h2 class="font-bold text-5xl">{{ $totalPeminjaman }}</h2>
                            <span class="text-xs font-light text-gray-500">Peminjaman</span>
                        </div>
                    </div>

                    <div class="w-full h-2 rounded-full overflow-hidden flex mt-3">
                        @foreach($kategoriStats as $stat)
                            <div class="h-full 
                                {{ $loop->first ? 'rounded-l-full' : '' }} 
                                {{ $loop->last ? 'rounded-r-full' : '' }}" 
                                style="width: {{ $stat['percentage'] }}%; background-color: {{ $stat['color'] }}">
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-4 mt-3 text-sm flex-wrap">
                        @foreach($kategoriStats as $stat)
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full" style="background-color: {{ $stat['color'] }}"></span>
                                <span>{{ $stat['nama'] }} ({{ $stat['total'] }})</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- baris1 kolom2 --}}
        <div class="h-full bg-gradient-to-r from-[#363062] to-[#4D4C7D] rounded-[20px] px-6 py-8 md:p-8 shadow-lg flex flex-col justify-between gap-6">
            <div class="flex justify-between items-start gap-4">
                <div class="flex flex-col">
                    <h2 class="text-xl sm:text-3xl font-bold text-white">Ingin Meminjam Alat?</h2>
                    <p class="text-white/80 text-xs md:text-sm mb-2">Quick search pada kolom dibawah</p>
                </div>

                <div class="bg-gradient-to-l from-[#FFFFFF] to-[#F5F5F5] shadow-md h-10 w-10 md:h-12 md:w-12 rounded-[12px] md:rounded-[15px] flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-9 md:w-9 text-[#F99417]" viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd">
                            <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                            <path fill="currentColor" d="m13.25 2.567l6.294 3.634a2.5 2.5 0 0 1 1.25 2.165v7.268a2.5 2.5 0 0 1-1.25 2.165l-6.294 3.634a2.5 2.5 0 0 1-2.5 0l-6.294-3.634a2.5 2.5 0 0 1-1.25-2.165V8.366a2.5 2.5 0 0 1 1.25-2.165l6.294-3.634a2.5 2.5 0 0 1 2.5 0M5.206 9.232v6.402a.5.5 0 0 0 .25.433l5.544 3.2V12.56zm13.588 0L13 12.56v6.709l5.544-3.201a.5.5 0 0 0 .242-.345l.008-.088zM11.75 4.3L6.206 7.5l5.544 3.201a.5.5 0 0 0 .5 0L17.794 7.5L12.25 4.299a.5.5 0 0 0-.5 0Z" />
                        </g>
                    </svg>
                </div>
            </div>

            {{-- QUICK SEARCH FORM --}}
            <div class="relative" x-data="{ 
                query: '{{ $searchQuery ?? '' }}',
                results: [],
                showResults: false,
                isLoading: false,
                searchTimeout: null,
                
                async search() {
                    if (this.query.length < 2) {
                        this.results = [];
                        this.showResults = false;
                        return;
                    }
                    
                    this.isLoading = true;
                    this.showResults = true;
                    
                    try {
                        const response = await fetch('{{ route("peminjam-search-alat") }}?q=' + encodeURIComponent(this.query));
                        const data = await response.json();
                        this.results = data.data;
                    } catch (error) {
                        console.error('Search error:', error);
                        this.results = [];
                    } finally {
                        this.isLoading = false;
                    }
                },
                
                handleInput() {
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        this.search();
                    }, 300);
                },
                
                goToAlatPage() {
                    if (this.query.length >= 2) {
                        window.location.href = '{{ route("peminjam-alat") }}?search=' + encodeURIComponent(this.query);
                    }
                }
            }" class="relative">
                
                {{-- Search Input dengan Ikon --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        x-model="query"
                        @input="handleInput()"
                        @keydown.enter.prevent="goToAlatPage()"
                        @focus="if(query.length >= 2) showResults = true"
                        @click.away="showResults = false"
                        placeholder="Cari alat (min. 2 karakter)..." 
                        class="w-full pl-10 pr-24 py-3 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-white/50 transition-shadow bg-white/90 backdrop-blur-sm"
                    >
                    
                    {{-- Tombol Cari --}}
                    <button 
                        @click="goToAlatPage()"
                        class="absolute right-1 top-1 bottom-1 px-4 rounded-full bg-[#F99417] text-white text-sm font-semibold hover:bg-[#e0850f] transition-colors">
                        Cari
                    </button>
                </div>
                
                {{-- Loading Indicator --}}
                <div x-show="isLoading" class="absolute left-0 right-0 mt-2 bg-white rounded-xl shadow-lg z-20 p-4 text-center text-gray-500">
                    <svg class="animate-spin h-5 w-5 mx-auto text-[#363062]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-xs">Mencari...</span>
                </div>
                
                {{-- Hasil Pencarian --}}
                <div x-show="showResults && !isLoading && results.length > 0" 
                    x-cloak
                    class="absolute left-0 right-0 mt-2 bg-white rounded-xl shadow-lg z-20 max-h-64 overflow-y-auto">
                    <template x-for="alat in results" :key="alat.id">
                        <a :href="'{{ route('peminjam-alat') }}?search=' + encodeURIComponent(alat.nama_alat)" 
                        class="flex items-center justify-between p-3 hover:bg-gray-50 border-b last:border-b-0 transition-colors">
                            <div>
                                <p class="font-medium" x-text="alat.nama_alat"></p>
                                <p class="text-xs text-gray-500">
                                    <span x-text="alat.kode_alat"></span> • Stok: <span x-text="alat.stok"></span>
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-[#4D4C7D]" x-text="alat.kategori?.nama_kategori || '-'"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M8.59 16.59L13.17 12L8.59 7.41L10 6l6 6l-6 6z"/>
                                </svg>
                            </div>
                        </a>
                    </template>
                </div>
                
                {{-- Hasil Pencarian Kosong --}}
                <div x-show="showResults && !isLoading && query.length >= 2 && results.length === 0" 
                    x-cloak
                    class="absolute left-0 right-0 mt-2 bg-white rounded-xl shadow-lg z-20 p-4 text-center text-gray-500">
                    <p class="text-sm">Tidak ada alat ditemukan untuk "<span x-text="query"></span>"</p>
                    <button @click="goToAlatPage()" class="mt-2 text-xs text-[#F99417] hover:underline">
                        Lihat semua hasil →
                    </button>
                </div>
            </div>
        </div>

        {{-- baris2 kolom1 --}}
        <div class="relative flex flex-col h-96">

            {{-- title --}}
            <div class="mb-4">
                <h2 class="text-xl sm:text-3xl font-bold">Peminjaman Anda saat ini</h2>
                <p class="text-sm font-light text-gray-500">
                    Daftar peminjaman yang sedang berlangsung
                </p>
            </div>

            <div class="flex-1 overflow-y-auto pl-6 flex flex-col gap-4 no-scrollbar">
                @forelse($activePeminjaman as $pinjam)
                @php
                    // Ambil gambar secara random dari detail peminjaman
                    $detailPeminjaman = $pinjam->detailPeminjaman;
                    $randomImage = null;
                    
                    if ($detailPeminjaman->count() > 0) {
                        // Kumpulkan semua gambar yang tersedia
                        $images = [];
                        foreach ($detailPeminjaman as $detail) {
                            if ($detail->alat->gambar) {
                                $images[] = asset('storage/' . $detail->alat->gambar);
                            }
                        }
                        // Random pick gambar, kalau gaada gambar pake default
                        $randomImage = !empty($images) ? $images[array_rand($images)] : asset('images/id1.jpg');
                    } else {
                        $randomImage = asset('images/id1.jpg');
                    }
                    
                    // Hitung waktu peminjaman (dari tanggal_disetujui)
                    $waktuMulai = $pinjam->tanggal_disetujui ? Carbon\Carbon::parse($pinjam->tanggal_disetujui) : null;
                    $deadline = $pinjam->deadline ? Carbon\Carbon::parse($pinjam->deadline) : null;
                    
                    // Format waktu peminjaman (jam mulai - jam deadline)
                    $waktuPeminjaman = '';
                    if ($waktuMulai && $deadline) {
                        $waktuPeminjaman = $waktuMulai->format('H:i') . ' - ' . $deadline->format('H:i');
                    } elseif ($waktuMulai) {
                        $waktuPeminjaman = $waktuMulai->format('H:i') . ' (Mulai)';
                    } else {
                        $waktuPeminjaman = '-';
                    }
                @endphp
                
                {{-- card list antrian --}}
                <div class="relative w-full min-h-[5rem] py-4 flex-shrink-0 bg-white rounded-[20px] flex flex-col md:flex-row items-start md:items-center pl-12 pr-4 md:px-10 shadow-md gap-4">

                    <div class="absolute -left-4 w-14 h-16 bg-gray-500 rounded-[15px] shadow-md overflow-hidden">
                        <img src="{{ $randomImage }}" class="object-cover w-full h-full">
                    </div>

                    <div class="ml-4 flex flex-col">
                        <p class="font-medium text-[#363062]">{{ $pinjam->kode_peminjaman }}</p>
                        <p class="flex font-light text-sm text-[#4D4C7D]">{{ Str::limit($pinjam->daftar_alat, 40) }}</p>
                    </div>

                    <div class="w-full md:w-auto md:ml-auto flex flex-wrap md:flex-nowrap items-center gap-3 mt-2 md:mt-0 justify-between md:justify-end">
                        <div class="flex items-center gap-2 flex-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#363062] shrink-0" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0" />
                                    <path d="M12 7v5l3 3" />
                                </g>
                            </svg>
                            <div class="flex items-center gap-1 text-[10px] md:text-xs">
                                <span class="text-[#363062] bg-[#363062]/10 p-1.5 rounded-lg whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($pinjam->tanggal_disetujui)->format('H:i | d-m-Y') }}
                                </span>
                                <span class="text-[#363062]">-</span>
                                <span class="text-[#363062] bg-[#363062]/10 p-1.5 rounded-lg whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($pinjam->deadline)->format('H:i | d-m-Y') }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('peminjam-peminjaman') }}" class="h-8 w-24 px-2 rounded-full bg-[#4D4C7D] flex items-center justify-center text-white text-xs font-semibold hover:bg-[#363062] transition-colors shrink-0 ml-auto md:ml-0">
                            Selengkapnya
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    Tidak ada peminjaman aktif
                </div>
                @endforelse
            </div>
            <div class="pointer-events-none absolute bottom-0 left-0 w-full h-3 bg-gradient-to-t from-white to-transparent">
            </div>
        </div>

        {{-- baris2 kolom2 --}}
        <div class="relative w-full min-h-[24rem] md:h-96 bg-white rounded-[20px] p-6 md:p-10 overflow-hidden shadow-lg">

            @if($recommendedAlat->isNotEmpty())
            @php $rekom = $recommendedAlat->first(); @endphp
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $rekom->gambar ? asset('storage/' . $rekom->gambar) : asset('images/default-alat.jpg') }}')">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-black/30"></div>
            </div>

            <div class="relative z-10 flex flex-col h-full text-white">
                <div class="space-y-1">
                    <h1 class="text-2xl sm:text-4xl font-bold">Untuk Anda!</h1>
                    <p class="text-base md:text-lg font-light line-clamp-4 md:line-clamp-none">Optimalkan alur kerja Anda dengan rekomendasi inventaris
                        yang relevan. Perangkat di bawah ini dipilih secara otomatis untuk mendukung kebutuhan teknis
                        Anda saat ini.</p>
                </div>

                <div class="mt-auto flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 pt-4">

                    <!-- kiri -->
                    <div class="flex flex-col gap-1">
                        <p class="font-semibold text-white">{{ $rekom->nama_alat }}</p>

                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/>
                                    <path d="M12 7v5l3 3"/>
                                </g>
                            </svg>
                            <p class="font-medium">{{ floor($rekom->durasi / 60) }} Jam {{ $rekom->durasi % 60 }} Menit</p>
                        </div>
                    </div>

                    <!-- kanan -->
                    <a href="{{ route('peminjam-alat') }}?alat_id={{ $rekom->id }}" class="h-9 w-full sm:w-48 px-4 rounded-full border border-white flex items-center justify-center text-white text-sm font-semibold hover:bg-white hover:text-[#4D4C7D] transition-colors shrink-0">
                        Pinjam Sekarang
                    </a>
                </div>
            </div>
            @else
            <div class="flex items-center justify-center h-full text-gray-500">
                Belum ada rekomendasi alat
            </div>
            @endif
        </div>
    </div>{{-- end grid --}}
</div>
@endsection