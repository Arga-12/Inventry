@extends('layouts.app')

@section('content')
	<div class="mx-auto">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-stretch">

			{{-- baris1 kolom1 --}}
			<div class="flex flex-col gap-8 h-full">
				<div class="flex-1 flex flex-col">
					<h1 class="text-4xl font-bold text-gray-900">Dashboard</h1>
					<p class="text-gray-500">Selamat datang di Inventry, tempat Anda meminjam barang</p>
				</div>

				<div class="flex items-center justify-between gap-8">
					<div class="h-max w-full bg-white shadow-lg rounded-[20px] flex flex-col items-start p-6 gap-2">

						<div class="flex justify-between items-center w-full">
							<div class="flex flex-col items-start">
								<h2 class="font-bold text-3xl">Total Peminjaman</h2>
								<p class="text-sm font-light text-gray-500">Total peminjaman anda berdasarkan tiap kategori
								</p>
							</div>

							<div class="flex items-baseline gap-1">
								<h2 class="font-bold text-5xl">167</h2>
								<span class="text-xs font-light text-gray-500">Peminjaman</span>
							</div>
						</div>

						<div class="w-full h-2 rounded-full overflow-hidden flex mt-3">
							<div class="h-full bg-[#363062]" style="width: 45%"></div>
							<div class="h-full bg-[#4D4C7D]" style="width: 25%"></div>
							<div class="h-full bg-[#F99417]" style="width: 30%"></div>
						</div>

						<div class="flex items-center gap-4 mt-3 text-sm">
							<div class="flex items-center gap-2">
								<span class="w-2 h-2 rounded-full bg-[#363062]"></span>
								<span>Kategori1</span>
							</div>

							<div class="flex items-center gap-2">
								<span class="w-2 h-2 rounded-full bg-[#4D4C7D]"></span>
								<span>Kategori2</span>
							</div>

							<div class="flex items-center gap-2">
								<span class="w-2 h-2 rounded-full bg-[#F99417]"></span>
								<span>Kategori3</span>
							</div>

						</div>
					</div>
				</div>
			</div>

			{{-- baris1 kolom2 --}}
			<div class="h-full">
				<div
					class="h-full bg-gradient-to-r from-[#363062] to-[#4D4C7D] rounded-[20px] p-6 shadow-lg flex flex-col justify-between">
					<div class="flex justify-between">
						<div class="flex flex-col">
							<h2 class="text-3xl font-bold text-white">Ingin Meminjam Alat?</h2>
							<p class="text-gray-200 text-sm">Quick search pada kolom dibawah</p>
						</div>

						<div
							class="bg-gradient-to-l from-[#FFFFFF] to-[#F5F5F5] shadow-md h-12 w-12 p-auto rounded-[15px] flex items-center justify-center">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-[#F99417]" viewBox="0 0 24 24">
								<g fill="none" fill-rule="evenodd">
									<path
										d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
									<path fill="currentColor"
										d="m13.25 2.567l6.294 3.634a2.5 2.5 0 0 1 1.25 2.165v7.268a2.5 2.5 0 0 1-1.25 2.165l-6.294 3.634a2.5 2.5 0 0 1-2.5 0l-6.294-3.634a2.5 2.5 0 0 1-1.25-2.165V8.366a2.5 2.5 0 0 1 1.25-2.165l6.294-3.634a2.5 2.5 0 0 1 2.5 0M5.206 9.232v6.402a.5.5 0 0 0 .25.433l5.544 3.2V12.56zm13.588 0L13 12.56v6.709l5.544-3.201a.5.5 0 0 0 .242-.345l.008-.088zM11.75 4.3L6.206 7.5l5.544 3.201a.5.5 0 0 0 .5 0L17.794 7.5L12.25 4.299a.5.5 0 0 0-.5 0Z" />
								</g>
							</svg>
						</div>
					</div>

					<div class="flex gap-3">
						<input type="text" placeholder="Cari alat..." class="flex-1 rounded-full px-4 py-3">
						<button
							class="border-2 border-white px-6 py-3 rounded-full text-white font-bold hover:bg-white hover:border-transparent hover:text-[#F99417] transition-colors">
							Cari
						</button>
					</div>
				</div>
			</div>

			{{-- baris2 kolom1 --}}

			<div class="relative flex flex-col h-96">

				{{-- title --}}
				<div class="mb-4">
					<h2 class="text-3xl font-bold">Peminajam Anda saat ini</h2>
					<p class="text-sm font-light text-gray-500">
						Daftar peminjaman yang sedang berlangsung
					</p>
				</div>

				<div class="flex-1 overflow-y-auto pl-6 flex flex-col gap-4 no-scrollbar">
					{{-- card list antrian --}}
					<div
						class="relative w-full h-20 flex-shrink-0 bg-white rounded-[20px] flex items-center px-10 shadow-md">

						<div class="absolute -left-4 w-14 h-16 bg-gray-200 rounded-[15px] shadow-md overflow-hidden">
							<img src={{ asset("images/id1.jpg") }} class="object-cover w-full h-full">
						</div>

						<div class="ml-4 flex flex-col">
							<p class="font-medium text-[#363062]">#INVT-2604-023</p>
							<p class="flex font-light text-sm text-[#4D4C7D]">RTX 3050, Mouse Micro, Remote AC</p>
						</div>

						<div class="ml-auto flex items-center gap-3 mr-[-40x]">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#363062]" viewBox="0 0 24 24">
								<g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
									stroke-width="2">
									<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0" />
									<path d="M12 7v5l3 3" />
								</g>
							</svg>

							<div class="flex items-center gap-2">
								<span
									class="px-2 py-1 bg-[#363062]/5 rounded-md text-xs font-medium text-[#363062] tracking-wider">
									20/04 08:00
								</span>
								<span class="text-gray-300">—</span>
								<span
									class="px-2 py-1 bg-[#363062]/5 rounded-md text-xs font-medium text-[#363062] tracking-wider">
									20/04 15:00
								</span>
							</div>

							<button
								class="h-8 w-28 p-2 rounded-full bg-[#4D4C7D] flex items-center justify-center text-white text-sm font-semibold">
								Detail Struk
							</button>
						</div>
					</div>

					<div
						class="relative w-full h-20 flex-shrink-0 bg-white rounded-[20px] flex items-center px-10 shadow-md">

						<div class="absolute -left-4 w-14 h-16 bg-gray-200 rounded-[15px] shadow-md overflow-hidden">
							<img src={{ asset("images/id1.jpg") }} class="object-cover w-full h-full">
						</div>

						<div class="ml-4 flex flex-col">
							<p class="font-medium text-[#363062]">#INVT-2604-023</p>
							<p class="flex font-light text-sm text-[#4D4C7D]">RTX 3050, Mouse Micro, Remote AC</p>
						</div>

						<div class="ml-auto flex items-center gap-3 mr-[-40x]">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#363062]" viewBox="0 0 24 24">
								<g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
									stroke-width="2">
									<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0" />
									<path d="M12 7v5l3 3" />
								</g>
							</svg>

							<div class="flex items-center gap-2">
								<span
									class="px-2 py-1 bg-[#363062]/5 rounded-md text-xs font-medium text-[#363062] tracking-wider">
									20/04 08:00
								</span>
								<span class="text-gray-300">—</span>
								<span
									class="px-2 py-1 bg-[#363062]/5 rounded-md text-xs font-medium text-[#363062] tracking-wider">
									20/04 15:00
								</span>
							</div>

							<button
								class="h-8 w-28 p-2 rounded-full bg-[#4D4C7D] flex items-center justify-center text-white text-sm font-semibold">
								Detail Struk
							</button>
						</div>
					</div>

					<div
						class="relative w-full h-20 flex-shrink-0 bg-white rounded-[20px] flex items-center px-10 shadow-md">

						<div class="absolute -left-4 w-14 h-16 bg-gray-200 rounded-[15px] shadow-md overflow-hidden">
							<img src={{ asset("images/id1.jpg") }} class="object-cover w-full h-full">
						</div>

						<div class="ml-4 flex flex-col">
							<p class="font-medium text-[#363062]">#INVT-2604-023</p>
							<p class="flex font-light text-sm text-[#4D4C7D]">RTX 3050, Mouse Micro, Remote AC</p>
						</div>

						<div class="ml-auto flex items-center gap-3 mr-[-40x]">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#363062]" viewBox="0 0 24 24">
								<g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
									stroke-width="2">
									<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0" />
									<path d="M12 7v5l3 3" />
								</g>
							</svg>

							<div class="flex items-center gap-2">
								<span
									class="px-2 py-1 bg-[#363062]/5 rounded-md text-xs font-medium text-[#363062] tracking-wider">
									20/04 08:00
								</span>
								<span class="text-gray-300">—</span>
								<span
									class="px-2 py-1 bg-[#363062]/5 rounded-md text-xs font-medium text-[#363062] tracking-wider">
									20/04 15:00
								</span>
							</div>

							<button
								class="h-8 w-28 p-2 rounded-full bg-[#4D4C7D] flex items-center justify-center text-white text-sm font-semibold">
								Detail Struk
							</button>
						</div>
					</div>

					<div
						class="relative w-full h-20 flex-shrink-0 bg-white rounded-[20px] flex items-center px-10 shadow-md">

						<div class="absolute -left-4 w-14 h-16 bg-gray-200 rounded-[15px] shadow-md overflow-hidden">
							<img src={{ asset("images/id1.jpg") }} class="object-cover w-full h-full">
						</div>

						<div class="ml-4 flex flex-col">
							<p class="font-medium text-[#363062]">#INVT-2604-023</p>
							<p class="flex font-light text-sm text-[#4D4C7D]">RTX 3050, Mouse Micro, Remote AC</p>
						</div>

						<div class="ml-auto flex items-center gap-3 mr-[-40x]">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#363062]" viewBox="0 0 24 24">
								<g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
									stroke-width="2">
									<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0" />
									<path d="M12 7v5l3 3" />
								</g>
							</svg>

							<div class="flex items-center gap-2">
								<span
									class="px-2 py-1 bg-[#363062]/5 rounded-md text-xs font-medium text-[#363062] tracking-wider">
									20/04 08:00
								</span>
								<span class="text-gray-300">—</span>
								<span
									class="px-2 py-1 bg-[#363062]/5 rounded-md text-xs font-medium text-[#363062] tracking-wider">
									20/04 15:00
								</span>
							</div>

							<button
								class="h-8 w-28 p-2 rounded-full bg-[#4D4C7D] flex items-center justify-center text-white text-sm font-semibold">
								Detail Struk
							</button>
						</div>
					</div>

					<div
						class="relative w-full h-20 flex-shrink-0 bg-white rounded-[20px] flex items-center px-10 shadow-md">

						<div class="absolute -left-4 w-14 h-16 bg-gray-200 rounded-[15px] shadow-md overflow-hidden">
							<img src={{ asset("images/id1.jpg") }} class="object-cover w-full h-full">
						</div>

						<div class="ml-4 flex flex-col">
							<p class="font-medium text-[#363062]">#INVT-2604-023</p>
							<p class="flex font-light text-sm text-[#4D4C7D]">RTX 3050, Mouse Micro, Remote AC</p>
						</div>

						<div class="ml-auto flex items-center gap-3 mr-[-40x]">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#363062]" viewBox="0 0 24 24">
								<g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
									stroke-width="2">
									<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0" />
									<path d="M12 7v5l3 3" />
								</g>
							</svg>

							<div class="flex items-center gap-2">
								<span
									class="px-2 py-1 bg-[#363062]/5 rounded-md text-xs font-medium text-[#363062] tracking-wider">
									20/04 08:00
								</span>
								<span class="text-gray-300">—</span>
								<span
									class="px-2 py-1 bg-[#363062]/5 rounded-md text-xs font-medium text-[#363062] tracking-wider">
									20/04 15:00
								</span>
							</div>

							<button
								class="h-8 w-28 p-2 rounded-full bg-[#4D4C7D] flex items-center justify-center text-white text-sm font-semibold">
								Detail Struk
							</button>
						</div>
					</div>
				</div>
				<div
					class="pointer-events-none absolute bottom-0 left-0 w-full h-3 bg-gradient-to-t from-white to-transparent">
				</div>
			</div>

			{{-- baris2 kolom2 --}}
			<div class="relative w-full h-96 bg-white rounded-[20px] p-10 overflow-hidden shadow-lg">

				<div
					class="absolute inset-0 bg-[url('https://images.pexels.com/photos/18338417/pexels-photo-18338417.jpeg')] bg-cover bg-center">
					<div class="absolute inset-0 bg-gradient-to-t from-black/80 to-black/30"></div>
				</div>

				<div class="relative z-10 flex flex-col h-full text-white">
					<div class="space-y-1">
						<h1 class="text-4xl font-bold">Untuk Anda!</h1>
						<p class="text-lg font-light text-gray-200">Optimalkan alur kerja Anda dengan rekomendasi inventaris
							yang relevan. Perangkat di bawah ini dipilih secara otomatis untuk mendukung kebutuhan teknis
							Anda saat ini.</p>
					</div>

					<div class="mt-auto flex justify-between items-end gap-10">

						<!-- kiri -->
						<div class="flex flex-col gap-1">
							<p class="font-semibold text-white">RTX 2080 4GB</p>

							<div class="flex items-center gap-2">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/><path d="M12 7v5l3 3"/></g></svg>
								<p class="font-medium">1 Jam 30 Menit</p>
							</div>
						</div>

						<!-- kanan -->
						<button
							class="h-8 w-48 p-2 rounded-full border border-white flex items-center justify-center text-white text-sm font-semibold">
							Pinjam Sekarang
						</button>
					</div>
				</div>
			</div>

			{{-- baris3 kolom1--}}
		</div>
	</div>
@endsection