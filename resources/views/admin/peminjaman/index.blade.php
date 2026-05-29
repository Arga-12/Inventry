@extends('layouts.app')

@section('content')
	<div class="mx-auto pt-20 pb-8 lg:py-8 px-4">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

			{{-- HEADER --}}
			<div class="lg:col-span-2 flex flex-col gap-1">
				<h1 class="text-2xl sm:text-4xl font-bold text-gray-900">Manajemen Peminjaman</h1>
				<p class="text-xs sm:text-sm text-gray-500 font-medium">
					Kelola seluruh proses peminjaman, pantau status, dan pastikan alur berjalan dengan lancar.
				</p>
			</div>

			{{-- CARD 1 --}}
			<div
				class="bg-white border border-gray-300 rounded-[20px] p-4 sm:p-6 shadow-lg flex flex-col justify-between gap-2 h-full">
				{{-- HEADER --}}
				<div class="flex justify-between items-start gap-4">
					<h3 class="font-bold text-lg sm:text-2xl text-black">
						Peminjam menunggu persetujuan
					</h3>
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

				<div class="flex items-end gap-3">
					<span class="text-4xl sm:text-6xl font-bold text-[#363062]">{{ $stats['menunggu'] }}</span>
					<span class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2 font-medium">Antrean</span>
				</div>

				<p class="text-[10px] sm:text-xs font-medium text-gray-500">Pengajuan baru yang perlu di-review</p>
			</div>

			{{-- CARD 2 --}}
			<div
				class="bg-white border border-gray-300 rounded-[20px] p-4 sm:p-6 shadow-lg flex flex-col justify-between gap-2 h-full">
				<h3 class="font-bold text-lg sm:text-2xl text-black">Total Alat Dipinjam</h3>

				<div class="flex items-end gap-3">
					<span class="text-4xl sm:text-6xl font-bold text-[#363062]">{{ $stats['dipinjam'] }}</span>
					<span class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2 font-medium">Peminjaman</span>
				</div>

				<div class="flex items-center gap-3">
					<span
						class="px-2 py-0.5 sm:px-3 sm:py-1 text-white font-bold bg-gradient-to-r from-[#F99417] to-[#F99417]/70 rounded-full text-[10px] sm:text-xs">
						{{ $stats['total_alat'] }} Alat
					</span>
					<span class="text-[10px] sm:text-xs font-medium text-gray-500 whitespace-nowrap">
						Barang dlm peminjaman aktif
					</span>
				</div>
			</div>

			{{-- SECTION LEFT --}}
			<div id="menunggu" class="flex flex-col gap-4 h-full">

				<div class="flex items-center justify-between mb-2">
				<h2 class="text-lg sm:text-2xl font-bold">Menunggu Persetujuan</h2>
				<div class="flex items-center gap-2">
					<div class="h-1.5 w-1.5 sm:h-2 sm:w-2 bg-yellow-500 rounded-full"></div>
					<span class="text-xs sm:text-sm text-gray-500">{{ $menunggu->total() }} Peminjaman</span>
				</div>
			</div>

				{{-- TOP BAR MENUNGGU --}}
				<form method="GET" action="{{ route('admin-peminjaman') . '#menunggu' }}">
					<div class="flex flex-col gap-3 lg:flex-row lg:justify-between lg:items-center">
						<div class="flex items-center gap-3 flex-wrap">
							{{-- SEARCH --}}
							<div class="relative w-52 h-full flex-shrink-0">
								<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
										viewBox="0 0 24 24">
										<path fill="currentColor"
											d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6" />
									</svg>
								</div>
								<input type="text" name="search_menunggu" value="{{ request('search_menunggu') }}"
									placeholder="Cari peminjam..." onchange="this.form.submit()"
									class="w-full h-full pl-10 pr-4 py-3 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
							</div>

							{{-- HIDDEN FIELDS UNTUK MENGOSONGKAN FILTER AKTIF --}}
							<input type="hidden" name="search_aktif" value="">
							<input type="hidden" name="durasi_aktif" value="">
							<input type="hidden" name="status_aktif" value="">

							{{-- FILTER DROPDOWN --}}
							<div x-data="{ open: false }" class="relative inline-block text-left">
								<button type="button" @click="open = !open"
									class="flex-shrink-0 w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]"
										viewBox="0 0 24 24">
										<path fill="currentColor"
											d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75" />
									</svg>
								</button>

								<div x-show="open" @click.outside="open = false" style="display:none" x-transition.opacity
									class="max-h-[250px] absolute left-0 z-20 mt-2 w-56 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 overflow-y-auto border border-gray-100">
									<div class="py-2">
										<p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Durasi</p>

										<label
											class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
											<input type="radio" name="durasi_menunggu" value=""
												onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_menunggu') == '' ? 'checked' : '' }}>
											Semua Durasi
										</label>

										@foreach($durasiList as $durasi)
											<label
												class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
												<input type="radio" name="durasi_menunggu" value="{{ $durasi }}"
													onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_menunggu') == $durasi ? 'checked' : '' }}>
												{{ $durasi }} Menit
											</label>
										@endforeach
									</div>
								</div>
							</div>

							{{-- RESET BUTTON --}}
							@if(request('search_menunggu') || request('durasi_menunggu'))
								<a href="{{ route('admin-peminjaman') . '#menunggu' }}"
									class="px-4 py-3 text-sm text-[#363062]/90 hover:text-[#363062] border border-[#363062] rounded-full transition font-semibold">
									Reset Filter
								</a>
							@endif
						</div>

						<div class="w-full lg:w-auto flex">
							<a href="{{ route('admin-peminjaman-create') }}"
								class="w-full lg:w-auto px-4 py-3 flex items-center justify-center gap-2 border border-transparent text-white font-semibold rounded-full text-sm bg-[#363062] group hover:bg-transparent hover:text-[#363062] hover:border-[#363062] transition-all">
								Tambahkan Peminjaman
								<svg xmlns="http://www.w3.org/2000/svg"
									class="h-5 w-5 text-white group-hover:text-[#363062]" viewBox="0 0 24 24">
									<path fill="currentColor"
										d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2" />
								</svg>
							</a>
						</div>
					</div>
				</form>

				<div class="flex flex-col gap-4 p-4 max-h-[600px] overflow-y-auto pr-2">
					@forelse($menunggu as $data)
						{{-- CONTENT --}}
						<div
							class="bg-white border border-gray-300 rounded-[20px] p-4 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col gap-3">

							{{-- HEADER CARD --}}
							<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
								<div class="flex items-center gap-3 flex-wrap">
									<h3 class="text-xl sm:text-2xl font-bold text-[#363062] leading-none">
										#{{ $data->kode_peminjaman }}
									</h3>

									<span
										class="px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold shrink-0 {{ $data->status_badge }}">
										{{ $data->status_label }}
									</span>
								</div>

								<div class="flex items-center gap-2">
									<div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden border border-gray-200">
										<img src="{{ $data->peminjam->foto_url }}" alt="user"
											class="w-full h-full object-cover">
									</div>
									<div class="text-xs sm:text-sm">
										<p class="font-bold text-gray-900 leading-tight">{{ $data->peminjam->nama_lengkap }}</p>
										<p class="text-[10px] sm:text-xs text-gray-500 font-medium">
											{{ $data->detailPeminjaman->count() }} Alat dipinjam
										</p>
									</div>
								</div>
							</div>

							<hr class="border-gray-500 opacity-30">

							{{-- BODY --}}
							<div class="flex flex-col gap-3">

								{{-- TOP ROW INFO --}}
								<div class="flex justify-between items-start text-[10px] sm:text-xs text-gray-500 font-medium">
									<p class="text-gray-900">
										Daftar alat / barang:
									</p>

									<p class="text-right">
										Waktu pengajuan: <br class="sm:hidden">
										<span
											class="text-[#363062] font-bold">{{ \Carbon\Carbon::parse($data->tanggal_pengajuan)->format('H:i | d-m-Y') }}</span>
									</p>
								</div>

								{{-- LIST ALAT --}}
								<div class="flex flex-col gap-3 max-h-40 overflow-y-auto pr-1">
									@foreach($data->detailPeminjaman as $detail)
										<div class="flex items-center justify-between gap-3">

											{{-- LEFT ITEM --}}
											<div class="flex items-center gap-3 flex-1 min-w-0">
												<div
													class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl border flex items-center justify-center overflow-hidden bg-gray-50 flex-shrink-0">
													<img src="{{ asset('storage/' . $detail->alat->gambar) }}" alt="img"
														class="w-full h-full object-cover">
												</div>

												<div class="flex-1 min-w-0">
													<p class="text-xs sm:text-sm font-bold text-gray-900 truncate">
														{{ $detail->alat->nama_alat }}
														<span
															class="text-[10px] sm:text-xs font-medium text-gray-500">×{{ $detail->jumlah }}</span>
													</p>
													<div class="flex items-center gap-1 mt-0.5">
														<div class="h-1.5 w-1.5 rounded-full flex-shrink-0"
															style="background: {{ $detail->alat->kategori->warna }}"></div>
														<p class="text-[10px] sm:text-xs text-gray-500 font-medium truncate">
															{{ $detail->alat->kategori->nama_kategori }}
														</p>
													</div>
												</div>
											</div>

											{{-- RIGHT DURATION --}}
											<div
												class="text-right text-[10px] sm:text-xs text-gray-500 whitespace-nowrap flex-shrink-0">
												<p class="font-medium">Durasi Peminjaman</p>
												<div class="flex items-center justify-end gap-1 text-gray-900">
													<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4"
														viewBox="0 0 24 24">
														<g fill="none" stroke="currentColor" stroke-linecap="round"
															stroke-linejoin="round" stroke-width="2.5">
															<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0" />
															<path d="M12 7v5l3 3" />
														</g>
													</svg>
													<span class="font-bold">{{ $detail->alat->durasi }} Menit</span>
												</div>
											</div>

										</div>
									@endforeach
								</div>

							</div>

							{{-- ACTION --}}
							<div class="flex justify-end gap-2 mt-2 pt-3 border-t border-gray-100">
								<a href={{ route('admin-peminjaman-edit', $data) }}
									class="px-4 py-1.5 sm:px-5 sm:py-2 border border-transparent rounded-full bg-[#F99417] text-white text-xs sm:text-sm font-bold hover:bg-white hover:text-[#F99417] hover:border-[#F99417] transition-all shadow-sm">
									Edit
								</a>
								<form action="{{ route('admin-peminjaman-destroy', $data) }}" method="POST"
									onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?');">
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
						<div
							class="lg:col-span-2 flex flex-col gap-3 items-center justify-center bg-white border border-gray-300 rounded-[20px] p-6 text-gray-500 font-medium text-center">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 sm:h-14 sm:w-14 text-gray-300"
								viewBox="0 0 24 24">
								<path d="M0 0h24v24H0z" fill="none" />
								<path fill="currentColor"
									d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34M15 14H9l-.117.007a1 1 0 0 0 0 1.986L9 16h6l.117-.007a1 1 0 0 0 0-1.986zM9.01 9l-.127.007a1 1 0 0 0 0 1.986L9 11l.127-.007a1 1 0 0 0 0-1.986zm6 0l-.127.007a1 1 0 0 0 0 1.986L15 11l.127-.007a1 1 0 0 0 0-1.986z" />
							</svg>
							<p>Tidak ada data peminjaman menunggu.</p>
						</div>
					@endforelse
				</div>

				{{-- Pagination Menunggu --}}
				@if($menunggu->hasPages())
					<div class="mt-4">
						<div class="flex flex-col items-center justify-between gap-4">
							<div class="flex items-center gap-2">
								{{-- Tombol Previous --}}
								@if($menunggu->onFirstPage())
									<button type="button" disabled
										class="p-2.5 sm:p-3 rounded-full border text-xs flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
											<defs>
												<path id="SVG_menunggu_prev" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG_menunggu_prev"
												transform="rotate(-180 5.02 9.505)" />
										</svg>
									</button>
								@else
									<a href="{{ $menunggu->appends(request()->query())->previousPageUrl() . '#menunggu' }}"
										class="p-2.5 sm:p-3 rounded-full border bg-white text-xs flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
											<defs>
												<path id="SVG_menunggu_prev" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG_menunggu_prev"
												transform="rotate(-180 5.02 9.505)" />
										</svg>
									</a>
								@endif

								{{-- Nomor Halaman --}}
								<div class="flex items-center gap-1 bg-gray-100 p-1 sm:p-1.5 rounded-full shadow-inner">
									@php
										$currentPage = $menunggu->currentPage();
										$lastPage = $menunggu->lastPage();
										$start = max(1, $currentPage - 1);
										$end = min($lastPage, $currentPage + 1);

										if ($start > 1) {
											$activeClassFirst = (1 == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
											echo '<a href="' . $menunggu->appends(request()->query())->url(1) . '#menunggu" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $activeClassFirst . '">1</a>';
											if ($start > 2) {
												echo '<span class="px-0.5 text-gray-400 text-[10px]">...</span>';
											}
										}

										for ($i = $start; $i <= $end; $i++) {
											$activeClass = ($i == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
											echo '<a href="' . $menunggu->appends(request()->query())->url($i) . '#menunggu" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $activeClass . '">' . $i . '</a>';
										}

										if ($end < $lastPage) {
											if ($end < $lastPage - 1) {
												echo '<span class="px-0.5 text-gray-400 text-[10px]">...</span>';
											}
											$activeClassLast = ($lastPage == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
											echo '<a href="' . $menunggu->appends(request()->query())->url($lastPage) . '#menunggu" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $activeClassLast . '">' . $lastPage . '</a>';
										}
									@endphp
								</div>

								{{-- Tombol Next --}}
								@if($menunggu->hasMorePages())
									<a href="{{ $menunggu->appends(request()->query())->nextPageUrl() . '#menunggu' }}"
										class="p-2.5 sm:p-3 rounded-full border bg-white text-xs flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
											<defs>
												<path id="SVG_menunggu_next" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG_menunggu_next"
												transform="rotate(-180 5.02 9.505)" />
										</svg>
									</a>
								@else
									<button type="button" disabled
										class="p-2.5 sm:p-3 rounded-full border text-xs flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
											<defs>
												<path id="SVG_menunggu_next" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG_menunggu_next"
												transform="rotate(-180 5.02 9.505)" />
										</svg>
									</button>
								@endif
							</div>
						</div>
					</div>
				@endif

				<div class="text-sm text-gray-500 text-center">
					Menampilkan {{ $menunggu->firstItem() ?? 0 }}
					-
					{{ $menunggu->lastItem() ?? 0 }}
					dari
					{{ $menunggu->total() }}
					data
				</div>

			</div>

			{{-- SECTION RIGHT --}}
			<div id="aktif" class="flex flex-col gap-4 h-full">

				<div class="flex items-center justify-between mb-2">
				<h2 class="text-lg sm:text-2xl font-bold">Peminjaman Aktif</h2>
				<div class="flex items-center gap-2">
					<div class="h-1.5 w-1.5 sm:h-2 sm:w-2 bg-blue-500 rounded-full"></div>
					<span class="text-xs sm:text-sm text-gray-500">{{ $dipinjam->total() }} Peminjaman</span>
				</div>
			</div>

				{{-- TOP BAR AKTIF --}}
				<form method="GET" action="{{ route('admin-peminjaman') . '#aktif' }}">
					<div class="flex flex-col gap-3 lg:flex-row lg:justify-between lg:items-center">
						<div class="flex items-center gap-3 flex-wrap">
							{{-- SEARCH --}}
							<div class="relative w-52 h-full flex-shrink-0">
								<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
										viewBox="0 0 24 24">
										<path fill="currentColor"
											d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6" />
									</svg>
								</div>
								<input type="text" name="search_aktif" value="{{ request('search_aktif') }}"
									placeholder="Cari peminjam..." onchange="this.form.submit()"
									class="w-full h-full pl-10 pr-4 py-3 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
							</div>

							{{-- HIDDEN FIELDS UNTUK MENGOSONGKAN FILTER MENUNGGU --}}
							<input type="hidden" name="search_menunggu" value="">
							<input type="hidden" name="durasi_menunggu" value="">

							{{-- FILTER DROPDOWN --}}
							<div x-data="{ open: false }" class="relative inline-block text-left">
								<button type="button" @click="open = !open"
									class="flex-shrink-0 w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]"
										viewBox="0 0 24 24">
										<path fill="currentColor"
											d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75" />
									</svg>
								</button>

								<div x-show="open" @click.outside="open = false" style="display:none" x-transition.opacity
									class="max-h-[250px] absolute left-0 z-20 mt-2 w-56 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 overflow-y-auto border border-gray-100">
									<div class="py-2">

										{{-- FILTER STATUS --}}
										<p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Status</p>

										<label
											class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
											<input type="radio" name="status_aktif" value="" onchange="this.form.submit()"
												class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_aktif') == '' ? 'checked' : '' }}>
											Semua Status
										</label>
										<label
											class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
											<input type="radio" name="status_aktif" value="dipinjam"
												onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_aktif') == 'dipinjam' ? 'checked' : '' }}>
											Dipinjam
										</label>
										<label
											class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
											<input type="radio" name="status_aktif" value="jatuh_tempo"
												onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_aktif') == 'jatuh_tempo' ? 'checked' : '' }}>
											Jatuh Tempo
										</label>
										<label
											class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
											<input type="radio" name="status_aktif" value="terlambat"
												onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_aktif') == 'terlambat' ? 'checked' : '' }}>
											Terlambat
										</label>

										<div class="border-t border-gray-100 my-1 mx-4"></div>

										{{-- FILTER DURASI --}}
										<p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Durasi</p>

										<label
											class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
											<input type="radio" name="durasi_aktif" value="" onchange="this.form.submit()"
												class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_aktif') == '' ? 'checked' : '' }}>
											Semua Durasi
										</label>

										@foreach($durasiList as $durasi)
											<label
												class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
												<input type="radio" name="durasi_aktif" value="{{ $durasi }}"
													onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_aktif') == $durasi ? 'checked' : '' }}>
												{{ $durasi }} Menit
											</label>
										@endforeach

									</div>
								</div>
							</div>

							{{-- THE GREAT RESET --}}
							@if(request('search_aktif') || request('durasi_aktif') || request('status_aktif'))
								<a href="{{ route('admin-peminjaman') . '#aktif' }}"
									class="px-4 py-3 text-sm text-[#363062]/90 hover:text-[#363062] border border-[#363062] rounded-full transition font-semibold">
									Reset Filter
								</a>
							@endif
						</div>

						<div class="w-full lg:w-auto flex">
							<a href="{{ route('admin-peminjaman-create') }}"
								class="w-full lg:w-auto px-4 py-3 flex items-center justify-center gap-2 border border-transparent text-white font-semibold rounded-full text-sm bg-[#363062] group hover:bg-transparent hover:text-[#363062] hover:border-[#363062] transition-all">
								Tambahkan Peminjaman
								<svg xmlns="http://www.w3.org/2000/svg"
									class="h-5 w-5 text-white group-hover:text-[#363062]" viewBox="0 0 24 24">
									<path fill="currentColor"
										d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2" />
								</svg>
							</a>
						</div>
					</div>
				</form>

				<div class="flex flex-col gap-4 p-4 max-h-[600px] overflow-y-auto pr-2">
					@forelse($dipinjam as $data)
						{{-- CONTENT --}}
						<div
							class="bg-white border border-gray-300 rounded-[20px] p-4 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col gap-3">

							{{-- HEADER CARD --}}
							<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
								{{-- KITA HITUNG STATUS REAL-TIME --}}
								@php
									$realStatusLabel = $data->status_label;
									$realStatusBadge = $data->status_badge;

									if (!is_null($data->deadline) && in_array($data->status, ['dipinjam', 'jatuh_tempo', 'terlambat'])) {
										$deadline = \Carbon\Carbon::parse($data->deadline);
										$lateTime = $deadline->copy()->addMinutes(10);
										$now = \Carbon\Carbon::now();

										if ($now->greaterThanOrEqualTo($lateTime)) {
											$realStatusLabel = 'Terlambat';
											$realStatusBadge = 'bg-red-100 text-red-700 border-red-500';
										} elseif ($now->greaterThanOrEqualTo($deadline)) {
											$realStatusLabel = 'Jatuh Tempo';
											$realStatusBadge = 'bg-orange-100 text-orange-700 border-orange-500';
										}
									}
								@endphp

								<div class="flex items-center gap-3 flex-wrap">
									<h3 class="text-xl sm:text-2xl font-bold text-[#363062] leading-none">
										#{{ $data->kode_peminjaman }}
									</h3>

									<span
										class="px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold shrink-0 {{ $realStatusBadge }}">
										{{ $realStatusLabel }}
									</span>
								</div>

								<div class="flex items-center gap-2">
									<div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden border border-gray-200">
										<img src="{{ $data->peminjam->foto_url }}" alt="user"
											class="w-full h-full object-cover">
									</div>
									<div class="text-xs sm:text-sm">
										<p class="font-bold text-gray-900 leading-tight">{{ $data->peminjam->nama_lengkap }}</p>
										<p class="text-[10px] sm:text-xs text-gray-500 font-medium">
											{{ $data->detailPeminjaman->count() }} Alat dipinjam
										</p>
									</div>
								</div>
							</div>

							<hr class="border-gray-500 opacity-30">

							{{-- BODY --}}
							<div class="flex flex-col gap-3">

								{{-- TOP ROW INFO --}}
								<div class="flex justify-between items-start text-[10px] sm:text-xs text-gray-500 font-medium">
									<p class="text-gray-900">
										Daftar alat / barang:
									</p>

									<div class="flex flex-col text-right gap-0.5">
										<p>
											Pengajuan: <span
												class="text-[#363062] font-bold">{{ \Carbon\Carbon::parse($data->tanggal_pengajuan)->format('d-m-Y') }}</span>
										</p>
										@if($data->tanggal_disetujui)
											<p>
												Diterima: <span
													class="text-[#363062] font-bold">{{ \Carbon\Carbon::parse($data->tanggal_disetujui)->format('H:i | d-m-Y') }}</span>
											</p>
										@endif
									</div>
								</div>

								{{-- LIST ALAT --}}
								<div class="flex flex-col gap-3 max-h-40 overflow-y-auto pr-1">
									@foreach($data->detailPeminjaman as $detail)
										<div class="flex items-center justify-between gap-3">

											{{-- LEFT ITEM --}}
											<div class="flex items-center gap-3 flex-1 min-w-0">
												<div
													class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl border flex items-center justify-center overflow-hidden bg-gray-50 flex-shrink-0">
													<img src="{{ asset('storage/' . $detail->alat->gambar) }}" alt="img"
														class="w-full h-full object-cover">
												</div>

												<div class="flex-1 min-w-0">
													<p class="text-xs sm:text-sm font-bold text-gray-900 truncate">
														{{ $detail->alat->nama_alat }}
														<span
															class="text-[10px] sm:text-xs font-medium text-gray-500">×{{ $detail->jumlah }}</span>
													</p>
													<div class="flex items-center gap-1 mt-0.5">
														<div class="h-1.5 w-1.5 rounded-full flex-shrink-0"
															style="background: {{ $detail->alat->kategori->warna }}"></div>
														<p class="text-[10px] sm:text-xs text-gray-500 font-medium truncate">
															{{ $detail->alat->kategori->nama_kategori }}
														</p>
													</div>
												</div>
											</div>

											{{-- RIGHT DURATION / COUNTDOWN --}}
											<div
												class="text-right text-[10px] sm:text-xs text-gray-500 whitespace-nowrap flex-shrink-0 leading-tight">
												<p class="font-medium">Durasi Peminjaman</p>

												@php
													$hasDeadline = !is_null($data->deadline);
													$deadlineObj = $hasDeadline ? \Carbon\Carbon::parse($data->deadline) : null;
												@endphp

												@if(!$hasDeadline)
													<span class="font-bold text-yellow-600">Pending</span>
												@else
													<div x-data="{
															deadline: new Date('{{ $deadlineObj->toIso8601String() }}').getTime(),
															lateTime: new Date('{{ $deadlineObj->copy()->addMinutes(10)->toIso8601String() }}').getTime(),
															timeLeft: '',
															statusClass: 'text-gray-900',
															init() {
																const update = () => {
																	const now = new Date().getTime();
																	const distanceToDeadline = this.deadline - now;
																	const distanceToLate = this.lateTime - now;

																	if (distanceToLate <= 0) {
																		this.timeLeft = 'Terlambat';
																		this.statusClass = 'text-red-500';
																		return;
																	}
																	if (distanceToDeadline <= 0) {
																		this.timeLeft = 'Jatuh Tempo';
																		this.statusClass = 'text-[#F99417]';
																		return;
																	}

																	const hours = Math.floor((distanceToDeadline % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
																	const minutes = Math.floor((distanceToDeadline % (1000 * 60 * 60)) / (1000 * 60));
																	const seconds = Math.floor((distanceToDeadline % (1000 * 60)) / 1000);

																	this.timeLeft = String(hours).padStart(2, '0') + ':' +
																				String(minutes).padStart(2, '0') + ':' +
																				String(seconds).padStart(2, '0');
																	this.statusClass = 'text-gray-900';
																};
																update();
																setInterval(update, 1000);
															}
														}" class="flex items-center justify-end gap-1 font-bold" :class="statusClass">
														<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4"
															viewBox="0 0 24 24">
															<g fill="none" stroke="currentColor" stroke-linecap="round"
																stroke-linejoin="round" stroke-width="2.5">
																<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0" />
																<path d="M12 7v5l3 3" />
															</g>
														</svg>
														<span x-text="timeLeft"></span>
													</div>
												@endif
											</div>

										</div>
									@endforeach
								</div>

							</div>

							{{-- ACTION --}}
							<div class="flex justify-end gap-2 mt-2 pt-3 border-t border-gray-100">
								<a href={{ route('admin-peminjaman-edit', $data) }}
									class="px-4 py-1.5 sm:px-5 sm:py-2 border border-transparent rounded-full bg-[#F99417] text-white text-xs sm:text-sm font-bold hover:bg-white hover:text-[#F99417] hover:border-[#F99417] transition-all shadow-sm">
									Edit
								</a>
								<form action="{{ route('admin-peminjaman-destroy', $data) }}" method="POST"
									onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?');">
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
						<div
							class="lg:col-span-2 flex flex-col gap-3 items-center justify-center bg-white border border-gray-300 rounded-[20px] p-6 text-gray-500 font-medium text-center">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 sm:h-14 sm:w-14 text-gray-300"
								viewBox="0 0 24 24">
								<path d="M0 0h24v24H0z" fill="none" />
								<path fill="currentColor"
									d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34M15 14H9l-.117.007a1 1 0 0 0 0 1.986L9 16h6l.117-.007a1 1 0 0 0 0-1.986zM9.01 9l-.127.007a1 1 0 0 0 0 1.986L9 11l.127-.007a1 1 0 0 0 0-1.986zm6 0l-.127.007a1 1 0 0 0 0 1.986L15 11l.127-.007a1 1 0 0 0 0-1.986z" />
							</svg>
							<p>Tidak ada data peminjaman aktif.</p>
						</div>
					@endforelse
				</div>

				{{-- Pagination Aktif --}}
				@if($dipinjam->hasPages())
					<div class="mt-4">
						<div class="flex flex-col items-center justify-between gap-4">
							<div class="flex items-center gap-2">
								{{-- Tombol Previous --}}
								@if($dipinjam->onFirstPage())
									<button type="button" disabled
										class="p-2.5 sm:p-3 rounded-full border text-xs flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
											<defs>
												<path id="SVG_aktif_prev" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG_aktif_prev" transform="rotate(-180 5.02 9.505)" />
										</svg>
									</button>
								@else
									<a href="{{ $dipinjam->appends(request()->query())->previousPageUrl() . '#aktif' }}"
										class="p-2.5 sm:p-3 rounded-full border bg-white text-xs flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
											<defs>
												<path id="SVG_aktif_prev" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG_aktif_prev" transform="rotate(-180 5.02 9.505)" />
										</svg>
									</a>
								@endif

								{{-- Nomor Halaman --}}
								<div class="flex items-center gap-1 bg-gray-100 p-1 sm:p-1.5 rounded-full shadow-inner">
									@php
										$currentPage = $dipinjam->currentPage();
										$lastPage = $dipinjam->lastPage();
										$start = max(1, $currentPage - 1);
										$end = min($lastPage, $currentPage + 1);

										if ($start > 1) {
											$activeClassFirst = (1 == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
											echo '<a href="' . $dipinjam->appends(request()->query())->url(1) . '#aktif" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $activeClassFirst . '">1</a>';
											if ($start > 2) {
												echo '<span class="px-0.5 text-gray-400 text-[10px]">...</span>';
											}
										}

										for ($i = $start; $i <= $end; $i++) {
											$activeClass = ($i == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
											echo '<a href="' . $dipinjam->appends(request()->query())->url($i) . '#aktif" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $activeClass . '">' . $i . '</a>';
										}

										if ($end < $lastPage) {
											if ($end < $lastPage - 1) {
												echo '<span class="px-0.5 text-gray-400 text-[10px]">...</span>';
											}
											$activeClassLast = ($lastPage == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
											echo '<a href="' . $dipinjam->appends(request()->query())->url($lastPage) . '#aktif" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $activeClassLast . '">' . $lastPage . '</a>';
										}
									@endphp
								</div>

								{{-- Tombol Next --}}
								@if($dipinjam->hasMorePages())
									<a href="{{ $dipinjam->appends(request()->query())->nextPageUrl() . '#aktif' }}"
										class="p-2.5 sm:p-3 rounded-full border bg-white text-xs flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
											<defs>
												<path id="SVG_aktif_next" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG_aktif_next" transform="rotate(-180 5.02 9.505)" />
										</svg>
									</a>
								@else
									<button type="button" disabled
										class="p-2.5 sm:p-3 rounded-full border text-xs flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
											<defs>
												<path id="SVG_aktif_next" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG_aktif_next" transform="rotate(-180 5.02 9.505)" />
										</svg>
									</button>
								@endif
							</div>
						</div>
					</div>
				@endif

				<div class="text-sm text-gray-500 text-center">
					Menampilkan {{ $dipinjam->firstItem() ?? 0 }}
					-
					{{ $dipinjam->lastItem() ?? 0 }}
					dari
					{{ $dipinjam->total() }}
					data
				</div>
			</div>

			{{-- SECTION BAWAH: HISTORI PEMINJAMAN --}}
			<div id="riwayat" class="lg:col-span-2 flex flex-col gap-6 mt-8 pt-8 border-t border-gray-300">

				<div class="flex items-center justify-between mb-2">
					<h2 class="text-lg sm:text-2xl font-bold text-gray-900">Histori Peminjaman</h2>
					<div class="flex items-center gap-2">
						<div class="h-1.5 w-1.5 sm:h-2 sm:w-2 bg-green-500 rounded-full"></div>
						<span class="text-xs sm:text-sm text-gray-500">{{ $riwayat->total() }} Peminjaman</span>
					</div>
				</div>
				<p class="text-xs sm:text-sm text-gray-500 font-medium">
						Daftar transaksi peminjaman yang telah selesai atau pengajuan yang ditolak.
					</p>

				{{-- SEARCH & FILTER UNTUK HISTORY --}}
				<form method="GET" action="{{ route('admin-peminjaman') . '#riwayat' }}">
					<div class="flex flex-col sm:flex-row items-center gap-3">

						{{-- SEARCH BAR --}}
						<div class="relative w-full sm:w-64 flex-shrink-0">
							<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24">
									<path fill="currentColor"
										d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6" />
								</svg>
							</div>
							<input type="text" name="search_riwayat" value="{{ request('search_riwayat') }}"
								placeholder="Cari kode atau peminjam..." onchange="this.form.submit()"
								class="w-full pl-10 pr-4 py-3 border border-[#363062] rounded-full text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
						</div>

						<div class="flex items-center gap-3 w-full sm:w-auto">
							{{-- FILTER DROPDOWN --}}
							<div x-data="{ open: false }" class="relative inline-block text-left">
								<button type="button" @click="open = !open"
									class="flex-shrink-0 w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100 transition">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#363062]"
										viewBox="0 0 24 24">
										<path fill="currentColor"
											d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75" />
									</svg>
								</button>

								<div x-show="open" @click.outside="open = false" style="display:none" x-transition.opacity
									class="max-h-[300px] absolute left-0 z-20 mt-2 w-64 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 overflow-y-auto border border-gray-100">
									<div class="py-2">

										{{-- FILTER STATUS --}}
										<p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Status</p>

										<label
											class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
											<input type="radio" name="status_riwayat" value="" onchange="this.form.submit()"
												class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_riwayat') == '' ? 'checked' : '' }}>
											Semua Status
										</label>
										<label
											class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
											<input type="radio" name="status_riwayat" value="selesai"
												onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_riwayat') == 'selesai' ? 'checked' : '' }}>
											<span class="flex items-center gap-2">
												Selesai
											</span>
										</label>
										<label
											class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
											<input type="radio" name="status_riwayat" value="ditolak"
												onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_riwayat') == 'ditolak' ? 'checked' : '' }}>
											<span class="flex items-center gap-2">
												Ditolak
											</span>
										</label>

										<div class="border-t border-gray-100 my-1 mx-4"></div>

										{{-- FILTER DURASI --}}
										<p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Durasi</p>

										<label
											class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
											<input type="radio" name="durasi_riwayat" value="" onchange="this.form.submit()"
												class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_riwayat') == '' ? 'checked' : '' }}>
											Semua Durasi
										</label>

										@foreach($durasiList as $durasi)
											<label
												class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
												<input type="radio" name="durasi_riwayat" value="{{ $durasi }}"
													onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('durasi_riwayat') == $durasi ? 'checked' : '' }}>
												{{ $durasi }} Menit
											</label>
										@endforeach

									</div>
								</div>
							</div>

							{{-- RESET FILTER BUTTON --}}
							@if(request('search_riwayat') || request('status_riwayat') || request('durasi_riwayat'))
								<a href="{{ route('admin-peminjaman') . '#riwayat' }}"
									class="px-4 py-2.5 text-xs sm:text-sm text-[#363062]/90 hover:text-[#363062] border border-[#363062] rounded-full transition font-semibold">
									Reset
								</a>
							@endif
						</div>

					</div>
				</form>

				{{-- KONTENER CARD --}}
				<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

					@forelse($riwayat as $data)
						{{-- CONTENT CARD --}}
						<div
							class="bg-white border border-gray-300 rounded-[20px] p-4 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col gap-3">

							{{-- HEADER CARD --}}
							<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
								<div class="flex items-center gap-3 flex-wrap">
									<h3 class="text-xl sm:text-2xl font-bold text-[#363062] leading-none">
										#{{ $data->kode_peminjaman }}
									</h3>

									<span class="px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold shrink-0 {{ $data->status_badge }}">
										{{ $data->status_label }}
									</span>
								</div>

								<div class="flex items-center gap-2">
									<div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden border border-gray-200">
										<img src="{{ $data->peminjam->foto_url }}" alt="user"
											class="w-full h-full object-cover">
									</div>
									<div class="text-xs sm:text-sm">
										<p class="font-bold text-gray-900 leading-tight">{{ $data->peminjam->nama_lengkap }}</p>
										<p class="text-[10px] sm:text-xs text-gray-500 font-medium">
											{{ $data->detailPeminjaman->count() }} Item
										</p>
									</div>
								</div>
							</div>

							<hr class="border-gray-200 opacity-50">

							{{-- DATES INFO --}}
							<div
								class="flex justify-between items-start text-[10px] sm:text-xs text-gray-600 bg-gray-50 p-2 sm:p-3 rounded-xl border border-gray-100 font-medium">
								<div class="flex flex-col gap-1">
									<p>Tgl Pengajuan:</p>
									<span
										class="text-[#363062] font-bold">{{ \Carbon\Carbon::parse($data->tanggal_pengajuan)->format('d-m-Y') }}</span>
								</div>
								<div class="flex flex-col gap-1 text-right">
									<p>{{ $data->status == 'selesai' ? 'Tgl Kembali:' : 'Tgl Ditolak:' }}</p>
									<span
										class="font-bold {{ $data->status == 'selesai' ? 'text-green-600' : 'text-red-600' }}">
										{{ \Carbon\Carbon::parse($data->updated_at)->format('H:i | d-m-Y') }}
									</span>
								</div>
							</div>

							{{-- LIST ITEM --}}
							<div class="flex flex-col gap-3 max-h-40 overflow-y-auto pr-1">
								@foreach($data->detailPeminjaman as $detail)
									<div class="flex items-center justify-between gap-3">
										<div class="flex items-center gap-3 flex-1 min-w-0">
											<div
												class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg border flex items-center justify-center overflow-hidden bg-gray-50 flex-shrink-0">
												<img src="{{ asset('storage/' . $detail->alat->gambar) }}" alt="img"
													class="w-full h-full object-cover">
											</div>
											<div class="flex-1 min-w-0">
												<p class="text-xs sm:text-sm text-gray-900 font-bold truncate">
													{{ $detail->alat->nama_alat }} <span
														class="text-[10px] sm:text-xs text-gray-500 font-medium">×{{ $detail->jumlah }}</span>
												</p>
												<div class="flex items-center gap-1 mt-0.5">
													<div class="h-1.5 w-1.5 rounded-full flex-shrink-0"
														style="background: {{ $detail->alat->kategori->warna }}"></div>
													<p class="text-[10px] sm:text-xs text-gray-500 font-medium truncate">
														{{ $detail->alat->kategori->nama_kategori }}
													</p>
												</div>
											</div>
										</div>

										<div class="text-right flex items-center gap-1 text-[10px] sm:text-xs text-gray-500 font-bold whitespace-nowrap">
											<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4"
												viewBox="0 0 24 24">
												<g fill="none" stroke="currentColor" stroke-linecap="round"
													stroke-linejoin="round" stroke-width="2.5">
													<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0" />
													<path d="M12 7v5l3 3" />
												</g>
											</svg>
											<p>{{ $detail->alat->durasi }} Menit</p>
										</div>
									</div>
								@endforeach
							</div>

							{{-- ACTION --}}
							<div class="flex justify-end gap-2 mt-2 pt-3 border-t border-gray-100">
								<a href="{{ route('admin-peminjaman-edit', $data->kode_peminjaman) }}"
									class="px-4 py-1.5 sm:px-5 sm:py-2 border border-transparent rounded-full bg-[#F99417] text-white text-xs sm:text-sm font-bold hover:bg-white hover:text-[#F99417] hover:border-[#F99417] transition-all shadow-sm">
									Edit
								</a>

								<form action="{{ route('admin-peminjaman-destroy', $data->kode_peminjaman) }}" method="POST"
									onsubmit="return confirm('Yakin ingin menghapus histori ini?')">
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
						<div
							class="col-span-1 sm:col-span-2 py-10 flex flex-col items-center justify-center bg-gray-50 rounded-[20px] border border-dashed border-gray-300 text-gray-400 font-medium">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 opacity-30" viewBox="0 0 24 24">
								<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
									stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0a9 9 0 0 1 18 0" />
							</svg>
							<p>Belum ada histori peminjaman.</p>
						</div>
					@endforelse

				</div>

				{{-- Custom Pagination Riwayat --}}
				@if($riwayat->hasPages())
					<div class="mt-6">
						<div class="flex flex-col sm:flex-row items-center justify-between gap-4">

							{{-- Keterangan (mobile: bawah, desktop: kiri) --}}
							<div class="text-sm text-gray-500 order-2 sm:order-1">
								Menampilkan {{ $riwayat->firstItem() ?? 0 }} - {{ $riwayat->lastItem() ?? 0 }} dari {{ $riwayat->total() }} data
							</div>

							{{-- Tombol Paginasi (mobile: atas, desktop: kanan) --}}
							<div class="flex items-center gap-2 order-1 sm:order-2">
								{{-- Tombol Previous --}}
								@if($riwayat->onFirstPage())
									<button type="button" disabled
										class="p-2.5 sm:p-3 rounded-full border text-xs flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
											<defs>
												<path id="SVG_riwayat_prev" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG_riwayat_prev" transform="rotate(-180 5.02 9.505)" />
										</svg>
									</button>
								@else
									<a href="{{ $riwayat->appends(request()->query())->previousPageUrl() }}"
										class="p-2.5 sm:p-3 rounded-full border bg-white text-xs flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
											<defs>
												<path id="SVG_riwayat_prev" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG_riwayat_prev" transform="rotate(-180 5.02 9.505)" />
										</svg>
									</a>
								@endif

								{{-- Nomor Halaman --}}
								<div class="flex items-center gap-1 bg-gray-100 p-1 sm:p-1.5 rounded-full shadow-inner">
									@php
										$currentPageRiwayat = $riwayat->currentPage();
										$lastPageRiwayat = $riwayat->lastPage();
										$startRiwayat = max(1, $currentPageRiwayat - 1);
										$endRiwayat = min($lastPageRiwayat, $currentPageRiwayat + 1);

										if ($startRiwayat > 1) {
											$activeClassFirst = (1 == $currentPageRiwayat) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
											echo '<a href="' . $riwayat->appends(request()->query())->url(1) . '#riwayat" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $activeClassFirst . '">1</a>';
											if ($startRiwayat > 2) {
												echo '<span class="px-0.5 text-gray-400 text-[10px]">...</span>';
											}
										}

										for ($i = $startRiwayat; $i <= $endRiwayat; $i++) {
											$activeClass = ($i == $currentPageRiwayat) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
											echo '<a href="' . $riwayat->appends(request()->query())->url($i) . '#riwayat" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $activeClass . '">' . $i . '</a>';
										}

										if ($endRiwayat < $lastPageRiwayat) {
											if ($endRiwayat < $lastPageRiwayat - 1) {
												echo '<span class="px-0.5 text-gray-400 text-[10px]">...</span>';
											}
											$activeClassLast = ($lastPageRiwayat == $currentPageRiwayat) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
											echo '<a href="' . $riwayat->appends(request()->query())->url($lastPageRiwayat) . '#riwayat" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full text-[10px] sm:text-xs font-bold transition ' . $activeClassLast . '">' . $lastPageRiwayat . '</a>';
										}
									@endphp
								</div>

								{{-- Tombol Next --}}
								@if($riwayat->hasMorePages())
									<a href="{{ $riwayat->appends(request()->query())->nextPageUrl() }}"
										class="p-2.5 sm:p-3 rounded-full border bg-white text-xs flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
											<defs>
												<path id="SVG_riwayat_next" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG_riwayat_next" transform="rotate(-180 5.02 9.505)" />
										</svg>
									</a>
								@else
									<button type="button" disabled
										class="p-2.5 sm:p-3 rounded-full border text-xs flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
											<defs>
												<path id="SVG_riwayat_next" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG_riwayat_next" transform="rotate(-180 5.02 9.505)" />
										</svg>
									</button>
								@endif
							</div>{{-- end tombol paginasi --}}
						</div>{{-- end flex row --}}
					</div>{{-- end mt-6 --}}
				@endif

			</div>
		</div>

	</div>
@endsection