@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4">
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-stretch">

		<div class="lg:col-span-3 flex flex-col gap-1 mb-2">
			<h1 class="text-4xl font-bold">Dashboard</h1>
			<p class="text-sm font-medium text-gray-500">
				Selamat datang di Inventry, kelola data peminjaman, pantau stok alat, dan awasi aktivitas sistem secara real-time.
			</p>
		</div>

		{{-- CARD DIAGRAM (KOSONG DULU) --}}
		<div class="lg:col-span-2 h-full">
			<div class="w-full h-full bg-white shadow-lg border border-gray-300 rounded-[20px] p-4 flex flex-col gap-4 items-center">
				<div class="w-full flex items-center justify-between">
					<h2 class="text-2xl font-bold">Pengajuan Peminjaman & Pengembalian</h2>

					<button class="flex items-center gap-2 px-4 py-2 text-sm bg-[#363062] text-white rounded-full shadow-sm">
						Per Bulan

						<svg xmlns="http://www.w3.org/2000/svg" 
						class="w-4 h-4 text-white"
						viewBox="0 0 1024 1024">
						<path fill="currentColor" d="M831.9 340.9L512 652.7L192.1 340.9a30.6 30.6 0 0 0-42.7 0a29 29 0 0 0 0 41.6l340.3 331.7a32 32 0 0 0 44.6 0l340.3-331.7a29 29 0 0 0 0-41.7a30.6 30.6 0 0 0-42.7 0z"/>
					</button>
				</div>


				<div id="chart" class="w-full h-full"></div>
			</div>
		</div>

		{{-- KOLOM KANAN --}}
		<div class="lg:col-span-1 flex flex-col gap-6">

			{{-- CARD 1: STOK KESELURUHAN --}}
			<div class="bg-gradient-to-br from-[#363062] to-[#4D4C7D] text-white rounded-[20px] shadow-lg p-4 flex flex-col justify-between h-[200px]">

				<div class="flex flex-col gap-2">
					<span class="text-lg text-white font-semibold">
						Stok keseluruhan alat saat ini
					</span>

					<span class="text-5xl font-bold mt-3">
						514
					</span>
				</div>

				{{-- PROGRESS --}}
				<div class="w-full">
					<div class="w-full h-2 rounded-full overflow-hidden bg-gray-600 relative">
						<div class="absolute left-0 top-0 h-full w-[40%] bg-[#F99417]"></div>
						<div class="absolute left-[40%] top-0 h-full w-[25%] bg-[#42f5d7]"></div>
						<div class="absolute left-[65%] top-0 h-full w-[35%] bg-[#eb8abf]"></div>
					</div>

					{{-- LEGEND --}}
					<div class="flex items-center gap-4 text-xs text-gray-300 mt-2 flex-wrap">

						<div class="flex items-center gap-2">
							<div class="h-2 w-2 rounded-full bg-[#F99417]"></div>
							<span>Komponen Komputer</span>
						</div>

						<div class="flex items-center gap-2">
							<div class="h-2 w-2 rounded-full bg-[#42f5d7]"></div>
							<span>Alat Bantu</span>
						</div>

						<div class="flex items-center gap-2">
							<div class="h-2 w-2 rounded-full bg-[#eb8abf]"></div>
							<span>ATK</span>
						</div>

					</div>
				</div>

			</div>

			{{-- CARD 2: STOK MENIPIS --}}
			<div class="bg-gradient-to-br from-[#363062] to-[#4D4C7D] text-white rounded-[20px] shadow-lg p-4 flex flex-col gap-4">

				<span class="font-bold text-lg">
					Stok alat menipis
				</span>

				{{-- LIST --}}
				<div class="flex flex-col gap-3 text-sm">

					<div class="flex items-center justify-between">
						<div class="flex items-center gap-2">
							<div class="h-2 w-2 rounded-full bg-gray-400"></div>
							<span>alat1 - kategori</span>
						</div>
						<span class="text-gray-300">3 Tersisa</span>
					</div>

					<div class="flex items-center justify-between">
						<div class="flex items-center gap-2">
							<div class="h-2 w-2 rounded-full bg-gray-400"></div>
							<span>alat1 - kategori</span>
						</div>
						<span class="text-gray-300">3 Tersisa</span>
					</div>

					<div class="flex items-center justify-between">
						<div class="flex items-center gap-2">
							<div class="h-2 w-2 rounded-full bg-gray-400"></div>
							<span>alat1 - kategori</span>
						</div>
						<span class="text-gray-300">3 Tersisa</span>
					</div>

					<div class="flex items-center justify-between">
						<div class="flex items-center gap-2">
							<div class="h-2 w-2 rounded-full bg-gray-400"></div>
							<span>alat1 - kategori</span>
						</div>
						<span class="text-gray-300">3 Tersisa</span>
					</div>

				</div>

				{{-- WARNING --}}
				<div class="flex items-center gap-2 text-xs text-gray-400 mt-auto">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M2.725 21q-.275 0-.5-.137t-.35-.363t-.137-.488t.137-.512l9.25-16q.15-.25.388-.375T12 3t.488.125t.387.375l9.25 16q.15.25.138.513t-.138.487t-.35.363t-.5.137zm1.725-2h15.1L12 6zm8.263-1.287Q13 17.425 13 17t-.288-.712T12 16t-.712.288T11 17t.288.713T12 18t.713-.288m0-3Q13 14.425 13 14v-3q0-.425-.288-.712T12 10t-.712.288T11 11v3q0 .425.288.713T12 15t.713-.288M12 12.5"/></svg>
					<span>Segera isi persediaan alat yang hampir habis</span>
				</div>

			</div>

		</div>

		{{-- ROW BARU --}}
		<div class="lg:col-span-2 h-full">
			<div class="w-full h-[350px] bg-white border border-gray-300 rounded-[20px] p-4 shadow-lg flex flex-col">

				{{-- HEADER --}}
				<div class="flex items-center justify-between mb-4">
					<h2 class="text-2xl font-bold">
						Users Online saat ini
					</h2>

					<div class="flex items-center gap-3 text-sm text-[#4D4C7D]">
						<span>12 Peminjam</span>
						<span>|</span>
						<span>10 Petugas</span>
						<span>|</span>
						<span>1 Admin</span>

						<div class="ml-3 px-3 py-1 flex items-center gap-2 bg-gradient-to-r from-[#363062] to-[#4D4C7D] rounded-full text-xs font-semibold text-white">
							<div class="h-2 w-2 rounded-full bg-green-400"></div>

							23 Users
						</div>
					</div>
				</div>

				{{-- LIST USERS --}}
				<div class="grid grid-cols-1 md:grid-cols-3 gap-6 flex-1">

					@for ($i = 0; $i < 9; $i++)
					<div class="flex items-center rounded-full px-2 justify-between bg-transparent group hover:shadow-lg transition-all">

						<div class="flex items-center gap-3">
							<div class="w-10 h-10 rounded-full border border-gray-300 overflow-hidden">
								<img src="{{ asset('images/mygw.jpeg') }}" alt="user" class="w-full h-full object-cover">
							</div>

							<div class="flex flex-col">
								<span class="font-medium">Nama Users</span>
								<div class="flex items-center">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M12 6c1.654 0 3 1.346 3 3s-1.346 3-3 3s-3-1.346-3-3s1.346-3 3-3m0-2C9.236 4 7 6.238 7 9s2.236 5 5 5s5-2.238 5-5s-2.236-5-5-5m0 13c2.021 0 3.301.771 3.783 1.445c-.683.26-1.969.555-3.783.555c-1.984 0-3.206-.305-3.818-.542C8.641 17.743 9.959 17 12 17m0-2c-3.75 0-6 2-6 4c0 1 2.25 2 6 2c3.518 0 6-1 6-2c0-2-2.354-4-6-4"/></svg>
									<span class="text-xs font-[#363062]">Peminjam</span>
								</div>
							</div>
						</div>

						<button class="w-10 h-10 rounded-full flex items-center justify-center bg-gradient-to-r from-[#363062] to-[#4D4C7D] opacity-0 group-hover:opacity-100 transition-opacity duration-200">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 16l-1 4l4-1L19.586 7.414a2 2 0 0 0 0-2.828l-.172-.172a2 2 0 0 0-2.828 0zM15 6l3 3m-5 11h8"/></svg>
						</button>

					</div>
					@endfor

				</div>

				{{-- BUTTON --}}
				<div class="flex justify-end mt-4">
					<button class="px-4 py-2 text-sm border border-transparent bg-[#363062] text-white rounded-full hover:text-[#363062] hover:border-[#363062] hover:bg-transparent transition-all">
						Selengkapnya
					</button>
				</div>

			</div>
		</div>

		{{-- LOG AKTIVITAS --}}
		<div class="lg:col-span-1 h-[350px]">
			<div class="w-full h-full bg-gradient-to-r from-[#363062] to-[#4D4C7D] border border-gray-300 rounded-[20px] shadow-lg p-4 flex flex-col">

				<h2 class="text-lg font-bold text-white mb-3">
					Log aktivitas terbaru
				</h2>

				{{-- SCROLL AREA --}}
				<div class="flex flex-col gap-4 overflow-y-auto pr-1 flex-1">

					@for ($i = 0; $i < 8; $i++)
					<div class="bg-white rounded-xl p-3 flex flex-col gap-2">

						<div class="flex items-center justify-between">
							<div class="flex items-center gap-2">
								<div class="w-8 h-8 rounded-full overflow-hidden">
									<img src="{{ asset('images/mygw.jpeg') }}" alt="log" class="h-full w-full object-cover">
								</div>
								<span class="font-semibold">4rgandull</span>
							</div>

							<span class="text-xs bg-[#F99417]/50 text-[#363062] px-2 py-1 rounded-full">
								14:23
							</span>
						</div>

						<p class="text-xs text-[#363062]">
							Menunggu pengajuan peminjaman ID: #INVT-2605-001
						</p>

					</div>
					@endfor

				</div>

			</div>
		</div>
	</div>
</div>
@endsection