@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4 flex flex-col overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-stretch flex-1 min-h-0 mb-6 h-screen">

        <div class="lg:col-span-3 flex flex-col gap-1 mb-2">
            <h1 class="text-4xl font-bold">Manajemen Peminjaman</h1>
            <p class="text-sm font-medium text-gray-500">
                Kelola antrean persetujuan, pantau alat yang sedang dipinjam, dan periksa log aktivitas secara real-time.
            </p>
        </div>

        {{-- Statistik Cards --}}
        <div class="p-4 border-b-2 border-black rounded-[20px] bg-[#F5F5F5] flex flex-col shadow-lg justify-between gap-2">
            <div class="flex justify-between items-start gap-4">
                <h3 class="font-bold text-2xl">Menunggu Persetujuan</h3>
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

            <span class="text-5xl font-bold">{{ $totalDipinjamHariIni }}</span>
            <p class="text-xs font-medium text-gray-500">Item dalam peminjaman</p>
        </div>

        <div class="p-4 rounded-[20px] bg-gradient-to-r from-[#363062] to-[#4D4C7D] flex flex-col items-center justify-center gap-2 shadow-lg">
            <h3 class="font-bold text-xs tracking-widest uppercase text-white">Time<span class="text-[#F99417]">stamp</span></h3>
            <span class="text-5xl font-bold text-white tracking-wider font-mono" id="clock">-- : -- : --</span>
        </div>

        {{-- Kolom Kiri: List Peminjam --}}
        <div class="lg:col-span-1 flex flex-col min-h-0 gap-4 h-full">

            <form method="GET" action="{{ route('petugas-peminjaman') }}" class="relative w-full h-[52px] flex-shrink-0">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
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
                    <h2 class="text-2xl font-bold text-gray-900">Antrean peminjaman</h2>
                    <hr class="border-t border-gray-500 -mx-4">
                </div>

                <div class="flex-1 overflow-y-auto flex flex-col gap-4 custom-scrollbar min-h-0">
					@forelse($menungguList as $item)
					<a href="{{ route('petugas-peminjaman', ['peminjaman_id' => $item['id'], 'search' => request('search')]) }}" 
					class="flex items-center gap-3 w-full group">
						<div class="w-12 h-12 rounded-full border border-gray-300 flex-shrink-0 bg-gray-100 shadow-sm overflow-hidden">
							<img src="{{ asset('storage/' . ($item['peminjam']['foto'] ?? '')) }}" 
								alt="" 
								class="w-full h-full object-cover"
								onerror="this.src='{{ asset('images/default-avatar.png') }}'">
						</div>
						<div class="transition-all duration-300 flex-1 flex justify-between items-center rounded-full px-4 py-3 border 
							{{ $selectedPeminjamanId == $item['id'] 
								? 'bg-[#363062] text-white border-transparent' 
								: 'bg-transparent text-[#363062] border-[#363062]' 
							}} 
							group-hover:bg-[#363062] group-hover:text-white group-hover:border-transparent">
							<span class="transition-colors duration-300 font-bold text-sm">
								{{ $item['peminjam']['nama_lengkap'] }}
							</span>
							
							<span class="transition-colors duration-300 text-[10px] font-bold">
								#{{ $item['kode_peminjaman'] }}
							</span>
						</div>
					</a>
					@empty
					<div class="text-center text-gray-500 py-8">
						Tidak ada antrean peminjaman
					</div>
					@endforelse
				</div>
            </div>
        </div>

        {{-- Kolom Kanan: Detail Peminjaman --}}
        <div class="lg:col-span-2 flex flex-col min-h-0 gap-4 h-full">

            <div class="flex items-center gap-4 h-[52px] flex-shrink-0">
				<span class="font-bold text-3xl">Detail peminjaman</span>
            </div>

            @if($selectedPeminjaman)
			<div class="p-4 border border-gray-300 rounded-[20px] bg-white shadow-lg flex flex-col flex-1 overflow-hidden h-full">
				<div class="flex flex-col flex-shrink-0">
					<div class="flex justify-between items-start mb-2">
						<h2 class="text-2xl font-bold text-gray-900">{{ $selectedPeminjaman['kode_peminjaman'] }}</h2>
						<div class="text-right text-xs font-medium text-gray-600">
							<p>ID User: {{ $selectedPeminjaman['peminjam']['id'] }}</p>
							<p>Tanggal Pengajuan: {{ $selectedPeminjaman['tanggal_pengajuan'] ? \Carbon\Carbon::parse($selectedPeminjaman['tanggal_pengajuan'])->format('d - m - Y') : '-' }}</p>
						</div>
					</div>
					<hr class="border-t border-gray-500 -mx-4 mb-2">
				</div>

				<div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col pr-2 min-h-0">
					<div class="flex flex-col gap-5 mb-8">
						<h3 class="font-bold text-gray-800 text-lg">Daftar alat dan barang peminjaman:</h3>

						@foreach($selectedPeminjaman['detail_peminjaman'] as $detail)
						<div class="flex justify-between items-center w-full">
							<div class="flex items-center gap-4">
								<div class="w-14 h-14 rounded-xl border border-gray-300 bg-gray-50 flex-shrink-0 overflow-hidden">
									<img src="{{ asset('storage/' . ($detail['alat']['gambar'] ?? '')) }}" 
										alt="" 
										class="w-full h-full object-cover"
										onerror="this.src='{{ asset('images/id1.jpg') }}'">
								</div>
								<div class="flex flex-col">
									<span class="font-bold text-gray-900 text-base">
										{{ $detail['alat']['nama_alat'] }} 
										<span class="font-normal text-sm text-gray-600">x{{ $detail['jumlah'] }}</span>
									</span>
									<div class="flex gap-2 items-center">
										<span class="text-xs font-medium text-gray-500">Jumlah stok: </span>
										<div class="flex items-center gap-2 px-3 py-1 bg-[#F99417]/50 text-white rounded-full shadow-sm">

											@php
												$stokSetelah = $detail['alat']['stok'] - $detail['jumlah'];
											@endphp
											<span class="text-[10px] font-bold whitespace-nowrap">{{ $detail['alat']['stok']}} Tersisa</span>
											<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 flex-shrink-0" viewBox="0 0 24 24">
												<g fill="none">
													<path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/>
													<path fill="currentColor" d="m14.707 5.636l5.657 5.657a1 1 0 0 1 0 1.414l-5.657 5.657a1 1 0 0 1-1.414-1.414l3.95-3.95H4a1 1 0 1 1 0-2h13.243l-3.95-3.95a1 1 0 1 1 1.414-1.414"/>
												</g>
											</svg>
											<span class="text-[10px] font-bold text-red-700 whitespace-nowrap">{{ $stokSetelah >= 0 ? $stokSetelah : 0 }} Tersisa</span>
										</div>
									</div>
								</div>
							</div>
							<div class="flex flex-col items-end gap-1">
								<span class="text-xs font-bold text-gray-500">Kategori: {{ $detail['alat']['kategori']['nama_kategori'] ?? 'Unknown' }}</span>
								<div class="flex items-center gap-1.5 font-bold text-gray-800">
									<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
									<span class="text-base">{{ $selectedPeminjaman['durasi'] }} Menit</span>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>

				<div class="flex-shrink-0 -mx-4 px-4 mt-4 pt-4 border-t border-gray-500 flex gap-4">
					<form action="{{ route('petugas-peminjaman-tolak', $selectedPeminjaman['kode_peminjaman']) }}" method="POST" class="flex-1">
						@csrf
						@method('PUT')
						<button type="submit" class="w-full py-3 border-2 border-gray-800 rounded-full font-bold text-gray-800 bg-white hover:bg-gray-100 transition-colors">
							Batalkan Peminjaman
						</button>
					</form>
					<form action="{{ route('petugas-peminjaman-update', $selectedPeminjaman['kode_peminjaman']) }}" method="POST" class="flex-1">
						@csrf
						@method('PUT')
						<button type="submit" class="w-full py-3 border-2 border-transparent bg-[#363062] text-white rounded-full font-bold hover:bg-[#4D4C7D] transition-colors shadow-md">
							Setujui Peminjaman
						</button>
					</form>
				</div>
			</div>
			@else
			<div class="p-4 border border-gray-300 rounded-[20px] bg-white shadow-lg flex flex-col items-center justify-center h-full">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
					<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
					<circle cx="12" cy="7" r="4"></circle>
				</svg>
				<p class="text-gray-500 text-center">Pilih peminjam dari daftar di samping untuk melihat detail peminjaman</p>
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