@extends('layouts.app')

@section('content')
    <div class="mx-auto pt-20 pb-8 lg:py-8 px-4">
        <div class="w-full flex flex-col gap-10">

            {{-- HEADER --}}
            <div class="flex flex-col gap-1">
                <h1 class="text-2xl sm:text-4xl font-bold">
                    Edit alat / barang peminjaman
                </h1>

                <p class="text-xs sm:text-sm text-gray-500">
                    Lengkapi informasi peminjaman alat dan barang dengan benar.
                </p>
            </div>

            <form action="{{ route('admin-alat-update', $alat, $kategori) }}" method="POST" enctype="multipart/form-data"
                class="flex flex-col gap-10">
                @csrf
                @method('PUT')
                {{-- FOTO BARANG --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start">

                    <div class="flex flex-col gap-1">
                        <h2 class="text-xl sm:text-3xl font-bold">
                            Foto Barang
                        </h2>

                        <p class="text-xs sm:text-sm text-gray-500">
                            Unggah foto alat atau barang.
                        </p>
                    </div>

                    <div x-data="{ preview: '{{ asset('storage/' . $alat->gambar) }}' }">

                        <label
                            class="group w-full h-64 border border-gray-300 rounded-3xl flex flex-col items-center justify-center bg-gray-100 hover:bg-gray-200 transition cursor-pointer overflow-hidden relative">

                            <input type="file" name="gambar" class="hidden" accept="image/*" @change="
                            preview = URL.createObjectURL($event.target.files[0])
                            ">

                            {{-- preview image --}}
                            <template x-if="preview">
                                <img :src="preview" class="absolute inset-0 w-full h-full object-cover">
                            </template>

                            {{-- upload text overlay --}}
                            <div class="absolute inset-0 flex flex-col items-center justify-center transition-all duration-300"
                                :class="preview ? 'bg-black/40 opacity-0 group-hover:opacity-100' : 'opacity-100'">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-3"
                                    :class="preview ? 'text-white' : 'text-gray-500'" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>

                                <span class="text-sm font-medium" :class="preview ? 'text-white' : 'text-gray-500'">
                                    Upload foto barang
                                </span>

                            </div>

                        </label>

                    </div>

                </div>

                <hr class="border-t border-gray-300">

                {{-- DETAIL BARANG --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start">

                    <div class="flex flex-col gap-1">
                        <h2 class="text-xl sm:text-3xl font-bold">
                            Detail Barang
                        </h2>

                        <p class="text-xs sm:text-sm text-gray-500">
                            Lengkapi nama barang dan kategori.
                        </p>
                    </div>

                    <div class="flex flex-col gap-6">

                        <div class="flex flex-col gap-2">
                            <label class="text-xs sm:text-sm font-bold text-gray-700">
                                Nama Barang
                            </label>

                            <input type="text" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}"
                                placeholder="Masukkan nama barang..."
                                class="w-full border border-gray-400 rounded-xl px-4 py-2.5 sm:py-3 bg-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-xs sm:text-sm font-bold text-gray-700">
                                Kategori
                            </label>

                            <select name="kategori_id"
                                class="w-full border border-gray-400 rounded-xl px-4 py-2.5 sm:py-3 bg-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow">
                                @foreach($kategori as $data)
                                    <option value="{{ $data->id }}" {{ $alat->kategori_id == $data->id ? 'selected' : '' }}>
                                        {{ $data->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </div>

                <hr class="border-t border-gray-300">

                {{-- DURASI & KETERANGAN --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start">

                    <div class="flex flex-col gap-1">
                        <h2 class="text-xl sm:text-3xl font-bold">
                            Durasi & Stok
                        </h2>

                        <p class="text-xs sm:text-sm text-gray-500">
                            Tentukan waktu peminjaman dan jumlah barang yang tersedia.
                        </p>
                    </div>

                    <div class="flex flex-col gap-6">

                        <div class="flex flex-col gap-2">
                            <label class="text-xs sm:text-sm font-bold text-gray-700">
                                Stok saat ini
                            </label>

                            <input rows="4" type="number" name="stok" value="{{ old('stok', $alat->stok) }}"
                                class="w-full border border-gray-400 rounded-xl px-4 py-2.5 sm:py-3 bg-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow resize-none"></input>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                            <div class="flex flex-col items-center justify-center gap-2">
                                <span class="text-xs sm:text-sm font-bold text-gray-700">Durasi peminjaman</span>
                            </div>

                            <div class="flex flex-col items-center justify-center gap-2">
                                <input type="number" name="durasi" value="{{ old('durasi', $alat->durasi) }}"
                                    class="w-full border border-gray-400 rounded-xl px-4 py-2.5 sm:py-3 bg-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow">
                            </div>

                            <div class="flex flex-col items-center justify-center gap-2">
                                <div
                                    class="w-full h-full text-left border border-gray-400 rounded-xl px-4 py-2.5 sm:py-3 bg-white text-xs sm:text-sm">
                                    <span class="font-medium text-gray-500">Menit</span>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <hr class="border-t border-gray-300">

                {{-- ACTION --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

                    <div></div>

                    <div class="flex items-center gap-4">

                        <a href="{{ route('admin-alat') }}" type="button"
                            class="w-full text-center border border-gray-300 rounded-full px-6 py-2.5 sm:py-3 hover:bg-gray-100 transition-all font-bold text-xs sm:text-sm">
                            Batal
                        </a>

                        <button type="submit"
                            class="w-full border border-transparent bg-[#363062] rounded-full px-6 py-2.5 sm:py-3 text-white hover:bg-white hover:border-[#363062] hover:text-[#363062] transition-all font-bold text-xs sm:text-sm shadow-sm">
                            Simpan
                        </button>

                    </div>

                </div>

            </form>

        </div>
    </div>
@endsection