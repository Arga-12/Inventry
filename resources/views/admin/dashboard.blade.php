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

        {{-- CARD DIAGRAM --}}
		<div class="lg:col-span-2 h-full">
			<div class="w-full h-full bg-white shadow-lg border border-gray-300 rounded-[20px] p-4 flex flex-col gap-4">
				
				{{-- HEADER DENGAN FILTER --}}
				<div class="w-full flex items-center justify-between flex-wrap gap-3">
					<h2 class="text-2xl font-bold">Pengajuan Peminjaman & Pengembalian</h2>

					<div class="flex items-center gap-2">
						{{-- FILTER TAHUN (CUSTOM DROPDOWN) --}}
						<div x-data="{ open: false, tahun: {{ $chart['tahun'] }} }" class="relative inline-block text-left">
							<button type="button" @click="open = !open" class="px-4 py-2 text-sm bg-white border border-[#363062] text-[#363062] rounded-full shadow-sm cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#F99417] hover:bg-gray-50 transition flex items-center gap-2">
								<span x-text="tahun"></span>
								<svg xmlns="http://www.w3.org/2000/svg" 
									class="h-5 w-5 text-[#363062] transition-transform duration-200" 
									:class="open ? 'rotate-0' : 'rotate-180'" 
									viewBox="0 0 1024 1024">
									<path fill="currentColor" d="M488.8 344.3L149 701a32 32 0 0 0 0 44.2l.4.3a29.4 29.4 0 0 0 42.7 0l320-335.8l319.8 335.8a29.4 29.4 0 0 0 42.7 0l.4-.3a32 32 0 0 0 0-44.2L535.2 344.3a32 32 0 0 0-46.4 0"/>
								</svg>
							</button>

							<div x-show="open" @click.outside="open = false" style="display:none" x-transition.opacity
								class="absolute right-0 z-20 mt-2 w-40 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 overflow-y-auto border border-gray-100">
								<div class="py-2">
									@for ($i = Carbon\Carbon::now()->year - 2; $i <= Carbon\Carbon::now()->year + 1; $i++)
									<a href="{{ route('admin-home', ['tahun' => $i]) }}" 
									class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition {{ $chart['tahun'] == $i ? 'bg-gray-100 font-semibold' : '' }}"
									@click="open = false">
										{{ $i }}
									</a>
									@endfor
								</div>
							</div>
						</div>
						
						{{-- RESET FILTER BUTTON (muncul jika ada filter aktif) --}}
						@if($chart['tahun'] != Carbon\Carbon::now()->year)
						<a href="{{ route('admin-home') }}" class="px-3 py-2 text-sm bg-gray-100 rounded-full hover:bg-gray-200 transition flex items-center gap-1">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"><path fill="currentColor" d="M12 16c1.657 0 3 1.343 3 3s-1.343 3-3 3s-3-1.343-3-3s1.343-3 3-3m0-8c1.657 0 3 1.343 3 3s-1.343 3-3 3s-3-1.343-3-3s1.343-3 3-3m0-8c1.657 0 3 1.343 3 3s-1.343 3-3 3s-3-1.343-3-3s1.343-3 3-3"/></svg>
							Reset
						</a>
						@endif
					</div>
				</div>
				
				{{-- CHART ATAU EMPTY STATE --}}
				@if($chart['totalData'] > 0)
					<div id="chart" class="w-full h-[350px]"></div>
				@else
					{{-- EMPTY STATE --}}
					<div class="w-full h-[350px] flex flex-col items-center justify-center gap-3 bg-gray-50 rounded-2xl">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300" viewBox="0 0 24 24">
							<path d="M0 0h24v24H0z" fill="none" />
							<g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
								<path d="M2.97 12.92A2 2 0 0 0 2 14.63v3.24a2 2 0 0 0 .97 1.71l3 1.8a2 2 0 0 0 2.06 0L12 19v-5.5l-5-3zM7 16.5l-4.74-2.85M7 16.5l5-3m-5 3v5.17m5-8.17V19l3.97 2.38a2 2 0 0 0 2.06 0l3-1.8a2 2 0 0 0 .97-1.71v-3.24a2 2 0 0 0-.97-1.71L17 10.5zm5 3l-5-3m5 3l4.74-2.85M17 16.5v5.17" />
								<path d="M7.97 4.42A2 2 0 0 0 7 6.13v4.37l5 3l5-3V6.13a2 2 0 0 0-.97-1.71l-3-1.8a2 2 0 0 0-2.06 0zM12 8L7.26 5.15M12 8l4.74-2.85M12 13.5V8" />
							</g>
						</svg>

						<p class="text-gray-500 font-medium text-lg">Belum ada data</p>
						<p class="text-sm text-gray-500 text-center max-w-md">
							Belum terdapat data peminjaman atau pengembalian<br>pada tahun <span class="font-semibold text-[#363062]">{{ $chart['tahun'] }}</span>
						</p>
						@if($chart['tahun'] != Carbon\Carbon::now()->year)
						<a href="{{ route('admin-home') }}" class="mt-4 px-6 py-2 text-sm bg-[#363062] text-white rounded-full hover:bg-[#4D4C7D] transition shadow-md">
							Lihat tahun {{ Carbon\Carbon::now()->year }}
						</a>
						@endif
					</div>
				@endif
				
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
						{{ number_format($stok['total']) }}
					</span>
				</div>
				
				{{-- PROGRESS BAR --}}
				<div class="w-full">
					<div class="w-full h-2 rounded-full overflow-hidden bg-gray-600 relative flex">
						@php
							$currentPosition = 0;
						@endphp
						@foreach($stok['persentase'] as $kategori)
							@if($kategori['persentase'] > 0)
							<div class="h-full" style="width: {{ $kategori['persentase'] }}%; background-color: {{ $kategori['warna'] }};"></div>
							@endif
						@endforeach
					</div>
					
					{{-- LEGEND --}}
					<div class="flex items-center gap-4 text-xs text-gray-300 mt-2 flex-wrap">
						@foreach($stok['persentase'] as $kategori)
							@if($kategori['stok'] > 0)
							<div class="flex items-center gap-2">
								<div class="h-2 w-2 rounded-full" style="background-color: {{ $kategori['warna'] }}"></div>
								<span>{{ $kategori['nama'] }} ({{ number_format($kategori['stok']) }})</span>
							</div>
							@endif
						@endforeach
					</div>
				</div>
				
			</div>
			
			{{-- CARD 2: STOK MENIPIS --}}
			<div class="bg-gradient-to-br from-[#363062] to-[#4D4C7D] text-white rounded-[20px] shadow-lg p-4 flex flex-col gap-4 h-[250px]">
				
				<span class="font-bold text-lg">
					Stok alat menipis
				</span>
				
				{{-- LIST --}}
				<div class="flex flex-col gap-3 text-sm max-h-[200px] overflow-y-auto">
					@forelse($stok['menipis'] as $alat)
					<div class="flex items-center justify-between">
						<div class="flex items-center gap-2">
							<div class="h-2 w-2 rounded-full" style="background-color: {{ $alat->kategori->warna ?? '#F99417' }}"></div>
							<span class="truncate">{{ $alat->nama_alat }}</span>
							<span class="text-xs text-gray-500">({{ $alat->kategori->nama_kategori ?? 'Tanpa Kategori' }})</span>
						</div>
						<span class="text-{{ $alat->stok <= 2 ? 'red-400' : 'yellow-400' }} font-semibold">
							{{ $alat->stok }} Tersisa
						</span>
					</div>
					@empty
					<div class="text-center text-gray-500 py-4">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto opacity-50" viewBox="0 0 24 24">
							<path d="M0 0h24v24H0z" fill="none" />
							<path fill="currentColor" d="m9 20.42l-6.21-6.21l2.83-2.83L9 14.77l9.88-9.89l2.83 2.83z" />
						</svg>

						<p class="text-sm">Semua stok aman, tidak ada alat yang menipis.</p>
					</div>
					@endforelse
				</div>
				
				{{-- WARNING (tampilkan hanya jika ada stok menipis) --}}
				@if($stok['menipis']->count() > 0)
				<div class="flex items-center gap-2 text-xs text-gray-500 mt-auto">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 24 24"><path fill="currentColor" d="M2.725 21q-.275 0-.5-.137t-.35-.363t-.137-.488t.137-.512l9.25-16q.15-.25.388-.375T12 3t.488.125t.387.375l9.25 16q.15.25.138.513t-.138.487t-.35.363t-.5.137zm1.725-2h15.1L12 6zm8.263-1.287Q13 17.425 13 17t-.288-.712T12 16t-.712.288T11 17t.288.713T12 18t.713-.288m0-3Q13 14.425 13 14v-3q0-.425-.288-.712T12 10t-.712.288T11 11v3q0 .425.288.713T12 15t.713-.288M12 12.5"/></svg>
					<span>Segera isi persediaan alat yang hampir habis</span>
				</div>
				@endif
				
			</div>
			
		</div>
		
		{{-- ROW USER --}}
		<div class="lg:col-span-2 h-full">
			<div class="w-full h-[350px] bg-white border border-gray-300 rounded-[20px] p-4 shadow-lg flex flex-col">
				
				{{-- HEADER --}}
				<div class="flex items-center justify-between mb-4">
					<h2 class="text-2xl font-bold">
						Users Online saat ini
					</h2>
					
					<div class="flex items-center gap-3 text-sm text-[#4D4C7D] flex-wrap">
						<span>{{ $userStats['online']['peminjam'] }} Peminjam</span>
						<span>|</span>
						<span>{{ $userStats['online']['petugas'] }} Petugas</span>
						<span>|</span>
						<span>{{ $userStats['online']['admin'] }} Admin</span>
						
						<div class="ml-3 px-3 py-1 flex items-center gap-2 bg-gradient-to-r from-[#363062] to-[#4D4C7D] rounded-full text-xs font-semibold text-white">
							<div class="h-2 w-2 rounded-full bg-green-400"></div>
							{{ $userStats['online']['total'] }} Users
						</div>
					</div>
				</div>
				
				{{-- LIST USERS --}}
				@if($userStats['list']->count() > 0)
				<div class="grid grid-cols-1 md:grid-cols-3 auto-rows-min gap-4 flex-1 overflow-y-auto pr-2">
					@foreach($userStats['list'] as $user)
					<div class="flex items-center rounded-full px-2 py-2 border justify-between bg-transparent group hover:shadow-lg transition-all">
						
						<div class="flex items-center gap-3">
							<div class="w-10 h-10 rounded-full border border-gray-300 overflow-hidden">
								<img src="{{ $user->foto_url }}" alt="user" class="w-full h-full object-cover">
							</div>
							
							<div class="flex flex-col">
								<span class="font-medium text-sm truncate max-w-[100px]">{{ $user->nama_lengkap }}</span>
								<div class="flex items-center">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#363062]" viewBox="0 0 24 24"><path fill="currentColor" d="M12 6c1.654 0 3 1.346 3 3s-1.346 3-3 3s-3-1.346-3-3s1.346-3 3-3m0-2C9.236 4 7 6.238 7 9s2.236 5 5 5s5-2.238 5-5s-2.236-5-5-5m0 13c2.021 0 3.301.771 3.783 1.445c-.683.26-1.969.555-3.783.555c-1.984 0-3.206-.305-3.818-.542C8.641 17.743 9.959 17 12 17m0-2c-3.75 0-6 2-6 4c0 1 2.25 2 6 2c3.518 0 6-1 6-2c0-2-2.354-4-6-4"/></svg>
									<span class="text-xs text-[#363062] capitalize">{{ $user->role }}</span>
								</div>
							</div>
						</div>
						
						<a href="{{ route('admin-pengguna-edit', $user) }}" class="w-10 h-10 rounded-full flex items-center justify-center bg-gradient-to-r from-[#363062] to-[#4D4C7D] opacity-0 group-hover:opacity-100 transition-opacity duration-200">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24">
								<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 16l-1 4l4-1L19.586 7.414a2 2 0 0 0 0-2.828l-.172-.172a2 2 0 0 0-2.828 0zM15 6l3 3m-5 11h8"/>
							</svg>
						</a>
						
					</div>
					@endforeach
				</div>
				@else
				{{-- EMPTY STATE --}}
				<div class="flex-1 flex flex-col items-center justify-center gap-3">
					<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" class="text-gray-500" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0z" fill="none" />
						<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.18 8.189a4.01 4.01 0 0 0 2.616 2.627m3.507-.545a4 4 0 1 0-5.59-5.552M6 21v-2a4 4 0 0 1 4-4h4c.412 0 .81.062 1.183.178m2.633 2.618c.12.38.184.785.184 1.204v2M3 3l18 18" />
					</svg>
					<p class="text-gray-500 font-medium">Tidak ada user online</p>
					<p class="text-sm text-gray-500 text-center">Saat ini tidak ada user yang sedang aktif</p>
				</div>
				@endif
				
				{{-- BUTTON --}}
				<div class="flex justify-end mt-4">
					<a href="{{ route('admin-pengguna') }}" class="px-4 py-2 text-sm border border-transparent bg-[#363062] text-white rounded-full hover:text-[#363062] hover:border-[#363062] hover:bg-transparent transition-all">
						Lihat Semua User
					</a>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dataPeminjaman = @json($chart['dataPeminjaman']);
        const dataPengembalian = @json($chart['dataPengembalian']);
        const bulanLabels = @json($chart['bulanLabels']);
        const totalData = @json($chart['totalData']);        
        // const totalData = [...dataPeminjaman, ...dataPengembalian].reduce((a, b) => a + b, 0);

        // Cek apakah element #chart ada
        const chartElement = document.querySelector("#chart");
        
        if (totalData > 0 && chartElement) {
            const options = {
                chart: { type: "bar", height: 350, toolbar: { show: false } },
                series: [
                    { name: "Peminjaman", data: dataPeminjaman },
                    { name: "Pengembalian", data: dataPengembalian },
                ],
                xaxis: { categories: bulanLabels },
                plotOptions: { bar: { columnWidth: "50%" } },
                colors: ["#4D4C7D", "#F99417"],
                dataLabels: { enabled: false },
                legend: { position: "bottom", horizontalAlign: "left" },
                grid: { borderColor: "#eee" },
                tooltip: { y: { formatter: (val) => val + " transaksi" } }
            };
            
            const chart = new ApexCharts(chartElement, options);
            chart.render();
            console.log('Chart rendered successfully');
        } else {
            console.log('Tidak ada data atau element chart tidak ditemukan');
        }
    });
</script>
@endpush


@endsection