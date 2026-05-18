@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4">
	<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

		{{-- HEADER --}}
		<div class="lg:col-span-2 flex flex-col gap-1">
			<h1 class="text-4xl font-bold">Manajemen Peminjaman</h1>
			<p class="text-sm text-gray-500">
				Kelola seluruh proses peminjaman, pantau status, dan pastikan alur berjalan dengan lancar.
			</p>
		</div>

		{{-- CARD 1 --}}
		<div class="bg-white border border-gray-300 rounded-[20px] p-6 shadow-lg flex flex-col gap-4">
			{{-- HEADER --}}
			<div class="flex justify-between items-start gap-4">
				<h2 class="text-xl text-black font-bold">
					Peminjam menunggu persetujuan
				</h2>

				<svg xmlns="http://www.w3.org/2000/svg" 
				class="w-7 h-7 text-[#F99417] flex-shrink-0" 
				viewBox="0 0 24 24">
					<g fill="currentColor">
						<path d="M12 4a8 8 0 1 0 0 16a8 8 0 0 0 0-16M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12"/>
						<path d="M12 14a1 1 0 0 1-1-1V7a1 1 0 1 1 2 0v6a1 1 0 0 1-1 1m-1.5 2.5a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0"/>
					</g>
				</svg>
			</div>

			<div class="flex items-end gap-3">
				<span class="text-6xl font-bold text-[#363062]">{{ $stats['menunggu'] }}</span>
				<span class="text-sm text-gray-500 mb-2">Antrean</span>
			</div>

			<div class="flex items-center gap-3">
				<span class="px-3 py-1 text-white font-semibold bg-gradient-to-r from-[#F99417] to-[#F99417]/70 rounded-full text-xs">
					{{ $stats['total_alat'] }} Alat
				</span>
				<span class="text-xs text-gray-500">
					Dalam peminjaman
				</span>
			</div>
		</div>

		{{-- CARD 2 --}}
		<div class="bg-white border border-gray-300 rounded-[20px] p-6 shadow-lg flex flex-col gap-4">

			<h2 class="text-xl text-black font-bold">
				Dalam proses peminjaman
			</h2>

			<div class="flex items-end gap-3">
				<span class="text-6xl font-bold text-[#363062]">{{ $stats['dipinjam'] }}</span>
				<span class="text-sm text-gray-500 mb-2">Peminjaman</span>
			</div>

			<div class="flex items-center gap-3">
				<span class="text-xs text-gray-500">
					Alat & barang dalam peminjaman
				</span>
			</div>

		</div>

		{{-- SECTION LEFT --}}
		<div class="flex flex-col gap-4">

			<h2 class="text-3xl font-bold">
				Menunggu persetujuan
			</h2>

			{{-- TOP BAR --}}
			<div class="flex justify-between items-centerm">

				<div class="flex items-center gap-3 flex-wrap">

					<div class="relative w-52 h-full flex-shrink-0">
						<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
						</div>
						<input type="text" placeholder="Cari peminjam..." class="w-full h-full pl-10 pr-4 py-3 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
					</div>

					<button class="w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/></svg>
					</button>
				</div>

				<div class="flex items-center gap-3 flex-wrap">
					<a href="{{ route('admin-peminjaman-create') }}" class="px-4 py-3 flex items-center gap-2 border border-transparent text-white font-semibold rounded-full text-sm bg-[#363062] group hover:bg-transparent hover:text-[#363062] hover:border-[#363062] transition-all">
						Tambahkan Peminjaman

						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white group-hover:text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2"/></svg>
					</a>

				</div>
			</div>

			<div class="max-h-[400px] overflow-y-auto p-2 pr-2 flex flex-col gap-4">

				@forelse($menunggu as $data)
				{{-- CONTENT --}}
				<div class="bg-white border border-gray-300 rounded-[20px] p-4 shadow-lg">

					{{-- HEADER --}}
					<div class="flex items-start justify-between">
						<div class="flex items-center gap-3">
							<h3 class="text-2xl font-semibold">
								#{{ $data->kode_peminjaman }}
							</h3>

							<span class="px-3 py-1 rounded-full text-xs font-semibold {{ $data->status_badge }}">
								{{ $data->status_label }}
							</span>
						</div>

						<div class="flex items-center gap-2">
							<div class="w-8 h-8 rounded-full overflow-hidden">
								<img src="{{ asset('images/mygw.jpeg') }}" alt="user" class="w-full h-full object-cover">
							</div>
							<div class="text-sm">
								<p class="font-medium">{{ $data->peminjam->nama_lengkap }}</p>
								<p class="text-xs text-gray-500">{{ $data->detailPeminjaman->count() }} Alat</p>
							</div>
						</div>
					</div>

					<hr class="my-2 border-gray-500">

					{{-- BODY --}}
					<div class="flex flex-col gap-3">

						{{-- TOP ROW --}}
						<div class="flex justify-between items-start text-xs text-gray-500">
							<p class="text-sm text-black">
								Daftar alat / barang dipinjam:
							</p>

							<p class="whitespace-nowrap">
								Tanggal pengajuan: <span class="text-[#363062] font-semibold">{{ \Carbon\Carbon::parse($data->tanggal_pengajuan)->format('d - m - Y') }}</span>
							</p>
						</div>

						{{-- LIST --}}
						@foreach($data->detailPeminjaman as $detail)
						<div class="flex items-center justify-between gap-4">

							{{-- LEFT ITEM --}}
							<div class="flex items-center gap-3">
								<div class="w-12 h-12 rounded-xl border flex items-center justify-center overflow-hidden">
									<img 
										src="{{ asset('storage/' . $detail->alat->gambar) }}"
										alt="img"
										class="w-full h-full object-cover"
									>
								</div>

								<div>
									<p class="text-sm">{{ $detail->alat->nama_alat }} <span class="text-xs font-medium text-gray-500">×{{ $detail->jumlah }}</span></p>
									<div class="flex items-center gap-1">
										<div class="h-2 w-2 rounded-full" style="background: {{ $detail->alat->kategori->warna }}"></div>
										<p class="text-xs text-gray-500">{{ $detail->alat->kategori->nama_kategori }}</p>
									</div>
								</div>
							</div>

							{{-- RIGHT DURATION --}}
							<div class="text-right text-xs text-gray-500 whitespace-nowrap">
								<p>Durasi peminjaman - Sehari</p>
								<div class="flex items-center justify-end gap-1">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/><path d="M12 7v5l3 3"/></g></svg>
									<span class="font-semibold text-black">{{ $detail->alat->durasi }} Menit</span>
								</div>
							</div>

						</div>
						@endforeach

					</div>

					{{-- ACTION --}}
					<div class="flex justify-end gap-2 mt-4">
						<a href={{ route('admin-peminjaman-edit', $data) }} class="px-4 py-2 border border-transparent rounded-full bg-[#F99417] text-white text-sm hover:bg-white hover:text-[#F99417] hover:border-[#F99417] transition">
							Edit
						</a>
						<form action="{{ route('admin-peminjaman-destroy', $data) }}" method="POST" 
							onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/menghapus transaksi ini? Stok barang akan dikembalikan ke gudang.');">
							@csrf
							@method('DELETE')
							
							<button type="submit" 
									class="px-4 py-2 border border-transparent rounded-full text-sm bg-red-500 text-white hover:bg-white hover:text-red-500 hover:border-red-500 transition">
								Hapus
							</button>
						</form>
					</div>
				</div>
				@empty<p class="text-sm text-gray-500">
					Tidak ada data peminjaman.
				</p>
				@endforelse
			</div>

		</div>

	{{-- SECTION RIGHT --}}
		<div class="flex flex-col gap-4">

			<h2 class="text-3xl font-bold">
				Sedang dipinjam
			</h2>

			{{-- TOP BAR --}}
			<div class="flex justify-between items-centerm">

				<div class="flex items-center gap-3 flex-wrap">

					<div class="relative w-52 h-full flex-shrink-0">
						<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
						</div>
						<input type="text" placeholder="Cari peminjam..." class="w-full h-full pl-10 pr-4 py-3 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
					</div>

					<button class="w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/></svg>
					</button>
				</div>

				<div class="flex items-center gap-3 flex-wrap">
					<a href="{{ route('admin-peminjaman-create') }}" class="px-4 py-3 flex items-center gap-2 border border-transparent text-white font-semibold rounded-full text-sm bg-[#363062] group hover:bg-transparent hover:text-[#363062] hover:border-[#363062] transition-all">
						Tambahkan Peminjaman

						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white group-hover:text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2"/></svg>
					</a>

				</div>
			</div>

			<div class="max-h-[400px] overflow-y-auto p-2 pr-2 flex flex-col gap-4">

				@forelse($dipinjam as $data)
				{{-- CONTENT --}}

				<div class="bg-white border border-gray-300 rounded-[20px] p-4 shadow-lg">

					{{-- HEADER --}}
					<div class="flex items-start justify-between">
						<div class="flex items-center gap-3">
							<h3 class="text-2xl font-semibold">
								{{ $data->kode_peminjaman }}
							</h3>

							<span class="px-3 py-1 rounded-full text-xs font-semibold {{ $data->status_badge }}">
								{{ $data->status_label }}
							</span>
						</div>


						<div class="flex items-center gap-2">
							<div class="w-8 h-8 rounded-full overflow-hidden">
								@if($data->peminjam->foto_profil)
								<img 
									src="{{ asset('storage/' . $data->peminjam->foto_profil) }}" 
									alt="user" 
									class="w-full h-full object-cover"
								>
								@else
								<img 
									src="{{ asset('images/mygw.jpeg') }}" 
									alt="user" 
									class="w-full h-full object-cover"
								>
								@endif
							</div>
							<div class="text-sm">
								<p class="font-medium">{{ $data->peminjam->nama_lengkap }}</p>
								<p class="text-xs text-gray-500">{{ $data->detailPeminjaman->count() }} Alat</p>
							</div>
						</div>
					</div>

					<hr class="my-2 border-gray-500">

					{{-- BODY --}}
					<div class="flex flex-col gap-3">

						{{-- TOP ROW --}}
						<div class="flex justify-between items-start text-xs text-gray-500">
							<p class="text-sm text-black">
								Daftar alat / barang dipinjam:
							</p>

							<div class="flex flex-col text-right">
								<p class="whitespace-nowrap">
									Tanggal pengajuan:
									<span class="text-[#363062] font-semibold">
										{{ \Carbon\Carbon::parse($data->tanggal_pengajuan)->format('d - m - Y') }}
									</span>
								</p>
								@if($data->tanggal_disetujui)
								<p class="whitespace-nowrap">
									Waktu diterima:
									<span class="text-[#363062] font-semibold">
										{{ \Carbon\Carbon::parse($data->tanggal_disetujui)->format('H:i | d - m - Y') }}
									</span>
								</p>
								@endif
							</div>
						</div>

						{{-- LIST --}}
						@foreach($data->detailPeminjaman as $detail)
						<div class="flex items-center justify-between gap-4">

							{{-- LEFT ITEM --}}
							<div class="flex items-center gap-3">
								<div class="w-12 h-12 rounded-xl border flex items-center justify-center overflow-hidden">
									<img 
										src="{{ asset('storage/' . $detail->alat->gambar) }}" 
										alt="img" 
										class="w-full h-full object-cover"
									>
								</div>

								<div>
									<p class="text-sm">{{ $detail->alat->nama_alat }} <span class="text-xs font-medium text-gray-500">×{{ $detail->jumlah }}</span></p>
									<div class="flex items-center gap-1">
										<div class="h-2 w-2 rounded-full" style="background: {{ $detail->alat->kategori->warna }}"></div>
										<p class="text-xs text-gray-500">{{ $detail->alat->kategori->nama_kategori }}</p>
									</div>
								</div>
							</div>

							{{-- RIGHT DURATION --}}
							<div class="text-right text-xs text-gray-500 whitespace-nowrap">
								<p>Durasi peminjaman - {{ $detail->alat->durasi }} Menit</p>
								
								@php
									$hasDeadline = !is_null($data->deadline);
									$deadline = $hasDeadline
										? \Carbon\Carbon::parse($data->deadline)
										: null;
								@endphp

								{{-- JIKA DEADLINE MASIH KOSONG (KARENA STATUS ITEM MASIH MENUNGGU) --}}
								@if(!$hasDeadline)
									<span class="font-semibold text-yellow-600">
										Menunggu Persetujuan
									</span>

								{{-- JIKA DEADLINE SUDAH LEWAT --}}
								@elseif($deadline->isPast())
									<span class="font-semibold text-red-500">
										Terlambat
									</span>

								{{-- JIKA DEADLINE MASIH JALAN --}}
								@else
									<span class="font-semibold text-black">
										<div x-data="{
												deadline: new Date('{{ $deadline->toIso8601String() }}').getTime(),
												timeLeft: '',
												expired: false,

												init() {
													const update = () => {
														const now = new Date().getTime();
														const distance = this.deadline - now;

														if (distance <= 0) {
															this.timeLeft = 'Terlambat';
															this.expired = true;
															return;
														}

														const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
														const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
														const seconds = Math.floor((distance % (1000 * 60)) / 1000);

														this.timeLeft = 
															String(hours).padStart(2, '0') + ':' +
															String(minutes).padStart(2, '0') + ':' +
															String(seconds).padStart(2, '0');
													};

													update();
													setInterval(update, 1000);
												}
											}"
											class="font-semibold"
											:class="expired ? 'text-red-500' : 'text-black'"
										>
											<span x-text="timeLeft"></span>
										</div>
									</span>
								@endif
							</div>

						</div>
						@endforeach

					</div>

					{{-- ACTION --}}
					<div class="flex justify-end gap-2 mt-4">
						<a href={{ route('admin-peminjaman-edit', $data) }} class="px-4 py-2 border border-transparent rounded-full bg-[#F99417] text-white text-sm hover:bg-white hover:text-[#F99417] hover:border-[#F99417] transition">
							Edit
						</a>
						<form action="{{ route('admin-peminjaman-destroy', $data) }}" method="POST" 
							onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/menghapus transaksi ini? Stok barang akan dikembalikan ke gudang.');">
							@csrf
							@method('DELETE')
							
							<button type="submit" 
									class="px-4 py-2 border border-transparent rounded-full text-sm bg-red-500 text-white hover:bg-white hover:text-red-500 hover:border-red-500 transition">
								Hapus
							</button>
						</form>
					</div>
				</div>
				@empty<p class="text-sm text-gray-500">
					Tidak ada data peminjaman.
				</p>
				@endforelse
			</div>
		</div>

		{{-- SECTION BAWAH: HISTORI PEMINJAMAN --}}
		<div class="lg:col-span-2 flex flex-col gap-4 mt-8 pt-8 border-t-2 border-gray-200">
			
			<div class="flex flex-col gap-1">
				<h2 class="text-3xl font-bold">
					Histori Peminjaman
				</h2>
				<p class="text-sm text-gray-500">
					Daftar transaksi peminjaman yang telah selesai atau pengajuan yang ditolak.
				</p>
			</div>

			{{-- PLACEHOLDER UNTUK SEARCH BAR & FILTER --}}
			<div class="w-full h-14 border border-gray-400 border-dashed rounded-full flex items-center justify-center bg-gray-50 mb-2">
				<p class="text-sm text-gray-400 italic">
					-- Tempat Search Bar dan Filter --
				</p>
			</div>

			{{-- KONTENER CARD --}}
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
				
				@forelse($riwayat as $data)
				{{-- CONTENT CARD --}}
				<div class="bg-white border border-gray-300 rounded-[20px] p-5 shadow-sm hover:shadow-lg transition-shadow duration-300 flex flex-col justify-between">
					
					<div class="flex flex-col gap-3">
						{{-- HEADER CARD --}}
						<div class="flex items-start justify-between">
							<div class="flex flex-col gap-1">
								<h3 class="text-2xl font-semibold">
									{{ $data->kode_peminjaman }}
								</h3>

								<div class="flex items-center">
									<span class="px-3 py-1 rounded-full text-xs font-bold border {{ $data->status_badge }}">
										{{ $data->status_label }}
									</span>
								</div>
							</div>

							<div class="flex items-center gap-3">
								<div class="text-right text-sm">
									<p class="font-medium text-black">{{ $data->peminjam->nama_lengkap }}</p>
									<p class="text-xs text-gray-500">{{ $data->detailPeminjaman->count() }} Item</p>
								</div>
								<div class="w-10 h-10 rounded-full overflow-hidden border border-gray-200">
									@if($data->peminjam->foto_profil)
										<img src="{{ asset('storage/' . $data->peminjam->foto_profil) }}" alt="user" class="w-full h-full object-cover">
									@else
										<img src="{{ asset('images/mygw.jpeg') }}" alt="user" class="w-full h-full object-cover">
									@endif
								</div>
							</div>
						</div>

						<hr class="border-gray-200">

						{{-- DATES INFO --}}
						<div class="flex justify-between items-start text-xs text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100">
							<div class="flex flex-col gap-1">
								<p>Tgl Pengajuan:</p>
								<span class="text-black font-semibold">{{ \Carbon\Carbon::parse($data->tanggal_pengajuan)->format('d - m - Y') }}</span>
							</div>
							<div class="flex flex-col gap-1 text-right">
								<p>{{ $data->status == 'selesai' ? 'Tgl Dikembalikan:' : 'Tgl Ditolak:' }}</p>
								<span class="font-semibold {{ $data->status == 'selesai' ? 'text-green-600' : 'text-red-600' }}">
									{{ \Carbon\Carbon::parse($data->updated_at)->format('H:i | d - m - Y') }}
								</span>
							</div>
						</div>

						{{-- LIST ITEM --}}
						<div class="flex flex-col gap-2 max-h-[160px] overflow-y-auto pr-2">
							@foreach($data->detailPeminjaman as $detail)
							<div class="flex items-center justify-between gap-3">
								<div class="flex items-center gap-3">
									<div class="w-10 h-10 rounded-lg border flex items-center justify-center overflow-hidden">
										<img src="{{ asset('storage/' . $detail->alat->gambar) }}" alt="img" class="w-full h-full object-cover">
									</div>
									<div>
										<p class="text-sm text-black font-medium">{{ $detail->alat->nama_alat }} <span class="text-xs text-gray-500">×{{ $detail->jumlah }}</span></p>
										<div class="flex items-center gap-1">
											<div class="h-1.5 w-1.5 rounded-full" style="background: {{ $detail->alat->kategori->warna }}"></div>
											<p class="text-[10px] text-gray-500">{{ $detail->alat->kategori->nama_kategori }}</p>
										</div>
									</div>
								</div>
								
								<div class="text-right text-xs text-gray-500">
									<p>{{ $detail->alat->durasi }} Menit</p>
								</div>
							</div>
							@endforeach
						</div>
					</div>

					{{-- ACTION --}}
					<div class="flex justify-end gap-2 mt-4 pt-4 border-t border-gray-100">
						{{-- EDIT --}}
						<a
							href="{{ route('admin-peminjaman-edit', $data->kode_peminjaman) }}"
							class="px-5 py-2 border border-[#F99417] text-[#F99417] rounded-full text-sm font-semibold hover:bg-[#F99417] hover:text-white transition"
						>
							Edit
						</a>

						{{-- DELETE --}}
						<form
							action="{{ route('admin-peminjaman-destroy', $data->kode_peminjaman) }}"
							method="POST"
							onsubmit="return confirm('Yakin ingin menghapus histori ini?')"
						>
							@csrf
							@method('DELETE')

							<button
								type="submit"
								class="px-5 py-2 border border-red-500 text-red-500 rounded-full text-sm font-semibold hover:bg-red-500 hover:text-white transition"
							>
								Hapus
							</button>
						</form>
					</div>
					
				</div>
				@empty
				<div class="col-span-1 lg:col-span-2 py-10 flex flex-col items-center justify-center bg-gray-50 rounded-[20px] border border-dashed border-gray-300">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-2" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0a9 9 0 0 1 18 0"/></svg>
					<p class="text-sm text-gray-500">Belum ada histori peminjaman.</p>
				</div>
				@endforelse

			</div>

			{{-- PAGINATION --}}
			@if($riwayat->hasPages())
			<div class="mt-4 w-full flex justify-center">
				{{ $riwayat->links() }}
			</div>
			@endif

		</div>
	</div>

</div>
@endsection