@extends('layouts.app')

@section('content')
<div class="mx-auto pt-20 pb-8 lg:py-8 px-4">
    <div class="w-full flex flex-col gap-10">

        {{-- HEADER --}}
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl sm:text-4xl font-bold">
                Tambahkan data pengembalian
            </h1>

            <p class="text-xs sm:text-sm text-gray-500">
                Lengkapi informasi pengembalian alat dan barang dengan benar.
            </p>
        </div>

        <form
            action="{{ route('admin-pengembalian-update', $pengembalian) }}"
            method="POST"
            class="flex flex-col gap-10"
        >
            @csrf
            @method('PUT')

            <div x-data="pengembalianForm()" class="flex flex-col gap-10">

                {{-- DATA PEMINJAMAN --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

                    <div>
                        <h2 class="text-xl sm:text-3xl font-bold">Data Peminjaman</h2>
                        <p class="text-xs sm:text-sm text-gray-500">
                            Pilih kode peminjaman yang ingin dikembalikan.
                        </p>
                    </div>

                    <div class="flex flex-col gap-4">

                        <label class="text-xs sm:text-sm font-bold text-gray-700">Kode Peminjaman</label>

                        <select
                            name="peminjaman_id"
                            x-model="selectedPeminjaman"
                            x-init="selectedPeminjaman = '{{ old('peminjaman_id', $pengembalian->peminjaman_id) }}'"
                            class="w-full border border-gray-400 rounded-xl px-4 py-2.5 sm:py-3 bg-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow">
                        >
                            <option value="">Pilih peminjaman</option>

                            @foreach($peminjaman as $item)
                                <option
                                    value="{{ $item->id }}"
                                    @selected(old('peminjaman_id', $pengembalian->peminjaman_id) == $item->id)
                                >
                                    {{ $item->kode_peminjaman }} - {{ $item->peminjam->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <hr>

                {{-- INFORMASI --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

                    <div>
                        <h2 class="text-xl sm:text-3xl font-bold">Informasi Pengembalian</h2>
                        <p class="text-xs sm:text-sm text-gray-500">
                            Atur status dan waktu pengembalian barang.
                        </p>
                    </div>

                    <div class="flex flex-col gap-6">

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                            {{-- STATUS --}}
                            <div>
                                <label class="text-xs sm:text-sm font-bold text-gray-700">Status</label>

                                <select
                                    name="status"
                                    x-model="status"
                                    x-init="status = '{{ old('status', $pengembalian->status) }}'"
                                    class="w-full border border-gray-400 rounded-xl px-4 py-2.5 sm:py-3 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow">
                                >
                                    <option value="menunggu_verifikasi"
                                        @selected(old('status', $pengembalian->status) == 'menunggu_verifikasi')
                                    >
                                        Menunggu Verifikasi
                                    </option>

                                    <option value="selesai"
                                        @selected(old('status', $pengembalian->status) == 'selesai')
                                    >
                                        Selesai
                                    </option>
                                </select>
                            </div>

                            {{-- TANGGAL --}}
                            <div>
                                <label class="text-xs sm:text-sm font-bold text-gray-700">Tanggal Pengembalian</label>

                                <input
                                    type="datetime-local"
                                    name="tanggal_pengembalian"
                                    value="{{ old('tanggal_pengembalian', \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('Y-m-d\TH:i')) }}"
                                    class="w-full border border-gray-400 rounded-xl px-4 py-2.5 sm:py-3 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow"
                                >
                            </div>

                        </div>

                        {{-- VERIFIKASI --}}
                        <div x-show="status === 'selesai'">

                           <label class="text-xs sm:text-sm font-bold text-gray-700">Tanggal Verifikasi</label>

                            <input
                                type="datetime-local"
                                name="tanggal_verifikasi"
                                value="{{ old('tanggal_verifikasi', optional($pengembalian->tanggal_verifikasi)->format('Y-m-d\TH:i')) }}"
                                class="w-full border border-gray-400 rounded-xl px-4 py-2.5 sm:py-3 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow"
                            >

                        </div>

                    </div>
                </div>

                <hr x-show="status === 'selesai' || status === 'menunggu_verifikasi'" class="border-t border-gray-300">

                {{-- DETAIL --}}
                <div x-show="status === 'selesai'" x-transition class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

                    <div>
                        <h2 class="text-xl sm:text-3xl font-bold">
                            Kondisi Barang
                        </h2>

                        <p class="text-xs sm:text-sm text-gray-500">
                            Atur kondisi setiap barang yang dikembalikan.
                        </p>
                    </div>

                    <div class="flex flex-col gap-4">

                        @foreach($pengembalian->detailPengembalian as $index => $detail)

                            <div
                                x-show="selectedPeminjaman == '{{ $pengembalian->peminjaman_id }}'"
                                x-transition
                                class="border border-gray-300 rounded-2xl p-5 flex flex-col gap-4"
                            >

                                <input
                                    type="hidden"
                                    name="items[{{ $index }}][detail_peminjaman_id]"
                                    value="{{ $detail->detail_peminjaman_id }}"
                                >

                                {{-- nama alat --}}
                                <div class="flex flex-col gap-1">

                                    <h3 class="font-semibold text-base sm:text-lg">
                                        {{ $detail->detailPeminjaman->alat->nama_alat }} <span class="text-xs sm:text-sm text-gray-500">×{{ $detail->jumlah_kembali }}</span>
                                    </h3>

                                </div>

                                {{-- kondisi --}}
                                <div class="flex flex-col gap-2">

                                    <label class="text-xs sm:text-sm font-bold text-gray-700">Kondisi</label>

                                    <select
                                        name="items[{{ $index }}][kondisi]"
                                        class="w-full border border-gray-400 rounded-xl px-4 py-2.5 sm:py-3 bg-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow">
                                    >
                                        <option value="lolos"
                                            @selected(old("items.$index.kondisi", $detail->kondisi) == 'lolos')
                                        >
                                            Lolos
                                        </option>

                                        <option value="rusak"
                                            @selected(old("items.$index.kondisi", $detail->kondisi) == 'rusak')
                                        >
                                            Rusak
                                        </option>
                                    </select>

                                </div>

                                {{-- catatan --}}
                                <div class="flex flex-col gap-2">

                                    <label class="text-xs sm:text-sm font-bold text-gray-700">Catatan Kondisi</label>

                                    <textarea
                                        name="items[{{ $index }}][catatan_kondisi]"
                                        rows="3"
                                        placeholder="Tambahkan catatan kondisi barang..."
                                        class="w-full border border-gray-400 rounded-xl px-4 py-2.5 sm:py-3 bg-white resize-none text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow"
                                    >{{ old("items.$index.catatan_kondisi", $detail->catatan_kondisi) }}</textarea>

                                </div>

                            </div>

                        @endforeach

                    </div>
                </div>

                <hr x-show="status === 'selesai' && selectedPeminjaman" class="border-t border-gray-300"/>

                {{-- ACTION --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

                    <div></div>

                    <div class="flex items-center gap-4">

                        <a
                            href="{{ route('admin-pengembalian') }}"
                            class="w-full text-center border border-gray-300 rounded-full px-6 py-2.5 sm:py-3 hover:bg-gray-100 transition-all font-bold text-xs sm:text-sm"
                        >
                            Batal
                        </a>

                        <button type="submit" class="w-full border border-transparent bg-[#363062] rounded-full px-6 py-2.5 sm:py-3 text-white hover:bg-white hover:border-[#363062] hover:text-[#363062] transition-all font-bold text-xs sm:text-sm shadow-sm">
                            Update
                        </button>

                    </div>

                </div>

            </div>
        </form>
    </div>
</div>

<script>
function pengembalianForm() {
    return {
        status: '{{ old('status', $pengembalian->status) }}',
        selectedPeminjaman: '{{ old('peminjaman_id', $pengembalian->peminjaman_id) }}',
    }
}
</script>
@endsection