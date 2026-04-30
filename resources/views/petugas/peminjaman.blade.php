@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4 h-screen flex flex-col overflow-hidden">
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-stretch flex-1 min-h-0 mb-6 h-screen">

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

		<div class="lg:col-span-1 flex flex-col min-h-0 gap-4 h-full">

			<div class="relative w-full h-[52px] flex-shrink-0">
				<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
				</div>
				<input type="text" placeholder="Cari peminjam..." class="w-full h-full pl-10 pr-4 py-3 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow bg-[#F5F5F5]">
			</div>

			<div class="p-4 rounded-[20px] bg-white shadow-lg border border-gray-300 flex flex-col gap-4 h-full">

				<div class="flex flex-col gap-2 mb-2">
					<h2 class="text-2xl font-bold text-gray-900">Antrean peminjaman</h2>
					<hr class="border-t border-gray-500 -mx-4">
				</div>

				<div class="flex-1 overflow-y-auto flex flex-col gap-4 custom-scrollbar min-h-0">

					<div class="flex items-center gap-3 w-full">
						<div class="w-12 h-12 rounded-full border border-gray-300 flex-shrink-0 bg-gray-100 shadow-sm overflow-hidden">
							<img src="{{ asset('images/mygw.jpeg') }}" alt="" class="w-full h-full object-cover">
						</div>
						<div class="transition-all duration-300 flex-1 flex justify-between items-center rounded-full bg-[#363062] px-4 py-3 border border-transparent group hover:bg-transparent hover:border-[#363062]">
							<span class="transition-colors duration-300 font-bold text-white text-sm group-hover:text-[#363062]">Budi Tarmiji</span>
							<div class="flex items-center gap-1.5">
								<div class="transition-colors duration-300 w-1.5 h-1.5 bg-[#F99417] rounded-full group-hover:bg-[#363062]"></div>
								<span class="transition-colors duration-300 text-[10px] font-bold text-white group-hover:text-[#363062]">3 Items</span>
							</div>
						</div>
					</div>

					<div class="flex items-center gap-3 w-full">
						<div class="w-12 h-12 rounded-full border border-gray-300 flex-shrink-0 bg-gray-100 shadow-sm overflow-hidden">
							<img src="{{ asset('images/mygw.jpeg') }}" alt="" class="w-full h-full object-cover">
						</div>
						<div class="transition-all duration-300 flex-1 flex justify-between items-center rounded-full bg-[#363062] px-4 py-3 border border-transparent group hover:bg-transparent hover:border-[#363062]">
							<span class="transition-colors duration-300 font-bold text-white text-sm group-hover:text-[#363062]">Ochaskulll</span>
							<div class="flex items-center gap-1.5">
								<div class="transition-colors duration-300 w-1.5 h-1.5 bg-[#F99417] rounded-full group-hover:bg-[#363062]"></div>
								<span class="transition-colors duration-300 text-[10px] font-bold text-white group-hover:text-[#363062]">3 Items</span>
							</div>
						</div>
					</div>

					<div class="flex items-center gap-3 w-full">
						<div class="w-12 h-12 rounded-full border border-gray-300 flex-shrink-0 bg-gray-100 shadow-sm overflow-hidden">
							<img src="{{ asset('images/mygw.jpeg') }}" alt="" class="w-full h-full object-cover">
						</div>
						<div class="transition-all duration-300 flex-1 flex justify-between items-center rounded-full bg-[#363062] px-4 py-3 border border-transparent group hover:bg-transparent hover:border-[#363062]">
							<span class="transition-colors duration-300 font-bold text-white text-sm group-hover:text-[#363062]">Agnes Tachyon</span>
							<div class="flex items-center gap-1.5">
								<div class="transition-colors duration-300 w-1.5 h-1.5 bg-[#F99417] rounded-full group-hover:bg-[#363062]"></div>
								<span class="transition-colors duration-300 text-[10px] font-bold text-white group-hover:text-[#363062]">3 Items</span>
							</div>
						</div>
					</div>

				</div>


			</div>
		</div>

		<div class="lg:col-span-2 flex flex-col min-h-0 gap-4 h-full">

			{{-- Search Bar & Filter (Tetap di atas, tidak ikut scroll) --}}
			<div class="flex gap-4 items-center h-[52px] flex-shrink-0">
				<button class="w-[52px] h-[52px] rounded-full border border-gray-300 flex items-center justify-center bg-[#F5F5F5] hover:bg-gray-100 flex-shrink-0 transition-colors">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/></svg>
				</button>

				<div class="relative w-full h-full">
					<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
					</div>
					<input type="text" placeholder="Cari nama alat..." class="w-full h-full pl-10 pr-4 py-3 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow bg-[#F5F5F5]">
				</div>
			</div>

			{{-- Main Card --}}
			<div class="p-4 border border-gray-300 rounded-[20px] bg-white shadow-lg flex flex-col flex-1 overflow-hidden h-full">

				{{-- Header Card (ID & Tgl) - Flex-shrink-0 supaya tidak ikut tergulung --}}
				<div class="flex flex-col flex-shrink-0">
					<div class="flex justify-between items-start mb-2">
						<h2 class="text-2xl font-bold text-gray-900">#INVT-2604-003</h2>
						<div class="text-right text-xs font-medium text-gray-600">
							<p>ID User: 23</p>
							<p>28 - 04 - 2026</p>
						</div>
					</div>
					<hr class="border-t border-gray-500 -mx-4 mb-2">
				</div>

				{{-- SCROLL AREA: Gabungkan Daftar Item & Durasi di SINI --}}
				<div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col pr-2 min-h-0">

					{{-- Bagian Daftar Barang --}}
					<div class="flex flex-col gap-5 mb-8">
						<h3 class="font-bold text-gray-800 text-lg">Daftar alat dan barang peminjaman:</h3>

						{{-- Item 1 --}}
						<div class="flex justify-between items-center w-full">
							<div class="flex items-center gap-4">
								<div class="w-14 h-14 rounded-xl border border-gray-300 bg-gray-50 flex-shrink-0 overflow-hidden">
									<img src="{{ asset('images/id1.jpg') }}" alt="" class="w-full h-full object-cover">									
								</div>
								<div class="flex flex-col">
									<span class="font-bold text-gray-900 text-base">Keyboard Mechanical <span class="font-normal text-sm text-gray-600">x3</span></span>
									<div class="flex gap-2 items-center">
										<span class="text-xs font-medium text-gray-500">Oleh: Admin Inventry</span>
										<div class="flex items-center gap-2 px-3 py-1 bg-[#F99417]/50 text-white rounded-full shadow-sm">
											<span class="text-[10px] font-bold whitespace-nowrap">12 Tersisa</span>

											<!-- SVG Panah dari kamu -->
											<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 flex-shrink-0" viewBox="0 0 24 24">
												<g fill="none">
													<path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/>
													<path fill="currentColor" d="m14.707 5.636l5.657 5.657a1 1 0 0 1 0 1.414l-5.657 5.657a1 1 0 0 1-1.414-1.414l3.95-3.95H4a1 1 0 1 1 0-2h13.243l-3.95-3.95a1 1 0 1 1 1.414-1.414"/>
												</g>
											</svg>

											<span class="text-[10px] font-bold text-red-700 whitespace-nowrap">9 Tersisa</span>
										</div>
									</div>
								</div>
							</div>
							<div class="flex flex-col items-end gap-1">
								<span class="text-xs font-bold text-gray-500">Utility Desktop</span>
								<div class="flex items-center gap-1.5 font-bold text-gray-800">
									<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
									<span class="text-base">45 Menit</span>
								</div>
							</div>
						</div>

						<div class="flex justify-between items-center w-full">
							<div class="flex items-center gap-4">
								<div class="w-14 h-14 rounded-xl border border-gray-300 bg-gray-50 flex-shrink-0 overflow-hidden">
									<img src="{{ asset('images/id1.jpg') }}" alt="" class="w-full h-full object-cover">									
								</div>
								<div class="flex flex-col">
									<span class="font-bold text-gray-900 text-base">Keyboard Mechanical <span class="font-normal text-sm text-gray-600">x3</span></span>
									<div class="flex gap-2 items-center">
										<span class="text-xs font-medium text-gray-500">Oleh: Admin Inventry</span>
										<div class="flex items-center gap-2 px-3 py-1 bg-[#F99417]/50 text-white rounded-full shadow-sm">
											<span class="text-[10px] font-bold whitespace-nowrap">12 Tersisa</span>

											<!-- SVG Panah dari kamu -->
											<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 flex-shrink-0" viewBox="0 0 24 24">
												<g fill="none">
													<path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/>
													<path fill="currentColor" d="m14.707 5.636l5.657 5.657a1 1 0 0 1 0 1.414l-5.657 5.657a1 1 0 0 1-1.414-1.414l3.95-3.95H4a1 1 0 1 1 0-2h13.243l-3.95-3.95a1 1 0 1 1 1.414-1.414"/>
												</g>
											</svg>

											<span class="text-[10px] font-bold text-red-700 whitespace-nowrap">9 Tersisa</span>
										</div>
									</div>
								</div>
							</div>
							<div class="flex flex-col items-end gap-1">
								<span class="text-xs font-bold text-gray-500">Utility Desktop</span>
								<div class="flex items-center gap-1.5 font-bold text-gray-800">
									<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
									<span class="text-base">45 Menit</span>
								</div>
							</div>
						</div>

						<div class="flex justify-between items-center w-full">
							<div class="flex items-center gap-4">
								<div class="w-14 h-14 rounded-xl border border-gray-300 bg-gray-50 flex-shrink-0 overflow-hidden">
									<img src="{{ asset('images/id1.jpg') }}" alt="" class="w-full h-full object-cover">									
								</div>
								<div class="flex flex-col">
									<span class="font-bold text-gray-900 text-base">Keyboard Mechanical <span class="font-normal text-sm text-gray-600">x3</span></span>
									<div class="flex gap-2 items-center">
										<span class="text-xs font-medium text-gray-500">Oleh: Admin Inventry</span>
										<div class="flex items-center gap-2 px-3 py-1 bg-[#F99417]/50 text-white rounded-full shadow-sm">
											<span class="text-[10px] font-bold whitespace-nowrap">12 Tersisa</span>

											<!-- SVG Panah dari kamu -->
											<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 flex-shrink-0" viewBox="0 0 24 24">
												<g fill="none">
													<path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/>
													<path fill="currentColor" d="m14.707 5.636l5.657 5.657a1 1 0 0 1 0 1.414l-5.657 5.657a1 1 0 0 1-1.414-1.414l3.95-3.95H4a1 1 0 1 1 0-2h13.243l-3.95-3.95a1 1 0 1 1 1.414-1.414"/>
												</g>
											</svg>

											<span class="text-[10px] font-bold text-red-700 whitespace-nowrap">9 Tersisa</span>
										</div>
									</div>
								</div>
							</div>
							<div class="flex flex-col items-end gap-1">
								<span class="text-xs font-bold text-gray-500">Utility Desktop</span>
								<div class="flex items-center gap-1.5 font-bold text-gray-800">
									<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
									<span class="text-base">45 Menit</span>
								</div>
							</div>
						</div>

						{{-- Tambahkan item lainnya di sini... --}}
					</div>

					{{-- Bagian Durasi & Catatan (Sekarang berada di dalam scroll) --}}
					<div class="flex-shrink-0 pt-4 border-t border-dashed border-gray-500">
						<h4 class="font-bold text-lg mb-3">Durasi peminjaman (Hari)</h4>

						<div class="flex flex-col gap-2 mb-6">
							<div class="flex justify-between items-center text-sm">
								<span class="text-gray-500">Nama Barang <span class="text-xs font-medium ml-1">x1</span></span>
								<span class="font-medium">Sehari</span>
							</div>
							<div class="flex justify-between items-center text-sm">
								<span class="text-gray-500">Kamera Sony <span class="text-xs font-medium ml-1">x1</span></span>
								<span class="font-medium">Sehari</span>
							</div>
						</div>
						
					</div>

				</div>

				{{-- Footer Card (Tombol) - Flex-shrink-0 supaya tetap terlihat di bawah --}}
				<div class="flex-shrink-0 -mx-4 px-4 mt-4 pt-4 border-t border-gray-500 flex gap-4">
					<button class="flex-1 py-3 border-2 border-gray-800 rounded-full font-bold text-gray-800 bg-white hover:bg-gray-100 transition-colors">
						Batalkan Peminjaman
					</button>
					<button class="flex-1 py-3 border-2 border-transparent bg-[#363062] text-white rounded-full font-bold hover:bg-[#4D4C7D] transition-colors shadow-md">
						Setujui Peminjaman
					</button>
				</div>

			</div>
		</div>

	</div>
</div>
@endsection