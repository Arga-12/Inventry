@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4 h-screen">
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-stretch">

		<div class="flex flex-col col-span-3">
			<h1 class="text-4xl font-bold text-gray-900">Peminjaman Alat & Barang</h1>
			<p class="text-gray-500">Lakukan peminjaman alat & barang yang telah disediakan oleh Inventry</p>
		</div>

		<div class="h-36 w-full bg-white flex flex-shrink-0 flex-col col-span-3 items-stretch justify-between gap-4 p-6 shadow-lg rounded-[20px]">
			<div class="flex items-center gap-3 bg-gray-100 px-4 py-3 rounded-full focus-within:ring-2 focus-within:ring-[#363062] transition-all">

				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>

				<input type="text" placeholder="Cari alat..." class="bg-transparent outline-none flex-1 text-sm placeholder-gray-400">
			</div>

			<div class="flex items-stretch justify-between h-full w-full">
				<div class="flex items-center gap-2">
					<button class="h-10 w-24 border border-[#363062] rounded-full p-4 flex items-center justify-center text-[#363062] font-normal text-sm">
						<div class="flex gap-1 items-center">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#363062]" viewBox="0 0 32 32"><path fill="currentColor" d="M16 3C8.832 3 3 8.832 3 16s5.832 13 13 13s13-5.832 13-13S23.168 3 16 3m0 2c6.087 0 11 4.913 11 11s-4.913 11-11 11S5 22.087 5 16S9.913 5 16 5m-3.78 5.78l-1.44 1.44L14.564 16l-3.782 3.78l1.44 1.44L16 17.437l3.78 3.78l1.44-1.437L17.437 16l3.78-3.78l-1.437-1.44L16 14.564l-3.78-3.782z"/></svg>
							filter1
						</div>
					</button>
					<button class="h-10 w-24 border border-[#363062] rounded-full p-4 flex items-center justify-center text-[#363062] font-normal text-sm">
						<div class="flex gap-1 items-center">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#363062]" viewBox="0 0 32 32"><path fill="currentColor" d="M16 3C8.832 3 3 8.832 3 16s5.832 13 13 13s13-5.832 13-13S23.168 3 16 3m0 2c6.087 0 11 4.913 11 11s-4.913 11-11 11S5 22.087 5 16S9.913 5 16 5m-3.78 5.78l-1.44 1.44L14.564 16l-3.782 3.78l1.44 1.44L16 17.437l3.78 3.78l1.44-1.437L17.437 16l3.78-3.78l-1.437-1.44L16 14.564l-3.78-3.782z"/></svg>
							filter2
						</div>
					</button>
					<button class="h-10 w-24 border border-[#363062] rounded-full p-4 flex items-center justify-center text-[#363062] font-normal text-sm">
						<div class="flex gap-1 items-center">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#363062]" viewBox="0 0 32 32"><path fill="currentColor" d="M16 3C8.832 3 3 8.832 3 16s5.832 13 13 13s13-5.832 13-13S23.168 3 16 3m0 2c6.087 0 11 4.913 11 11s-4.913 11-11 11S5 22.087 5 16S9.913 5 16 5m-3.78 5.78l-1.44 1.44L14.564 16l-3.782 3.78l1.44 1.44L16 17.437l3.78 3.78l1.44-1.437L17.437 16l3.78-3.78l-1.437-1.44L16 14.564l-3.78-3.782z"/></svg>
							filter3
						</div>
					</button>
				</div>

				<div class="flex gap-2 items-center">
					<div class="h-10 w-10 bg-[#F5F5F5] border border-[#363062] rounded-full flex items-center justify-center">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/></svg>
					</div>
					<button class="h-10 w-32 p-4 bg-[#363062] flex items-center justify-center text-white font-normal rounded-full border border-transparent hover:bg-transparent hover:text-[#363062] hover:border-[#363062] transition-all duration-200">
						Cari
					</button>
				</div>
			</div>
		</div>

		<x-card-alat />
		<x-card-alat />
		<x-card-alat />
		<x-card-alat />
		<x-card-alat />
		<x-card-alat />
	</div>
</div>
@endsection