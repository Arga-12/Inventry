@extends('layouts.app')

@section('content')
<div class="mx-auto pt-20 pb-8 lg:py-8 px-4">
    <div class="flex flex-col gap-8 lg:grid lg:grid-cols-3 lg:gap-10 lg:items-start">

        {{-- baris1 kolom1 --}}
        <div class="lg:col-span-1 flex flex-col gap-3">
            <h1 class="text-2xl sm:text-4xl font-bold tracking-tight">Dashboard</h1>
            <p class="text-gray-500 font-medium leading-relaxed">
                Selamat datang di Inventry, mari pantau dan kelola antrean persetujuan peminjaman serta pengembalian alat hari ini.
            </p>
        </div>

        {{-- baris1 kolom2 col-span2 --}}
        <div class="lg:col-span-2 rounded-[20px] p-4 bg-gradient-to-r from-[#363062] to-[#4D4C7D] flex flex-col sm:flex-row gap-6 relative shadow-lg">

            {{-- Menunggu Persetujuan --}}
            <div class="flex-1 flex flex-col min-w-0">
                <div class="flex flex-wrap justify-between items-center gap-2 mb-3">
                    <h3 class="font-bold text-white text-base sm:text-lg">Menunggu Persetujuan</h3>
                    <div class="flex items-center gap-1.5 text-xs sm:text-sm font-normal text-white shrink-0">
                        <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        {{ $totalMenungguPersetujuan }} Peminjam
                    </div>
                </div>

                <div class="flex flex-col gap-2 mb-3 min-h-[80px]">
                    @forelse($menungguPersetujuan as $item)
                    <div class="flex justify-between items-center gap-2">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full shadow-md flex-shrink-0 bg-gray-50 overflow-hidden">
                                <img src="{{ asset('storage/' . $item['foto']) }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                            </div>
                            <span class="font-bold text-white text-sm truncate">{{ $item['nama'] }}</span>
                        </div>
                        <span class="text-xs sm:text-sm font-medium text-white shrink-0">{{ $item['total_item'] }} Item</span>
                    </div>
                    @empty
                    <div class="text-white/70 text-sm text-center py-4">Tidak ada data</div>
                    @endforelse
                </div>

                <a href="{{ route('petugas-peminjaman') }}" 
                   class="w-full mt-auto py-2 border border-transparent rounded-full font-normal text-center text-[#363062] bg-white hover:bg-transparent hover:border-white hover:text-white transition-colors text-sm">
                    Selengkapnya
                </a>
            </div>

            <div class="hidden sm:block w-0.5 bg-white/50 rounded-full flex-shrink-0"></div>
            <div class="block sm:hidden h-0.5 w-full bg-white/50 rounded-full flex-shrink-0"></div>

            {{-- Menunggu Konfirmasi --}}
            <div class="flex-1 flex flex-col min-w-0">
                <div class="flex flex-wrap justify-between items-center gap-2 mb-3">
                    <h3 class="font-bold text-white text-base sm:text-lg">Menunggu Konfirmasi</h3>
                    <div class="flex items-center gap-1.5 text-xs sm:text-sm font-normal text-white shrink-0">
                        <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        {{ $totalMenungguKonfirmasi }} Pengembali
                    </div>
                </div>

                <div class="flex flex-col gap-2 mb-3 min-h-[80px]">
                    @forelse($menungguKonfirmasi as $item)
                    <div class="flex justify-between items-center gap-2">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full shadow-md flex-shrink-0 bg-gray-50 overflow-hidden">
                                <img src="{{ asset('storage/' . $item['foto']) }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                            </div>
                            <span class="font-bold text-white text-sm truncate">{{ $item['nama'] }}</span>
                        </div>
                        <span class="text-xs sm:text-sm font-medium text-white shrink-0">{{ $item['total_item'] }} Item</span>
                    </div>
                    @empty
                    <div class="text-white/70 text-sm text-center py-4">Tidak ada data</div>
                    @endforelse
                </div>

                <a href="{{ route('petugas-pengembalian') }}" 
                   class="w-full mt-auto py-2 border border-transparent rounded-full font-normal text-center text-[#363062] bg-white hover:bg-transparent hover:border-white hover:text-white transition-colors text-sm">
                    Selengkapnya
                </a>
            </div>

        </div>

        {{-- baris2 --}}
        <div class="w-full p-4 flex flex-col col-span-3 gap-3">

            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-l from-[#363062] to-[#4D4C7D] shadow-lg h-14 w-14 p-auto rounded-[15px] flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#F5F5F5]" viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd">
                            <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                            <path fill="currentColor" d="m13.25 2.567l6.294 3.634a2.5 2.5 0 0 1 1.25 2.165v7.268a2.5 2.5 0 0 1-1.25 2.165l-6.294 3.634a2.5 2.5 0 0 1-2.5 0l-6.294-3.634a2.5 2.5 0 0 1-1.25-2.165V8.366a2.5 2.5 0 0 1 1.25-2.165l6.294-3.634a2.5 2.5 0 0 1 2.5 0M5.206 9.232v6.402a.5.5 0 0 0 .25.433l5.544 3.2V12.56zm13.588 0L13 12.56v6.709l5.544-3.201a.5.5 0 0 0 .242-.345l.008-.088zM11.75 4.3L6.206 7.5l5.544 3.201a.5.5 0 0 0 .5 0L17.794 7.5L12.25 4.299a.5.5 0 0 0-.5 0Z" />
                        </g>
                    </svg>
                </div>

                <div class="flex flex-col gap-1">
                    <h2 class="text-xl sm:text-3xl font-bold">Aktivitas Saya</h2>
                    <p class="text-sm font-medium text-gray-500">
                        Pantau aktivitas persetujuan dan verifikasi yang telah Anda lakukan.
                    </p>
                </div>
            </div>

            <div class="w-full">
                <div class="flex flex-col">

                    {{-- Statistik aktivitas petugas --}}
                    <div class="flex gap-4 mb-6">
                        <div class="text-xs font-medium invisible shrink-0 pointer-events-none">
                            argandull
                        </div>
                        <div class="flex-1 grid grid-cols-2 gap-8">
                            <div class="flex flex-col items-start">
                                <span class="block text-5xl font-bold">{{ $totalPengajuanDiterima }}</span>
                                <span class="text-sm font-medium text-gray-500">Pengajuan disetujui</span>
                            </div>
                            <div class="flex flex-col items-start">
                                <span class="block text-5xl font-bold">{{ $totalPengembalianDilakukan }}</span>
                                <span class="text-sm font-medium text-gray-500">Pengembalian diverifikasi</span>
                            </div>
                        </div>
                    </div>

                    {{-- CHART MATRIKS: 12 Kolom (Bulan) x 4 Baris (Minggu 1-4) --}}
                    <div class="border-t border-gray-200 pt-6">
                        <div class="w-full">
                            <div class="w-full">
                                
                                {{-- BARIS 1-4: Minggu 1 sampai Minggu 4 --}}
                                @for($week = 1; $week <= 4; $week++)
                                <div class="flex mb-1.5">
                                    <div class="w-16 sm:w-24 flex-shrink-0 flex items-center">
                                        <span class="text-[10px] sm:text-xs font-medium text-gray-500">Minggu {{ $week }}</span>
                                    </div>
                                    <div class="flex flex-1 gap-1 sm:gap-2">
                                        @for($month = 1; $month <= 12; $month++)
                                            @php
                                                $count = isset($chartData['weeklyData'][$month][$week]) ? $chartData['weeklyData'][$month][$week] : 0;
                                                $color = isset($chartData['weeklyColors'][$month][$week]) ? $chartData['weeklyColors'][$month][$week] : '#F3F4F6';
                                            @endphp
                                            <div class="flex-1">
                                                <div class="rounded sm:rounded-lg h-6 sm:h-10 transition-all duration-200 cursor-pointer relative group {{ $count == 0 ? 'border border-gray-200' : '' }}" 
                                                    style="background-color: {{ $color }};"
                                                    title="Minggu {{ $week }} - {{ $chartData['months'][$month-1] }}: {{ $count }} aktivitas">
                                                    @if($count > 0)
                                                    <div class="absolute bottom-0.5 right-0.5 text-white text-[7px] sm:text-[9px] font-bold opacity-80 hidden sm:block">
                                                        {{ $count }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                                @endfor
                                
                                {{-- NAMA BULAN DI BAWAH MATRIKS --}}
                                <div class="flex mt-2">
                                    <div class="w-16 sm:w-24 flex-shrink-0"></div>
                                    <div class="flex flex-1 gap-1 sm:gap-2">
                                        @foreach($chartData['months'] as $month)
                                        <div class="flex-1 text-center text-[8px] sm:text-xs font-semibold text-gray-600">
                                            {{ substr($month, 0, 3) }}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>

            {{-- Legend --}}
            <div class="border-t border-gray-200 pt-4 mt-2">
                <div class="flex items-center gap-4 text-xs flex-wrap">
                    <span class="text-gray-500 font-medium">Intensitas aktivitas:</span>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded" style="background-color: #F3F4F6; border: 1px solid #E5E7EB;"></div>
                        <span class="text-gray-500">0</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded" style="background-color: #E0E0F0"></div>
                        <span class="text-gray-500">1-5</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded" style="background-color: #B8B8D4"></div>
                        <span class="text-gray-500">6-10</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded" style="background-color: #8B8AB2"></div>
                        <span class="text-gray-500">11-15</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded" style="background-color: #4D4C7D"></div>
                        <span class="text-gray-500">16-25</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded" style="background-color: #2A2952"></div>
                        <span class="text-gray-500">26+</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection