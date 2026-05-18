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
					{{ $stoktotal }}
				</div>
				
				<p class="text-sm text-gray-500 mt-4">
					@if ($totalstokmenipis != 0)
					Mohon perhatikan untuk <span class="font-semibold text-red-500">{{ $totalstokmenipis }} Alat</span> lainnya yang mengalami kekurangan stok!
					@else
					Seluruh persediaan alat terpantau aman. Tidak ada indikasi kekurangan stok.
					@endif
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
					@foreach ($kategori as $data)
					<div class="flex items-center justify-between">
						<div class="flex items-center gap-2">
							<div class="w-2 h-2 rounded-full" style="background-color: {{ $data->warna }}"></div>
							<span>{{ $data->nama_kategori }}</span>
						</div>
					</div>
					
					<span class="text-gray-500 text-xs">
						{{ $data->alat_count }} Item
					</span>
					@endforeach
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
						
						<form action="{{ route('admin-alat') }}" method="GET" class="flex items-center gap-3 flex-wrap">
							<div class="relative flex-1 w-full h-full flex-shrink-0">
								<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
								</div>
								<input type="text" name="search_stok" placeholder="Cari peminjam..." class="w-full h-full pl-10 pr-4 py-3 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
							</div>
							
							{{-- 2. Tombol Cari (Submit) --}}
							<button type="submit" class="w-24 h-11 flex items-center justify-center bg-[#363062] text-white rounded-full hover:bg-[#4D4C7D] transition shadow-md">
								Cari
							</button>
							
							<div x-data="{ open: false }" class="relative inline-block text-left">
								<button type="button" @click="open = !open" class="flex-shrink-0 w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/></svg>
								</button>
								
								<div x-show="open" 
								@click.outside="open = false" 
								style="display: none;" 
								x-transition.opacity
								class="absolute left-0 sm:right-0 sm:left-auto z-20 mt-2 w-56 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden border border-gray-100">
								
								<div class="py-2">
									<p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">
										Filter Kategori
									</p>
									
									{{-- Opsi: Semua Kategori --}}
									<label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
										<input type="radio" name="kategori_stok" value="" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062] focus:ring-[#363062]" {{ request('kategori_stok') == '' ? 'checked' : '' }}>
										Semua Kategori
									</label>
									
									{{-- Looping Data Kategori --}}
									@foreach ($kategori as $kat)
									<label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
										<input type="radio" name="kategori_stok" value="{{ $kat->id }}" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062] focus:ring-[#363062]" {{ request('kategori_stok') == $kat->id ? 'checked' : '' }}>
										{{ $kat->nama_kategori }}
									</label>
									@endforeach
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		
			@forelse ($stokmenipis as $items)
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 border-t border-gray-200 pt-6">
				
				@foreach ($items as $data)
				{{-- card alat stok menipis --}}
				<div class="flex h-36 bg-white border border-gray-200 rounded-[20px] overflow-hidden shadow-sm hover:shadow-lg transition">
				
				<div class="w-1/3 relative">
					{{-- 2. Ganti bg-cover dengan w-full h-full object-cover agar gambar tidak penyok --}}
					<img src="{{ asset('storage/' . $data->gambar) }}" alt="gambar alat" class="absolute inset-0 w-full h-full object-cover bg-center">
					<div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>
				</div>
				
				<div class="w-2/3 p-4 flex flex-col justify-between">
					
					<div class="flex items-start justify-between">
						<div>
							<h3 class="font-semibold text-[#363062]">
								{{ $data->nama_alat }}
							</h3>
							<p class="text-xs text-gray-500">
								Kategori: {{ $data->kategori->nama_kategori ?? 'Tanpa Kategori' }}
							</p>
						</div>
						
						<span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full">
							Stok menipis
						</span>
					</div>
					
					<div class="flex items-center gap-2 text-sm text-gray-500">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/><path d="M12 7v5l3 3"/></g></svg>
						<span>{{ $data->durasi }} Menit</span>
					</div>
					
					<div class="flex items-center justify-between">
						<span class="text-sm font-semibold text-[#363062]">
							Sisa: {{ $data->stok }}
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
			@endforeach
			
			</div> 
				
			@empty
			<div class="w-full flex flex-col items-center gap-3 justify-center border-t border-gray-200 py-8">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-500" viewBox="0 0 48 48"><g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"><path d="M24 44a19.94 19.94 0 0 0 14.142-5.858A19.94 19.94 0 0 0 44 24a19.94 19.94 0 0 0-5.858-14.142A19.94 19.94 0 0 0 24 4A19.94 19.94 0 0 0 9.858 9.858A19.94 19.94 0 0 0 4 24a19.94 19.94 0 0 0 5.858 14.142A19.94 19.94 0 0 0 24 44Z"/><path stroke-linecap="round" d="m16 24l6 6l12-12"/></g></svg>
				
				<span class="text-sm text-gray-500">Tidak ada stok alat dalam keadaan mendekati habis</span>
			</div>
			@endforelse
		</div>
	</div>
	
	{{-- list alat dan barang - baris5 --}}
	<div class="lg:col-span-3">
		<div class="w-full flex flex-col gap-6">
			
			<h2 class="font-bold text-3xl">Daftar Alat & Barang</h2>
			
			<div class="flex items-center justify-between gap-4 flex-wrap w-full">
				
				<div class="flex items-center gap-3 flex-wrap">
					
					<form action="{{ route('admin-alat') }}#search-alat" method="GET" class="flex items-center gap-3 flex-wrap">
						<div class="relative flex-1 w-full h-full flex-shrink-0">
							<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
							</div>
							<input id="search-alat" value="{{ request('search') }}" type="text" name="search" placeholder="Cari peminjam..." class="w-full h-full pl-10 pr-4 py-3 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
						</div>
						
						{{-- 2. Tombol Cari (Submit) --}}
						<button type="submit" class="w-24 h-11 flex items-center justify-center bg-[#363062] text-white rounded-full hover:bg-[#4D4C7D] transition shadow-md">
							Cari
						</button>
						
						<div x-data="{ open: false }" class="relative inline-block text-left">
							<button type="button" @click="open = !open" class="flex-shrink-0 w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/></svg>
							</button>
							
							<div x-show="open" 
							@click.outside="open = false" 
							style="display: none;" 
							x-transition.opacity
							class="max-h-[250px] absolute left-0 sm:right-0 sm:left-auto z-20 mt-2 w-56 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none overflow-y-auto border border-gray-100">
							
							<div class="py-2">
								<p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">
									Filter Kategori
								</p>
								
								{{-- Opsi: Semua Kategori --}}
								<label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
									<input type="radio" name="kategori_id" value="" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062] focus:ring-[#363062]" {{ request('kategori_id') == '' ? 'checked' : '' }}>
									Semua Kategori
								</label>
								
								{{-- Looping Data Kategori --}}
								@foreach($kategori as $kat)
								<label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
									<input type="radio" name="kategori_id" value="{{ $kat->id }}" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062] focus:ring-[#363062]" {{ request('kategori_id') == $kat->id ? 'checked' : '' }}>
									{{ $kat->nama_kategori }}
								</label>
								@endforeach

								<div class="border-t border-gray-100 my-1 mx-4"></div>

								{{-- Opsi: durasi --}}
								<p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">
									Filter Durasi
								</p>
								
								<label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
									<input type="radio" name="durasi" value="" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062] focus:ring-[#363062]" {{ request('durasi') == '' ? 'checked' : '' }}>
									Semua Durasi
								</label>
								
								{{-- looping durasi --}}
								@foreach($alat->pluck('durasi')->unique()->filter()->sort() as $durasi)
								<label class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
									<input type="radio" name="durasi" value="{{ $durasi }}" onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062] focus:ring-[#363062]" {{ request('durasi') == $durasi ? 'checked' : '' }}>
									{{ $durasi }} Menit
								</label>
								@endforeach
							</div>
						</div>
					</div>
				</form>
			</div>
			
			<div class="flex">
				<a href="{{ route('admin-alat-create') }}" class="px-4 py-3 flex items-center gap-2 border border-transparent text-white font-semibold rounded-full text-sm bg-[#363062] group hover:bg-transparent hover:text-[#363062] hover:border-[#363062] transition-all">
					Tambahkan Alat / Barang
					
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white group-hover:text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2"/></svg>
				</a>
				
			</div>
		</div>
		
		<div class="w-full overflow-x-auto grid grid-cols-3 gap-10">
			@forelse ($alat as $data)
			<div class="w-full h-[400px]">
				<div class="relative w-full h-full bg-white rounded-[20px] p-4 overflow-hidden shadow-lg">
					<img src="{{ asset('storage/' . $data->gambar) }}" alt="gambar alat" class="absolute inset-0 bg-cover bg-center">							
					<div class="absolute inset-0 bg-gradient-to-t from-black/30 to-black/10"></div>
					
					<div class="absolute bottom-0 left-0 w-full z-20">
						<div class="backdrop-blur-md bg-white/20 p-4 text-white">
							
							<div class="flex items-center justify-between">
								
								<div class="flex flex-col">
									<p class="text-lg font-semibold">{{ $data->nama_alat }}</p>
									
									<span class="text-base font-medium">Kategori: {{ $data->kategori->nama_kategori }}</span>
									
								</div>
								
								<div class="flex flex-col gap-2 items-center">
									<div class="flex items-center h-8 w-32 gap-2">
										<div class="h-full w-full flex items-center justify-center gap-2 bg-white border border-[#F99417] rounded-full p-2">
											<span class="w-2 h-2 rounded-full bg-[#F99417]"></span>
											<span class="text-sm text-[#F99417]">4 Dipinjam</span>
										</div>
									</div>
									
									<div class="flex items-center h-8 w-32 gap-2">
										@if ($data->stok <= 7)
										<div class="h-full w-full flex items-center justify-center gap-2 border border-white bg-white/70 rounded-full p-2">
											<span class="w-2 h-2 rounded-full bg-red-500"></span>
											<span class="text-sm font-semibold text-red-500">{{ $data->stok }} Tersisa</span>
										</div>
										@else
										<div class="h-full w-full flex items-center justify-center gap-2 border border-white rounded-full p-2">
											<span class="w-2 h-2 rounded-full bg-white"></span>
											<span class="text-sm">{{ $data->stok }} Tersisa</span>
										</div>
										@endif
									</div>
								</div>
							</div>
							
							<div class="flex items-center justify-between mt-2">
								<div class="flex items-center gap-2">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/><path d="M12 7v5l3 3"/></g></svg>
									<p class="font-medium">{{ $data->durasi }} Menit</p>
								</div>
								
								<div class="h-8 w-32 flex items-center gap-2">
									<a href="{{ route('admin-alat-edit', $data) }}" class="h-full w-full inline-flex items-center justify-center rounded-full bg-white text-[#F99417] text-sm hover:bg-[#F99417] hover:text-white border border-[#F99417] hover:border-transparent transition">
										Edit
									</a>
									<form action="{{ route('admin-alat-destroy', $data) }}" method="POST" class="h-full w-full">
										@csrf
										@method('DELETE')
										<button class="h-full w-full rounded-full bg-white text-red-500 text-sm hover:bg-red-500 hover:text-white border border-red-500 hover:border-transparent transition">
											Hapus
										</button>
									</form>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			
			@empty
			<div class="col-span-3 py-4 flex flex-col gap-2 items-center justify-center">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-500" viewBox="0 0 24 24">
					<g fill="none" fill-rule="evenodd">
						<path
						d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
						<path fill="currentColor"
						d="m13.25 2.567l6.294 3.634a2.5 2.5 0 0 1 1.25 2.165v7.268a2.5 2.5 0 0 1-1.25 2.165l-6.294 3.634a2.5 2.5 0 0 1-2.5 0l-6.294-3.634a2.5 2.5 0 0 1-1.25-2.165V8.366a2.5 2.5 0 0 1 1.25-2.165l6.294-3.634a2.5 2.5 0 0 1 2.5 0M5.206 9.232v6.402a.5.5 0 0 0 .25.433l5.544 3.2V12.56zm13.588 0L13 12.56v6.709l5.544-3.201a.5.5 0 0 0 .242-.345l.008-.088zM11.75 4.3L6.206 7.5l5.544 3.201a.5.5 0 0 0 .5 0L17.794 7.5L12.25 4.299a.5.5 0 0 0-.5 0Z" />
					</g>
				</svg>
				
				<span class="text-sm text-gray-500">Anda masih belum menambahkan data alat & barang peminjaman...</span>
			</div>
			@endforelse
		</div>
	</div>
	
</div>
</div>
</div>
@endsection
