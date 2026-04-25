@extends('layouts.app')

@section('content')
<div class="mx-auto py-12">

    <div class="flex flex-col mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Manajemen Peminjaman</h1>
        <p class="text-gray-500">Lihat detail mengenai peminjaman dan lakukan <span class="font-bold">Pengembalian</span> disini</p>
    </div>

    <div class="flex items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-2 flex-1 border border-gray-400 rounded-full px-3 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 flex-shrink-0" viewBox="0 0 24 24"><path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6"/></svg>
            <input type="text" placeholder="Cari..." class="w-full bg-transparent outline-none">
        </div>

        <button class="flex items-center gap-2 border border-gray-400 rounded-full px-4 py-2 flex-shrink-0 hover:bg-gray-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#363062] flex-shrink-0" viewBox="0 0 24 24"><path fill="currentColor" d="M6.532 4.75h6.936c.457 0 .854 0 1.165.03c.307.028.685.095.993.348c.397.326.621.814.624 1.322c.002.39-.172.726-.34.992c-.168.27-.411.59-.695.964l-.031.04l-.01.013l-2.555 3.369c-.252.332-.315.42-.359.51a1.2 1.2 0 0 0-.099.297c-.02.1-.023.212-.023.634v4.243c0 .208 0 .412-.014.578c-.015.164-.052.427-.224.663c-.21.287-.537.473-.9.495c-.302.019-.547-.103-.69-.183c-.144-.08-.309-.195-.476-.31l-.989-.683l-.048-.033c-.191-.131-.403-.276-.562-.477a1.7 1.7 0 0 1-.303-.585c-.071-.244-.07-.5-.07-.738v-2.97c0-.422-.004-.534-.023-.634a1.2 1.2 0 0 0-.1-.297c-.043-.09-.106-.178-.358-.51L4.825 8.459l-.01-.012l-.03-.04c-.284-.375-.527-.695-.696-.965c-.167-.266-.34-.602-.339-.992a1.72 1.72 0 0 1 .624-1.322c.308-.253.686-.32.993-.349c.311-.029.707-.029 1.165-.029m.397 4l1.647 2.17l.035.047c.201.264.361.475.478.715q.154.317.222.665c.051.261.05.527.05.864v2.968c0 .158.001.247.005.314l.006.062a.2.2 0 0 0 .036.073l.041.034c.05.04.12.088.248.176l.941.65V13.21c0-.337 0-.603.051-.864q.068-.347.222-.665c.117-.24.277-.45.478-.715l.035-.046l1.646-2.17zm7.28-1.5c.195-.26.334-.45.43-.604c.08-.126.104-.188.11-.207a.22.22 0 0 0-.057-.134a1 1 0 0 0-.2-.032c-.232-.022-.556-.023-1.06-.023H6.568c-.504 0-.828 0-1.06.023a1 1 0 0 0-.2.032a.22.22 0 0 0-.057.134c.006.019.03.081.11.207c.096.155.235.344.43.604zm1.541 3.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-1.5 2.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75m-.5 2.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m0 2.5a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75"/></svg>
            <span>Filter</span>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 h-[650px]">

        <div class="flex flex-col gap-6 h-full overflow-y-auto pr-4 pb-4 ">

            <div class="flex-shrink-0">
                <x-card-pengembalian />
            </div>
            
            <div class="flex-shrink-0">
                <x-card-pengembalian />
            </div>
            <div class="flex-shrink-0">
                <x-card-pengembalian />
            </div>

        </div>

        <div class="w-full h-full bg-[#FAFAFA] rounded-[20px] border-2 border-gray-300 flex flex-col p-6 overflow-hidden">
            
            <div class="flex-shrink-0">
                <p class="text-sm font-medium text-gray-500 mb-1">Detail Struk</p>

                <div class="flex justify-between items-start">
                    <h2 class="text-3xl font-bold text-[#363062]">#INVT-2604-003</h2>

                    <div class="text-right">
                        <p class="text-sm text-gray-500">Diterima oleh</p>
                        <p class="font-bold text-gray-800">Budi - Petugas</p>
                    </div>
                </div>
            </div>

            <hr class="border-t-2 border-gray-300 my-4 flex-shrink-0" />

            <p class="font-medium text-gray-800 mb-4 flex-shrink-0">Daftar alat dan barang peminjaman Anda:</p>

            <div class="flex-1 flex flex-col gap-6 overflow-y-auto pr-3 pb-2 custom-scrollbar">

                <div class="flex flex-col gap-3">
                    <div class="flex justify-between items-start gap-2">
                        <div class="flex gap-4">
                            <div class="w-14 h-14 border border-gray-400 rounded-xl flex-shrink-0 overflow-hidden">
                            </div>
                            <div>
                                <div class="font-bold text-lg text-gray-800 flex items-center gap-2">
                                    Nama Barang <span class="text-sm font-medium text-[#4D4C7D] bg-gray-200 px-2 rounded">x3</span>
                                </div>
                                <div class="text-sm text-gray-600 mt-1">1 jam 30 menit</div>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <div class="text-xs text-gray-500 mb-1">Waktu tersisa</div>
                            <div class="font-mono font-bold text-xl text-[#363062]">00:56:45</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mt-1">
                        <button class="flex items-center justify-center gap-2 px-4 py-2 border border-transparent rounded-full text-sm font-medium bg-[#F99417] text-white w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M2.725 21q-.275 0-.5-.137t-.35-.363t-.137-.488t.137-.512l9.25-16q.15-.25.388-.375T12 3t.488.125t.387.375l9.25 16q.15.25.138.513t-.138.487t-.35.363t-.5.137zm1.725-2h15.1L12 6zm8.263-1.287Q13 17.425 13 17t-.288-.712T12 16t-.712.288T11 17t.288.713T12 18t.713-.288m0-3Q13 14.425 13 14v-3q0-.425-.288-.712T12 10t-.712.288T11 11v3q0 .425.288.713T12 15t.713-.288M12 12.5"/>
                            </svg>
                            <span>Kembalikan sekarang</span>
                        </button>
                        <button class="py-2 border border-gray-400 rounded-full text-sm font-medium text-white bg-gray-400 hover:bg-gray-50 hover:text-[#363062] hover:border-[#363062] transition-colors">Kembalikan</button>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <div class="flex justify-between items-start gap-2">
                        <div class="flex gap-4">
                            <div class="w-14 h-14 border border-gray-400 rounded-xl flex-shrink-0 overflow-hidden"></div>
                            <div>
                                <div class="font-bold text-lg text-gray-800 flex items-center gap-2">
                                    Kamera Sony <span class="text-sm font-medium text-[#4D4C7D] bg-gray-200 px-2 rounded">x2</span>
                                </div>
                                <div class="text-sm text-gray-600 mt-1">1 jam 30 menit</div>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <div class="text-xs text-gray-500 mb-1">Waktu tersisa</div>
                            <div class="font-mono font-bold text-xl text-[#363062]">00:56:45</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mt-1">
                        <button class="flex items-center justify-center gap-2 px-4 py-2 border border-transparent rounded-full text-sm font-medium bg-[#F99417] text-white w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M2.725 21q-.275 0-.5-.137t-.35-.363t-.137-.488t.137-.512l9.25-16q.15-.25.388-.375T12 3t.488.125t.387.375l9.25 16q.15.25.138.513t-.138.487t-.35.363t-.5.137zm1.725-2h15.1L12 6zm8.263-1.287Q13 17.425 13 17t-.288-.712T12 16t-.712.288T11 17t.288.713T12 18t.713-.288m0-3Q13 14.425 13 14v-3q0-.425-.288-.712T12 10t-.712.288T11 11v3q0 .425.288.713T12 15t.713-.288M12 12.5"/>
                            </svg>
                            <span>Kembalikan sekarang</span>
                        </button>
                        <button class="py-2 border border-gray-400 rounded-full text-sm font-medium text-white bg-gray-400 hover:bg-gray-50 hover:text-[#363062] hover:border-[#363062] transition-colors">Kembalikan</button>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <div class="flex justify-between items-start gap-2">
                        <div class="flex gap-4">
                            <div class="w-14 h-14 border border-gray-400 rounded-xl flex-shrink-0 overflow-hidden"></div>
                            <div>
                                <div class="font-bold text-lg text-gray-800 flex items-center gap-2">
                                    Tripod <span class="text-sm font-medium text-[#4D4C7D] bg-gray-200 px-2 rounded">x1</span>
                                </div>
                                <div class="text-sm text-gray-600 mt-1">1 jam 30 menit</div>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <div class="text-xs text-gray-500 mb-1">Waktu tersisa</div>
                            <div class="font-mono font-bold text-xl text-[#363062]">00:56:45</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mt-1">
                        <button class="flex items-center justify-center gap-2 px-4 py-2 border border-transparent rounded-full text-sm font-medium bg-[#F99417] text-white w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M2.725 21q-.275 0-.5-.137t-.35-.363t-.137-.488t.137-.512l9.25-16q.15-.25.388-.375T12 3t.488.125t.387.375l9.25 16q.15.25.138.513t-.138.487t-.35.363t-.5.137zm1.725-2h15.1L12 6zm8.263-1.287Q13 17.425 13 17t-.288-.712T12 16t-.712.288T11 17t.288.713T12 18t.713-.288m0-3Q13 14.425 13 14v-3q0-.425-.288-.712T12 10t-.712.288T11 11v3q0 .425.288.713T12 15t.713-.288M12 12.5"/>
                            </svg>
                            <span>Kembalikan sekarang</span>
                        </button>
                        <button class="py-2 border border-gray-400 rounded-full text-sm font-medium text-white bg-gray-400 hover:bg-gray-50 hover:text-[#363062] hover:border-[#363062] transition-colors">Kembalikan</button>
                    </div>
                </div>

            </div>

            <div class="flex-shrink-0 pt-4 mt-2">
                <hr class="border-t-2 border-gray-300 mb-4" />

                <h4 class="font-bold text-gray-800 mb-3">Durasi peminjaman (Hari)</h4>

                <div class="flex flex-col gap-2 mb-6">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Nama Barang <span class="text-xs font-medium ml-1">x1</span></span>
                        <span class="font-medium text-gray-800">Sehari</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Kamera Sony <span class="text-xs font-medium ml-1">x1</span></span>
                        <span class="font-medium text-gray-800">Sehari</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Tripod <span class="text-xs font-medium ml-1">x1</span></span>
                        <span class="font-medium text-gray-800">Sehari</span>
                    </div>
                </div>

                <div class="bg-gray-100 rounded-xl p-3">
                    <p class="text-xs text-center text-gray-500 leading-relaxed">
                        <span class="font-semibold text-gray-700">Catatan Pengembalian:</span> Harap kembalikan barang sesuai dengan tenggat waktu yang tertera. Keterlambatan, kehilangan, atau kerusakan sebagian/seluruh alat akan dikenakan sanksi sesuai dengan peraturan sistem yang berlaku.
                    </p>
                </div>
            </div>


            
            {{-- <div class="w-24 h-24 mb-4 text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada struk yang dipilih</h3>
            <p class="text-gray-500 max-w-sm">
                Klik tombol <span class="font-bold">"Detail struk"</span> pada daftar peminjaman di sebelah kiri untuk melihat rincian pengembalian di sini.
            </p> --}}

        </div>

    </div>
</div>
@endsection