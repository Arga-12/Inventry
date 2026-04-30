@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4 h-screen">
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-stretch">

		<div class="lg:col-span-3 flex flex-col gap-1 mb-2">
			<h1 class="text-4xl font-bold">Laporan Peminjaman</h1>
			<p class="text-sm font-medium text-gray-500">
				Kelola dan cetak laporan peminjaman alat berdasarkan periode tertentu dengan data yang terstruktur dan siap arsip.
			</p>
		</div>

		{{-- KOLOM 1: Total Peminjaman & Diagram (col-span-2) --}}
		<div class="lg:col-span-2 h-full">
			<div class="h-full w-full bg-white border-b-2 border-black shadow-lg rounded-[20px] flex flex-col justify-between p-6 gap-4">

				<div class="flex flex-col w-full">
					{{-- Header & Total Angka --}}
					<div class="flex justify-between items-start w-full">
						<div class="flex flex-col items-start gap-1">
							<h2 class="font-bold text-2xl text-gray-800">Total Peminjaman & Pengembalian diatasi</h2>
							<p class="text-sm font-medium text-gray-500">Total peminjaman anda berdasarkan tiap kategori</p>
						</div>

						<div class="flex items-baseline gap-1">
							<h2 class="font-bold text-5xl text-gray-900">145</h2>
						</div>
					</div>

					{{-- Diagram Garis (Progress Bar) --}}
					<div class="w-full h-2 rounded-full overflow-hidden flex mt-8">
						<div class="h-full bg-[#363062]" style="width: 45%"></div>
						<div class="h-full bg-[#4D4C7D]" style="width: 25%"></div>
						<div class="h-full bg-[#F99417]" style="width: 30%"></div>
					</div>

					{{-- Legend Diagram --}}
					<div class="flex items-center gap-5 mt-4 text-sm font-medium text-gray-600">
						<div class="flex items-center gap-2">
							<span class="w-3 h-3 rounded-full bg-[#363062]"></span>
							<span>Kategori 1</span>
						</div>
						<div class="flex items-center gap-2">
							<span class="w-3 h-3 rounded-full bg-[#4D4C7D]"></span>
							<span>Kategori 2</span>
						</div>
						<div class="flex items-center gap-2">
							<span class="w-3 h-3 rounded-full bg-[#F99417]"></span>
							<span>Kategori 3</span>
						</div>
					</div>
				</div>

			</div>
		</div>

		{{-- KOLOM 2: Rincian Peminjaman & Pengembalian (col-span-1) --}}
		<div class="lg:col-span-1 h-full">
			<div class="h-full w-full bg-white border-b-2 border-black shadow-lg rounded-[20px] flex flex-col justify-between p-6 gap-6">

				{{-- Angka Peminjaman & Pengembalian --}}
				<div class="grid grid-cols-2 w-full">
					<div class="flex flex-col gap-1">
						<span class="font-bold text-[#363062] text-xl">Peminjaman</span>
						<span class="text-5xl font-bold text-gray-900 mt-1">12</span>
					</div>

					<div class="flex flex-col gap-1 items-start">
						<span class="font-bold text-[#363062] text-xl">Pengembalian</span>
						<span class="text-5xl font-bold text-gray-900 mt-1">3</span>
					</div>
				</div>

				{{-- Footer Info (Hari ini) --}}
				<div class="flex items-center justify-center gap-4 w-full mt-auto pt-4 border-t border-gray-500">
					<span class="font-medium text-gray-500 leading-tight">
						Peminjaman & Pengembalian dilakukan pada:
					</span>
					<div class="px-3 py-1.5 bg-[#F99417] rounded-full text-xs text-white font-bold whitespace-nowrap">
						Hari ini
					</div>
				</div>

			</div>
		</div>

		{{-- CARD TABEL + FILTER --}}
		<div class="lg:col-span-3 w-full">
			<div class="w-full flex flex-col gap-6">

				{{-- TOP BAR (FILTER + EXPORT) --}}
				<div class="flex items-center justify-between gap-4 flex-wrap">

					<div class="flex items-center gap-3 flex-wrap">
						<button class="flex items-center gap-2 h-11 px-4 border border-[#363062] rounded-full text-sm font-medium bg-white text-[#363062] hover:bg-gray-100">
							<span>Sepanjang waktu</span>

							<svg xmlns="http://www.w3.org/2000/svg" 
							class="w-4 h-4"
							viewBox="0 0 1024 1024">
							<path fill="currentColor" d="M831.9 340.9L512 652.7L192.1 340.9a30.6 30.6 0 0 0-42.7 0a29 29 0 0 0 0 41.6l340.3 331.7a32 32 0 0 0 44.6 0l340.3-331.7a29 29 0 0 0 0-41.7a30.6 30.6 0 0 0-42.7 0z"/>
						</svg>
					</button>

					<div class="relative w-52 h-full flex-shrink-0">
						<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
						</div>
						<input type="text" placeholder="Cari peminjam..." class="w-full h-full pl-10 pr-4 py-3 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow bg-[#F5F5F5]">
					</div>

					<button class="w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/></svg>
					</button>
				</div>

				{{-- KANAN --}}
				<div class="flex items-center gap-3 flex-wrap">
					<button class="px-4 py-3 border border-[#363062] text-[#363062] rounded-full text-sm font-medium bg-white hover:bg-gray-100">
						Export PDF
					</button>

					<button class="px-4 py-3 border border-[#363062] text-[#363062] rounded-full text-sm font-medium bg-white hover:bg-gray-100">
						Export Excel
					</button>
				</div>

			</div>

			<div class="w-full overflow-x-auto">

				<table class="w-full text-sm border-collapse">

					{{-- HEADER --}}
					<thead>
						<tr class="bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white">
							<th class="py-3 px-4 text-left w-12 rounded-tl-[20px]">No</th>
							<th class="py-3 px-4 text-left">ID</th>
							<th class="py-3 px-4 text-left">Nama Peminjam</th>
							<th class="py-3 px-4 text-left">Tgl Pinjam</th>
							<th class="py-3 px-4 text-left">Tgl Kembali (Seluruh Item)</th>
							<th class="py-3 px-4 text-left">Jumlah alat / barang dipinjam</th>
							<th class="py-3 px-4 text-left rounded-tr-[20px]">Status</th>
						</tr>
					</thead>

					{{-- BODY --}}
					<tbody class="text-gray-800">

						{{-- ROW --}}
						<tr class="border-b border-gray-400">
							<td class="py-3 px-4">1.</td>
							<td class="py-3 px-4">Pasokon</td>
							<td class="py-3 px-4">Komputer</td>
							<td class="py-3 px-4">45 Menit</td>
							<td class="py-3 px-4">45 Menit</td>
							<td class="py-3 px-4">
								<span class="px-3 py-1 text-xs rounded-lg bg-gray-500 text-white">
									12 Tersisa
								</span>
							</td>
							<td class="py-3 px-4 text-left">2 Alat</td>
						</tr>

						{{-- EMPTY STATE --}}
						<tr>
							<td colspan="6" class="text-center py-10 text-gray-400">
								Belum ada data
							</td>
						</tr>

					</tbody>

				</table>
			</div>
		</div>
	</div>

</div>
</div>
@endsection