@extends('layouts.app')

@section('content')
<div class="mx-auto py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

        {{-- baris1 kolom1 --}}
        <div class="lg:col-span-1 flex flex-col gap-3">
            <h1 class="text-4xl font-bold tracking-tight">Dashboard</h1>
            <p class="text-gray-500 font-medium leading-relaxed text-lg">
                Selamat datang di Inventry. Mari pantau dan kelola antrean persetujuan peminjaman serta pengembalian alat hari ini.
            </p>
        </div>

        {{-- baris1 kolom2 col-span2 --}}
        <div class="lg:col-span-2 rounded-[20px] p-4 bg-gradient-to-r from-[#363062] to-[#4D4C7D] flex flex-col md:flex-row gap-8 relative shadow-lg">

            <div class="flex-1 flex flex-col">

                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-white text-lg">Menunggu Persetujuan</h3>
                    <div class="flex items-center gap-2 text-sm font-normal text-white">
                        <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        12 Peminjam
                    </div>
                </div>

                <div class="relative overflow-hidden h-28 mb-3">

                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full shadow-md flex-shrink-0 bg-gray-50 overflow-hidden">
                                    <img src="{{ asset('images/mygw.jpeg') }}" class="w-full h-full object-cover">
                                </div>

                                <span class="font-bold text-white">Budi</span>
                            </div>
                            <span class="text-sm font-medium text-white">3 Item</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full shadow-md flex-shrink-0 bg-gray-50 overflow-hidden">
                                    <img src="{{ asset('images/mygw.jpeg') }}" class="w-full h-full object-cover">
                                </div>
                                <span class="font-bold text-white">Agus</span>
                            </div>
                            <span class="text-sm font-medium text-white">1 Item</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full shadow-md flex-shrink-0 bg-gray-50 overflow-hidden">
                                    <img src="{{ asset('images/mygw.jpeg') }}" class="w-full h-full object-cover">
                                </div>
                                <span class="font-bold text-white">Hulk</span>
                            </div>
                            <span class="text-sm font-medium text-white">1 Item</span>
                        </div>
                    </div>

                    <div class="absolute bottom-0 left-0 w-full border border-white pointer-events-none"></div>


                </div>

                <button class="w-full mt-auto py-2 border border-transparent rounded-full font-normal text-[#363062] bg-white hover:bg-transparent hover:border-white hover:text-white transition-colors">
                    Selengkapnya
                </button>
            </div>

            <div class="hidden md:block w-0.5 bg-white rounded-full flex-shrink-0"></div>
            <div class="block md:hidden h-0.5 w-full bg-white rounded-full flex-shrink-0"></div>

            <div class="flex-1 flex flex-col">

                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-white text-lg">Menunggu Konfirmasi</h3>
                    <div class="flex items-center gap-2 text-sm font-normal text-white">
                        <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        2 Pengembali
                    </div>
                </div>

                <div class="relative overflow-hidden h-28 mb-3">

                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full shadow-md flex-shrink-0 bg-gray-50 overflow-hidden">
                                    <img src="{{ asset('images/mygw.jpeg') }}" class="w-full h-full object-cover">
                                </div>
                                <span class="font-bold text-white">Budi</span>
                            </div>
                            <span class="text-sm font-medium text-white">3 Item</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full shadow-md flex-shrink-0 bg-gray-50 overflow-hidden">
                                    <img src="{{ asset('images/mygw.jpeg') }}" class="w-full h-full object-cover">
                                </div>
                                <span class="font-bold text-white">Agus</span>
                            </div>
                            <span class="text-sm font-medium text-white">1 Item</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full shadow-md flex-shrink-0 bg-gray-50 overflow-hidden">
                                    <img src="{{ asset('images/mygw.jpeg') }}" class="w-full h-full object-cover">
                                </div>
                                <span class="font-bold text-white">Hulk</span>
                            </div>
                            <span class="text-sm font-medium text-white">1 Item</span>
                        </div>
                    </div>

                    <div class="absolute bottom-0 left-0 w-full border border-white pointer-events-none"></div>

                </div>

                <button class="w-full mt-auto py-2 border border-transparent rounded-full font-normal text-[#363062] bg-white hover:bg-transparent hover:border-white hover:text-white transition-colors">
                    Selengkapnya
                </button>
            </div>

        </div>

        {{-- baris2 --}}
        <div class="w-full p-4 flex flex-col col-span-3 gap-3">

            <div class="flex items-center gap-4">

             <div class="bg-gradient-to-l from-[#363062] to-[#4D4C7D] shadow-lg h-14 w-14 p-auto rounded-[15px] flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#F5F5F5]" viewBox="0 0 24 24">
                    <g fill="none" fill-rule="evenodd">
                        <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                        <path fill="currentColor" d="m13.25 2.567l6.294 3.634a2.5 2.5 0 0 1 1.25 2.165v7.268a2.5 2.5 0 0 1-1.25 2.165l-6.294 3.634a2.5 2.5 0 0 1-2.5 0l-6.294-3.634a2.5 2.5 0 0 1-1.25-2.165V8.366a2.5 2.5 0 0 1 1.25-2.165l6.294-3.634a2.5 2.5 0 0 1 2.5 0M5.206 9.232v6.402a.5.5 0 0 0 .25.433l5.544 3.2V12.56zm13.588 0L13 12.56v6.709l5.544-3.201a.5.5 0 0 0 .242-.345l.008-.088zM11.75 4.3L6.206 7.5l5.544 3.201a.5.5 0 0 0 .5 0L17.794 7.5L12.25 4.299a.5.5 0 0 0-.5 0Z" />
                    </g>
                </svg>
            </div>

            <div class="flex flex-col gap-1">
                <h2 class="text-3xl font-bold">Analisis data peminjaman</h2>
                <p class="text-sm font-medium text-gray-500">
                    Pantau tren dan intensitas sirkulasi peminjaman maupun pengembalian alat sepanjang tahun.
                </p>
            </div>


        </div>

        <div class="w-full overflow-x-auto custom-scrollbar pb-2">
            <div class="min-w-[800px] flex flex-col">

                <div class="flex gap-4 mb-6">
                    <div class="text-xs font-medium invisible shrink-0 pointer-events-none">
                        argandull
                    </div>

                    <div class="flex-1 grid grid-cols-2 gap-8">
                        <div class="flex flex-col items-start">
                            <span class="block text-5xl font-bold">97</span>
                            <span class="text-sm font-medium text-gray-500">Pengajuan diterima</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="block text-5xl font-bold">83</span>
                            <span class="text-sm font-medium text-gray-500">Pengembalian dilakukan</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">

                    <div class="flex flex-col gap-2 text-xs font-medium text-gray-500 shrink-0">
                        <span class="h-16 flex items-center">Minggu 1</span>
                        <span class="h-16 flex items-center">Minggu 2</span>
                        <span class="h-16 flex items-center">Minggu 3</span>
                        <span class="h-16 flex items-center">Minggu 4</span>
                    </div>

                    <div class="flex-1 flex flex-col gap-2">

                        <div class="grid grid-cols-12 gap-2">
                            @for ($i = 0; $i < 48; $i++)
                            <div class="bg-gray-300 rounded-xl h-16 w-full hover:bg-gray-400 cursor-pointer transition-colors" title="Data peminjaman"></div>
                            @endfor
                        </div>

                        <div class="grid grid-cols-12 gap-2 mt-1 text-xs font-medium text-gray-500 text-center">
                            <span>Januari</span>
                            <span>Februari</span>
                            <span>Maret</span>
                            <span>April</span>
                            <span>Mei</span>
                            <span>Juni</span>
                            <span>Juli</span>
                            <span>Agustus</span>
                            <span>September</span>
                            <span>Oktober</span>
                            <span>November</span>
                            <span>Desember</span>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
@endsection 