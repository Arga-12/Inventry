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
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div class="flex items-center gap-3 flex-wrap">
            <h3 class="text-xl font-semibold text-[#363062] leading-none">
                {{ $pengembalian->kode_pengembalian }}
            </h3>
            <span class="px-3 py-1 rounded-full text-xs font-semibold shrink-0 {{ $status['badge'] }}">
                {{ $status['label'] }}
            </span>
        </div>

        {{-- Informasi Tanggal --}}
        <div class="flex flex-col sm:text-right text-xs text-gray-500">
            <p>
                Waktu peminjaman:
                <span class="text-[#363062] font-semibold">
                    {{ $peminjaman->tanggal_disetujui ? \Carbon\Carbon::parse($peminjaman->tanggal_disetujui)->format('H:i | d/m/Y') : '-' }}
                </span>
            </p>
            <p class="mt-1">
                {{ $pengembalian->status == 'menunggu_verifikasi' ? 'Waktu pengajuan kembali:' : 'Waktu dikembalikan:' }}
                <span class="text-[#363062] font-semibold">
                    {{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('H:i | d/m/Y') }}
                </span>
            </p>
        </div>
    </div>

    <hr class="my-2 border-gray-500">

    {{-- BODY --}}
    <div class="flex flex-col gap-3">

        {{-- TOP ROW --}}
        <div class="flex flex-col-reverse sm:flex-row sm:justify-between sm:items-start gap-2">
            <p class="text-xs sm:text-sm text-black font-medium">Daftar alat / barang dikembalikan:</p>

            <div class="flex flex-col sm:text-right text-[10px] sm:text-xs text-gray-500 shrink-0">
                @if($pengembalian->status == 'menunggu_verifikasi')
                    <p>
                        Tgl Pengajuan Pinjam:
                        <span class="text-[#363062] font-semibold">
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengajuan)->format('d/m/Y H:i') }}
                        </span>
                    </p>
                @else
                    <p>
                        Waktu Terverifikasi:
                        <span class="text-[#363062] font-semibold">
                            {{ $pengembalian->tanggal_verifikasi ? \Carbon\Carbon::parse($pengembalian->tanggal_verifikasi)->format('H:i | d/m/Y') : '-' }}
                        </span>
                    </p>
                @endif
            </div>
        </div>

        {{-- LIST ALAT --}}
        <div class="flex flex-col gap-3 max-h-52 overflow-y-auto pr-1">
            @foreach ($pengembalian->detailPengembalian as $detail)
                @php
                    $detailPeminjaman = $detail->detailPeminjaman;
                    $alat = $detailPeminjaman->alat;
                @endphp
                <div class="flex flex-col gap-2">
                    <div class="flex items-start justify-between gap-4">

                        {{-- LEFT ITEM --}}
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <div
                                class="w-12 h-12 rounded-xl border flex items-center justify-center overflow-hidden bg-gray-50 flex-shrink-0">
                                <img src="{{ $alat->gambar ? asset('storage/' . $alat->gambar) : asset('images/default-alat.jpg') }}"
                                    alt="{{ $alat->nama_alat }}" class="w-full h-full object-cover">
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium truncate">
                                    {{ $alat->nama_alat }}
                                    <span class="text-xs font-medium text-gray-500">×{{ $detail->jumlah_kembali }}</span>
                                </p>
                                <div class="flex items-center gap-1 mt-0.5">
                                    <div class="h-2 w-2 rounded-full flex-shrink-0"
                                        style="background: {{ $alat->kategori->warna ?? '#363062' }}"></div>
                                    <p class="text-xs text-gray-500 truncate">
                                        {{ $alat->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT DURASI --}}
                        <div class="text-right text-xs text-gray-500 flex-shrink-0">
                            <p>Durasi peminjaman</p>
                            <div class="flex items-center justify-end gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2">
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0" />
                                        <path d="M12 7v5l3 3" />
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
                            <span class="px-2 py-1 rounded-lg text-xs font-semibold shrink-0 {{ $detail->kondisi_badge }}">
                                {{ $detail->kondisi_label }}
                            </span>

                            @if($detail->catatan_kondisi)
                                <div
                                    class="flex-1 min-w-0 px-3 py-1 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-500 truncate">
                                    <span class="font-medium">Catatan: </span>{{ $detail->catatan_kondisi }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <hr class="border-gray-200">
            @endforeach
        </div>
    </div>
</div>