@extends('layouts.app')

@section('content')
	<div class="mx-auto pt-20 pb-8 lg:py-8 px-4">

		{{-- HEADER --}}
		<div class="mb-8 sm:mb-10 flex flex-col gap-1">
			<h1 class="text-2xl sm:text-4xl font-bold text-gray-900 leading-tight">Manajemen Users</h1>
			<p class="text-xs sm:text-sm text-gray-500 font-medium">
				Kelola data pengguna, pantau aktivitas, dan kontrol akses sistem dengan mudah.
			</p>
		</div>

		{{-- CARD --}}
		<div class="bg-white border border-gray-300 rounded-[20px] p-4 sm:p-6 shadow-lg mb-8 sm:mb-10">
			<h2 class="text-xl sm:text-2xl font-semibold mb-4 sm:mb-6">
				Total Users saat ini
			</h2>

			{{-- GRID 3 KOLOM --}}
			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-10 items-start">

				{{-- PEMINJAM --}}
				<div class="flex flex-col gap-2 sm:gap-4 items-start">
					<span
						class="w-fit px-2 py-0.5 sm:px-3 sm:py-1 text-white text-[10px] sm:text-sm bg-gradient-to-r from-[#363062] to-[#4D4C7D] shadow-md rounded-full font-bold">
						Peminjam
					</span>

					<div class="flex items-center gap-2">
						<div class="w-12 h-12 sm:w-20 sm:h-20">
							<svg xmlns="http://www.w3.org/2000/svg" class="text-black" viewBox="0 0 24 24">
								<path fill="currentColor"
									d="M12 6c1.654 0 3 1.346 3 3s-1.346 3-3 3s-3-1.346-3-3s1.346-3 3-3m0-2C9.236 4 7 6.238 7 9s2.236 5 5 5s5-2.238 5-5s-2.236-5-5-5m0 13c2.021 0 3.301.771 3.783 1.445c-.683.26-1.969.555-3.783.555c-1.984 0-3.206-.305-3.818-.542C8.641 17.743 9.959 17 12 17m0-2c-3.75 0-6 2-6 4c0 1 2.25 2 6 2c3.518 0 6-1 6-2c0-2-2.354-4-6-4" />
							</svg>
						</div>
						<span class="text-3xl sm:text-5xl font-bold">
							{{ $stats['total']['peminjam'] }}
						</span>
					</div>

					<div class="flex items-center gap-2">
						<div class="w-2 h-2 bg-green-500 rounded-full"></div>
						<span class="text-[10px] sm:text-sm text-gray-500 font-medium">{{ $stats['online']['peminjam'] }}
							Peminjam online saat ini</span>
					</div>
				</div>

				{{-- PETUGAS --}}
				<div class="flex flex-col gap-2 sm:gap-4 items-start">
					<span
						class="w-fit px-2 py-0.5 sm:px-3 sm:py-1 text-white text-[10px] sm:text-sm bg-gradient-to-r from-gray-500 to-gray-400 rounded-full font-bold">
						Petugas
					</span>

					<div class="flex items-center gap-2">
						<div class="w-12 h-12 sm:w-20 sm:h-20">
							<svg xmlns="http://www.w3.org/2000/svg" class="text-black" viewBox="0 0 24 24">
								<path fill="currentColor"
									d="M12 6c1.654 0 3 1.346 3 3s-1.346 3-3 3s-3-1.346-3-3s1.346-3 3-3m0-2C9.236 4 7 6.238 7 9s2.236 5 5 5s5-2.238 5-5s-2.236-5-5-5m0 13c2.021 0 3.301.771 3.783 1.445c-.683.26-1.969.555-3.783.555c-1.984 0-3.206-.305-3.818-.542C8.641 17.743 9.959 17 12 17m0-2c-3.75 0-6 2-6 4c0 1 2.25 2 6 2c3.518 0 6-1 6-2c0-2-2.354-4-6-4" />
							</svg>
						</div>
						<span class="text-3xl sm:text-5xl font-bold">
							{{ $stats['total']['petugas'] }}
						</span>
					</div>

					<div class="flex items-center gap-2">
						<div class="w-2 h-2 bg-green-500 rounded-full"></div>
						<span class="text-[10px] sm:text-sm text-gray-500 font-medium">{{ $stats['online']['petugas'] }}
							Petugas online saat ini</span>
					</div>
				</div>

				{{-- ADMIN --}}
				<div class="flex flex-col gap-2 sm:gap-4 items-start">
					<span
						class="w-fit px-2 py-0.5 sm:px-3 sm:py-1 text-white text-[10px] sm:text-sm bg-gradient-to-r from-[#F99417] to-[#F99417]/50 rounded-full font-bold">
						Admin
					</span>

					<div class="flex items-center gap-2">
						<div class="w-12 h-12 sm:w-20 sm:h-20">
							<svg xmlns="http://www.w3.org/2000/svg" class="text-black" viewBox="0 0 24 24">
								<path fill="currentColor"
									d="M12 6c1.654 0 3 1.346 3 3s-1.346 3-3 3s-3-1.346-3-3s1.346-3 3-3m0-2C9.236 4 7 6.238 7 9s2.236 5 5 5s5-2.238 5-5s-2.236-5-5-5m0 13c2.021 0 3.301.771 3.783 1.445c-.683.26-1.969.555-3.783.555c-1.984 0-3.206-.305-3.818-.542C8.641 17.743 9.959 17 12 17m0-2c-3.75 0-6 2-6 4c0 1 2.25 2 6 2c3.518 0 6-1 6-2c0-2-2.354-4-6-4" />
							</svg>
						</div>
						<span class="text-3xl sm:text-5xl font-bold">
							{{ $stats['total']['admin'] }}
						</span>
					</div>

					<div class="flex items-center gap-2">
						<div class="w-2 h-2 bg-green-500 rounded-full"></div>
						<span class="text-[10px] sm:text-sm text-gray-500 font-medium">{{ $stats['online']['admin'] }} Admin
							online saat ini</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- CARD TABEL + FILTER --}}
	<div class="lg:col-span-3 w-full">
		<div class="w-full flex flex-col gap-6">

			{{-- TOP BAR (FILTER + EXPORT) --}}
			<form method="GET" action="{{ route('admin-pengguna') }}"
				class="flex items-center justify-between gap-4 flex-wrap">

				<div class="flex items-center gap-3 flex-wrap">

					{{-- SEARCH --}}
					<div class="relative w-52 h-full flex-shrink-0">
						<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24">
								<path fill="currentColor"
									d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6" />
							</svg>
						</div>
						<input type="text" name="search" value="{{ request('search') }}" placeholder="Cari user..."
							onchange="this.form.submit()"
							class="w-full h-full pl-10 pr-4 py-3 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black transition-shadow bg-white">
					</div>

					{{-- FILTER DROPDOWN --}}
					<div x-data="{ open: false }" class="relative inline-block text-left">
						<button type="button" @click="open = !open"
							class="w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]" viewBox="0 0 24 24">
								<path fill="currentColor"
									d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75" />
							</svg>
						</button>

						<div x-show="open" @click.outside="open = false" style="display:none" x-transition.opacity
							class="max-h-[250px] absolute left-0 z-20 mt-2 w-56 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 overflow-y-auto border border-gray-100">
							<div class="py-2">

								{{-- FILTER ROLE --}}
								<p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Role</p>

								<label
									class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
									<input type="radio" name="role_filter" value="" onchange="this.form.submit()"
										class="mr-3 w-4 h-4 text-[#363062]" {{ request('role_filter') == '' ? 'checked' : '' }}>
									Semua Role
								</label>

								<label
									class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
									<input type="radio" name="role_filter" value="admin" onchange="this.form.submit()"
										class="mr-3 w-4 h-4 text-[#363062]" {{ request('role_filter') == 'admin' ? 'checked' : '' }}>
									Admin
								</label>

								<label
									class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
									<input type="radio" name="role_filter" value="petugas" onchange="this.form.submit()"
										class="mr-3 w-4 h-4 text-[#363062]" {{ request('role_filter') == 'petugas' ? 'checked' : '' }}>
									Petugas
								</label>

								<label
									class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
									<input type="radio" name="role_filter" value="peminjam" onchange="this.form.submit()"
										class="mr-3 w-4 h-4 text-[#363062]" {{ request('role_filter') == 'peminjam' ? 'checked' : '' }}>
									Peminjam
								</label>

								<div class="border-t border-gray-100 my-1 mx-4"></div>

								{{-- FILTER STATUS --}}
								<p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Status</p>

								<label
									class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
									<input type="radio" name="status_filter" value="" onchange="this.form.submit()"
										class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_filter') == '' ? 'checked' : '' }}>
									Semua Status
								</label>

								<label
									class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
									<input type="radio" name="status_filter" value="aktif" onchange="this.form.submit()"
										class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_filter') == 'aktif' ? 'checked' : '' }}>
									<span class="flex items-center gap-2">
										<span class="w-2 h-2 bg-green-500 rounded-full"></span>
										Aktif
									</span>
								</label>

								<label
									class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
									<input type="radio" name="status_filter" value="nonaktif" onchange="this.form.submit()"
										class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_filter') == 'nonaktif' ? 'checked' : '' }}>
									<span class="flex items-center gap-2">
										<span class="w-2 h-2 bg-gray-400 rounded-full"></span>
										Nonaktif
									</span>
								</label>

							</div>
						</div>
					</div>

					{{-- RESET FILTER BUTTON --}}
					@if(request('search') || request('role_filter') || request('status_filter'))
						<a href="{{ route('admin-pengguna') }}"
							class="px-4 py-3 text-sm text-[#363062]/90 hover:text-[#363062] border border-[#363062] rounded-full transition font-semibold">
							Reset Filter
						</a>
					@endif

				</div>

				<div class="flex items-center gap-3 flex-wrap">
					<a href="{{ route('admin-pengguna-create') }}"
						class="px-4 py-3 flex items-center gap-2 border border-transparent text-white font-semibold rounded-full text-sm bg-[#363062] group hover:bg-transparent hover:text-[#363062] hover:border-[#363062] transition-all">
						Tambahkan User
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white group-hover:text-[#363062]"
							viewBox="0 0 24 24">
							<path fill="currentColor"
								d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2" />
						</svg>
					</a>
				</div>

			</form>

			<div class="w-full overflow-x-auto">

				<table class="w-full text-sm border-collapse">

					{{-- HEADER --}}
					<thead>
						<tr class="bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white">
							<th class="py-3 px-4 text-left w-12 rounded-tl-[20px]">No</th>
							<th class="py-3 px-4 text-left">Username</th>
							<th class="py-3 px-4 text-left">Nama Lengkap</th>
							<th class="py-3 px-4 text-left">Email</th>
							<th class="py-3 px-4 text-left">Role</th>
							<th class="py-3 px-4 text-left">Status</th>
							<th class="py-3 px-4 text-left rounded-tr-[20px]">Tombol Aksi</th>
						</tr>
					</thead>

					{{-- BODY --}}
					<tbody class="text-[#363062]">
						@forelse($users as $index => $user)
							<tr class="border-b border-gray-400 hover:bg-gray-50 transition">
								<td class="py-3 px-4">{{ $users->firstItem() + $index }}.</td>
								<td class="py-3 px-4">
									<div class="flex items-center gap-3">
										<div class="w-9 h-9 rounded-full overflow-hidden border border-gray-300">
											<img src="{{ $user->foto_url }}" alt="user" class="w-full h-full object-cover">
										</div>
										<span class="font-semibold text-[#363062]">
											{{ $user->username }}
										</span>
									</div>
								</td>
								<td class="py-3 px-4">{{ $user->nama_lengkap }}</td>
								<td class="py-3 px-4 text-gray-600">{{ $user->email }}</td>
								<td class="py-3 px-4">
									@php
										$roleColors = [
											'admin' => 'from-[#F99417] to-[#F99417]/50',
											'petugas' => 'from-gray-400 to-gray-300',
											'peminjam' => 'from-[#363062] to-[#4D4C7D]',
										];
										$roleColor = $roleColors[$user->role] ?? 'from-gray-400 to-gray-300';
									@endphp
									<span
										class="inline-flex px-3 py-1 text-xs text-white bg-gradient-to-r {{ $roleColor }} rounded-full">
										{{ ucfirst($user->role) }}
									</span>
								</td>
								<td class="py-3 px-4">
									@if($user->isOnline())
										<span
											class="inline-flex items-center gap-2 px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
											<span class="w-2 h-2 bg-green-500 rounded-full"></span>
											Aktif
										</span>
									@else
										<span
											class="inline-flex items-center gap-2 px-3 py-1 text-xs font-medium bg-gray-100 text-gray-500 rounded-full">
											<span class="w-2 h-2 bg-gray-400 rounded-full"></span>
											Offline
										</span>
									@endif
								</td>
								<td class="py-3 px-4">
									<div class="flex items-center gap-2">
										<a href="{{ route('admin-pengguna-edit', $user->username) }}"
											class="px-3 py-1 text-sm rounded-full border border-[#363062] text-[#363062] hover:bg-[#363062] hover:text-white transition">
											Edit
										</a>
										<form action="{{ route('admin-pengguna-destroy', $user) }}" method="POST"
											onsubmit="return confirm('Yakin ingin menghapus user ini?')">
											@csrf
											@method('DELETE')
											<button type="submit"
												class="px-3 py-1 text-sm rounded-full border border-red-400 text-red-500 hover:bg-red-500 hover:text-white transition">
												Hapus
											</button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center py-10 text-gray-400">
									Belum ada data user
								</td>
							</tr>
						@endforelse
					</tbody>

				</table>

				{{-- Pagination --}}
				<div class="col-span-3 mt-6">
					@if($users->hasPages())
						<div class="flex flex-col sm:flex-row items-center justify-between gap-4">
							{{-- Keterangan Data --}}
							<div class="text-sm text-gray-500 order-2 sm:order-1 text-center sm:text-left">
								Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }}
								data
							</div>

							{{-- Navigasi Tombol --}}
							<div class="flex items-center gap-2 order-1 sm:order-2">
								{{-- Tombol Previous --}}
								@if($users->onFirstPage())
									<button type="button" disabled
										class="p-3 rounded-full border text-sm flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
											<defs>
												<path id="SVG1pzpbdYY_prev" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG1pzpbdYY_prev" transform="rotate(-180 5.02 9.505)" />
										</svg>
									</button>
								@else
									<a href="{{ $users->appends(request()->query())->previousPageUrl() }}"
										class="p-3 rounded-full border bg-white text-sm flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
											<defs>
												<path id="SVG1pzpbdYY_prev" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG1pzpbdYY_prev" transform="rotate(-180 5.02 9.505)" />
										</svg>
									</a>
								@endif

								{{-- Nomor Halaman --}}
								<div class="flex items-center gap-1 bg-gray-100 p-1.5 sm:p-2 rounded-full shadow-inner">
									@php
										$currentPage = $users->currentPage();
										$lastPage = $users->lastPage();
										$start = max(1, $currentPage - 1); // Di mobile disempitkan jangkauannya agar tidak kepanjangan
										$end = min($lastPage, $currentPage + 1);

										if ($start > 1) {
											$activeClassFirst = (1 == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
											echo '<a href="' . $users->appends(request()->query())->url(1) . '" class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition ' . $activeClassFirst . '">1</a>';
											if ($start > 2) {
												echo '<span class="px-1 text-gray-400 text-xs">...</span>';
											}
										}

										for ($i = $start; $i <= $end; $i++) {
											$activeClass = ($i == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
											echo '<a href="' . $users->appends(request()->query())->url($i) . '" class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition ' . $activeClass . '">' . $i . '</a>';
										}

										if ($end < $lastPage) {
											if ($end < $lastPage - 1) {
												echo '<span class="px-1 text-gray-400 text-xs">...</span>';
											}
											$activeClassLast = ($lastPage == $currentPage) ? 'bg-[#363062] text-white' : 'hover:bg-gray-200 text-gray-700';
											echo '<a href="' . $users->appends(request()->query())->url($lastPage) . '" class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition ' . $activeClassLast . '">' . $lastPage . '</a>';
										}
									@endphp
								</div>

								{{-- Tombol Next --}}
								@if($users->hasMorePages())
									<a href="{{ $users->appends(request()->query())->nextPageUrl() }}"
										class="p-3 rounded-full border bg-white text-sm flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
											<defs>
												<path id="SVG1pzpbdYY_next" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG1pzpbdYY_next" transform="rotate(-180 5.02 9.505)" />
										</svg>
									</a>
								@else
									<button type="button" disabled
										class="p-3 rounded-full border text-sm flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
											<defs>
												<path id="SVG1pzpbdYY_next" fill="currentColor"
													d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
											</defs>
											<use fill-rule="evenodd" href="#SVG1pzpbdYY_next" transform="rotate(-180 5.02 9.505)" />
										</svg>
									</button>
								@endif
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>

	</div>
	</div>
	</div>
@endsection