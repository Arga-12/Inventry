@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4">

    {{-- HEADER --}}
    <div class="mb-10">
        <h1 class="text-4xl font-bold">Manajemen Kategori</h1>

        <p class="text-sm text-gray-500">
            Kelola kategori alat dan berikan identitas warna untuk mempermudah pengelompokan data.
        </p>
    </div>

    {{-- TOPBAR --}}
    <div class="flex items-center justify-between gap-4 flex-wrap mb-6">

        {{-- SEARCH --}}
        <div class="relative w-64">

            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/>
                </svg>
            </div>

            <input
                type="text"
                placeholder="Cari kategori..."
                class="w-full pl-10 pr-4 py-3 border border-[#363062] rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#363062]"
            >

        </div>

        {{-- BUTTON --}}
        <a href="{{ route('admin-kategori-create') }}" class="px-5 py-3 flex items-center gap-2 rounded-full bg-[#363062] text-white hover:bg-[#2B2750] transition-all">

            Tambahkan Kategori

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24">
                <path fill="currentColor" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2"/>
            </svg>

        </a>

    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full border-collapse text-sm">

            {{-- TABLE HEADER --}}
            <thead>

                <tr class="bg-gradient-to-r from-[#363062] to-[#4D4C7D] text-white">

                    <th class="py-4 px-4 text-left rounded-tl-[20px] w-16">
                        No
                    </th>

                    <th class="py-4 px-4 text-left">
                        Warna
                    </th>

                    <th class="py-4 px-4 text-left">
                        Kode Kategori
                    </th>

                    <th class="py-4 px-4 text-left">
                        Nama Kategori
                    </th>

                    <th class="py-4 px-4 text-left">
                        Total Barang
                    </th>

                    <th class="py-4 px-4 text-left rounded-tr-[20px]">
                        Aksi
                    </th>

                </tr>

            </thead>

            {{-- TABLE BODY --}}
            <tbody class="text-[#363062]">

                @forelse ($kategori as $data)
                <tr class="border-b border-gray-300 hover:bg-gray-50 transition-all">

                    {{-- NO --}}
                    <td class="py-4 px-4 font-medium">
                        {{ $loop->iteration }}.
                    </td>

                    {{-- COLOR --}}
                    <td class="py-4 px-4">

                        <div class="flex items-center gap-3">

                            <div
                                class="w-5 h-5 rounded-full border border-gray-300"
                                style="background-color: {{ $data->warna }}"
                            ></div>

                            <span class="text-gray-500 text-xs">
                                {{ strtoupper($data->warna) }}
                            </span>

                        </div>

                    </td>

                    {{-- KODE --}}
                    <td class="py-4 px-4 font-semibold">
                        {{ $data->kode_kategori }}
                    </td>

                    {{-- NAMA --}}
                    <td class="py-4 px-4 text-black font-semibold">
                        {{ $data->nama_kategori }}
                    </td>

                    {{-- TOTAL --}}
                    <td class="py-4 px-4 text-gray-600">
                        24 Barang
                    </td>

                    {{-- AKSI --}}
                    <td class="py-4 px-4">

                        <div class="flex items-center gap-2">

                            <a href="{{ route('admin-kategori-edit', $data) }}" class="px-4 py-2 rounded-full border border-[#363062] text-[#363062] hover:bg-[#363062] hover:text-white transition-all">
                                Edit
                            </a>

                            <form action="{{ route('admin-kategori-destroy', $data) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="Anda yakin?" type="submit" class="px-4 py-2 rounded-full border border-red-400 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                    Hapus
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="6" class="py-16 text-center text-gray-400">
                        Belum ada kategori tersedia
                    </td>
                </tr>

                @endforelse
               

            </tbody>

        </table>

    </div>

</div>
@endsection