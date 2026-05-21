@props(['pengembalian'])

@php
    $status = [
        'label' => $pengembalian->status_label,
        'badge' => $pengembalian->status_badge,
    ];
    $peminjaman = $pengembalian->peminjaman;
@endphp

<div class="bg-white border border-gray-300 rounded-[20px] p-4 shadow-lg">
    
    {{-- HEADER --}}
    <div class="flex items-start justify-between">
        <div class="flex items-center gap-3">
            <h3 class="text-2xl font-semibold text-[#363062]">
                {{ $pengembalian->kode_pengembalian }}
            </h3>
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $status['badge'] }}">
                {{ $status['label'] }}
            </span>
        </div>

        {{-- Informasi Tanggal --}}
        <div class="flex flex-col text-right text-xs">
            @if($pengembalian->status == 'menunggu_verifikasi')
                <p class="whitespace-nowrap">
                    Waktu peminjaman: 
                    <span class="text-[#363062] font-semibold">
                        {{ $peminjaman->tanggal_disetujui ? \Carbon\Carbon::parse($peminjaman->tanggal_disetujui)->format('H:i | d - m - Y') : '-' }}
                    </span>
                </p>
                <p class="whitespace-nowrap mt-1">
                    Waktu pengajuan kembali: 
                    <span class="text-[#363062] font-semibold">
                        {{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('H:i | d - m - Y') }}
                    </span>
                </p>
            @else
                <p class="whitespace-nowrap">
                    Waktu peminjaman: 
                    <span class="text-[#363062] font-semibold">
                        {{ $peminjaman->tanggal_disetujui ? \Carbon\Carbon::parse($peminjaman->tanggal_disetujui)->format('H:i | d - m - Y') : '-' }}
                    </span>
                </p>
                <p class="whitespace-nowrap mt-1">
                    Waktu dikembalikan: 
                    <span class="text-[#363062] font-semibold">
                        {{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('H:i | d - m - Y') }}
                    </span>
                </p>
            @endif
        </div>
    </div>

    <hr class="my-2 border-gray-500">

    {{-- BODY --}}
    <div class="flex flex-col gap-3">

        {{-- TOP ROW --}}
        <div class="flex justify-between items-start text-xs text-gray-500">
            <p class="text-sm text-black">
                Daftar alat / barang dikembalikan:
            </p>

            <div class="flex flex-col text-right">
                @if($pengembalian->status == 'menunggu_verifikasi')
                    <p class="whitespace-nowrap">
                        Tgl Pengajuan Pinjam: 
                        <span class="text-[#363062] font-semibold">
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengajuan)->format('d/m/Y H:i') }}
                        </span>
                    </p>
                @else
                    <p class="whitespace-nowrap">
                        Waktu Terverifikasi: 
                        <span class="text-[#363062] font-semibold">
                            {{ $pengembalian->tanggal_verifikasi ? \Carbon\Carbon::parse($pengembalian->tanggal_verifikasi)->format('H:i | d/m/Y') : '-' }}
                        </span>
                    </p>
                @endif
            </div>
        </div>

        {{-- LIST ALAT --}}
        @foreach ($pengembalian->detailPengembalian as $detail)
        @php
            $detailPeminjaman = $detail->detailPeminjaman;
            $alat = $detailPeminjaman->alat;
        @endphp
        <div class="flex flex-col gap-2">	
            <div class="flex items-center justify-between gap-4">

                {{-- LEFT ITEM --}}
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl border flex items-center justify-center overflow-hidden">
                        <img 
                            src="{{ $alat->gambar ? asset('storage/' . $alat->gambar) : asset('images/default-alat.jpg') }}"
                            alt="img"
                            class="w-full h-full object-cover"
                        >
                    </div>

                    <div>
                        <p class="text-sm">
                            {{ $alat->nama_alat }} 
                            <span class="text-xs font-medium text-gray-500">×{{ $detail->jumlah_kembali }}</span>
                        </p>
                        <div class="flex items-center gap-1">
                            <div class="h-2 w-2 rounded-full" style="background: {{ $alat->kategori->warna ?? '#363062' }}"></div>
                            <p class="text-xs text-gray-500">{{ $alat->kategori->nama_kategori ?? 'Tanpa Kategori' }}</p>
                        </div>
                    </div>
                </div>

                {{-- RIGHT DURASI --}}
                <div class="text-right text-xs text-gray-500 whitespace-nowrap">
                    <p>Durasi peminjaman</p>
                    <div class="flex items-center justify-end gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            class="h-4 w-4" 
                            viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/>
                                <path d="M12 7v5l3 3"/>
                            </g>
                        </svg>
                        <span class="font-semibold text-black">
                            {{ floor($alat->durasi / 60) > 0 ? floor($alat->durasi / 60) . ' Jam ' : '' }}{{ $alat->durasi % 60 > 0 ? ($alat->durasi % 60) . ' Menit' : '' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- KONDISI & CATATAN --}}
            @if($pengembalian->status == 'selesai')
            <div class="flex items-center gap-2">
                <span class="px-2 py-1 rounded-lg text-xs font-semibold {{ $detail->kondisi_badge }}">
                    {{ $detail->kondisi_label }}
                </span>

                @if($detail->catatan_kondisi)
                <div class="flex-1 px-3 py-1 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-500 truncate">
                    <span class="font-medium">Catatan: </span>{{ $detail->catatan_kondisi }}
                </div>
                @endif
            </div>
            @endif
        </div>
        <hr class="my-4 border-gray-500">
        @endforeach
    </div>
</div>