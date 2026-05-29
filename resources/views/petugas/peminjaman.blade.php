@extends('layouts.app')

@section('content')
	<div class="mx-auto pt-20 pb-8 lg:py-8 px-4">

		{{-- Page Header --}}
		<div class="flex flex-col mb-6">
			<h1 class="text-2xl sm:text-4xl font-bold">Manajemen Peminjaman</h1>
			<p class="text-gray-500">Kelola antrean persetujuan, pantau alat yang sedang dipinjam, dan periksa log aktivitas
				secara real-time.</p>
		</div>

		{{-- Statistik Cards --}}
		<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
			<div
				class="p-4 border-b-2 border-black rounded-[20px] bg-[#F5F5F5] flex flex-col shadow-lg justify-between gap-2">
				<div class="flex justify-between items-start gap-4">
					<h3 class="font-bold text-lg sm:text-2xl">Menunggu Persetujuan</h3>
					<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-7 sm:h-7 text-[#F99417] flex-shrink-0"
						viewBox="0 0 24 24">
						<g fill="currentColor">
							<path
								d="M12 4a8 8 0 1 0 0 16a8 8 0 0 0 0-16M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12" />
							<path
								d="M12 14a1 1 0 0 1-1-1V7a1 1 0 1 1 2 0v6a1 1 0 0 1-1 1m-1.5 2.5a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0" />
						</g>
					</svg>
				</div>
				<span class="text-4xl sm:text-5xl font-bold">{{ $totalMenunggu }}</span>
				<p class="text-xs font-medium text-gray-500">Pengajuan baru yang perlu di-review</p>
			</div>

			<div
				class="p-4 border-b-2 border-black rounded-[20px] bg-[#F5F5F5] flex flex-col justify-between shadow-lg gap-2">
				<h3 class="font-bold text-lg sm:text-2xl">Total Alat Dipinjam</h3>
				<span class="text-4xl sm:text-5xl font-bold">{{ $totalDipinjamHariIni }}</span>
				<p class="text-xs font-medium text-gray-500">Item dalam peminjaman</p>
			</div>

			<div
				class="p-4 rounded-[20px] bg-gradient-to-r from-[#363062] to-[#4D4C7D] flex flex-col items-center justify-center gap-2 shadow-lg">
				<h3 class="font-bold text-xs tracking-widest uppercase text-white">Time<span
						class="text-[#F99417]">stamp</span></h3>
				<span class="text-3xl sm:text-5xl font-bold text-white tracking-wider font-mono" id="clock">-- : -- : --</span>
			</div>
		</div>

		{{-- Main Content: List + Detail --}}
		<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:h-[calc(100vh-22rem)]">

			{{-- Kolom Kiri: List Peminjam --}}
			<div class="lg:col-span-1 flex flex-col min-h-0 gap-4 h-[40vh] lg:h-full">

				<form method="GET" action="{{ route('petugas-peminjaman') }}"
					class="relative w-full h-[52px] flex-shrink-0">
					<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24">
							<path fill="currentColor"
								d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6" />
						</svg>
					</div>
					<input type="text" name="search" value="{{ request('search') }}" placeholder="Cari peminjam..."
						class="w-full h-full pl-10 pr-4 py-3 border bg-white border-gray-500 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow"
						onchange="this.form.submit()">
				</form>

				<div
					class="p-4 rounded-[20px] bg-white shadow-lg border border-gray-300 flex flex-col gap-4 flex-1 min-h-0">
					<div class="flex flex-col gap-2 mb-0 flex-shrink-0">
						<h2 class="text-lg sm:text-2xl font-bold text-gray-900">Antrean peminjaman</h2>
						<hr class="border-t border-gray-500 -mx-4">
					</div>

					<div class="flex-1 overflow-y-auto flex flex-col gap-4 custom-scrollbar min-h-0">
						@forelse($menungguList as $item)
										<a href="{{ route('petugas-peminjaman', ['peminjaman_id' => $item['id'], 'search' => request('search')]) }}"
											class="flex items-center gap-3 w-full group">
											<div
												class="w-12 h-12 rounded-full border border-gray-300 flex-shrink-0 bg-gray-100 shadow-sm overflow-hidden">
												<img src="{{ asset('storage/' . ($item['peminjam']['foto'] ?? '')) }}" alt=""
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
													<span class="md:hidden">
														{{ Str::limit($item['peminjam']['nama_lengkap'], 5, '...') }}
													</span>

													<span class="hidden md:inline">
														{{ $item['peminjam']['nama_lengkap'] }}
													</span>
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
			<div class="lg:col-span-2 flex flex-col min-h-0 gap-4 h-[70vh] lg:h-full">

				<div class="flex items-center gap-4 h-[52px] flex-shrink-0">
					<h2 class="font-bold text-lg sm:text-2xl">Detail peminjaman</h2>
				</div>

				@if($selectedPeminjaman)
					<div
						class="p-4 border border-gray-300 rounded-[20px] bg-white shadow-lg flex flex-col flex-1 overflow-hidden min-h-0">
						<div class="flex flex-col flex-shrink-0">
							<div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1 mb-2">
								<h2 class="text-xl font-bold text-gray-900">{{ $selectedPeminjaman['kode_peminjaman'] }}</h2>
								<div class="text-left sm:text-right text-xs font-medium text-gray-600">
									<p>ID User: {{ $selectedPeminjaman['peminjam']['id'] }} |
										{{ $selectedPeminjaman['peminjam']['nama_lengkap'] }}</p>
									<p>Tanggal Pengajuan:
										{{ $selectedPeminjaman['tanggal_pengajuan'] ? \Carbon\Carbon::parse($selectedPeminjaman['tanggal_pengajuan'])->format('d - m - Y') : '-' }}
									</p>
								</div>
							</div>
							<hr class="border-t border-gray-500 -mx-4 mb-2">
						</div>

						<div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col pr-1 min-h-0">
							<div class="flex flex-col gap-4 mb-4">
								<p class="font-bold text-gray-800 text-sm">Daftar alat dan barang peminjaman:</p>

								@foreach($selectedPeminjaman['detail_peminjaman'] as $detail)
									<div class="flex items-center gap-3 w-full">
										{{-- Gambar alat --}}
										<div
											class="w-11 h-11 rounded-xl border border-gray-300 bg-gray-50 flex-shrink-0 overflow-hidden">
											<img src="{{ asset('storage/' . ($detail['alat']['gambar'] ?? '')) }}" alt=""
												class="w-full h-full object-cover"
												onerror="this.src='{{ asset('images/id1.jpg') }}'">
										</div>

										{{-- Info alat --}}
										<div class="flex flex-col flex-1 min-w-0">
											<span class="font-bold text-gray-900 text-sm truncate">
												{{ $detail['alat']['nama_alat'] }}
												<span class="font-normal text-xs text-gray-600">x{{ $detail['jumlah'] }}</span>
											</span>
											<div class="flex items-center gap-1.5 mt-0.5">
												<span class="text-xs font-medium text-gray-500">Stok:</span>
												<span class="text-xs font-medium text-gray-500">{{ $detail['alat']['stok'] }}</span>
											</div>
										</div>

										{{-- Kategori & Durasi --}}
										<div class="flex flex-col items-end gap-1 flex-shrink-0 text-right">
											<span
												class="text-[10px] font-bold text-gray-500">{{ $detail['alat']['kategori']['nama_kategori'] ?? 'Unknown' }}</span>
											<div class="flex items-center gap-1 font-bold text-gray-800">
												<svg class="w-4 h-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
													viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
														d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
												</svg>
												<span class="text-xs whitespace-nowrap">{{ $selectedPeminjaman['durasi'] }}
													Menit</span>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>

						<div class="flex-shrink-0 -mx-4 px-4 mt-4 pt-4 border-t border-gray-500 flex gap-4">
							<form action="{{ route('petugas-peminjaman-tolak', $selectedPeminjaman['kode_peminjaman']) }}"
								method="POST" class="flex-1">
								@csrf
								@method('PUT')
								<button type="submit"
									class="w-full py-3 border-2 border-gray-800 rounded-full font-bold text-sm text-gray-800 bg-white hover:bg-gray-100 transition-colors">
									Tolak
								</button>
							</form>
							<form action="{{ route('petugas-peminjaman-update', $selectedPeminjaman['kode_peminjaman']) }}"
								method="POST" class="flex-1">
								@csrf
								@method('PUT')
								<button type="submit"
									class="w-full py-3 border-2 border-transparent bg-[#363062] text-white rounded-full font-bold text-sm hover:bg-[#4D4C7D] transition-colors shadow-md">
									Setujui
								</button>
							</form>
						</div>
					</div>
				@else
					<div
						class="p-4 border border-gray-300 rounded-[20px] bg-white shadow-lg flex flex-col items-center justify-center flex-1 min-h-0">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" viewBox="0 0 24 24"
							fill="none" stroke="currentColor" stroke-width="1">
							<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
							<circle cx="12" cy="7" r="4"></circle>
						</svg>
						<p class="text-gray-500 text-center text-sm">Pilih peminjam dari daftar di samping untuk melihat detail
							peminjaman</p>
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