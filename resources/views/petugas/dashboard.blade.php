@extends('layouts.app')

@section('content')
<div class="mx-auto py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-stretch">

        <div class="flex flex-col gap-8">
            
            <div class="flex flex-col gap-2">
                <h1 class="text-4xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-500">
                    Selamat datang di Inventry, mari pantau dan kelola persetujuan peminjaman alat hari ini.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 h-full">
                
                <div class="border-2 border-gray-800 rounded-[20px] p-6 flex flex-col bg-white">
                    <h3 class="font-bold text-gray-800 text-lg mb-2">Peminjaman di setujui</h3>
                    <span class="text-5xl font-bold text-gray-900 mb-4">21</span>
                    <p class="text-sm text-gray-500 mt-auto">Total peminjaman yang telah Anda setujui</p>
                </div>

                <div class="border-2 border-gray-800 rounded-[20px] p-6 flex flex-col bg-white">
                    <h3 class="font-bold text-gray-800 text-lg mb-2">Pengembalian di atasi</h3>
                    <span class="text-5xl font-bold text-gray-900 mb-4">13</span>
                    <p class="text-sm text-gray-500 mt-auto">Total pengembalian yang telah Anda atasi</p>
                </div>

            </div>

        </div>

        <div class="border-2 border-gray-800 rounded-[24px] p-8 flex flex-col bg-white h-full">
            
            <div class="flex flex-col flex-1 gap-4">
                <h2 class="text-2xl font-bold text-gray-800">Peminjam Menunggu Persetujuan</h2>
                <span class="text-5xl font-bold text-gray-900">12</span>
                <p class="text-base font-medium text-gray-500">Peminjam menunggu pengajuan peminjamannya dari Anda</p>
            </div>

            <div class="flex flex-col gap-4 mt-4">
                <div class="border-t-2 border-gray-800 rounded-full w-full"></div>
                
                <button class="w-full py-2 border-2 border-gray-800 rounded-full font-bold text-gray-800 bg-white hover:bg-gray-100 transition-colors">
                    Menuju Laman Persetujuan Peminjaman
                </button>
            </div>

        </div>

    </div>
</div>
@endsection