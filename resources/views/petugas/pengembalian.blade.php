@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4 flex flex-col overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-stretch flex-1 min-h-0 mb-6 h-screen">

        <div class="lg:col-span-3 flex flex-col gap-1 mb-2">
            <h1 class="text-4xl font-bold">Manajemen Pengembalian</h1>
            <p class="text-sm font-medium text-gray-500">
                Kelola antrean persetujuan, pantau alat yang sedang dipinjam, dan periksa log aktivitas secara real-time.
            </p>
        </div>

        {{-- Statistik Cards --}}
        <div class="p-4 border-b-2 border-black rounded-[20px] bg-[#F5F5F5] flex flex-col shadow-lg justify-between gap-2">
            <div class="flex justify-between items-start gap-4">
                <h3 class="font-bold text-2xl">Menunggu Penerimaan</h3>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#F99417] flex-shrink-0" viewBox="0 0 24 24">
                    <g fill="currentColor">
                        <path d="M12 4a8 8 0 1 0 0 16a8 8 0 0 0 0-16M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12"/>
                        <path d="M12 14a1 1 0 0 1-1-1V7a1 1 0 1 1 2 0v6a1 1 0 0 1-1 1m-1.5 2.5a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0"/>
                    </g>
                </svg>
            </div>
            <span class="text-5xl font-bold">{{ $totalMenunggu }}</span>
            <p class="text-xs font-medium text-gray-500">Pengajuan baru yang perlu di-review</p>
        </div>

        <div class="p-4 border-b-2 border-black rounded-[20px] bg-[#F5F5F5] flex flex-col justify-between shadow-lg gap-2">
            <h3 class="font-bold text-2xl">Total Alat Dipinjam</h3>
            
			<span class="text-5xl font-bold">{{ $totalAlatDipinjam }}</span>
            <p class="text-xs font-medium text-gray-500">Item dalam peminjaman</p>
        </div>

        <div class="p-4 rounded-[20px] bg-gradient-to-r from-[#363062] to-[#4D4C7D] flex flex-col items-center justify-center gap-2 shadow-lg">
            <h3 class="font-bold text-xs tracking-widest uppercase text-white">Time<span class="text-[#F99417]">stamp</span></h3>
            <span class="text-5xl font-bold text-white tracking-wider font-mono" id="clock">-- : -- : --</span>
        </div>

        {{-- Kolom Kiri: List Pengembali --}}
        <div class="lg:col-span-1 flex flex-col min-h-0 gap-4 h-full">

            <form method="GET" action="{{ route('petugas-pengembalian') }}" class="relative w-full h-[52px] flex-shrink-0">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari peminjam..." 
                    class="w-full h-full pl-10 pr-4 py-3 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow bg-[#F5F5F5]"
                    onchange="this.form.submit()"
                >
            </form>

            <div class="p-4 rounded-[20px] bg-white shadow-lg border border-gray-300 flex flex-col gap-4 h-full">
                <div class="flex flex-col gap-2 mb-2">
                    <h2 class="text-2xl font-bold text-gray-900">Antrean Pengembalian</h2>
                    <hr class="border-t border-gray-500 -mx-4">
                </div>

                <div class="flex-1 overflow-y-auto flex flex-col gap-4 custom-scrollbar min-h-0">
                    @forelse($menungguList as $item)
                    <a href="{{ route('petugas-pengembalian', ['pengembalian_id' => $item['id'], 'search' => request('search')]) }}" 
                    class="flex items-center gap-3 w-full group">
                        <div class="w-12 h-12 rounded-full border border-gray-300 flex-shrink-0 bg-gray-100 shadow-sm overflow-hidden">
                            <img src="{{ asset('storage/' . ($item['peminjam']['foto'] ?? '')) }}" 
                                alt="" 
                                class="w-full h-full object-cover"
                                onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                        </div>
                        <div class="transition-all duration-300 flex-1 flex justify-between items-center rounded-full px-4 py-3 border 
                            {{ $selectedPengembalianId == $item['id'] 
                                ? 'bg-[#363062] text-white border-transparent' 
                                : 'bg-transparent text-[#363062] border-[#363062]' 
                            }} 
                            group-hover:bg-[#363062] group-hover:text-white group-hover:border-transparent">
                            <span class="transition-colors duration-300 font-bold text-sm">
                                {{ $item['peminjam']['nama_lengkap'] }}
                            </span>
                            
                            <span class="transition-colors duration-300 text-[10px] font-bold">
                                #{{ $item['kode_pengembalian'] }}
                            </span>
                        </div>
                    </a>
                    @empty
                    <div class="text-center text-gray-500 py-8">
                        Tidak ada antrean pengembalian
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Detail Pengembalian --}}
        <div class="lg:col-span-2 flex flex-col min-h-0 gap-4 h-full">

            <div class="flex gap-4 items-center h-[52px] flex-shrink-0">
                <span class="font-bold text-3xl">Detail pengembalian</span>
            </div>

            @if($selectedPengembalian)
            <form action="{{ route('petugas-pengembalian-update', $selectedPengembalian['kode_pengembalian']) }}" method="POST" class="flex-1 flex flex-col min-h-0">
                @csrf
                @method('PUT')
                
                <div class="p-4 border border-gray-300 rounded-[20px] bg-white shadow-lg flex flex-col flex-1 overflow-hidden h-full">

                    <div class="flex flex-col flex-shrink-0">
                        <div class="flex justify-between items-start mb-2">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $selectedPengembalian['kode_pengembalian'] }}</h2>
                            <div class="text-right text-xs font-medium text-gray-600">
                                <p>ID User: {{ $selectedPengembalian['peminjaman']['peminjam']['id'] }}</p>
                                <p>Waktu pengembalian: {{ $selectedPengembalian['tanggal_pengembalian'] ? \Carbon\Carbon::parse($selectedPengembalian['tanggal_pengembalian'])->format('H:i | d - m - Y') : '-' }}</p>
                            </div>
                        </div>
                        <hr class="border-t border-gray-500 -mx-4 mb-2">
                    </div>

                    <div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col pr-2 min-h-0">
                        <div class="flex flex-col gap-5 mb-8">
                            <h3 class="font-bold text-gray-800 text-lg">Daftar alat dan barang yang dikembalikan:</h3>

                            @foreach($selectedPengembalian['detail_pengembalian'] as $index => $detail)
                            <div class="flex flex-col gap-3">
                                <div class="flex justify-between items-center w-full gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-14 rounded-xl border border-gray-300 bg-gray-50 flex-shrink-0 overflow-hidden">
                                            <img src="{{ asset('storage/' . ($detail['detail_peminjaman']['alat']['gambar'] ?? '')) }}" 
                                                 alt="" 
                                                 class="w-full h-full object-cover"
                                                 onerror="this.src='{{ asset('images/id1.jpg') }}'">
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-900 text-base">
                                                {{ $detail['detail_peminjaman']['alat']['nama_alat'] }} 
                                                <span class="font-normal text-sm text-gray-600">x{{ $detail['jumlah_kembali'] }}</span>
                                            </span>
                                            <span class="text-xs font-medium text-gray-500">Jumlah Stok: {{ $detail['detail_peminjaman']['alat']['stok'] }}</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <div class="flex flex-col items-end gap-1">
                                            <span class="text-xs font-bold text-gray-500">Kategori: {{ $detail['detail_peminjaman']['alat']['kategori']['nama_kategori'] ?? 'Unknown' }}</span>
                                            <div class="flex items-center gap-1.5 font-bold text-gray-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#363062]" viewBox="0 0 48 48"><g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"><path d="M24 44a19.94 19.94 0 0 0 14.142-5.858A19.94 19.94 0 0 0 44 24a19.94 19.94 0 0 0-5.858-14.142A19.94 19.94 0 0 0 24 4A19.94 19.94 0 0 0 9.858 9.858A19.94 19.94 0 0 0 4 24a19.94 19.94 0 0 0 5.858 14.142A19.94 19.94 0 0 0 24 44Z"/><path stroke-linecap="round" d="m16 24l6 6l12-12"/></g></svg>
                                                <span class="text-base">{{ $selectedPengembalian['peminjaman']['durasi'] }} Menit</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mt-2">
                                    <input type="hidden" name="items[{{ $index }}][detail_pengembalian_id]" value="{{ $detail['id'] }}">
                                    
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Kondisi Barang</label>
                                        <select name="items[{{ $index }}][kondisi]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#363062]">
                                            <option value="lolos" {{ $detail['kondisi'] == 'lolos' ? 'selected' : '' }}>Lolos (Layak)</option>
                                            <option value="rusak" {{ $detail['kondisi'] == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Catatan Kondisi</label>
                                        <input type="text" name="items[{{ $index }}][catatan_kondisi]" value="{{ $detail['catatan_kondisi'] }}" placeholder="Optional..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#363062]">
                                    </div>
                                </div>
                                
                                @if(!$loop->last)
                                <hr class="border-t border-gray-200 my-2">
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex-shrink-0 -mx-4 px-4 mt-4 pt-4 border-t border-gray-500">
                        <button type="submit" class="w-full py-3 border-2 border-transparent bg-[#363062] text-white rounded-full font-bold hover:bg-[#4D4C7D] transition-colors shadow-md">
                            Selesaikan Peminjaman
                        </button>
                    </div>

                </div>
            </form>
            @else
            <div class="p-4 border border-gray-300 rounded-[20px] bg-white shadow-lg flex flex-col items-center justify-center h-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <p class="text-gray-500 text-center">Pilih pengembalian dari daftar di samping untuk melihat detail</p>
            </div>
            @endif

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('clock').innerHTML = `${hours} : ${minutes} : <span class="text-[#F99417]">${seconds}</span>`;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endpush