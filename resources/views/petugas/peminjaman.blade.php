@extends('layouts.app')

@section('content')
<div class="mx-auto py-12">
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-stretch">

		<div class="lg:col-span-3 flex flex-col gap-1 mb-2">
			<h1 class="text-4xl font-bold">Manajemen Peminjaman</h1>
			<p class="text-sm font-medium text-gray-500">
				Kelola antrean persetujuan, pantau alat yang sedang dipinjam, dan periksa log aktivitas secara real-time.
			</p>
		</div>

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

			<span class="text-5xl font-bold">33</span>
			<p class="text-xs font-medium text-gray-500">Pengajuan baru yang perlu di-review</p>
		</div>

		<div class="p-4 border-b-2 border-black rounded-[20px] bg-[#F5F5F5] flex flex-col justify-between shadow-lg gap-2">
			<div class="flex justify-between items-center">
				<h3 class="font-bold text-2xl">Total Alat Dipinjam</h3>
				<div class="flex items-center gap-1.5">
					<div class="w-1.5 h-1.5 bg-[#F99417] rounded-full"></div>
					<span class="text-xs font-bold text-gray-800">Hari ini</span>
				</div>
			</div>
			<span class="text-5xl font-bold">12</span>
			<p class="text-xs font-medium text-gray-500">Item dalam peminjaman</p>
		</div>

		<div class="p-4 rounded-[20px] bg-gradient-to-r from-[#363062] to-[#4D4C7D] flex flex-col items-center justify-center gap-2 shadow-lg">
			<h3 class="font-bold text-xs tracking-widest uppercase text-white">Time<span class="text-[#F99417]">stamp</span></h3>
			<span class="text-5xl font-bold text-white tracking-wider font-mono">14 : 54 : <span class="text-[#F99417]">12</span></span>
		</div>

		{{-- baris2 & baris3 (Digabungkan dalam struktur kolom vertikal) --}}

		<div class="lg:col-span-1 flex flex-col gap-4">

			<div class="relative w-full">
				<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
					<svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
					</svg>
				</div>
				<input type="text" placeholder="Cari peminjam..." class="w-full pl-10 pr-4 py-3 border-2 border-gray-800 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow bg-white">
			</div>

			<div class="p-5 border-2 border-gray-800 rounded-[20px] bg-white flex flex-col gap-4 min-h-[400px]">

				<div class="flex flex-col gap-2 mb-2">
					<h2 class="text-2xl font-bold text-gray-900">Antrean peminjaman</h2>
					<hr class="border-t-2 border-gray-200">
				</div>

				<div class="flex flex-col gap-3">

					<div class="flex items-center gap-3 w-full">
						<div class="w-12 h-12 rounded-full border-2 border-gray-800 flex-shrink-0 bg-gray-100 overflow-hidden">
						</div>
						<div class="flex-1 flex justify-between items-center border-2 border-gray-800 rounded-xl px-4 py-3">
							<span class="font-bold text-gray-800 text-sm">Budi Tarmiji</span>
							<div class="flex items-center gap-1.5">
								<div class="w-1.5 h-1.5 bg-gray-800 rounded-full"></div>
								<span class="text-[10px] font-bold text-gray-600">3 Items</span>
							</div>
						</div>
					</div>

					<div class="flex items-center gap-3 w-full">
						<div class="w-12 h-12 rounded-full border-2 border-gray-800 flex-shrink-0 bg-gray-100 overflow-hidden"></div>
						<div class="flex-1 flex justify-between items-center border-2 border-gray-800 rounded-xl px-4 py-3">
							<span class="font-bold text-gray-800 text-sm">Ochaskulll</span>
							<div class="flex items-center gap-1.5">
								<div class="w-1.5 h-1.5 bg-gray-800 rounded-full"></div>
								<span class="text-[10px] font-bold text-gray-600">3 Items</span>
							</div>
						</div>
					</div>

					<div class="flex items-center gap-3 w-full">
						<div class="w-12 h-12 rounded-full border-2 border-gray-800 flex-shrink-0 bg-gray-100 overflow-hidden"></div>
						<div class="flex-1 flex justify-between items-center border-2 border-gray-800 rounded-xl px-4 py-3">
							<span class="font-bold text-gray-800 text-sm">Agnes Tachyon</span>
							<div class="flex items-center gap-1.5">
								<div class="w-1.5 h-1.5 bg-gray-800 rounded-full"></div>
								<span class="text-[10px] font-bold text-gray-600">3 Items</span>
							</div>
						</div>
					</div>

				</div>

			</div>
		</div>

		<div class="lg:col-span-2 flex flex-col gap-4">

			<div class="flex gap-4">

				<button class="w-[52px] h-[52px] rounded-full border-2 border-gray-800 flex items-center justify-center bg-white hover:bg-gray-100 flex-shrink-0 transition-colors" title="Filter">
					<svg class="w-5 h-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
					</svg>
				</button>

				<div class="relative w-full max-w-sm">
					<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
						<svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
						</svg>
					</div>
					<input type="text" placeholder="Cari ID Peminjaman..." class="w-full pl-10 pr-4 py-3 border-2 border-gray-800 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow bg-white">
				</div>
			</div>

			<div class="p-4 border-2 border-gray-800 rounded-[20px] bg-white flex flex-col flex-1 min-h-[400px]">
			</div>
		</div>

	</div>
</div>
@endsection