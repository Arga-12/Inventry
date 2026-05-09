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
					Peminjam menunggu penerimaan
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
			<span class="text-6xl font-bold text-[#363062]">12</span>
			<span class="text-sm text-gray-500 mb-2">Peminjam</span>
		</div>

		<div class="flex items-center gap-3">
			<span class="px-3 py-1 text-white font-semibold bg-gradient-to-r from-[#F99417] to-[#F99417]/70 rounded-full text-xs">
				34 Alat
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
			<span class="text-6xl font-bold text-[#363062]">20</span>
			<span class="text-sm text-gray-500 mb-2">Peminjaman</span>
		</div>

		<div class="flex items-center gap-3">
			<span class="px-3 py-1 text-white font-semibold bg-gradient-to-r from-[#363062] to-[#4D4C7D]/70 rounded-full text-xs">
				7 Kategori
			</span>
			<span class="text-xs text-gray-500">
				Alat & barang dalam peminjaman
			</span>
		</div>

	</div>

	{{-- SECTION LEFT --}}
	<div class="flex flex-col gap-4">

		<h2 class="text-3xl font-bold">
			Menunggu Penerimaan
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
				<button class="px-4 py-3 flex items-center gap-2 border border-transparent text-white font-semibold rounded-full text-sm bg-[#363062] group hover:bg-transparent hover:text-[#363062] hover:border-[#363062] transition-all">
					Tambahkan Peminjaman

					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white group-hover:text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2"/></svg>
				</button>

			</div>
		</div>

		<div class="max-h-[400px] overflow-y-auto pr-2 flex flex-col gap-4">

			@for ($i = 0; $i < 3; $i++)
			{{-- CONTENT --}}
			<div class="bg-white border border-gray-300 rounded-[20px] p-4 shadow-lg">

				{{-- HEADER --}}
				<div class="flex items-start justify-between">
					<div class="flex items-center gap-3">
						<h3 class="text-2xl font-semibold">
							#INVT-2605-006
						</h3>

						<span class="px-3 py-1 rounded-full bg-yellow-100 text-[#F99417] text-xs font-semibold">
							Menunggu
						</span>
					</div>

					<div class="flex items-center gap-2">
						<div class="w-8 h-8 rounded-full overflow-hidden">
							<img src="{{ asset('images/mygw.jpeg') }}" alt="user" class="w-full h-full object-cover">
						</div>
						<div class="text-sm">
							<p class="font-medium">Budi Tarmiji</p>
							<p class="text-xs text-gray-500">3 Item</p>
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
							Tanggal pengajuan: <span class="text-[#363062] font-semibold">5 - 5 - 2026</span>
						</p>
					</div>

					{{-- LIST --}}
					@for ($j = 0; $j < 3; $j++)
					<div class="flex items-center justify-between gap-4">

						{{-- LEFT ITEM --}}
						<div class="flex items-center gap-3">
							<div class="w-12 h-12 rounded-xl border flex items-center justify-center overflow-hidden">
								<img src="{{ asset('images/id2.jpg') }}" alt="img" class="w-full h-full object-cover">
							</div>

							<div>
								<p class="text-sm">Nama alat <span class="text-xs font-medium text-gray-500">×2</span></p>
								<div class="flex items-center gap-1">
									<div class="h-2 w-2 rounded-full bg-[#F99417]"></div>
									<p class="text-xs text-gray-500">kategori alat</p>
								</div>
							</div>
						</div>

						{{-- RIGHT DURATION --}}
						<div class="text-right text-xs text-gray-500 whitespace-nowrap">
							<p>Durasi peminjaman - Sehari</p>
							<div class="flex items-center justify-end gap-1">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/><path d="M12 7v5l3 3"/></g></svg>
								<span class="font-semibold text-black">45 Menit</span>
							</div>
						</div>

					</div>
					@endfor

				</div>

				{{-- ACTION --}}
				<div class="flex justify-end gap-2 mt-4">
					<button class="px-4 py-2 border border-transparent rounded-full bg-[#F99417] text-white text-sm hover:bg-white hover:text-[#F99417] hover:border-[#F99417] transition">
						Edit
					</button>
					<button class="px-4 py-1 border border-transparent rounded-full text-sm bg-red-500 text-white hover:bg-white hover:text-red-500 hover:border-red-500 transition">
						Hapus
					</button>
				</div>

			</div>
			@endfor
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
				<button class="px-4 py-3 flex items-center gap-2 border border-transparent text-white font-semibold rounded-full text-sm bg-[#363062] group hover:bg-transparent hover:text-[#363062] hover:border-[#363062] transition-all">
					Tambahkan Peminjaman

					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white group-hover:text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2"/></svg>
				</button>

			</div>
		</div>

		<div class="max-h-[400px] overflow-y-auto pr-2 flex flex-col gap-4">

			@for ($i = 0; $i < 3; $i++)
			{{-- CONTENT --}}
			<div class="bg-white border border-gray-300 rounded-[20px] p-4 shadow-lg">

				{{-- HEADER --}}
				<div class="flex items-start justify-between">
					<div class="flex items-center gap-3">
						<h3 class="text-2xl font-semibold">
							#INVT-2605-006
						</h3>

						<span class="px-3 py-1 rounded-full bg-[#363062]/40 text-white text-xs font-semibold">
							Dipinjam
						</span>
					</div>


					<div class="flex items-center gap-2">
						<div class="w-8 h-8 rounded-full overflow-hidden">
							<img src="{{ asset('images/mygw.jpeg') }}" alt="user" class="w-full h-full object-cover">
						</div>
						<div class="text-sm">
							<p class="font-medium">Budi Tarmiji</p>
							<p class="text-xs text-gray-500">3 Item</p>
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
								Tanggal pengajuan: <span class="text-[#363062] font-semibold">5 - 5 - 2026</span>
							</p>
							<p class="whitespace-nowrap">
								Waktu diterima: <span class="text-[#363062] font-semibold">07:45 | 5 - 5 - 2026</span>
							</p>
						</div>
					</div>

					{{-- LIST --}}
					@for ($j = 0; $j < 3; $j++)
					<div class="flex items-center justify-between gap-4">

						{{-- LEFT ITEM --}}
						<div class="flex items-center gap-3">
							<div class="w-12 h-12 rounded-xl border flex items-center justify-center overflow-hidden">
								<img src="{{ asset('images/id2.jpg') }}" alt="img" class="w-full h-full object-cover">
							</div>

							<div>
								<p class="text-sm">Nama alat <span class="text-xs font-medium text-gray-500">×2</span></p>
								<div class="flex items-center gap-1">
									<div class="h-2 w-2 rounded-full bg-[#F99417]"></div>
									<p class="text-xs text-gray-500">kategori alat</p>
								</div>
							</div>
						</div>

						{{-- RIGHT DURATION --}}
						<div class="text-right text-xs text-gray-500 whitespace-nowrap">
							<p>Durasi peminjaman - Sehari</p>
							<span class="font-semibold text-black">00:35:12 - tersisa</span>
						</div>

					</div>
					@endfor

				</div>

				{{-- ACTION --}}
				<div class="flex justify-end gap-2 mt-4">
					<button class="px-4 py-2 border border-transparent rounded-full bg-[#F99417] text-white text-sm hover:bg-white hover:text-[#F99417] hover:border-[#F99417] transition">
						Edit
					</button>
					<button class="px-4 py-1 border border-transparent rounded-full text-sm bg-red-500 text-white hover:bg-white hover:text-red-500 hover:border-red-500 transition">
						Hapus
					</button>
				</div>

			</div>
			@endfor
		</div>

	</div>

</div>

</div>
@endsection