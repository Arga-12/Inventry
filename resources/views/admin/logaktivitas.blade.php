@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4">
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-stretch">

		{{-- HEADER TITLE & DESC --}}
		<div class="lg:col-span-3 flex flex-col gap-1 mb-2">
			<h1 class="text-4xl font-bold">Log Aktivitas</h1>
			<p class="text-sm font-medium text-gray-500">
				Monitor seluruh riwayat aktivitas peminjaman, status respons server, hingga log anomali sistem secara real-time untuk kebutuhan audit admin.
			</p>
		</div>

		{{-- CARD 1: Peminjaman & Pengembalian --}}
		<div class="lg:col-span-1 h-full">
			<div class="h-full w-full bg-white border border-gray-300 shadow-lg rounded-[20px] flex flex-col justify-between p-6">
				<h2 class="font-semibold text-lg">Aktivitas peminjaman & pengembalian</h2>

				{{-- Penambahan Flex Baseline --}}
				<div class="flex items-baseline gap-2 my-4">
					<span class="text-6xl font-bold text-[#363062]">165</span>
					<span class="text-sm font-medium text-gray-500">Aktivitas</span>
				</div>

				<div class="flex items-center gap-4 text-sm text-gray-500 mt-auto flex-wrap">
					<div class="flex items-center gap-2">
						<span class="w-2 h-2 rounded-full bg-[#F99417]"></span>
						<span>50 Peminjaman</span>
					</div>
					<div class="flex items-center gap-2">
						<span class="w-2 h-2 rounded-full bg-[#4D4C7D]"></span>
						<span>43 Pengembalian</span>
					</div>
				</div>
			</div>
		</div>

		{{-- CARD 2: Server Status --}}
		<div class="lg:col-span-1 h-full">
			<div class="h-full w-full bg-white border border-gray-300 shadow-lg rounded-[20px] flex flex-col justify-between p-6">
				<h2 class="font-semibold text-lg">HTTP Request Log</h2>

				{{-- Penambahan Flex Baseline --}}
				<div class="flex items-baseline gap-2 my-4">
					<span class="text-6xl font-bold text-[#363062]">450</span>
					<span class="text-sm font-medium text-gray-500">Requests</span>
				</div>

				<div class="flex items-center gap-4 text-sm text-gray-500 mt-auto flex-wrap">
					<div class="flex items-center gap-2">
						<span class="w-2 h-2 rounded-full bg-red-500"></span>
						<span>400 code - 24</span>
					</div>
					<div class="flex items-center gap-2">
						<span class="w-2 h-2 rounded-full bg-blue-500"></span>
						<span>300 code - 45</span>
					</div>
					<div class="flex items-center gap-2">
						<span class="w-2 h-2 rounded-full bg-green-500"></span>
						<span>200 code - 79</span>
					</div>
				</div>
			</div>
		</div>

		{{-- CARD 3: Kerentanan & Error --}}
		<div class="lg:col-span-1 h-full">
			<div class="h-full w-full bg-white border border-gray-300 shadow-lg rounded-[20px] flex flex-col justify-between p-6">
				<h2 class="font-semibold text-lg flex items-center gap-2">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M2.725 21q-.275 0-.5-.137t-.35-.363t-.137-.488t.137-.512l9.25-16q.15-.25.388-.375T12 3t.488.125t.387.375l9.25 16q.15.25.138.513t-.138.487t-.35.363t-.5.137zm1.725-2h15.1L12 6zm8.263-1.287Q13 17.425 13 17t-.288-.712T12 16t-.712.288T11 17t.288.713T12 18t.713-.288m0-3Q13 14.425 13 14v-3q0-.425-.288-.712T12 10t-.712.288T11 11v3q0 .425.288.713T12 15t.713-.288M12 12.5"/></svg>
					Aktivitas kerentanan & error
				</h2>

				{{-- Penambahan Flex Baseline --}}
				<div class="flex items-baseline gap-2 my-4">
					<span class="text-6xl font-bold text-[#363062]">12</span>
					<span class="text-sm font-medium text-gray-500">Insiden</span>
				</div>

				<div class="flex items-center gap-4 text-sm text-gray-500 mt-auto flex-wrap">
					<div class="flex items-center gap-2">
						<span class="w-2 h-2 rounded-full bg-red-500"></span>
						<span>2 Error platform</span>
					</div>
					<div class="flex items-center gap-2">
						<span class="w-2 h-2 rounded-full bg-red-700"></span>
						<span>10 Anomali</span>
					</div>
				</div>
			</div>
		</div>

		{{-- CARD TABEL + FILTER --}}
		<div class="lg:col-span-3 w-full">
			<div class="w-full flex flex-col gap-6">

				<div class="flex items-center justify-between gap-4 flex-wrap">

					<div class="flex items-center gap-3 flex-wrap">
						<button class="flex items-center gap-2 h-11 px-4 border border-[#363062] rounded-full text-sm font-medium bg-white text-[#363062] hover:bg-gray-100">
							<span>Sepanjang waktu</span>

							<svg xmlns="http://www.w3.org/2000/svg" 
							class="w-4 h-4"
							viewBox="0 0 1024 1024">
							<path fill="currentColor" d="M831.9 340.9L512 652.7L192.1 340.9a30.6 30.6 0 0 0-42.7 0a29 29 0 0 0 0 41.6l340.3 331.7a32 32 0 0 0 44.6 0l340.3-331.7a29 29 0 0 0 0-41.7a30.6 30.6 0 0 0-42.7 0z"/>
						</svg>
					</button>

					<div class="relative w-52 h-full flex-shrink-0">
						<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
						</div>
						<input type="text" placeholder="Cari peminjam..." class="w-full h-full pl-10 pr-4 py-3 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow bg-[#F5F5F5]">
					</div>

					<button class="w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/></svg>
					</button>
				</div>
			</div>

			<div class="w-full overflow-x-auto">

				<table class="w-full text-sm border-collapse">

					{{-- HEADER --}}
					<thead>
						<tr class="bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white">
							<th class="py-3 px-4 text-left w-24 rounded-tl-[20px]">Id log</th>
							<th class="py-3 px-4 text-left">Timestamp</th>
							<th class="py-3 px-4 text-left">User_id</th>
							<th class="py-3 px-4 text-left">Tipe aktivitas</th>
							<th class="py-3 px-4 text-left">Aksi</th>
							<th class="py-3 px-4 text-left">Keterangan</th>
							<th class="py-3 px-4 text-left rounded-tr-[20px]">Status</th>
						</tr>
					</thead>

					{{-- BODY --}}
					<tbody class="text-[#363062]">

						{{-- ROW 1: Contoh Aktivitas User (Peminjaman) --}}
						<tr class="border-b border-gray-300 hover:bg-gray-50 transition-colors">
							<td class="py-3 px-4 font-semibold">001</td>
							<td class="py-3 px-4">
								<div class="flex items-center gap-2">
									<div class="px-3 py-1 bg-gray-100 text-[#363062] border border-gray-200 rounded-full text-xs font-medium">
										12 - 05 - 2026
									</div>
									<div class="px-3 py-1 bg-gray-100 text-[#363062] border border-gray-200 rounded-full text-xs font-medium">
										06:45
									</div>
								</div>
							</td>
							<td class="py-3 px-4 font-medium">#1 Argandull</td>
							<td class="py-3 px-4">Peminjam</td>
							<td class="py-3 px-4">Peminjaman alat & barang</td>
							<td class="py-3 px-4 text-gray-600 truncate max-w-[200px]">
								Peminjaman dengan ID #INVT-2604-021
							</td>
							<td class="py-3 px-4 text-left">
								<div class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold text-xs text-center border border-green-200">
									Success
								</div>
							</td>
						</tr>

						{{-- ROW 2: Contoh Aktivitas Sistem (HTTP Request) --}}
						<tr class="border-b border-gray-300 hover:bg-gray-50 transition-colors">
							<td class="py-3 px-4 font-semibold">002</td>
							<td class="py-3 px-4">
								<div class="flex items-center gap-2">
									<div class="px-3 py-1 bg-gray-100 text-[#363062] border border-gray-200 rounded-full text-xs font-medium">
										12 - 05 - 2026
									</div>
									<div class="px-3 py-1 bg-gray-100 text-[#363062] border border-gray-200 rounded-full text-xs font-medium">
										07:15
									</div>
								</div>
							</td>
							<td class="py-3 px-4 font-medium">#21 Budi Tarmiji</td>
							<td class="py-3 px-4">Server Status</td>
							<td class="py-3 px-4 font-mono text-xs">POST /127.0.0.1:8000/login</td>
							<td class="py-3 px-4 text-gray-600 truncate max-w-[200px]" title="User authentication request">
								User authentication request
							</td>
							<td class="py-3 px-4 text-left">
								<div class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-semibold text-xs text-center border border-blue-200">
									200 OK
								</div>
							</td>
						</tr>

						{{-- ROW 3: Contoh Aktivitas Error (Kerentanan & Error) --}}
						<tr class="border-b border-gray-300 hover:bg-gray-50 transition-colors">
							<td class="py-3 px-4 font-semibold">003</td>
							<td class="py-3 px-4">
								<div class="flex items-center gap-2">
									<div class="px-3 py-1 bg-gray-100 text-[#363062] border border-gray-200 rounded-full text-xs font-medium">
										12 - 05 - 2026
									</div>
									<div class="px-3 py-1 bg-gray-100 text-[#363062] border border-gray-200 rounded-full text-xs font-medium">
										08:30
									</div>
								</div>
							</td>
							<td class="py-3 px-4 text-gray-400 italic">System</td>
							<td class="py-3 px-4">Error</td>
							<td class="py-3 px-4 font-mono text-xs text-red-600">DB_TIMEOUT</td>
							<td class="py-3 px-4 text-gray-600 truncate max-w-[200px]" title="Gagal terhubung ke database server utama">
								MariaDB timeout
							</td>
							<td class="py-3 px-4 text-left">
								<div class="px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold text-xs text-center border border-red-200">
									500 Error
								</div>
							</td>
						</tr>

						{{-- EMPTY STATE (Opsional, di-uncomment jika butuh) --}}
						{{-- <tr>
							<td colspan="7" class="text-center py-10 text-gray-400">
								Belum ada log aktivitas
							</td>
						</tr> --}}

					</tbody>

				</table>

				<div class="flex items-center justify-between mt-6">

					<div class="text-sm text-gray-500">
						Halaman 1 dari 10
					</div>

					<div class="flex items-center gap-2">

						<button class="p-3 rounded-full border text-sm flex items-center justify-center">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-180" viewBox="0 0 12 24"><defs><path id="SVG1pzpbdYY" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs><use fill-rule="evenodd" href="#SVG1pzpbdYY" transform="rotate(-180 5.02 9.505)"/></svg>
						</button>

						<div class="flex items-center gap-1 bg-gray-100 p-3 rounded-full">

							<button class="px-3 py-1 rounded-full text-sm bg-[#363062] text-white">
								1
							</button>

							<button class="px-3 py-1 rounded-full text-sm">
								2
							</button>

							<button class="px-3 py-1 rounded-full text-sm">
								3
							</button>

						</div>

						<button class="p-3 rounded-full border text-sm flex items-center justify-center">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 12 24"><defs><path id="SVG1pzpbdYY" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs><use fill-rule="evenodd" href="#SVG1pzpbdYY" transform="rotate(-180 5.02 9.505)"/></svg>
						</button>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection