@props(['alat'])

<div class="w-full h-[400px]">
  <div class="relative w-full h-full bg-white rounded-[20px] p-4 overflow-hidden shadow-lg">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $alat->gambar ? asset('storage/' . $alat->gambar) : asset('images/default-alat.jpg') }}')">
      <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-black/20"></div>
    </div>
    
    <div class="absolute bottom-0 left-0 w-full z-20">
      <div class="backdrop-blur-md bg-white/20 p-4 text-white">
        <div class="flex items-center justify-between">
          <p class="text-lg font-semibold">{{ $alat->nama_alat }}</p>
          <div class="h-8 w-32 flex items-center justify-center gap-2 border border-white rounded-full p-2">
            <span class="w-2 h-2 rounded-full bg-white"></span>
            <span class="text-sm">{{ $alat->stok }} Tersisa</span>
          </div>
        </div>
        
        <div class="flex items-center justify-between mt-2">
          <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24">
              <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/>
                <path d="M12 7v5l3 3"/>
              </g>
            </svg>
            <p class="font-medium">{{ floor($alat->durasi / 60) }} Jam {{ $alat->durasi % 60 }} Menit</p>
          </div>
          
          <button data-alat-id="{{ $alat->id }}"
            onclick="addToCartGlobal({
                id: {{ $alat->id }},
                nama_alat: '{{ addslashes($alat->nama_alat) }}',
                durasi: {{ $alat->durasi }},
                stok: {{ $alat->stok }},
                gambar: '{{ $alat->gambar ? asset('storage/' . $alat->gambar) : asset('images/id1.jpg') }}'
            })"
            class="h-8 w-32 rounded-full bg-white text-[#363062] text-sm hover:bg-transparent hover:text-white border border-transparent hover:border-white transition-all duration-200 transform active:scale-95">
            Pinjam Sekarang
          </button>
        </div>
        @if($alat->kategori)
        <div class="mt-2">
          <span class="text-xs bg-white/30 px-2 py-1 rounded-full">{{ $alat->kategori->nama_kategori }}</span>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>