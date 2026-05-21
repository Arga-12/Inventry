@props(['peminjaman'])

@php
    $status = $peminjaman->card_status;
@endphp

<div class="bg-white border border-gray-300 rounded-[20px] p-4 shadow-lg">
    
    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <h3 class="text-xl font-semibold text-[#363062]">
                {{ $peminjaman->kode_peminjaman }}
            </h3>
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $status['badge'] }}">
                {{ $status['label'] }}
            </span>
        </div>

        {{-- Informasi Tanggal --}}
        <div class="flex flex-col text-right text-xs">
            <p class="whitespace-nowrap">
                Waktu Pengajuan: 
                <span class="text-[#363062] font-semibold">
                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengajuan)->format('H:i | d/m/Y') }}
                </span>
            </p>
            
            <p class="whitespace-nowrap mt-1">
                Waktu Disetujui: 
                <span class="text-[#363062] font-semibold">
                    {{ $peminjaman->tanggal_disetujui ? \Carbon\Carbon::parse($peminjaman->tanggal_disetujui)->format('H:i | d/m/Y') : '-' }}
                </span>
            </p>
        </div>
    </div>

    <hr class="my-2 border-gray-500">

    {{-- BODY --}}
    <div class="flex flex-col gap-3">

        {{-- TOP ROW --}}
        <div class="flex justify-between items-start text-xs text-gray-500">
            <p class="text-sm text-black">Daftar alat / barang dipinjam:</p>

            <div class="flex items-center gap-1.5">
                <div class="h-1.5 w-1.5 rounded-full bg-[#363062]"></div>
                <p class="text-xs font-semibold text-[#363062]">
                    {{ $peminjaman->detailPeminjaman->sum('jumlah') }} Items
                </p>
            </div>
        </div>
        {{-- Daftar Alat --}}
        <div class="flex flex-col gap-3">
            @foreach($peminjaman->detailPeminjaman as $detail)
            <div class="flex items-center justify-between gap-4">
                
                {{-- LEFT ITEM --}}
                <div class="flex items-center gap-3 flex-1">
                    <div class="w-12 h-12 rounded-xl border flex items-center justify-center overflow-hidden bg-gray-50 flex-shrink-0">
                        <img 
                            src="{{ $detail->alat->gambar ? asset('storage/' . $detail->alat->gambar) : asset('images/default-alat.jpg') }}" 
                            alt="{{ $detail->alat->nama_alat }}" 
                            class="w-full h-full object-cover"
                        >
                    </div>

                    <div class="flex-1">
                        <p class="text-sm font-medium">
                            {{ $detail->alat->nama_alat }} 
                            <span class="text-xs font-medium text-gray-500">×{{ $detail->jumlah }}</span>
                        </p>
                        <div class="flex items-center gap-1 mt-0.5">
                            <div class="h-2 w-2 rounded-full" style="background: {{ $detail->alat->kategori->warna ?? '#363062' }}"></div>
                            <p class="text-xs text-gray-500">{{ $detail->alat->kategori->nama_kategori ?? 'Tanpa Kategori' }}</p>
                        </div>
                    </div>
                </div>

                {{-- RIGHT DURATION --}}
                <div class="text-right text-xs text-gray-500 whitespace-nowrap flex-shrink-0">
                    @php
                        $hasDeadline = !is_null($peminjaman->deadline);
                        $deadline = $hasDeadline ? \Carbon\Carbon::parse($peminjaman->deadline) : null;
                        $lateTime = $hasDeadline ? $deadline->copy()->addMinutes(10) : null;
                        $currentStatus = $status['label']; // 'Dipinjam', 'Jatuh Tempo', 'Terlambat', 'Menunggu', 'Selesai', dll
                    @endphp

                    @if(!$hasDeadline || in_array($currentStatus, ['Menunggu', 'Selesai', 'Ditolak']))
                        {{-- Menunggu / Selesai / Ditolak: warna hitam biasa --}}
                        <div class="flex flex-col gap-1">
                            <span>Durasi Peminjaman</span>
                            <div class="flex items-center text-black justify-end gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/>
                                        <path d="M12 7v5l3 3"/>
                                    </g>
                                </svg>
                                <span class="font-semibold">
                                    {{ floor($detail->alat->durasi / 60) > 0 ? floor($detail->alat->durasi / 60) . ' Jam ' : '' }}{{ $detail->alat->durasi % 60 > 0 ? ($detail->alat->durasi % 60) . ' Menit' : '' }}
                                </span>
                            </div>
                        </div>
                    @else
                        {{-- Dipinjam (aktif dengan deadline): tampilkan countdown dengan warna khusus saat jatuh tempo/terlambat --}}
                        <div x-data="countdown(
                            '{{ $deadline->toIso8601String() }}', 
                            '{{ $lateTime->toIso8601String() }}'
                        )" class="flex flex-col gap-1">
                            <span>Durasi Peminjaman</span>
                            <div class="flex items-center justify-end gap-1" :class="statusClass">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/>
                                        <path d="M12 7v5l3 3"/>
                                    </g>
                                </svg>
                                <span x-text="timeLeft" class="font-semibold"></span>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
            @endforeach
        </div>
    </div>

    {{-- ACTION BUTTON --}}
    <div class="flex justify-end gap-2 my-4 pt-4 border-t border-gray-500">
        @if(in_array($peminjaman->status, ['dipinjam', 'jatuh_tempo', 'terlambat']) && !$peminjaman->pengembalian)
            
            {{-- Cek dari property can_return yang sudah kita set di controller --}}
            @if($peminjaman->can_return ?? false)
                {{-- Tombol AKTIF (warna #363062) - bisa diklik --}}
                <form action="{{ route('peminjam.pengembalian.ajukan', $peminjaman->kode_peminjaman) }}" 
                    method="POST" 
                    onsubmit="return confirm('Apakah Anda yakin ingin mengajukan pengembalian untuk peminjaman ini?\n\nPastikan semua alat sudah siap untuk dikembalikan.');">
                    @csrf
                    <button type="submit" 
                            class="px-5 py-2 border border-transparent rounded-full text-sm transition-all duration-200 bg-[#363062] text-white hover:bg-transparent hover:border-[#363062] hover:text-[#363062]">
                        Ajukan Kembalikan
                    </button>
                </form>
            @else
                {{-- Tombol NON-AKTIF (abu-abu) - belum bisa diklik --}}
                <button type="button" 
                        disabled
                        class="px-5 py-2 border border-gray-300 rounded-full bg-gray-300 text-gray-500 text-sm cursor-not-allowed">
                    Belum Bisa Dikembalikan
                </button>
            @endif
            
        @elseif($peminjaman->pengembalian)
            <button type="button" 
                    disabled
                    class="px-5 py-2 border border-gray-300 rounded-full bg-gray-300 text-gray-500 text-sm cursor-not-allowed">
                Pengembalian Diajukan
            </button>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function countdown(deadline, lateTime) {
        return {
            deadline: new Date(deadline).getTime(),
            lateTime: new Date(lateTime).getTime(),
            timeLeft: '',
            statusClass: 'text-black', // default hitam
            
            init() {
                const update = () => {
                    const now = new Date().getTime();
                    const distanceToDeadline = this.deadline - now;
                    const distanceToLate = this.lateTime - now;
                    
                    // Fase Terlambat -> warna MERAH
                    if (distanceToLate <= 0) {
                        this.timeLeft = 'Terlambat';
                        this.statusClass = 'text-red-500';
                        return;
                    }
                    
                    // Fase Jatuh Tempo -> warna ORANGE (#F99417)
                    if (distanceToDeadline <= 0) {
                        this.timeLeft = 'Jatuh Tempo';
                        this.statusClass = 'text-[#F99417]';
                        return;
                    }
                    
                    // Fase Dipinjam (masih countdown) -> warna HITAM
                    const hours = Math.floor(distanceToDeadline / (1000 * 60 * 60));
                    const minutes = Math.floor((distanceToDeadline % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distanceToDeadline % (1000 * 60)) / 1000);
                    
                    this.timeLeft = String(hours).padStart(2, '0') + ':' +
                                String(minutes).padStart(2, '0') + ':' +
                                String(seconds).padStart(2, '0');
                    this.statusClass = 'text-black'; // hitam
                };
                
                update();
                setInterval(update, 1000);
            }
        }
    }
</script>
@endpush