@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4 h-screen">
	<div class="w-full flex flex-col gap-10">

		<div class="flex flex-col">
			<h1 class="text-4xl font-bold text-gray-900">Pengaturan & Preferensi</h1>
			<p class="text-gray-500">Atur pengaturan profil Anda</p>
		</div>

		<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start">

			<div class="flex flex-col gap-1">
				<h2 class="text-3xl font-bold text-gray-800">Detail Profil</h2>
				<p class="text-gray-500 text-sm">Keterangan mengenai profil Anda</p>
			</div>

			<div class="flex flex-col gap-6">

				<div class="flex flex-col md:flex-row items-center gap-6">

					<div class="group w-32 h-32 rounded-full border border-gray-400 flex flex-col items-center justify-center flex-shrink-0 relative overflow-hidden bg-gray-100 cursor-pointer">

						<img src="{{ asset('images/mygw.jpeg') }}" alt="Profil Anda" class="w-full h-full object-cover">

						<div class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">

							<svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white mb-1" viewBox="0 0 24 24">
								<path fill="currentColor" d="M5 21h14c1.1 0 2-.9 2-2v-7h-2v7H5V5h7V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2"/>
								<path fill="currentColor" d="M7 13v3c0 .55.45 1 1 1h3c.27 0 .52-.11.71-.29l9-9a.996.996 0 0 0 0-1.41l-3-3a.996.996 0 0 0-1.41 0l-9.01 8.99A1 1 0 0 0 7 13m10-7.59L18.59 7L17.5 8.09L15.91 6.5zm-8 8l5.5-5.5l1.59 1.59l-5.5 5.5H9z"/>
							</svg>

							<span class="text-xs text-white font-medium">Ubah foto profil</span>

						</div>
					</div>

					<div class="flex flex-col flex-1 gap-4 w-full">

						<div class="flex flex-col gap-2 flex-1">
							<label class="text-sm font-medium text-gray-700">Nama</label>
							<input type="text" value="Argandull" disabled class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-100 text-gray-400 cursor-not-allowed focus:outline-none">
						</div>

						<div class="flex flex-col gap-2 flex-1">
							<label class="text-sm font-medium text-gray-700">Role</label>
							<input type="text" value="Peminjam" disabled class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-100 text-gray-400 cursor-not-allowed focus:outline-none">
						</div>

					</div>
				</div>

				<div class="flex flex-col gap-2">
					<label class="text-sm font-medium text-gray-700">Email</label>
					<input type="email" placeholder="Masukkan email..." value="argarill226@gmail.com" class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white focus:outline-none">
				</div>

			</div>
		</div>

		<hr class="border-t border-gray-300">

		<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start">

			<div class="flex flex-col gap-1">
				<h2 class="text-3xl font-bold text-gray-800">Keamanan Akun</h2>
				<p class="text-gray-500 text-sm">Ubah password Anda untuk lebih mengamankan akun</p>
			</div>

			<div class="flex flex-col gap-6">

				<div class="flex flex-col gap-2">
					<label class="text-sm font-medium text-gray-700">Password saat ini</label>
					<input type="password" placeholder="Masukkan password Anda saat ini..." class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white focus:outline-none">
				</div>

				<div class="flex flex-col gap-2">
					<label class="text-sm font-medium text-gray-700">Password baru</label>
					<input type="password" placeholder="Masukkan password baru Anda..." class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white focus:outline-none">
				</div>

			</div>
		</div>

		<hr class="border-t border-gray-300">

		<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

			<div></div>

			<div>
				<button type="submit" class="w-full border border-transparent bg-[#363062] rounded-full px-6 py-3 text-white hover:bg-transparent hover:border-[#363062] hover:text-[#363062] transition-all">
					Simpan perubahan
				</button>
			</div>

		</div>

	</div>
</div>
@endsection