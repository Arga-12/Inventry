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
		
		{{-- CARD 1: Peminjaman & Pengembalian (TETAP SAMA) --}}
		<div class="lg:col-span-1 h-full">
			<div class="h-full w-full bg-white border border-gray-300 shadow-lg rounded-[20px] flex flex-col justify-between p-6">
				<h2 class="font-semibold text-lg">Aktivitas peminjaman & pengembalian</h2>
				
				<div class="flex items-baseline gap-2 my-4">
					<span class="text-6xl font-bold text-[#363062]">{{ $stats['total_aktivitas'] }}</span>
					<span class="text-sm font-medium text-gray-500">Total Aktivitas</span>
				</div>
				
				<div class="flex items-center gap-4 text-sm text-gray-500 mt-auto flex-wrap">
					<div class="flex items-center gap-2">
						<span class="w-2 h-2 rounded-full bg-[#F99417]"></span>
						<span>{{ $stats['peminjaman'] }} Peminjaman</span>
					</div>
					<div class="flex items-center gap-2">
						<span class="w-2 h-2 rounded-full bg-[#4D4C7D]"></span>
						<span>{{ $stats['pengembalian'] }} Pengembalian</span>
					</div>
				</div>
			</div>
		</div>

		{{-- CARD 2: STATUS LOG (Success, Warning, Error) --}}
		<div class="lg:col-span-1 h-full">
			<div class="h-full w-full bg-white border border-gray-300 shadow-lg rounded-[20px] flex flex-col justify-between p-6">
				<h2 class="font-semibold text-lg">Status Log Aktivitas</h2>
				
				<div class="flex items-baseline gap-2 my-4">
					<span class="text-6xl font-bold text-[#363062]">{{ $stats['total_log'] }}</span>
					<span class="text-sm font-medium text-gray-500">Total Log</span>
				</div>
				
				<div class="flex items-center gap-4 text-sm text-gray-500 mt-auto flex-wrap">
					<div class="flex items-center gap-2">
						<span class="w-2 h-2 rounded-full bg-green-500"></span>
						<span>Success - {{ $stats['status_success'] }}</span>
					</div>
					<div class="flex items-center gap-2">
						<span class="w-2 h-2 rounded-full bg-yellow-500"></span>
						<span>Warning - {{ $stats['status_warning'] }}</span>
					</div>
					<div class="flex items-center gap-2">
						<span class="w-2 h-2 rounded-full bg-red-500"></span>
						<span>Error - {{ $stats['status_error'] }}</span>
					</div>
				</div>
			</div>
		</div>

		{{-- CARD 3: ERROR & ANOMALI --}}
		<div class="lg:col-span-1 h-full">
			<div class="h-full w-full bg-white border border-gray-300 shadow-lg rounded-[20px] flex flex-col justify-between p-6">
				<h2 class="font-semibold text-lg flex items-center gap-2">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M2.725 21q-.275 0-.5-.137t-.35-.363t-.137-.488t.137-.512l9.25-16q.15-.25.388-.375T12 3t.488.125t.387.375l9.25 16q.15.25.138.513t-.138.487t-.35.363t-.5.137zm1.725-2h15.1L12 6zm8.263-1.287Q13 17.425 13 17t-.288-.712T12 16t-.712.288T11 17t.288.713T12 18t.713-.288m0-3Q13 14.425 13 14v-3q0-.425-.288-.712T12 10t-.712.288T11 11v3q0 .425.288.713T12 15t.713-.288M12 12.5"/></svg>
					Error & Anomali Sistem
				</h2>
				
				<div class="flex items-baseline gap-2 my-4">
					<span class="text-6xl font-bold text-[#363062]">{{ $stats['total_error'] }}</span>
					<span class="text-sm font-medium text-gray-500">Total Error</span>
				</div>
				
				<div class="flex items-center gap-4 text-sm text-gray-500 mt-auto flex-wrap">
					<div class="flex items-center gap-2">
						<span class="w-2 h-2 rounded-full bg-red-500"></span>
						<span>{{ $stats['total_error'] }} Error & Anomali</span>
					</div>
				</div>
			</div>
		</div>
		
		{{-- TABEL + FILTER --}}
		<div class="lg:col-span-3 w-full">
			<div class="w-full flex flex-col gap-6">
				
				{{-- FILTER FORM --}}
                <form 
                    x-data="{
                        tanggal: '{{ $tanggal ?? '' }}',
                        modul: '{{ $modul ?? 'semua' }}',
                        aksi: '{{ $aksi ?? 'semua' }}',
                        status: '{{ $status ?? 'semua' }}',
                        role: '{{ $role ?? 'semua' }}',
                        search: '{{ $search ?? '' }}',
                        
                        submitFilter() {
                            this.$refs.filterForm.submit()
                        }
                    }"
                    x-ref="filterForm"
                    method="GET" 
                    action="{{ route('admin-log') }}" 
                    class="flex items-center justify-between gap-4 flex-wrap"
                >
                    
                    <div class="flex items-center gap-3 flex-wrap">
                        <input 
                            type="date" 
                            name="tanggal" 
                            x-model="tanggal"
                            @change="submitFilter()"
                            class="h-11 px-4 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] bg-white cursor-pointer"
                        >
                        
                        <div x-data="{ open: false }" class="relative inline-block text-left">
                            <button type="button" @click="open = !open" class="px-4 py-2 h-11 text-sm bg-white border border-gray-300 text-[#363062] rounded-full shadow-sm cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#F99417] hover:bg-gray-50 transition flex items-center gap-2">
                                <span x-text="modul === 'semua' ? 'Semua Modul' : modul.charAt(0).toUpperCase() + modul.slice(1)"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="h-5 w-5 text-[#363062] transition-transform duration-200" 
                                    :class="open ? 'rotate-0' : 'rotate-180'" 
                                    viewBox="0 0 1024 1024">
                                    <path fill="currentColor" d="M488.8 344.3L149 701a32 32 0 0 0 0 44.2l.4.3a29.4 29.4 0 0 0 42.7 0l320-335.8l319.8 335.8a29.4 29.4 0 0 0 42.7 0l.4-.3a32 32 0 0 0 0-44.2L535.2 344.3a32 32 0 0 0-46.4 0"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.outside="open = false" style="display:none" x-transition.opacity
                                class="absolute left-0 z-20 mt-2 w-48 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 overflow-y-auto border border-gray-100 max-h-60">
                                <div class="py-2">
                                    <a href="#" 
                                        class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition {{ ($modul ?? 'semua') == 'semua' ? 'bg-gray-100 font-semibold' : '' }}"
                                        @click.prevent="modul = 'semua'; submitFilter(); open = false">
                                        Semua Modul
                                    </a>
                                    @foreach($modulOptions as $opt)
                                    <a href="#" 
                                        class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition {{ ($modul ?? '') == $opt ? 'bg-gray-100 font-semibold' : '' }}"
                                        @click.prevent="modul = '{{ $opt }}'; submitFilter(); open = false">
                                        {{ ucfirst($opt) }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <div x-data="{ open: false }" class="relative inline-block text-left">
                            <button type="button" @click="open = !open" class="px-4 py-2 h-11 text-sm bg-white border border-gray-300 text-[#363062] rounded-full shadow-sm cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#F99417] hover:bg-gray-50 transition flex items-center gap-2">
                                <span x-text="aksi === 'semua' ? 'Semua Aksi' : aksi.replace('_', ' ').charAt(0).toUpperCase() + aksi.replace('_', ' ').slice(1)"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="h-5 w-5 text-[#363062] transition-transform duration-200" 
                                    :class="open ? 'rotate-0' : 'rotate-180'" 
                                    viewBox="0 0 1024 1024">
                                    <path fill="currentColor" d="M488.8 344.3L149 701a32 32 0 0 0 0 44.2l.4.3a29.4 29.4 0 0 0 42.7 0l320-335.8l319.8 335.8a29.4 29.4 0 0 0 42.7 0l.4-.3a32 32 0 0 0 0-44.2L535.2 344.3a32 32 0 0 0-46.4 0"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.outside="open = false" style="display:none" x-transition.opacity
                                class="absolute left-0 z-20 mt-2 w-48 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 overflow-y-auto border border-gray-100 max-h-60">
                                <div class="py-2">
                                    <a href="#" 
                                        class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition {{ ($aksi ?? 'semua') == 'semua' ? 'bg-gray-100 font-semibold' : '' }}"
                                        @click.prevent="aksi = 'semua'; submitFilter(); open = false">
                                        Semua Aksi
                                    </a>
                                    @foreach($aksiOptions as $opt)
                                    <a href="#" 
                                        class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition {{ ($aksi ?? '') == $opt ? 'bg-gray-100 font-semibold' : '' }}"
                                        @click.prevent="aksi = '{{ $opt }}'; submitFilter(); open = false">
                                        {{ ucfirst(str_replace('_', ' ', $opt)) }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <div x-data="{ open: false }" class="relative inline-block text-left">
                            <button type="button" @click="open = !open" class="px-4 py-2 h-11 text-sm bg-white border border-gray-300 text-[#363062] rounded-full shadow-sm cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#F99417] hover:bg-gray-50 transition flex items-center gap-2">
                                <span x-text="status === 'semua' ? 'Semua Status' : status.charAt(0).toUpperCase() + status.slice(1)"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="h-5 w-5 text-[#363062] transition-transform duration-200" 
                                    :class="open ? 'rotate-0' : 'rotate-180'" 
                                    viewBox="0 0 1024 1024">
                                    <path fill="currentColor" d="M488.8 344.3L149 701a32 32 0 0 0 0 44.2l.4.3a29.4 29.4 0 0 0 42.7 0l320-335.8l319.8 335.8a29.4 29.4 0 0 0 42.7 0l.4-.3a32 32 0 0 0 0-44.2L535.2 344.3a32 32 0 0 0-46.4 0"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.outside="open = false" style="display:none" x-transition.opacity
                                class="absolute left-0 z-20 mt-2 w-48 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 overflow-y-auto border border-gray-100 max-h-60">
                                <div class="py-2">
                                    <a href="#" 
                                        class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition {{ ($status ?? 'semua') == 'semua' ? 'bg-gray-100 font-semibold' : '' }}"
                                        @click.prevent="status = 'semua'; submitFilter(); open = false">
                                        Semua Status
                                    </a>
                                    @foreach($statusOptions as $opt)
                                    <a href="#" 
                                        class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition {{ ($status ?? '') == $opt ? 'bg-gray-100 font-semibold' : '' }}"
                                        @click.prevent="status = '{{ $opt }}'; submitFilter(); open = false">
                                        {{ ucfirst($opt) }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <div x-data="{ open: false }" class="relative inline-block text-left">
                            <button type="button" @click="open = !open" class="px-4 py-2 h-11 text-sm bg-white border border-gray-300 text-[#363062] rounded-full shadow-sm cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#F99417] hover:bg-gray-50 transition flex items-center gap-2">
                                <span x-text="role === 'semua' ? 'Semua Role' : role.charAt(0).toUpperCase() + role.slice(1)"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="h-5 w-5 text-[#363062] transition-transform duration-200" 
                                    :class="open ? 'rotate-0' : 'rotate-180'" 
                                    viewBox="0 0 1024 1024">
                                    <path fill="currentColor" d="M488.8 344.3L149 701a32 32 0 0 0 0 44.2l.4.3a29.4 29.4 0 0 0 42.7 0l320-335.8l319.8 335.8a29.4 29.4 0 0 0 42.7 0l.4-.3a32 32 0 0 0 0-44.2L535.2 344.3a32 32 0 0 0-46.4 0"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.outside="open = false" style="display:none" x-transition.opacity
                                class="absolute left-0 z-20 mt-2 w-48 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 overflow-y-auto border border-gray-100 max-h-60">
                                <div class="py-2">
                                    <a href="#" 
                                        class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition {{ ($role ?? 'semua') == 'semua' ? 'bg-gray-100 font-semibold' : '' }}"
                                        @click.prevent="role = 'semua'; submitFilter(); open = false">
                                        Semua Role
                                    </a>
                                    @foreach($roleOptions as $opt)
                                    <a href="#" 
                                        class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition {{ ($role ?? '') == $opt ? 'bg-gray-100 font-semibold' : '' }}"
                                        @click.prevent="role = '{{ $opt }}'; submitFilter(); open = false">
                                        {{ ucfirst($opt) }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

						<a href="{{ route('admin-log') }}" class="h-11 px-6 border border-gray-300 rounded-full text-sm font-medium hover:bg-gray-100 transition flex items-center">
							Reset
						</a>
                    </div>
                    
                    {{-- Search Input --}}
                    <div class="relative w-64 h-full flex-shrink-0">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
                        </div>
                        <input 
                            type="text" 
                            name="search" 
                            x-model="search"
                            @input.debounce.300ms="submitFilter()"
                            placeholder="Cari pengguna, target, atau keterangan..." 
                            class="w-full h-full pl-10 pr-4 py-3 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow bg-white"
                        >
                    </div>
                    
                </form>
			</div>
			
			{{-- TABEL LOG --}}
			<div class="w-full overflow-x-auto mt-6">
				
				<table class="w-full text-sm border-collapse">
					
					{{-- HEADER --}}
					<thead>
						<tr class="bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white">
							<th class="py-3 px-4 text-left w-20 rounded-tl-[20px]">ID</th>
							<th class="py-3 px-4 text-left">Timestamp</th>
							<th class="py-3 px-4 text-left">User</th>
							<th class="py-3 px-4 text-left">Role</th>
							<th class="py-3 px-4 text-left">Modul</th>
							<th class="py-3 px-4 text-left">Aksi</th>
							<th class="py-3 px-4 text-left">Target</th>
							<th class="py-3 px-4 text-left">Keterangan</th>
							<th class="py-3 px-4 text-left rounded-tr-[20px]">Status</th>
						</tr>
					</thead>
					
					{{-- BODY --}}
					<tbody class="text-[#363062]">
						@forelse($logs as $log)
						<tr class="border-b border-gray-300 hover:bg-gray-50 transition-colors">
							<td class="py-3 px-4 font-semibold">{{ $log->id }}</td>
							<td class="py-3 px-4">
								<div class="flex items-center gap-2">
									<div class="px-3 py-1 bg-gray-100 text-[#363062] border border-gray-200 rounded-full text-xs font-medium">
										{{ $log->created_at->format('d - m - Y') }}
									</div>
									<div class="px-3 py-1 bg-gray-100 text-[#363062] border border-gray-200 rounded-full text-xs font-medium">
										{{ $log->created_at->format('H:i') }}
									</div>
								</div>
							</td>
							<td class="py-3 px-4 font-medium">
								{{ $log->user->nama_lengkap ?? $log->user->username ?? 'System' }}
							</td>
							<td class="py-3 px-4">
								<span class="px-2 py-1 rounded-full text-xs font-medium
									@if($log->role == 'admin') bg-purple-100 text-purple-700
									@elseif($log->role == 'petugas') bg-blue-100 text-blue-700
									@elseif($log->role == 'peminjam') bg-green-100 text-green-700
									@else bg-gray-100 text-gray-700
									@endif">
									{{ ucfirst($log->role ?? 'system') }}
								</span>
							</td>
							<td class="py-3 px-4">{{ ucfirst($log->modul) }}</td>
							<td class="py-3 px-4">{{ $log->formatted_aksi }}</td>
							<td class="py-3 px-4 text-gray-600 break-words max-w-[150px]">{{ $log->target ?? '-' }}</td>
							<td class="py-3 px-4 text-gray-600 break-words max-w-[250px]">{{ $log->keterangan }}</td>
							<td class="py-3 px-4 text-left">
								<div class="px-3 py-1 rounded-full text-xs font-semibold text-center inline-block
									@if($log->status == 'success') bg-green-100 text-green-700 border border-green-200
									@elseif($log->status == 'warning') bg-yellow-100 text-yellow-700 border border-yellow-200
									@elseif($log->status == 'error') bg-red-100 text-red-700 border border-red-200
									@endif">
									{{ ucfirst($log->status) }}
								</div>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="9" class="text-center py-10 text-gray-400">
								Belum ada log aktivitas
							</td>
						</tr>
						@endforelse
					</tbody>
					
				</table>
				
				{{-- PAGINATION --}}
				<div class="flex items-center justify-between mt-6">
					<div class="text-sm text-gray-500">
						Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }} log
					</div>
					
					<div class="flex items-center gap-2">
						{{ $logs->appends(request()->query())->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection