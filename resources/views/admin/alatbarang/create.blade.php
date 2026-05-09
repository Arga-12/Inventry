@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4">
	<div class="w-full flex flex-col gap-10">

		{{-- HEADER --}}
		<div class="flex flex-col gap-1">
			<h1 class="text-4xl font-bold">
				Tambahkan alat / barang peminjaman
			</h1>

			<p class="text-gray-500">
				Lengkapi informasi peminjaman alat dan barang dengan benar.
			</p>
		</div>

		<form action="#" method="POST" enctype="multipart/form-data" class="flex flex-col gap-10">

			{{-- FOTO BARANG --}}
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start">

				<div class="flex flex-col gap-1">
					<h2 class="text-3xl font-bold">
						Foto Barang
					</h2>

					<p class="text-gray-500 text-sm">
						Unggah foto alat atau barang.
					</p>
				</div>

				<div>
					<label class="group w-full h-64 border border-gray-300 rounded-3xl flex flex-col items-center justify-center bg-gray-100 hover:bg-gray-200 transition cursor-pointer overflow-hidden relative">

						<input 
						type="file" 
						class="hidden"
						accept="image/*"
						>

						<div class="flex flex-col items-center justify-center">

							<svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
							</svg>

							<span class="text-sm font-medium text-gray-600">
								Upload foto barang
							</span>

						</div>

					</label>
				</div>

			</div>

			<hr class="border-t border-gray-300">

			{{-- DETAIL BARANG --}}
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start">

				<div class="flex flex-col gap-1">
					<h2 class="text-3xl font-bold">
						Detail Barang
					</h2>

					<p class="text-gray-500 text-sm">
						Lengkapi nama barang dan kategori.
					</p>
				</div>

				<div class="flex flex-col gap-6">

					<div class="flex flex-col gap-2">
						<label class="text-sm font-medium">
							Nama Barang
						</label>

						<input 
						type="text"
						placeholder="Masukkan nama barang..."
						class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white focus:outline-none"
						>
					</div>

					<div class="flex flex-col gap-2">
						<label class="text-sm font-medium">
							Kategori
						</label>

						<select class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white focus:outline-none">
							<option>Pilih kategori barang</option>
							<option>Perangkat Jaringan</option>
							<option>Audio Visual</option>
							<option>Infrastruktur Server</option>
						</select>
					</div>

				</div>

			</div>

			<hr class="border-t border-gray-300">

			{{-- DURASI & KETERANGAN --}}
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start">

				<div class="flex flex-col gap-1">
					<h2 class="text-3xl font-bold">
						Durasi & Keterangan
					</h2>

					<p class="text-gray-500 text-sm">
						Tentukan waktu peminjaman dan jumlah barang yang tersedia.
					</p>
				</div>

				<div class="flex flex-col gap-6">

					<div class="flex flex-col gap-2">
						<label class="text-sm font-medium">
							Keperluan / Keterangan
						</label>

						<textarea 
						rows="4"
						placeholder="Jelaskan keperluan peminjaman..."
						class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white focus:outline-none resize-none"
						></textarea>
					</div>

					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

						<div class="flex flex-col gap-2">
							<label class="text-sm font-medium">
								Tanggal Mulai
							</label>

							<input 
							type="date"
							class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white focus:outline-none"
							>
						</div>

						<div class="flex flex-col gap-2">
							<label class="text-sm font-medium">
								Tanggal Selesai
							</label>

							<input 
							type="date"
							class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white focus:outline-none"
							>
						</div>

						<div class="flex flex-col gap-2">
							<label class="text-sm font-medium">
								Jumlah
							</label>

							<input 
							type="number"
							min="1"
							placeholder="0"
							class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white focus:outline-none"
							>
						</div>

					</div>

				</div>

			</div>

			<hr class="border-t border-gray-300">

			{{-- ACTION --}}
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

				<div></div>

				<div class="flex items-center gap-4">

					<button 
					type="button"
					class="w-full border border-gray-300 rounded-full px-6 py-3 hover:bg-gray-100 transition-all"
					>
					Batal
				</button>

				<button 
				type="submit"
				class="w-full border border-transparent bg-[#363062] rounded-full px-6 py-3 text-white hover:bg-transparent hover:border-[#363062] hover:text-[#363062] transition-all"
				>
				Simpan
			</button>

		</div>

	</div>

</form>

</div>
</div>
@endsection