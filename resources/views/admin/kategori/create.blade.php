@extends('layouts.app')

@section('content')
    <div class="mx-auto pt-20 pb-8 lg:py-8 px-4">

        <div class="w-full flex flex-col gap-10">

            {{-- HEADER --}}
            <div class="flex flex-col gap-1">

                <h1 class="text-2xl sm:text-4xl font-bold">
                    Tambahkan Kategori
                </h1>

                <p class="text-xs sm:text-sm text-gray-500">
                    Lengkapi informasi kategori barang dengan benar.
                </p>

            </div>

            <form action="{{ route('admin-kategori-store') }}" method="POST" class="flex flex-col gap-10">

                @csrf

                {{-- DETAIL KATEGORI --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start">

                    {{-- KIRI --}}
                    <div class="flex flex-col gap-1">

                        <h2 class="text-xl sm:text-3xl font-bold">
                            Detail Kategori
                        </h2>

                        <p class="text-xs sm:text-sm text-gray-500">
                            Masukkan kode, nama kategori, dan identitas warna kategori.
                        </p>

                    </div>

                    {{-- KANAN --}}
                    <div class="flex flex-col gap-6">

                        {{-- NAMA KATEGORI --}}
                        <div class="flex flex-col gap-2">

                            <label class="text-xs sm:text-sm font-bold text-gray-700">
                                Nama Kategori
                            </label>

                            <input type="text" name="nama_kategori" placeholder="Masukkan nama kategori..."
                                class="w-full border border-gray-400 rounded-xl px-4 py-2.5 sm:py-3 bg-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#363062] transition-shadow">

                        </div>

                        {{-- WARNA --}}
                        <div class="flex flex-col gap-2">

                            <label class="text-xs sm:text-sm font-bold text-gray-700">
                                Warna Kategori
                            </label>

                            <div class="flex items-center gap-4">

                                <div class="overflow-hidden w-16 h-14 border border-gray-300 rounded-xl">
                                    <input type="color" name="warna" value="#363062"
                                        class="block w-full h-full p-0 bg-transparent border-0 cursor-pointer [&::-webkit-color-swatch-wrapper]:p-0 [&::-webkit-color-swatch]:border-none [&::-moz-color-swatch]:border-none">
                                </div>

                                <div class="flex flex-col">

                                    <span class="text-sm font-medium text-[#363062]">
                                        Identitas Warna
                                    </span>

                                    <p class="text-xs text-gray-500">
                                        Warna digunakan untuk badge kategori dan statistik dashboard.
                                    </p>

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

                        <a href="{{ route('admin-kategori') }}" type="button"
                            class="w-full text-center border border-gray-300 rounded-full px-6 py-2.5 sm:py-3 hover:bg-gray-100 transition-all font-bold text-xs sm:text-sm">Batal</a>

                        <button type="submit"
                            class="w-full border border-transparent bg-[#363062] rounded-full px-6 py-2.5 sm:py-3 text-white hover:bg-white hover:border-[#363062] hover:text-[#363062] transition-all font-bold text-xs sm:text-sm shadow-sm">Simpan</button>

                    </div>

                </div>

            </form>
        </div>
    </div>
@endsection