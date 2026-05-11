@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4">
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

		{{-- title - baris1 --}}
		<div class="lg:col-span-3 flex flex-col gap-1">
			<h1 class="text-4xl font-bold">Manajemen Alat & Barang</h1>
			<p class="text-sm text-gray-500">
				Kelola seluruh inventaris alat dan barang, pantau stok, serta atur kategori dengan mudah dan efisien.
			</p>
		</div>

		{{-- 2 card header - baris2 --}}
		<div class="lg:col-span-3 grid grid-cols-1 lg:grid-cols-2 gap-6">
			<div class="bg-white border border-gray-300 rounded-[20px] p-6 shadow-lg flex flex-col justify-between">

				<div class="flex items-start justify-between">
					<h2 class="text-xl font-semibold">Total Stok</h2>

					<span class="px-3 py-1 flex items-center gap-2 bg-[#F99417]/20 rounded-full text-sm text-[#F99417]">
						<div class="h-2 w-2 rounded-full bg-[#F99417]"></div>

						75 items sedang dipinjam
					</span>
				</div>

				<div class="text-5xl font-bold text-[#363062] mt-4">
					135
				</div>

				<p class="text-sm text-gray-500 mt-4">
					Mohon perhatian untuk <span class="font-semibold text-red-500">7 alat</span> lainnya yang mengalami kekurangan stok!
				</p>

			</div>

			<div class="bg-white border border-gray-300 rounded-[20px] p-6 shadow-lg flex flex-col gap-4 h-full">

				<div class="flex items-center justify-between">
					<h2 class="text-xl font-semibold">
						Manajemen Kategori
					</h2>

					<a href="{{ route('admin-kategori') }}" class="px-3 flex items-center gap-2 py-1 text-xs border border-[#363062] text-[#363062] rounded-full hover:bg-[#363062] hover:text-white transition">
						Selengkapnya

						<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"><path fill="currentColor" d="M6.5 11L12 2l5.5 9zm11 11q-1.875 0-3.187-1.312T13 17.5t1.313-3.187T17.5 13t3.188 1.313T22 17.5t-1.312 3.188T17.5 22M3 21.5v-8h8v8zM17.5 20q1.05 0 1.775-.725T20 17.5t-.725-1.775T17.5 15t-1.775.725T15 17.5t.725 1.775T17.5 20M5 19.5h4v-4H5zM10.05 9h3.9L12 5.85zm7.45 8.5"/></svg>
					</a>
				</div>

				<div class="grid grid-cols-2 gap-3 text-sm">

					@php
					$colors = ['#363062', '#4D4C7D', '#F99417', '#42f5d7', '#eb8abf', '#6b7280'];
					@endphp

					@for ($i = 0; $i < 6; $i++)
					<div class="flex items-center justify-between">
						<div class="flex items-center gap-2">
							<div class="w-2 h-2 rounded-full"
							style="background-color: {{ $colors[$i % count($colors)] }}">
						</div>
						<span>Komponen PC</span>
					</div>

					<span class="text-gray-500 text-xs">
						3 Item
					</span>
				</div>
				@endfor

			</div>

			<div class="w-full mt-auto pt-3">
				<span class="text-xs text-gray-500">Total Katgeori: 7</span>
				<div class="w-full h-2 rounded-full overflow-hidden flex">
					
					<div class="h-full" style="width: 45%; background:#363062"></div>
					<div class="h-full" style="width: 25%; background:#4D4C7D"></div>
					<div class="h-full" style="width: 30%; background:#F99417"></div>
				</div>
			</div>
		</div>
	</div>

	{{-- kekurangan stok - baris3 --}}
	<div class="lg:col-span-3 flex flex-col">

		<div class="flex items-center gap-3">
			<div class="w-10 h-10 flex items-center justify-center">
				<svg xmlns="http://www.w3.org/2000/svg" class="text-black" viewBox="0 0 24 24"><path fill="currentColor" d="M2.725 21q-.275 0-.5-.137t-.35-.363t-.137-.488t.137-.512l9.25-16q.15-.25.388-.375T12 3t.488.125t.387.375l9.25 16q.15.25.138.513t-.138.487t-.35.363t-.5.137zm1.725-2h15.1L12 6zm8.263-1.287Q13 17.425 13 17t-.288-.712T12 16t-.712.288T11 17t.288.713T12 18t.713-.288m0-3Q13 14.425 13 14v-3q0-.425-.288-.712T12 10t-.712.288T11 11v3q0 .425.288.713T12 15t.713-.288M12 12.5"/></svg>
			</div>

			<h2 class="text-3xl font-semibold">
				Alat / Barang kekurangan stok
			</h2>
		</div>

		<p class="text-sm text-gray-500">
			Mohon segera lakukan restock untuk menjaga ketersediaan alat bagi peminjam.
		</p>

	</div>

	{{-- list barang kekurangan stok - baris4 --}}
	<div class="lg:col-span-3">

		<div class="bg-white border border-gray-300 rounded-[20px] p-6 shadow-lg">

			<div class="w-full flex items-center justify-between gap-4 flex-wrap mb-6">
				<div class="w-full flex items-center gap-3 flex-wrap">

					<div class="relative flex-1 w-full h-full flex-shrink-0">
						<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
						</div>
						<input type="text" placeholder="Cari peminjam..." class="w-full h-full pl-10 pr-4 py-3 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
					</div>

					<button class="flex-shrink-0 w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/></svg>
					</button>
				</div>
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

				@for ($i = 0; $i < 6; $i++)
				<div class="flex h-36 bg-white border border-gray-200 rounded-[20px] overflow-hidden shadow-sm hover:shadow-lg transition">

					<div class="w-1/3 relative">
						<div class="absolute inset-0 bg-[url('https://images.pexels.com/photos/18338417/pexels-photo-18338417.jpeg')] bg-cover bg-center"></div>
						<div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>
					</div>

					<div class="w-2/3 p-4 flex flex-col justify-between">

						<div class="flex items-start justify-between">
							<div>
								<h3 class="font-semibold text-[#363062]">
									RTX 2080 SUPER
								</h3>
								<p class="text-xs text-gray-500">
									Kategori: Komponen PC
								</p>
							</div>

							<span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full">
								Stok menipis
							</span>
						</div>

						<div class="flex items-center gap-2 text-sm text-gray-500">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/><path d="M12 7v5l3 3"/></g></svg>
							<span>1 Jam 30 Menit</span>
						</div>

						<div class="flex items-center justify-between">
							<span class="text-sm font-semibold text-[#363062]">
								Sisa: 2
							</span>

							<div class="flex items-center gap-2">
								<button class="text-xs px-3 py-1 border border-[#F99417] text-[#F99417] rounded-full hover:bg-[#F99417] hover:text-white transition">
									Edit
								</button>

								<button class="text-xs px-3 py-1 border border-red-500 text-red-500 rounded-full hover:bg-red-500 hover:text-white transition">
									Hapus
								</button>
							</div>
						</div>

					</div>

				</div>
				@endfor

			</div>

		</div>
	</div>

	{{-- list alat dan barang - baris5 --}}
	<div class="lg:col-span-3 w-full">
		<div class="w-full flex flex-col gap-6">

			<h2 class="font-bold text-3xl">Daftar Alat & Barang</h2>

			<div class="flex items-center justify-between gap-4 flex-wrap">

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
						Tambahkan Alat / Barang

						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white group-hover:text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2"/></svg>
					</button>

				</div>

				<div class="w-full overflow-x-auto grid grid-cols-3 gap-10">
					@for ($i = 0; $i < 6; $i++)
					<div class="w-full h-[400px]">
						<div class="relative w-full h-full bg-white rounded-[20px] p-4 overflow-hidden shadow-lg">
							<div class="absolute inset-0 bg-[url('https://images.pexels.com/photos/18338417/pexels-photo-18338417.jpeg')] bg-cover bg-center">
								<div class="absolute inset-0 bg-gradient-to-t from-black/30 to-black/10"></div>
							</div>

							<div class="absolute bottom-0 left-0 w-full z-20">
								<div class="backdrop-blur-md bg-white/20 p-4 text-white">

									<div class="flex items-center justify-between">
										
										<div class="flex flex-col">
											<p class="text-lg font-semibold">RTX 2080 SUPER</p>
											<span class="text-base font-medium">Kategori: Komponen PC</span>
										</div>

										<div class="flex flex-col gap-2 items-center">
											<div class="flex items-center h-8 w-32 gap-2">
												<div class="h-full w-full flex items-center justify-center gap-2 bg-white border border-[#F99417] rounded-full p-2">
													<span class="w-2 h-2 rounded-full bg-[#F99417]"></span>
													<span class="text-sm text-[#F99417]">4 Dipinjam</span>
												</div>
											</div>

											<div class="flex items-center h-8 w-32 gap-2">
												<div class="h-full w-full flex items-center justify-center gap-2 border border-white rounded-full p-2">
													<span class="w-2 h-2 rounded-full bg-white"></span>
													<span class="text-sm">12 Tersisa</span>
												</div>
											</div>
										</div>
									</div>

									<div class="flex items-center justify-between mt-2">
										<div class="flex items-center gap-2">
											<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/><path d="M12 7v5l3 3"/></g></svg>
											<p class="font-medium">1 Jam 30 Menit</p>
										</div>

										<div class="h-8 w-32 flex items-center gap-2">
											<button class="h-full w-full rounded-full bg-white text-[#F99417] text-sm hover:bg-[#F99417] hover:text-white border border-[#F99417] hover:border-transparent transition">
												Edit
											</button>
											<button class="h-full w-full rounded-full bg-white text-red-500 text-sm hover:bg-red-500 hover:text-white border border-red-500 hover:border-transparent transition">
												Hapus
											</button>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					@endfor
				</div>
			</div>

		</div>
	</div>
</div>
</div>
@endsection