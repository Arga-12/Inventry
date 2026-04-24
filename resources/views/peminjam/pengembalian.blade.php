@extends('layouts.app')

@section('content')
<div class="mx-auto">
    
    <div class="flex flex-col gap-1 mb-8">
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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 h-[600px]">
        
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

        <div class="w-full h-full bg-[#FAFAFA] rounded-[20px] border-2 border-gray-300 flex flex-col items-center justify-center p-4 text-center">
            
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