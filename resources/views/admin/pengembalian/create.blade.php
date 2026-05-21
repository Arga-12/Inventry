@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4">
    <div class="w-full flex flex-col gap-10">

        {{-- HEADER --}}
        <div class="flex flex-col gap-1">
            <h1 class="text-4xl font-bold">
                Tambahkan data pengembalian
            </h1>

            <p class="text-gray-500">
                Lengkapi informasi pengembalian alat dan barang dengan benar.
            </p>
        </div>

        <form
            action="{{ route('admin-pengembalian-store') }}"
            method="POST"
            class="flex flex-col gap-10"
        >
            @csrf

            <div x-data="pengembalianForm()" x-cloak class="flex flex-col gap-10">

                {{-- DATA PEMINJAMAN --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

                    <div>
                        <h2 class="text-3xl font-bold">Data Peminjaman</h2>
                        <p class="text-gray-500 text-sm">
                            Pilih kode peminjaman yang ingin dikembalikan.
                        </p>
                    </div>

                    <div class="flex flex-col gap-4">

                        <label class="text-sm font-medium">Kode Peminjaman</label>

                        <select
                            name="peminjaman_id"
                            x-model="selectedPeminjaman"
                            class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white"
                        >
                            <option value="">Pilih peminjaman</option>

                            @foreach($peminjaman as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->kode_peminjaman }} - {{ $item->peminjam->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <hr class="border-t border-gray-300">

                {{-- INFORMASI --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

                    <div>
                        <h2 class="text-3xl font-bold">Informasi Pengembalian</h2>
                        <p class="text-gray-500 text-sm">
                            Atur status dan waktu pengembalian barang.
                        </p>
                    </div>

                    <div class="flex flex-col gap-6">

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                            {{-- STATUS --}}
                            <div class="flex flex-col gap-2">

                                <label class="text-sm font-medium">Status</label>

                                <select
                                    name="status"
                                    x-model="status"
                                    class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white"
                                >
                                    <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                                    <option value="selesai">Selesai</option>
                                </select>

                            </div>

                            {{-- TANGGAL --}}
                            <div class="flex flex-col gap-2">

                                <label class="text-sm font-medium">Tanggal Pengembalian</label>

                                <input
                                    type="datetime-local"
                                    min="{{ now()->format('Y-m-d') }}"
                                    value="{{ now()->format('Y-m-d') }}"
                                    name="tanggal_pengembalian"
                                    class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white"
                                >

                            </div>

                        </div>

                        {{-- VERIFIKASI --}}
                        <div x-show="status === 'selesai'" x-transition class="flex flex-col gap-2">

                            <label class="text-sm font-medium">Tanggal Verifikasi</label>

                            <input
                                type="datetime-local"
                                name="tanggal_verifikasi"
                                class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white"
                            >

                        </div>

                    </div>
                </div>

                <hr class="border-t border-gray-300">

                {{-- KONDISI --}}
                <div
                    x-show="status === 'selesai' && selectedPeminjaman"
                    x-transition
                    class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16"
                >

                    <div>
                        <h2 class="text-3xl font-bold">Kondisi Barang</h2>
                        <p class="text-gray-500 text-sm">
                            Atur kondisi setiap barang yang dikembalikan.
                        </p>
                    </div>

                    <div class="flex flex-col gap-4">

                        @foreach($peminjaman as $data)

                            @foreach($data->detailPeminjaman as $index => $detail)

                                <div
                                    x-show="selectedPeminjaman == '{{ $data->id }}'"
                                    class="border border-gray-300 rounded-2xl p-5 flex flex-col gap-4"
                                >

                                    <input
                                        type="hidden"
                                        name="items[{{ $index }}][detail_peminjaman_id]"
                                        value="{{ $detail->id }}"
                                    >

                                    <div class="flex flex-col gap-1">
                                        <h3 class="font-semibold text-lg">
                                            {{ $detail->alat->nama_alat }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            Jumlah: {{ $detail->jumlah }}
                                        </p>
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        <label class="text-sm font-medium">Kondisi</label>

                                        <select
                                            name="items[{{ $index }}][kondisi]"
                                            class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white"
                                        >
                                            <option value="lolos">Lolos</option>
                                            <option value="rusak">Rusak</option>
                                        </select>
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        <label class="text-sm font-medium">Catatan</label>

                                        <textarea
                                            name="items[{{ $index }}][catatan_kondisi]"
                                            rows="3"
                                            class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white"
                                        ></textarea>
                                    </div>

                                </div>

                            @endforeach

                        @endforeach

                    </div>
                </div>

                {{-- ACTION --}}
                <hr x-show="status === 'selesai' && selectedPeminjaman" class="border-t border-gray-300">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

                    <div></div>

                    <div class="flex items-center gap-4">

                        <a
                            href="{{ route('admin-pengembalian') }}"
                            class="w-full text-center border border-gray-300 rounded-full px-6 py-3 hover:bg-gray-100"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="w-full bg-[#363062] text-white rounded-full px-6 py-3 hover:opacity-90"
                        >
                            Simpan
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
        status: 'menunggu_verifikasi',
        selectedPeminjaman: '',

        get showDetail() {
            return this.status === 'selesai' && this.selectedPeminjaman;
        }
    }
}
</script>
@endsection