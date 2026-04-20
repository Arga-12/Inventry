@extends('layouts.app')

@section('content')
<div class="mx-auto">
	<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

		{{-- kolom1 --}}
		<div class="flex flex-col gap-8">
			<div>
				<h1 class="text-4xl font-bold text-gray-900">Dashboard</h1>
				<p class="text-gray-500 mt-2">Selamat datang di Inventry, tempat kamu meminjam barang</p>
			</div>

			<div class="flex items-center justify-between gap-8">
				<div class="flex gap-6 items-center w-full">
					<div class="flex flex-col gap-2 w-full h-full p-4 bg-white shadow-lg rounded-[20px] border-b-2 border-[#363062]">
						<span class="text-gray-500 text-sm font-medium">Peminjaman dilakukan</span>
						<div class="flex justify-between">
							<span class="text-5xl font-bold text-[#363062]">67</span>
							<div class="flex items-center">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-full text-[#363062]/50 rotate-180" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 20V4m0 0l6 6m-6-6l-6 6"/></svg>
									<span class="text-5xl font-normal text-[#363062]/50">23</span>
							</div>
						</div>
						<span class="text-xs font-medium text-[#363062]">3 Lebih banyak daripada bulan lalu</span> 
					</div>
				</div>
				
				<div class="flex gap-6 items-center w-full">
					<div class="flex flex-col gap-2 w-full h-full p-4 bg-white shadow-lg rounded-[20px] border-b-2 border-[#363062]">
						<span class="text-gray-500 text-sm font-medium">Alat dikembalikan</span>
						<div class="flex justify-between">
							<span class="text-5xl font-bold text-[#363062]">23</span>
							<div class="flex items-center">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-full text-[#363062]/50" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 20V4m0 0l6 6m-6-6l-6 6"/></svg>
									<span class="text-5xl font-normal text-[#363062]/50">23</span>
							</div>
						</div>
						<span class="text-xs font-medium text-[#363062]">3 Lebih banyak daripada bulan lalu</span> 
					</div>
				</div>
			</div>
		</div>

		{{-- kolom2 --}}
		<div class="h-full">
			<div class="h-full bg-gradient-to-r from-[#363062] to-[#4D4C7D] rounded-[20px] p-8 shadow-lg">
				<div class="flex justify-between">
					<div class="flex flex-col">
						<h2 class="text-3xl font-bold text-white">Ingin Meminjam Alat?</h2>
						<p class="text-gray-200 mt-2 text-sm">Quick search pada kolom dibawah</p>
					</div>

					<div class="bg-gradient-to-l from-[#FFFFFF] to-[#F5F5F5] shadow-md h-12 w-12 p-auto rounded-[15px] flex items-center justify-center">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-[#F99417]" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="m13.25 2.567l6.294 3.634a2.5 2.5 0 0 1 1.25 2.165v7.268a2.5 2.5 0 0 1-1.25 2.165l-6.294 3.634a2.5 2.5 0 0 1-2.5 0l-6.294-3.634a2.5 2.5 0 0 1-1.25-2.165V8.366a2.5 2.5 0 0 1 1.25-2.165l6.294-3.634a2.5 2.5 0 0 1 2.5 0M5.206 9.232v6.402a.5.5 0 0 0 .25.433l5.544 3.2V12.56zm13.588 0L13 12.56v6.709l5.544-3.201a.5.5 0 0 0 .242-.345l.008-.088zM11.75 4.3L6.206 7.5l5.544 3.201a.5.5 0 0 0 .5 0L17.794 7.5L12.25 4.299a.5.5 0 0 0-.5 0Z"/></g></svg>
					</div>
				</div>	

				<div class="mt-14 flex gap-3">
					<input type="text" placeholder="Cari alat..." class="flex-1 rounded-full px-4 py-3">
					<button class="border-2 border-white px-6 py-3 rounded-full text-white font-bold hover:bg-white hover:border-transparent hover:text-[#F99417] transition-colors">
						Cari
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection