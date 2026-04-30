@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4 h-screen">
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-stretch">

		<div class="lg:col-span-3 flex flex-col gap-1 mb-2">
			<h1 class="text-4xl font-bold">Dashboard</h1>
			<p class="text-sm font-medium text-gray-500">
				Selamat datang di Inventry, kelola data peminjaman, pantau stok alat, dan awasi aktivitas sistem secara real-time.
			</p>
		</div>

		{{-- CARD DIAGRAM (KOSONG DULU) --}}
		<div class="lg:col-span-2 h-full">
			<div class="w-full h-full bg-white border border-gray-300 rounded-[24px] flex items-center justify-center">
				<span class="text-gray-400 text-lg">
					Area Diagram (ApexCharts nanti di sini)
				</span>
			</div>
		</div>

		{{-- KOLOM KANAN --}}
		<div class="lg:col-span-1 flex flex-col gap-6">

			{{-- CARD 1: STOK KESELURUHAN --}}
			<div class="bg-gradient-to-br from-[#363062] to-[#4D4C7D] text-white rounded-[20px] shadow-lg p-6 flex flex-col justify-between h-[200px]">

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
						<div class="absolute left-0 top-0 h-full w-[40%] bg-white"></div>
						<div class="absolute left-[40%] top-0 h-full w-[25%] bg-gray-400"></div>
						<div class="absolute left-[65%] top-0 h-full w-[35%] bg-gray-500"></div>
					</div>

					{{-- LEGEND --}}
					<div class="flex items-center gap-4 text-xs text-gray-300 mt-2 flex-wrap">

						<div class="flex items-center gap-2">
							<div class="h-2 w-2 rounded-full bg-gray-300"></div>
							<span>kategori1</span>
						</div>

						<div class="flex items-center gap-2">
							<div class="h-2 w-2 rounded-full bg-gray-400"></div>
							<span>kategori2</span>
						</div>

						<div class="flex items-center gap-2">
							<div class="h-2 w-2 rounded-full bg-gray-500"></div>
							<span>kategori3</span>
						</div>

						<div class="flex items-center gap-2">
							<div class="h-2 w-2 rounded-full bg-gray-600"></div>
							<span>kategori4</span>
						</div>

					</div>
				</div>

			</div>

			{{-- CARD 2: STOK MENIPIS --}}
			<div class="bg-gradient-to-br from-[#363062] to-[#4D4C7D] text-white rounded-[20px] shadow-lg p-6 flex flex-col gap-4">

				<span class="font-semibold text-lg">
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
				<div class="flex items-center gap-2 text-xs text-gray-500 mt-auto">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24"><path fill="currentColor" d="M2.725 21q-.275 0-.5-.137t-.35-.363t-.137-.488t.137-.512l9.25-16q.15-.25.388-.375T12 3t.488.125t.387.375l9.25 16q.15.25.138.513t-.138.487t-.35.363t-.5.137zm1.725-2h15.1L12 6zm8.263-1.287Q13 17.425 13 17t-.288-.712T12 16t-.712.288T11 17t.288.713T12 18t.713-.288m0-3Q13 14.425 13 14v-3q0-.425-.288-.712T12 10t-.712.288T11 11v3q0 .425.288.713T12 15t.713-.288M12 12.5"/></svg>
					<span>Segera isi persediaan alat yang hampir habis</span>
				</div>

			</div>

		</div>
	</div>
</div>
@endsection