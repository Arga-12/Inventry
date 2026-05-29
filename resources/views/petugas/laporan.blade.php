@extends('layouts.app')

@section('content')
    <div class="mx-auto pt-20 pb-8 lg:py-8 px-4">
        <div class="flex flex-col gap-8">

            {{-- Page Header --}}
            <div class="flex flex-col">
                <h1 class="text-2xl sm:text-4xl font-bold">Laporan Petugas</h1>
                <p class="text-gray-500">Kelola dan cetak laporan peminjaman alat berdasarkan periode tertentu dengan data
                    yang terstruktur dan siap arsip.</p>
            </div>

            {{-- Statistik Cards --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                {{-- Rasio Peminjaman & Pengembalian (col-span-2) --}}
                <div
                    class="lg:col-span-2 bg-white border-b-2 border-black shadow-lg rounded-[20px] flex flex-col justify-between p-6 gap-4">
                    <div class="flex flex-col w-full">
                        <div class="flex flex-col sm:flex-row justify-between items-start w-full gap-3">
                            <div class="flex flex-col items-start gap-1">
                                <h2 class="font-bold text-lg sm:text-2xl text-gray-800">Rasio Peminjaman &amp; Pengembalian
                                </h2>
                                <p class="text-sm font-medium text-gray-500">Perbandingan total peminjaman (selesai/ditolak)
                                    dan pengembalian (selesai)</p>
                            </div>
                            <div class="flex items-baseline gap-1 flex-shrink-0">
                                <h2 class="font-bold text-4xl sm:text-5xl text-gray-900">
                                    {{ $totalPeminjamanAll + $totalPengembalianAll }}
                                </h2>
                            </div>
                        </div>

                        {{-- Diagram Rasio --}}
                        <div class="mt-6 sm:mt-10">
                            <div class="w-full h-2 rounded-full overflow-hidden flex">
                                @foreach($diagramAktivitas as $data)
                                    <div class="h-full"
                                        style="width: {{ $data['persen'] }}%; background-color: {{ $data['warna'] }}"></div>
                                @endforeach
                            </div>
                            <div class="flex items-center gap-5 mt-2 text-sm font-medium text-gray-600 flex-wrap">
                                @foreach($diagramAktivitas as $data)
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full"
                                            style="background-color: {{ $data['warna'] }}"></span>
                                        <span>{{ $data['nama'] }} ({{ $data['count'] }})</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Rincian Hari Ini (col-span-1) --}}
                <div
                    class="lg:col-span-1 bg-white border-b-2 border-black shadow-lg rounded-[20px] flex flex-col justify-between p-6 gap-6">
                    <div class="grid grid-cols-2 w-full">
                        <div class="flex flex-col gap-1">
                            <span class="font-bold text-[#363062] text-lg sm:text-xl">Peminjaman</span>
                            <span class="text-4xl sm:text-5xl font-bold text-gray-900 mt-1">{{ $peminjamanHariIni }}</span>
                        </div>
                        <div class="flex flex-col gap-1 items-start">
                            <span class="font-bold text-[#363062] text-lg sm:text-xl">Pengembalian</span>
                            <span
                                class="text-4xl sm:text-5xl font-bold text-gray-900 mt-1">{{ $pengembalianHariIni }}</span>
                        </div>
                    </div>

                    <div
                        class="flex flex-wrap items-center justify-center gap-3 w-full mt-auto pt-4 border-t border-gray-500">
                        <span class="font-medium text-gray-500 leading-tight text-sm">Peminjaman &amp; Pengembalian
                            dilakukan pada:</span>
                        <div class="px-3 py-1.5 bg-[#F99417] rounded-full text-xs text-white font-bold whitespace-nowrap">
                            Hari ini</div>
                    </div>
                </div>
            </div>

            <div x-data="{ activeTab: '{{ request('tab', 'peminjaman') }}' }" class="flex flex-col gap-4">

                {{-- Header Laporan dengan Dropdown Switcher --}}
                <div class="flex items-center justify-between gap-3 w-full">
                    <h2 class="text-xl sm:text-3xl font-bold transition-all duration-300"
                        x-text="activeTab === 'peminjaman' ? 'Laporan Peminjaman' : 'Laporan Pengembalian'"></h2>

                    <div x-data="{ openTab: false }" class="relative inline-block text-left">
                        <button @click="openTab = !openTab" type="button"
                            class="h-11 px-5 flex items-center gap-3 border border-[#363062] rounded-full text-sm font-semibold bg-white text-[#363062] shadow-sm hover:bg-gray-50 focus:outline-none transition-all">
                            <span class="hidden sm:inline"
                                x-text="activeTab === 'peminjaman' ? 'Laporan Peminjaman' : 'Laporan Pengembalian'"></span>
                            <span class="sm:hidden"
                                x-text="activeTab === 'peminjaman' ? 'Peminjaman' : 'Pengembalian'"></span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-[#363062] transition-transform duration-200"
                                :class="openTab ? 'rotate-0' : 'rotate-180'" viewBox="0 0 1024 1024">
                                <path fill="currentColor"
                                    d="M488.8 344.3L149 701a32 32 0 0 0 0 44.2l.4.3a29.4 29.4 0 0 0 42.7 0l320-335.8l319.8 335.8a29.4 29.4 0 0 0 42.7 0l.4-.3a32 32 0 0 0 0-44.2L535.2 344.3a32 32 0 0 0-46.4 0" />
                            </svg>
                        </button>
                        <div x-show="openTab" @click.outside="openTab = false" x-cloak style="display:none"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            class="absolute right-0 z-30 mt-2 w-56 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 border border-gray-100 overflow-hidden">
                            <div class="py-1">
                                <button @click="activeTab = 'peminjaman'; openTab = false"
                                    class="w-full text-left px-4 py-3 text-sm font-semibold hover:bg-gray-50 transition"
                                    :class="activeTab === 'peminjaman' ? 'text-[#F99417] bg-orange-50/30' : 'text-[#363062]'">
                                    Laporan Peminjaman
                                </button>
                                <button @click="activeTab = 'pengembalian'; openTab = false"
                                    class="w-full text-left px-4 py-3 text-sm font-semibold hover:bg-gray-50 transition"
                                    :class="activeTab === 'pengembalian' ? 'text-[#F99417] bg-orange-50/30' : 'text-[#363062]'">
                                    Laporan Pengembalian
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BAGIAN TABEL PEMINJAMAN --}}
                <div x-show="activeTab === 'peminjaman'" x-cloak x-transition.opacity class="flex flex-col gap-4">

                    {{-- TOP BAR --}}
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <div class="flex items-center gap-3 flex-wrap">
                            <form method="GET" action="{{ route('petugas-laporan') }}"
                                class="flex items-center gap-3 flex-wrap">
                                <input type="hidden" name="tab" :value="activeTab">

                                {{-- Filter Periode --}}
                                <div x-data="{ openPeriode: false }" class="relative inline-block text-left">
                                    <button @click="openPeriode = !openPeriode" type="button"
                                        class="h-11 px-4 flex items-center gap-2 border border-[#363062] rounded-full text-sm font-medium bg-white text-[#363062] hover:bg-gray-100 focus:outline-none">
                                        <span>
                                            @if($periode == 'hari_ini') Hari ini
                                            @elseif($periode == 'minggu_ini') Minggu ini
                                            @elseif($periode == 'bulan_ini') Bulan ini
                                            @elseif($periode == 'tahun_ini') Tahun ini
                                            @else Sepanjang waktu
                                            @endif
                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-[#363062] transition-transform duration-200"
                                            :class="openPeriode ? 'rotate-0' : 'rotate-180'" viewBox="0 0 1024 1024">
                                            <path fill="currentColor"
                                                d="M488.8 344.3L149 701a32 32 0 0 0 0 44.2l.4.3a29.4 29.4 0 0 0 42.7 0l320-335.8l319.8 335.8a29.4 29.4 0 0 0 42.7 0l.4-.3a32 32 0 0 0 0-44.2L535.2 344.3a32 32 0 0 0-46.4 0" />
                                        </svg>
                                    </button>
                                    <div x-show="openPeriode" @click.outside="openPeriode = false" x-cloak
                                        style="display:none" x-transition.opacity
                                        class="absolute left-0 z-20 mt-2 w-56 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 border border-gray-100">
                                        <div class="py-2">
                                            <p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Periode</p>
                                            @foreach(['semua' => 'Sepanjang waktu', 'hari_ini' => 'Hari ini', 'minggu_ini' => 'Minggu ini', 'bulan_ini' => 'Bulan ini', 'tahun_ini' => 'Tahun ini'] as $val => $label)
                                                <label
                                                    class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                                    <input type="radio" name="periode" value="{{ $val }}"
                                                        onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ $periode == $val ? 'checked' : '' }}>
                                                    {{ $label }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Search --}}
                                <div class="relative flex-1 min-w-[180px]">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ $search }}"
                                        placeholder="Cari peminjam atau kode..."
                                        class="w-full h-11 pl-10 pr-4 py-2 bg-white border border-gray-500 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow bg-[#F5F5F5]"
                                        onchange="this.form.submit()">
                                </div>

                                {{-- Filter Status --}}
                                <div x-data="{ openFilterPeminjaman: false }" class="relative inline-block text-left">
                                    <button @click="openFilterPeminjaman = !openFilterPeminjaman" type="button"
                                        class="w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75" />
                                        </svg>
                                    </button>
                                    <div x-show="openFilterPeminjaman" @click.outside="openFilterPeminjaman = false" x-cloak
                                        style="display:none" x-transition.opacity
                                        class="absolute left-0 z-20 mt-2 w-56 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 border border-gray-100">
                                        <div class="py-2">
                                            <p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Status
                                                Peminjaman
                                            </p>
                                            <label
                                                class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                                <input type="radio" name="status_peminjaman" value="semua"
                                                    onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ $statusPeminjaman == 'semua' ? 'checked' : '' }}>Semua Status
                                            </label>
                                            <label
                                                class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                                <input type="radio" name="status_peminjaman" value="selesai"
                                                    onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_peminjaman') == 'selesai' ? 'checked' : '' }}>
                                                <span class="flex items-center gap-2"><span
                                                        class="w-2 h-2 bg-green-500 rounded-full"></span>Selesai</span>
                                            </label>
                                            <label
                                                class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                                <input type="radio" name="status_peminjaman" value="ditolak"
                                                    onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('status_peminjaman') == 'ditolak' ? 'checked' : '' }}>
                                                <span class="flex items-center gap-2"><span
                                                        class="w-2 h-2 bg-red-500 rounded-full"></span>Ditolak</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Export --}}
                        <div class="flex items-center gap-3 flex-wrap">
                            <a href="{{ route('laporan-export-peminjaman-pdf', request()->query()) }}"
                                class="px-4 py-2.5 border border-[#363062] text-[#363062] rounded-full text-sm font-medium bg-white hover:bg-gray-100">PDF</a>
                            <a href="{{ route('laporan-export-peminjaman-excel', request()->query()) }}"
                                class="px-4 py-2.5 border border-[#363062] text-[#363062] rounded-full text-sm font-medium bg-white hover:bg-gray-100">Excel</a>
                        </div>
                    </div>

                    {{-- Tabel --}}
                    <div class="w-full overflow-x-auto rounded-[20px] shadow-sm">
                        <table class="w-full text-sm border-collapse min-w-[600px]">
                            <thead>
                                <tr class="bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white">
                                    <th class="py-3 px-3 text-left w-10 rounded-tl-[20px]">No</th>
                                    <th class="py-3 px-3 text-left">ID Peminjaman</th>
                                    <th class="py-3 px-3 text-left">Nama Peminjam</th>
                                    <th class="py-3 px-3 text-left">Tgl Pinjam</th>
                                    <th class="py-3 px-3 text-left">Tgl Kembali</th>
                                    <th class="py-3 px-3 text-left">Alat</th>
                                    <th class="py-3 px-3 text-left rounded-tr-[20px]">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-[#363062]">
                                @forelse($peminjamanCollection as $item)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-3 text-gray-500">
                                            {{ ($peminjamanList->currentPage() - 1) * $peminjamanList->perPage() + $loop->iteration }}.
                                        </td>
                                        <td class="py-3 px-3 font-semibold text-xs">{{ $item['kode_peminjaman'] }}</td>
                                        <td class="py-3 px-3">{{ $item['nama_peminjam'] }}</td>
                                        <td class="py-3 px-3 border-b border-gray-100">
                                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-2">
                                                <span
                                                    class="px-2 py-0.5 bg-gray-100 text-[#363062] rounded-full text-[10px] sm:text-xs font-medium w-fit whitespace-nowrap">
                                                    {{ $item['tanggal_pinjam'] ? \Carbon\Carbon::parse($item['tanggal_pinjam'])->format('d - m - Y') : '-' }}
                                                </span>
                                                <span
                                                    class="px-2 py-0.5 bg-gray-100 text-[#363062] rounded-full text-[10px] sm:text-xs font-medium w-fit whitespace-nowrap">
                                                    {{ $item['waktu_pinjam'] ? \Carbon\Carbon::parse($item['waktu_pinjam'])->format('H:i') : '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 border-b border-gray-100">
                                            @if($item['tanggal_kembali'])
                                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-2">
                                                    <span
                                                        class="px-2 py-0.5 bg-gray-100 text-[#363062] rounded-full text-[10px] sm:text-xs font-medium w-fit whitespace-nowrap">
                                                        {{ \Carbon\Carbon::parse($item['tanggal_kembali'])->format('d - m - Y') }}
                                                    </span>
                                                    <span
                                                        class="px-2 py-0.5 bg-gray-100 text-[#363062] rounded-full text-[10px] sm:text-xs font-medium w-fit whitespace-nowrap">
                                                        {{ \Carbon\Carbon::parse($item['waktu_kembali'])->format('H:i') }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-sm">{{ $item['jumlah_alat'] }}</td>
                                        <td class="py-3 px-3">
                                            <div
                                                class="px-2 py-1 rounded-full font-semibold text-center text-xs {{ $item['status_badge'] }}">
                                                {{ $item['status_label'] }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-10 text-gray-400">Belum ada data peminjaman</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Peminjaman --}}
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">Halaman {{ $peminjamanList->currentPage() }} dari
                            {{ $peminjamanList->lastPage() }}
                        </div>
                        <div class="flex items-center gap-2">
                            @if($peminjamanList->onFirstPage())
                                <button
                                    class="p-3 rounded-full border text-sm flex items-center justify-center opacity-50 cursor-not-allowed bg-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
                                        <defs>
                                            <path id="pag_p1" fill="currentColor"
                                                d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
                                        </defs>
                                        <use fill-rule="evenodd" href="#pag_p1" transform="rotate(-180 5.02 9.505)" />
                                    </svg>
                                </button>
                            @else
                                <a href="{{ $peminjamanList->previousPageUrl() }}"
                                    class="p-3 rounded-full border bg-white text-sm flex items-center justify-center hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
                                        <defs>
                                            <path id="pag_p1" fill="currentColor"
                                                d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
                                        </defs>
                                        <use fill-rule="evenodd" href="#pag_p1" transform="rotate(-180 5.02 9.505)" />
                                    </svg>
                                </a>
                            @endif
                            <div class="flex items-center gap-1 bg-gray-100 p-1.5 rounded-full">
                                <span
                                    class="w-8 h-8 flex items-center justify-center rounded-full text-sm bg-[#363062] text-white font-medium">{{ $peminjamanList->currentPage() }}</span>
                            </div>
                            @if($peminjamanList->hasMorePages())
                                <a href="{{ $peminjamanList->nextPageUrl() }}"
                                    class="p-3 rounded-full border bg-white text-sm flex items-center justify-center hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
                                        <defs>
                                            <path id="pag_p1" fill="currentColor"
                                                d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
                                        </defs>
                                        <use fill-rule="evenodd" href="#pag_p1" transform="rotate(-180 5.02 9.505)" />
                                    </svg>
                                </a>
                            @else
                                <button
                                    class="p-3 rounded-full border bg-white text-sm flex items-center justify-center opacity-50 cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
                                        <defs>
                                            <path id="pag_p1" fill="currentColor"
                                                d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
                                        </defs>
                                        <use fill-rule="evenodd" href="#pag_p1" transform="rotate(-180 5.02 9.505)" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- BAGIAN TABEL PENGEMBALIAN --}}
                <div x-show="activeTab === 'pengembalian'" x-cloak x-transition.opacity class="flex flex-col gap-4">

                    {{-- TOP BAR --}}
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <div class="flex items-center gap-3 flex-wrap">
                            <form method="GET" action="{{ route('petugas-laporan') }}"
                                class="flex items-center gap-3 flex-wrap">
                                <input type="hidden" name="tab" :value="activeTab">

                                {{-- Filter Periode --}}
                                <div x-data="{ openPeriodePengembalian: false }" class="relative inline-block text-left">
                                    <button @click="openPeriodePengembalian = !openPeriodePengembalian" type="button"
                                        class="h-11 px-4 flex items-center gap-2 border border-[#363062] rounded-full text-sm font-medium bg-white text-[#363062] hover:bg-gray-100 focus:outline-none">
                                        <span>
                                            @if($periodePengembalian == 'hari_ini') Hari ini
                                            @elseif($periodePengembalian == 'minggu_ini') Minggu ini
                                            @elseif($periodePengembalian == 'bulan_ini') Bulan ini
                                            @elseif($periodePengembalian == 'tahun_ini') Tahun ini
                                            @else Sepanjang waktu
                                            @endif
                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-[#363062] transition-transform duration-200"
                                            :class="openPeriodePengembalian ? 'rotate-0' : 'rotate-180'"
                                            viewBox="0 0 1024 1024">
                                            <path fill="currentColor"
                                                d="M488.8 344.3L149 701a32 32 0 0 0 0 44.2l.4.3a29.4 29.4 0 0 0 42.7 0l320-335.8l319.8 335.8a29.4 29.4 0 0 0 42.7 0l.4-.3a32 32 0 0 0 0-44.2L535.2 344.3a32 32 0 0 0-46.4 0" />
                                        </svg>
                                    </button>
                                    <div x-show="openPeriodePengembalian" @click.outside="openPeriodePengembalian = false"
                                        x-cloak style="display:none" x-transition.opacity
                                        class="absolute left-0 z-20 mt-2 w-56 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 border border-gray-100">
                                        <div class="py-2">
                                            <p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Periode</p>
                                            @foreach(['semua' => 'Sepanjang waktu', 'hari_ini' => 'Hari ini', 'minggu_ini' => 'Minggu ini', 'bulan_ini' => 'Bulan ini', 'tahun_ini' => 'Tahun ini'] as $val => $label)
                                                <label
                                                    class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                                    <input type="radio" name="periode_pengembalian" value="{{ $val }}"
                                                        onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ $periodePengembalian == $val ? 'checked' : '' }}>
                                                    {{ $label }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Search --}}
                                <div class="relative flex-1 min-w-[180px]">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search_pengembalian" value="{{ $searchPengembalian }}"
                                        placeholder="Cari peminjam atau kode..."
                                        class="w-full h-11 pl-10 pr-4 py-2 bg-white border border-gray-500 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow bg-[#F5F5F5]"
                                        onchange="this.form.submit()">
                                </div>

                                {{-- Filter Kondisi --}}
                                <div x-data="{ openFilterPengembalian: false }" class="relative inline-block text-left">
                                    <button @click="openFilterPengembalian = !openFilterPengembalian" type="button"
                                        class="w-11 h-11 flex items-center justify-center border border-[#363062] rounded-full hover:bg-gray-100 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#363062]"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75" />
                                        </svg>
                                    </button>
                                    <div x-show="openFilterPengembalian" @click.outside="openFilterPengembalian = false"
                                        x-cloak style="display:none" x-transition.opacity
                                        class="absolute left-0 z-20 mt-2 w-56 rounded-[15px] bg-white shadow-xl ring-1 ring-black ring-opacity-5 border border-gray-100">
                                        <div class="py-2">
                                            <p class="px-4 py-2 text-xs font-bold text-gray-500 mb-1">Filter Kondisi
                                                Pengembalian</p>
                                            <label
                                                class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                                <input type="radio" name="kondisi_pengembalian" value="semua"
                                                    onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('kondisi_pengembalian', 'semua') == 'semua' ? 'checked' : '' }}>Semua
                                                Kondisi
                                            </label>
                                            <label
                                                class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                                <input type="radio" name="kondisi_pengembalian" value="lolos"
                                                    onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('kondisi_pengembalian') == 'lolos' ? 'checked' : '' }}>Lolos
                                            </label>
                                            <label
                                                class="flex items-center px-4 py-2.5 text-sm text-[#363062] hover:bg-gray-50 cursor-pointer transition">
                                                <input type="radio" name="kondisi_pengembalian" value="rusak"
                                                    onchange="this.form.submit()" class="mr-3 w-4 h-4 text-[#363062]" {{ request('kondisi_pengembalian') == 'rusak' ? 'checked' : '' }}>Rusak
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Export --}}
                        <div class="flex items-center gap-3 flex-wrap">
                            <a href="{{ route('laporan-export-pengembalian-pdf', request()->query()) }}"
                                class="px-4 py-2.5 border border-[#363062] text-[#363062] rounded-full text-sm font-medium bg-white hover:bg-gray-100">PDF</a>
                            <a href="{{ route('laporan-export-pengembalian-excel', request()->query()) }}"
                                class="px-4 py-2.5 border border-[#363062] text-[#363062] rounded-full text-sm font-medium bg-white hover:bg-gray-100">Excel</a>
                        </div>
                    </div>

                    {{-- Tabel --}}
                    <div class="w-full overflow-x-auto rounded-[20px] shadow-sm">
                        <table class="w-full text-sm border-collapse min-w-[600px]">
                            <thead>
                                <tr class="bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white">
                                    <th class="py-3 px-3 text-left w-10 rounded-tl-[20px]">No</th>
                                    <th class="py-3 px-3 text-left">ID Pengembalian</th>
                                    <th class="py-3 px-3 text-left">Nama Peminjam</th>
                                    <th class="py-3 px-3 text-left">Tgl Pengajuan</th>
                                    <th class="py-3 px-3 text-left">Tgl Verifikasi</th>
                                    <th class="py-3 px-3 text-left">Alat</th>
                                    <th class="py-3 px-3 text-left">Kondisi</th>
                                    <th class="py-3 px-3 text-left rounded-tr-[20px]">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-[#363062]">
                                @forelse($pengembalianCollection as $item)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-3 text-gray-500">
                                            {{ ($pengembalianList->currentPage() - 1) * $pengembalianList->perPage() + $loop->iteration }}.
                                        </td>
                                        <td class="py-3 px-3 font-semibold text-xs">{{ $item['kode_pengembalian'] }}</td>
                                        <td class="py-3 px-3">{{ $item['nama_peminjam'] }}</td>
                                        <td class="py-3 px-3 border-b border-gray-100">
                                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-2">
                                                <span
                                                    class="px-2 py-0.5 bg-gray-100 text-[#363062] rounded-full text-[10px] sm:text-xs font-medium w-fit whitespace-nowrap">
                                                    {{ $item['tanggal_pengajuan'] ? \Carbon\Carbon::parse($item['tanggal_pengajuan'])->format('d - m - Y') : '-' }}
                                                </span>
                                                <span
                                                    class="px-2 py-0.5 bg-gray-100 text-[#363062] rounded-full text-[10px] sm:text-xs font-medium w-fit whitespace-nowrap">
                                                    {{ $item['tanggal_pengajuan'] ? \Carbon\Carbon::parse($item['tanggal_pengajuan'])->format('H:i') : '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 border-b border-gray-100">
                                            @if($item['tanggal_verifikasi'])
                                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-2">
                                                    <span
                                                        class="px-2 py-0.5 bg-gray-100 text-[#363062] rounded-full text-[10px] sm:text-xs font-medium w-fit whitespace-nowrap">
                                                        {{ \Carbon\Carbon::parse($item['tanggal_verifikasi'])->format('d - m - Y') }}
                                                    </span>
                                                    <span
                                                        class="px-2 py-0.5 bg-gray-100 text-[#363062] rounded-full text-[10px] sm:text-xs font-medium w-fit whitespace-nowrap">
                                                        {{ \Carbon\Carbon::parse($item['tanggal_verifikasi'])->format('H:i') }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-sm">{{ $item['jumlah_alat'] }}</td>
                                        <td class="py-3 px-3">
                                            @php
                                                $kondisi = $item['kondisi'] ?? 'lolos';
                                                $badgeClass = $kondisi == 'lolos' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                                                $labelKondisi = $kondisi == 'lolos' ? 'Lolos' : 'Rusak';
                                            @endphp
                                            <div
                                                class="px-2 py-1 rounded-full font-semibold text-center text-xs inline-block {{ $badgeClass }}">
                                                {{ $labelKondisi }}
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div
                                                class="px-2 py-1 rounded-full font-semibold text-center text-xs {{ $item['status_badge'] }}">
                                                {{ $item['status_label'] }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-10 text-gray-400">Belum ada data pengembalian</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Pengembalian --}}
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">Halaman {{ $pengembalianList->currentPage() }} dari
                            {{ $pengembalianList->lastPage() }}
                        </div>
                        <div class="flex items-center gap-2">
                            @if($pengembalianList->onFirstPage())
                                <button
                                    class="p-3 rounded-full border bg-white text-sm flex items-center justify-center opacity-50 cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
                                        <defs>
                                            <path id="pag_p2" fill="currentColor"
                                                d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
                                        </defs>
                                        <use fill-rule="evenodd" href="#pag_p2" transform="rotate(-180 5.02 9.505)" />
                                    </svg>
                                </button>
                            @else
                                <a href="{{ $pengembalianList->previousPageUrl() }}"
                                    class="p-3 rounded-full border bg-white text-sm flex items-center justify-center hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" viewBox="0 0 12 24">
                                        <defs>
                                            <path id="pag_p2" fill="currentColor"
                                                d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
                                        </defs>
                                        <use fill-rule="evenodd" href="#pag_p2" transform="rotate(-180 5.02 9.505)" />
                                    </svg>
                                </a>
                            @endif
                            <div class="flex items-center gap-1 bg-gray-100 p-1.5 rounded-full">
                                <span
                                    class="w-8 h-8 flex items-center justify-center rounded-full text-sm bg-[#363062] text-white font-medium">{{ $pengembalianList->currentPage() }}</span>
                            </div>
                            @if($pengembalianList->hasMorePages())
                                <a href="{{ $pengembalianList->nextPageUrl() }}"
                                    class="p-3 rounded-full border bg-white text-sm flex items-center justify-center hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
                                        <defs>
                                            <path id="pag_p2" fill="currentColor"
                                                d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
                                        </defs>
                                        <use fill-rule="evenodd" href="#pag_p2" transform="rotate(-180 5.02 9.505)" />
                                    </svg>
                                </a>
                            @else
                                <button
                                    class="p-3 rounded-full border bg-white text-sm flex items-center justify-center opacity-50 cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 12 24">
                                        <defs>
                                            <path id="pag_p2" fill="currentColor"
                                                d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" />
                                        </defs>
                                        <use fill-rule="evenodd" href="#pag_p2" transform="rotate(-180 5.02 9.505)" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>

                </div> {{-- End Pengembalian Section --}}

            </div> {{-- End ActiveTab Context --}}

        </div> {{-- End gap-8 --}}
    </div> {{-- End mx-auto --}}
@endsection