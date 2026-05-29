@extends('layouts.app')

@section('content')
<div class="mx-auto pt-20 pb-8 lg:py-8 px-4">
	<div class="flex flex-col gap-8">

		{{-- HEADER --}}
		<div class="flex flex-col gap-1">
			<h1 class="text-2xl sm:text-4xl font-bold text-gray-900">Manajemen Pengembalian</h1>
			<p class="text-xs sm:text-sm text-gray-500 font-medium">
				Monitor proses pengembalian alat dan barang dari peminjam, lakukan validasi kondisi barang, dan jaga ketersediaan inventaris tetap optimal.
			</p>
		</div>

		{{-- STAT CARDS --}}
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

			{{-- CARD 1 --}}
			<div class="bg-white border border-gray-300 rounded-[20px] p-4 sm:p-6 shadow-lg flex flex-col justify-between gap-2 h-full">
				<div class="flex justify-between items-start gap-4">
					<h3 class="font-bold text-lg sm:text-2xl text-black">Pengembalian menunggu persetujuan</h3>
					<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-7 sm:h-7 text-[#F99417] flex-shrink-0" viewBox="0 0 24 24">
						<g fill="currentColor">
							<path d="M12 4a8 8 0 1 0 0 16a8 8 0 0 0 0-16M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12"/>
							<path d="M12 14a1 1 0 0 1-1-1V7a1 1 0 1 1 2 0v6a1 1 0 0 1-1 1m-1.5 2.5a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0"/>
						</g>
					</svg>
				</div>
				<div class="flex items-end gap-3">
					<span class="text-4xl sm:text-6xl font-bold text-[#363062]">{{ $stats['menunggu_verifikasi'] }}</span>
					<span class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2 font-medium">Pengembali</span>
				</div>
				<div class="flex items-center gap-3">
					<span class="px-2 py-0.5 sm:px-3 sm:py-1 text-white font-bold bg-gradient-to-r from-[#F99417] to-[#F99417]/70 rounded-full text-[10px] sm:text-xs">
						{{ $stats['total_item_menunggu'] }} Alat
					</span>
					<span class="text-[10px] sm:text-xs font-medium text-gray-500">Dalam proses pengembalian</span>
				</div>
			</div>

			{{-- CARD 2 --}}
			<div class="bg-white border border-gray-300 rounded-[20px] p-4 sm:p-6 shadow-lg flex flex-col justify-between gap-2 h-full">
				<h3 class="font-bold text-lg sm:text-2xl text-black">Selesai dikembalikan &amp; verifikasi kondisi alat</h3>
				<div class="flex items-end gap-3">
					<span class="text-4xl sm:text-6xl font-bold text-[#363062]">{{ $stats['selesai'] }}</span>
					<span class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2 font-medium">Data</span>
				</div>
				<div class="flex items-center gap-3">
					<span class="px-3 py-0.5 sm:px-4 sm:py-1 text-white font-bold bg-gradient-to-r from-[#363062] to-[#4D4C7D]/70 rounded-full text-[10px] sm:text-xs whitespace-nowrap shrink-0">
						{{ $stats['total_kategori_selesai'] }} Kategori
					</span>
					<span class="text-[10px] sm:text-xs font-medium text-gray-500">Alat & barang dalam proses pengembalian</span>
				</div>
			</div>
		</div>

		{{-- SECTION MENUNGGU --}}
		<div id="menunggu" class="flex flex-col gap-4">

			<div class="flex items-center justify-between mb-2">
			<h2 class="text-lg sm:text-2xl font-bold">Menunggu Persetujuan</h2>
			<div class="flex items-center gap-2">
				<div class="h-1.5 w-1.5 sm:h-2 sm:w-2 bg-yellow-500 rounded-full"></div>
				<span class="text-xs sm:text-sm text-gray-500">{{ $menunggu->total() }} Pengembalian</span>
			</div>
		</div>

			{{-- TOP BAR MENUNGGU --}}
			<form method="GET" action="{{ route('admin-pengembalian') . '#menunggu' }}">
				<div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center">
					<div class="flex items-center gap-3 flex-wrap">

						{{-- SEARCH --}}
						<div class="relative flex-1 min-w-[180px] sm:w-52 sm:flex-none">
							<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
							</div>
							<input type="text" name="search_menunggu" value="{{ request('search_menunggu') }}"
								placeholder="Cari peminjam..." onchange="this.form.submit()"
								class="w-full h-11 pl-10 pr-4 py-2 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
						</div>

						{{-- HIDDEN FIELDS --}}
						<input type="hidden" name="search_selesai" value="">
						<input type="hidden" name="durasi_selesai" value="">
						<input type="hidden" name="kondisi_selesai" value="">

						{{-- FILTER DROPDOWN --}}
						<div x-data="{ open: false }" class="relative inline-block text-left">
							<button type="button" @click="open = !open" class="flex-shrink-0 w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/></svg>
							</button>
							<div x-show="open" @click.outside="open = false" style="display:none" x-transition.opacity
								class="max-h-[250px] absolute left-0 z-20 mt-2 w-56 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 overflow-y-auto border border-gray-100">
								<div class="py-2">
									<p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Durasi</p>
									<label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
										<input type="radio" name="durasi_menunggu" value="" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_menunggu') == '' ? 'checked' : '' }}>
										Semua Durasi
									</label>
									@foreach($durasiList as $durasi)
									<label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
										<input type="radio" name="durasi_menunggu" value="{{ $durasi }}" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_menunggu') == $durasi ? 'checked' : '' }}>
										{{ $durasi }} Menit
									</label>
									@endforeach
								</div>
							</div>
						</div>

						{{-- RESET --}}
						@if(request('search_menunggu') || request('durasi_menunggu'))
						<a href="{{ route('admin-pengembalian') . '#menunggu' }}" class="px-4 py-2.5 text-xs sm:text-sm text-[#363062]/90 hover:text-[#363062] border border-[#363062] rounded-full transition font-semibold">
							Reset Filter
						</a>
						@endif
					</div>

					<div class="flex">
						<a href="{{ route('admin-pengembalian-create') }}" class="w-full sm:w-auto px-4 py-2.5 flex items-center justify-center gap-2 border border-transparent text-white font-semibold rounded-full text-sm bg-[#363062] group hover:bg-transparent hover:text-[#363062] hover:border-[#363062] transition-all">
							Tambahkan data
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white group-hover:text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2"/></svg>
						</a>
					</div>
				</div>
			</form>

			{{-- CARDS MENUNGGU --}}
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
				@forelse ($menunggu as $pengembalian)
				<div class="bg-white border border-gray-300 rounded-[20px] p-4 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col gap-3">

					{{-- HEADER CARD --}}
					<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
						<div class="flex items-center gap-3 flex-wrap">
							<h3 class="text-xl sm:text-2xl font-bold text-[#363062] leading-none">
								#{{ $pengembalian->kode_pengembalian }}
							</h3>
							<span class="px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold shrink-0 {{ $pengembalian->status_badge }}">
								{{ $pengembalian->status_label }}
							</span>
						</div>
						<div class="flex items-center gap-2">
							<div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden border border-gray-200">
								<img src="{{ $pengembalian->peminjaman->peminjam->foto_url }}" class="w-full h-full object-cover" alt="">
							</div>
							<div class="text-xs sm:text-sm">
								<p class="font-bold text-gray-900 leading-tight">{{ $pengembalian->peminjaman->peminjam->nama_lengkap }}</p>
								<p class="text-[10px] sm:text-xs text-gray-500 font-medium">{{ $pengembalian->detailPengembalian->count() }} Item</p>
							</div>
						</div>
					</div>

					<hr class="border-gray-500 opacity-30">

					{{-- BODY --}}
					<div class="flex flex-col gap-3">
						<div class="flex justify-between items-start text-[10px] sm:text-xs text-gray-500 font-medium">
							<p class="text-gray-900 text-xs sm:text-sm">Daftar alat / barang:</p>
							<div class="flex flex-col text-right gap-0.5">
								<p class="whitespace-nowrap">Waktu peminjaman: <span class="text-[#363062] font-bold">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_disetujui)->format('H:i | d-m-Y') }}</span></p>
								<p class="whitespace-nowrap">Pengajuan kembali: <span class="text-[#363062] font-bold">{{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('H:i | d-m-Y') }}</span></p>
							</div>
						</div>

						<div class="flex flex-col gap-3 max-h-40 overflow-y-auto pr-1">
							@foreach ($pengembalian->detailPengembalian as $detail)
							<div class="flex items-center justify-between gap-3">
								<div class="flex items-center gap-3 flex-1 min-w-0">
									<div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl border flex items-center justify-center overflow-hidden bg-gray-50 flex-shrink-0">
										<img src="{{ asset('storage/' . $detail->detailPeminjaman->alat->gambar) }}" alt="img" class="w-full h-full object-cover">
									</div>
									<div class="flex-1 min-w-0">
										<p class="text-xs sm:text-sm font-bold text-gray-900 truncate">
											{{ $detail->detailPeminjaman->alat->nama_alat }}
											<span class="text-[10px] sm:text-xs font-medium text-gray-500">×{{ $detail->jumlah_kembali }}</span>
										</p>
										<div class="flex items-center gap-1 mt-0.5">
											<div class="h-1.5 w-1.5 rounded-full flex-shrink-0" style="background: {{ $detail->detailPeminjaman->alat->kategori->warna }}"></div>
											<p class="text-[10px] sm:text-xs text-gray-500 font-medium truncate">{{ $detail->detailPeminjaman->alat->kategori->nama_kategori }}</p>
										</div>
									</div>
								</div>
								<div class="text-right text-[10px] sm:text-xs text-gray-500 whitespace-nowrap flex-shrink-0">
									<p class="font-medium">Durasi Peminjaman</p>
									<div class="flex items-center justify-end gap-1 text-gray-900 font-bold">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/><path d="M12 7v5l3 3"/></g></svg>
										<span>{{ $detail->detailPeminjaman->alat->durasi }} Menit</span>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>

					{{-- ACTION --}}
					<div class="flex justify-end gap-2 mt-2 pt-3 border-t border-gray-100">
						<a href="{{ route('admin-pengembalian-edit', $pengembalian) }}"
							class="px-4 py-1.5 sm:px-5 sm:py-2 border border-transparent rounded-full bg-[#F99417] text-white text-xs sm:text-sm font-bold hover:bg-white hover:text-[#F99417] hover:border-[#F99417] transition-all shadow-sm">
							Edit
						</a>
						<form action="{{ route('admin-pengembalian-destroy', $pengembalian) }}" method="POST"
							onsubmit="return confirm('Yakin ingin menghapus data pengembalian ini?')">
							@csrf
							@method('DELETE')
							<button type="submit"
								class="px-4 py-1.5 sm:px-5 sm:py-2 border border-transparent rounded-full text-xs sm:text-sm font-bold bg-red-500 text-white hover:bg-white hover:text-red-500 hover:border-red-500 transition-all shadow-sm">
								Hapus
							</button>
						</form>
					</div>

				</div>
				@empty
				<div class="sm:col-span-2 flex flex-col gap-3 items-center justify-center bg-white border border-gray-300 rounded-[20px] p-6 text-gray-500 font-medium text-center">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 sm:h-14 sm:w-14 text-gray-300" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0z" fill="none"/>
						<path fill="currentColor" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34M15 14H9l-.117.007a1 1 0 0 0 0 1.986L9 16h6l.117-.007a1 1 0 0 0 0-1.986zM9.01 9l-.127.007a1 1 0 0 0 0 1.986L9 11l.127-.007a1 1 0 0 0 0-1.986zm6 0l-.127.007a1 1 0 0 0 0 1.986L15 11l.127-.007a1 1 0 0 0 0-1.986z"/>
					</svg>
					<p>Tidak ada data pengembalian menunggu.</p>
				</div>
				@endforelse
			</div>

			{{-- PAGINATION MENUNGGU --}}
			@if($menunggu->hasPages())
			<div class="mt-4">
				<div class="flex flex-col sm:flex-row items-center justify-between gap-4">
					<div class="text-sm text-gray-500 order-2 sm:order-1">
						Menampilkan {{ $menunggu->firstItem() ?? 0 }} - {{ $menunggu->lastItem() ?? 0 }} dari {{ $menunggu->total() }} data
					</div>
					<div class="flex items-center gap-2 order-1 sm:order-2">
						@if($menunggu->onFirstPage())
						<button type="button" disabled class="p-2.5 sm:p-3 rounded-full border text-xs flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24"><defs><path id="pg_men_prev" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs><use fill-rule="evenodd" href="#pg_men_prev" transform="rotate(-180 5.02 9.505)"/></svg>
						</button>
						@else
						<a href="{{ $menunggu->appends(request()->query())->previousPageUrl() . '#menunggu' }}" class="p-2.5 sm:p-3 rounded-full border bg-white text-xs flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24"><defs><path id="pg_men_prev" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs><use fill-rule="evenodd" href="#pg_men_prev" transform="rotate(-180 5.02 9.505)"/></svg>
						</a>
						@endif
						<div class="flex items-center gap-1 bg-gray-100 p-1 sm:p-1.5 rounded-full shadow-inner">
							@php
								$cm = $menunggu->currentPage(); $lm = $menunggu->lastPage();
								$sm = max(1, $cm - 1); $em = min($lm, $cm + 1);
								if ($sm > 1) {
									$cls = (1 == $cm) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
									echo '<a href="' . $menunggu->appends(request()->query())->url(1) . '#menunggu" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $cls . '">1</a>';
									if ($sm > 2) echo '<span class="px-0.5 text-gray-400 text-[10px]">...</span>';
								}
								for ($i = $sm; $i <= $em; $i++) {
									$cls = ($i == $cm) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
									echo '<a href="' . $menunggu->appends(request()->query())->url($i) . '#menunggu" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $cls . '">' . $i . '</a>';
								}
								if ($em < $lm) {
									if ($em < $lm - 1) echo '<span class="px-0.5 text-gray-400 text-[10px]">...</span>';
									$cls = ($lm == $cm) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
									echo '<a href="' . $menunggu->appends(request()->query())->url($lm) . '#menunggu" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $cls . '">' . $lm . '</a>';
								}
							@endphp
						</div>
						@if($menunggu->hasMorePages())
						<a href="{{ $menunggu->appends(request()->query())->nextPageUrl() . '#menunggu' }}" class="p-2.5 sm:p-3 rounded-full border bg-white text-xs flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24"><defs><path id="pg_men_next" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs><use fill-rule="evenodd" href="#pg_men_next" transform="rotate(-180 5.02 9.505)"/></svg>
						</a>
						@else
						<button type="button" disabled class="p-2.5 sm:p-3 rounded-full border text-xs flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24"><defs><path id="pg_men_next" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs><use fill-rule="evenodd" href="#pg_men_next" transform="rotate(-180 5.02 9.505)"/></svg>
						</button>
						@endif
					</div>
				</div>
			</div>
			@endif

		</div>{{-- end section menunggu --}}

		{{-- SECTION SELESAI --}}
		<div id="selesai" class="flex flex-col gap-4 pt-8 border-t border-gray-300">

			<div class="flex items-center justify-between mb-2">
			<h2 class="text-lg sm:text-2xl font-bold">Selesai Dikembalikan</h2>
			<div class="flex items-center gap-2">
				<div class="h-1.5 w-1.5 sm:h-2 sm:w-2 bg-green-500 rounded-full"></div>
				<span class="text-xs sm:text-sm text-gray-500">{{ $selesai->total() }} Pengembalian</span>
			</div>
		</div>

			{{-- TOP BAR SELESAI --}}
			<form method="GET" action="{{ route('admin-pengembalian') . '#selesai' }}">
				<div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center">
					<div class="flex items-center gap-3 flex-wrap">

						{{-- SEARCH --}}
						<div class="relative flex-1 min-w-[180px] sm:w-52 sm:flex-none">
							<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
							</div>
							<input type="text" name="search_selesai" value="{{ request('search_selesai') }}"
								placeholder="Cari peminjam..." onchange="this.form.submit()"
								class="w-full h-11 pl-10 pr-4 py-2 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
						</div>

						{{-- HIDDEN FIELDS --}}
						<input type="hidden" name="search_menunggu" value="">
						<input type="hidden" name="durasi_menunggu" value="">

						{{-- FILTER DROPDOWN --}}
						<div x-data="{ open: false }" class="relative inline-block text-left">
							<button type="button" @click="open = !open" class="flex-shrink-0 w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/></svg>
							</button>
							<div x-show="open" @click.outside="open = false" style="display:none" x-transition.opacity
								class="max-h-[300px] absolute left-0 z-20 mt-2 w-64 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 overflow-y-auto border border-gray-100">
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
										<input type="radio" name="durasi_selesai" value="{{ $durasi }}" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_selesai') == $durasi ? 'checked' : '' }}>
										{{ $durasi }} Menit
									</label>
									@endforeach
								</div>
							</div>
						</div>

						{{-- RESET --}}
						@if(request('search_selesai') || request('durasi_selesai') || request('kondisi_selesai'))
						<a href="{{ route('admin-pengembalian') . '#selesai' }}" class="px-4 py-2.5 text-xs sm:text-sm text-[#363062]/90 hover:text-[#363062] border border-[#363062] rounded-full transition font-semibold">
							Reset Filter
						</a>
						@endif
					</div>

					<div class="flex">
						<a href="{{ route('admin-pengembalian-create') }}" class="w-full sm:w-auto px-4 py-2.5 flex items-center justify-center gap-2 border border-transparent text-white font-semibold rounded-full text-sm bg-[#363062] group hover:bg-transparent hover:text-[#363062] hover:border-[#363062] transition-all">
							Tambahkan data
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white group-hover:text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2"/></svg>
						</a>
					</div>
				</div>
			</form>

			{{-- CARDS SELESAI --}}
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
				@forelse ($selesai as $pengembalian)
				<div class="bg-white border border-gray-300 rounded-[20px] p-4 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col gap-3">

					{{-- HEADER CARD --}}
					<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
						<div class="flex items-center gap-3 flex-wrap">
							<h3 class="text-xl sm:text-2xl font-bold text-[#363062] leading-none">
								#{{ $pengembalian->kode_pengembalian }}
							</h3>
							<span class="px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold shrink-0 {{ $pengembalian->status_badge }}">
								{{ $pengembalian->status_label }}
							</span>
						</div>
						<div class="flex items-center gap-2">
							<div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden border border-gray-200">
								<img src="{{ $pengembalian->peminjaman->peminjam->foto_url }}" class="w-full h-full object-cover" alt="">
							</div>
							<div class="text-xs sm:text-sm">
								<p class="font-bold text-gray-900 leading-tight">{{ $pengembalian->peminjaman->peminjam->nama_lengkap }}</p>
								<p class="text-[10px] sm:text-xs text-gray-500 font-medium">{{ $pengembalian->detailPengembalian->count() }} Item</p>
							</div>
						</div>
					</div>

					<hr class="border-gray-200 opacity-50">

					{{-- DATES --}}
					<div class="flex justify-between items-start text-[10px] sm:text-xs text-gray-600 bg-gray-50 p-2 sm:p-3 rounded-xl border border-gray-100 font-medium">
						<div class="flex flex-col gap-1">
							<p>Waktu peminjaman:</p>
							<span class="text-[#363062] font-bold">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_disetujui)->format('H:i | d-m-Y') }}</span>
						</div>
						<div class="flex flex-col gap-1 text-right">
							<p>Waktu dikembalikan:</p>
							<span class="text-green-600 font-bold">{{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('H:i | d-m-Y') }}</span>
						</div>
					</div>

					{{-- LIST ITEM --}}
					<div class="flex flex-col gap-3 max-h-40 overflow-y-auto pr-1">
						@foreach ($pengembalian->detailPengembalian as $detail)
						<div class="flex flex-col gap-2">
							<div class="flex items-center justify-between gap-3">
								<div class="flex items-center gap-3 flex-1 min-w-0">
									<div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg border flex items-center justify-center overflow-hidden bg-gray-50 flex-shrink-0">
										<img src="{{ asset('storage/' . $detail->detailPeminjaman->alat->gambar) }}" alt="img" class="w-full h-full object-cover">
									</div>
									<div class="flex-1 min-w-0">
										<p class="text-xs sm:text-sm text-gray-900 font-bold truncate">
											{{ $detail->detailPeminjaman->alat->nama_alat }}
											<span class="text-[10px] sm:text-xs text-gray-500 font-medium">×{{ $detail->jumlah_kembali }}</span>
										</p>
										<div class="flex items-center gap-1 mt-0.5">
											<div class="h-1.5 w-1.5 rounded-full flex-shrink-0" style="background: {{ $detail->detailPeminjaman->alat->kategori->warna }}"></div>
											<p class="text-[10px] sm:text-xs text-gray-500 font-medium truncate">{{ $detail->detailPeminjaman->alat->kategori->nama_kategori }}</p>
										</div>
									</div>
								</div>
								<div class="text-right text-[10px] sm:text-xs text-gray-500 font-bold whitespace-nowrap">
									<p>{{ $detail->detailPeminjaman->alat->durasi }} Menit</p>
								</div>
							</div>

							{{-- KONDISI & CATATAN --}}
							<div class="flex items-center gap-2">
								<span class="px-2 py-1 rounded-lg text-[10px] sm:text-xs font-bold {{ $detail->kondisi_badge }}">
									{{ $detail->kondisi_label }}
								</span>
								@if($detail->catatan_kondisi)
								<div class="flex-1 px-3 py-1 bg-gray-50 border border-gray-200 rounded-lg text-[10px] sm:text-xs text-gray-500 truncate">
									<span class="font-medium">Catatan: </span>{{ $detail->catatan_kondisi }}
								</div>
								@endif
							</div>
						</div>
						@endforeach
					</div>

					{{-- ACTION --}}
					<div class="flex justify-end gap-2 mt-2 pt-3 border-t border-gray-100">
						<a href="{{ route('admin-pengembalian-edit', $pengembalian) }}"
							class="px-4 py-1.5 sm:px-5 sm:py-2 border border-transparent rounded-full bg-[#F99417] text-white text-xs sm:text-sm font-bold hover:bg-white hover:text-[#F99417] hover:border-[#F99417] transition-all shadow-sm">
							Edit
						</a>
						<form action="{{ route('admin-pengembalian-destroy', $pengembalian) }}" method="POST"
							onsubmit="return confirm('Yakin ingin menghapus data pengembalian ini?')">
							@csrf
							@method('DELETE')
							<button type="submit"
								class="px-4 py-1.5 sm:px-5 sm:py-2 border border-transparent rounded-full text-xs sm:text-sm font-bold bg-red-500 text-white hover:bg-white hover:text-red-500 hover:border-red-500 transition-all shadow-sm">
								Hapus
							</button>
						</form>
					</div>

				</div>
				@empty
				<div class="sm:col-span-2 flex flex-col gap-3 items-center justify-center bg-white border border-gray-300 rounded-[20px] p-6 text-gray-500 font-medium text-center">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 sm:h-14 sm:w-14 text-gray-300" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0z" fill="none"/>
						<path fill="currentColor" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34M15 14H9l-.117.007a1 1 0 0 0 0 1.986L9 16h6l.117-.007a1 1 0 0 0 0-1.986zM9.01 9l-.127.007a1 1 0 0 0 0 1.986L9 11l.127-.007a1 1 0 0 0 0-1.986zm6 0l-.127.007a1 1 0 0 0 0 1.986L15 11l.127-.007a1 1 0 0 0 0-1.986z"/>
					</svg>
					<p>Tidak ada data pengembalian selesai.</p>
				</div>
				@endforelse
			</div>

			{{-- PAGINATION SELESAI --}}
			@if($selesai->hasPages())
			<div class="mt-4">
				<div class="flex flex-col sm:flex-row items-center justify-between gap-4">
					<div class="text-sm text-gray-500 order-2 sm:order-1">
						Menampilkan {{ $selesai->firstItem() ?? 0 }} - {{ $selesai->lastItem() ?? 0 }} dari {{ $selesai->total() }} data
					</div>
					<div class="flex items-center gap-2 order-1 sm:order-2">
						@if($selesai->onFirstPage())
						<button type="button" disabled class="p-2.5 sm:p-3 rounded-full border text-xs flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24"><defs><path id="pg_sel_prev" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs><use fill-rule="evenodd" href="#pg_sel_prev" transform="rotate(-180 5.02 9.505)"/></svg>
						</button>
						@else
						<a href="{{ $selesai->appends(request()->query())->previousPageUrl() . '#selesai' }}" class="p-2.5 sm:p-3 rounded-full border bg-white text-xs flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24"><defs><path id="pg_sel_prev" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs><use fill-rule="evenodd" href="#pg_sel_prev" transform="rotate(-180 5.02 9.505)"/></svg>
						</a>
						@endif
						<div class="flex items-center gap-1 bg-gray-100 p-1 sm:p-1.5 rounded-full shadow-inner">
							@php
								$cs = $selesai->currentPage(); $ls = $selesai->lastPage();
								$ss = max(1, $cs - 1); $es = min($ls, $cs + 1);
								if ($ss > 1) {
									$cls = (1 == $cs) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
									echo '<a href="' . $selesai->appends(request()->query())->url(1) . '#selesai" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $cls . '">1</a>';
									if ($ss > 2) echo '<span class="px-0.5 text-gray-400 text-[10px]">...</span>';
								}
								for ($i = $ss; $i <= $es; $i++) {
									$cls = ($i == $cs) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
									echo '<a href="' . $selesai->appends(request()->query())->url($i) . '#selesai" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $cls . '">' . $i . '</a>';
								}
								if ($es < $ls) {
									if ($es < $ls - 1) echo '<span class="px-0.5 text-gray-400 text-[10px]">...</span>';
									$cls = ($ls == $cs) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
									echo '<a href="' . $selesai->appends(request()->query())->url($ls) . '#selesai" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $cls . '">' . $ls . '</a>';
								}
							@endphp
						</div>
						@if($selesai->hasMorePages())
						<a href="{{ $selesai->appends(request()->query())->nextPageUrl() . '#selesai' }}" class="p-2.5 sm:p-3 rounded-full border bg-white text-xs flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24"><defs><path id="pg_sel_next" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs><use fill-rule="evenodd" href="#pg_sel_next" transform="rotate(-180 5.02 9.505)"/></svg>
						</a>
						@else
						<button type="button" disabled class="p-2.5 sm:p-3 rounded-full border text-xs flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24"><defs><path id="pg_sel_next" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs><use fill-rule="evenodd" href="#pg_sel_next" transform="rotate(-180 5.02 9.505)"/></svg>
						</button>
						@endif
					</div>
				</div>
			</div>
			@endif

		</div>{{-- end section selesai --}}

	</div>{{-- end flex flex-col gap-8 --}}
</div>
@endsection
