@extends('layouts.app')

@section('content')
<div class="mx-auto py-8 px-4">
	<div class="w-full flex flex-col gap-10">
		
		{{-- HEADER --}}
		<div class="flex flex-col gap-1">
			<h1 class="text-4xl font-bold">
				Edit data peminjaman
			</h1>
			
			<p class="text-gray-500">
				Lengkapi informasi peminjaman alat dan barang dengan benar.
			</p>
		</div>
		
		<form action="{{ route('admin-peminjaman-update', $peminjaman->kode_peminjaman) }}" method="POST" class="flex flex-col gap-10">
            @csrf
            @method('PUT')
			
            {{-- Detail Peminjam --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

                <div>
                    <h2 class="text-3xl font-bold">Data Peminjam</h2>
                    <p class="text-gray-500 text-sm">Pilih siapa yang meminjam barang.</p>
                </div>

                <div>
                    <label class="text-sm font-medium">Peminjam</label>

                    <select name="peminjam_id"
                        class="w-full border border-gray-500 rounded-xl px-4 py-3 mb-3 bg-white">
                        
                        @foreach($peminjam as $user)
                        <option value="{{ $user->id }}"
                            @selected($peminjaman->peminjam_id == $user->id)>
                            {{ $user->nama_lengkap }}
                        </option>
                        @endforeach

                    </select>
                </div>
            </div>
                
            <hr class="border-t border-gray-300">
            {{-- Detail tanggal dan status --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
                <div>
                    <h2 class="text-3xl font-bold">Informasi Peminjaman</h2>
                </div>

                <div class="flex flex-col gap-4">

                    <div x-data="{ status: '{{ old('status', $peminjaman->status) }}' }" class="flex flex-col gap-6">

                        {{-- ROW --}}
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                            {{-- TANGGAL PENGAJUAN --}}
                            <div class="flex flex-col gap-2">

                                <label class="text-sm font-medium">
                                    Tanggal Pengajuan
                                </label>

                                <input
                                    type="datetime-local"
                                    name="tanggal_pengajuan"
                                    value="{{ old(
                                        'tanggal_pengajuan',
                                        \Carbon\Carbon::parse($peminjaman->tanggal_pengajuan)->format('Y-m-d\TH:i')
                                    ) }}"
                                    class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white focus:outline-none"
                                >

                            </div>

                            {{-- STATUS --}}
                            <div class="flex flex-col gap-2">

                                <label class="text-sm font-medium">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    x-model="status"
                                    class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white focus:outline-none"
                                >
                                    <option
                                        value="menunggu"
                                        @selected(old('status', $peminjaman->status) == 'menunggu')
                                    >
                                        Menunggu
                                    </option>

                                    <option
                                        value="dipinjam"
                                        @selected(old('status', $peminjaman->status) == 'dipinjam')
                                    >
                                        Dipinjam
                                    </option>

                                    <option
                                        value="selesai"
                                        @selected(old('status', $peminjaman->status) == 'selesai')
                                    >
                                        Selesai
                                    </option>

                                    <option
                                        value="ditolak"
                                        @selected(old('status', $peminjaman->status) == 'ditolak')
                                    >
                                        Ditolak
                                    </option>
                                </select>

                            </div>

                        </div>

                        {{-- KHUSUS DIPINJAM --}}
                        <div
                            x-show="status !== 'menunggu'"
                            x-transition
                            class="grid grid-cols-1 lg:grid-cols-2 gap-4"
                        >

                            {{-- TANGGAL DISETUJUI --}}
                            <div class="flex flex-col gap-2">

                                <label class="text-sm font-medium">
                                    Tanggal Disetujui
                                </label>

                                <input
                                    type="datetime-local"
                                    name="tanggal_disetujui"
                                    value="{{ old(
                                        'tanggal_disetujui',
                                        $peminjaman->tanggal_disetujui
                                            ? \Carbon\Carbon::parse($peminjaman->tanggal_disetujui)->format('Y-m-d\TH:i')
                                            : ''
                                    ) }}"
                                    :disabled="status === 'menunggu'"
                                    class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white focus:outline-none"
                                >

                            </div>

                            {{-- PETUGAS --}}
                            <div class="flex flex-col gap-2">

                                <label class="text-sm font-medium">
                                    Petugas
                                </label>
                                
                                <select name="petugas_id" :disabled="status === 'menunggu'" class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white focus:outline-none">
    
                                    <option value="">Pilih petugas</option> {{-- Masukkan ke dalam tag select --}}
                                    
                                    @foreach($petugas as $tugas)
                                        <option value="{{ $tugas->id }}" @selected($peminjaman->petugas_id == $tugas->id)>
                                            {{ $tugas->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="border-t border-gray-300">
            {{-- Alat dan barang peminjaman --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
                <div>
                    <h2 class="text-3xl font-bold">Alat yang Dipinjam</h2>
                    <p class="text-gray-500 text-sm">
                        Pilih alat dan jumlahnya.
                    </p>
                </div>

                <div x-data="alatForm(
                    {{ Js::from(
                        old('items', $peminjaman->detailPeminjaman->map(fn ($detail) => [
                            'alat_id' => $detail->alat_id,
                            'jumlah' => $detail->jumlah,
                        ])->toArray())
                    ) }},
                    {{ Js::from($alat) }}
                )"
                class="flex flex-col gap-4">

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium">
                            Durasi Peminjaman
                        </label>

                        <select
                            x-model="durasiDipilih"
                            name="durasi"
                            class="w-full border border-gray-400 rounded-xl px-4 py-3 bg-white"
                        >

                            <option value="">-- Pilih durasi --</option>

                            @foreach($durasiList as $durasi)
                                <option
                                    value="{{ $durasi }}"
                                    @selected(old('durasi', $peminjaman->durasi) == $durasi)
                                >
                                    {{ $durasi }} menit
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <template x-for="(item, index) in items" :key="index">

                        <div class="flex items-center gap-3 border p-3 rounded-xl">

                            {{-- SELECT ALAT --}}
                            <select 
                                :name="'items['+index+'][alat_id]'"
                                :value="item.alat_id"
                                @change="item.alat_id = $event.target.value"
                                required
                                class="flex-1 border rounded-xl px-3 py-2"
                            >
                                <option value="">-- Pilih alat --</option>
                                <template x-for="alat in filteredAlat" :key="alat.id">
                                    <option
                                        :value="alat.id.toString()"
                                        :selected="item.alat_id === alat.id.toString()"
                                        x-text="`${alat.nama_alat} (stok: ${alat.stok})`"
                                    ></option>
                                </template>
                            </select>

                            {{-- JUMLAH --}}
                            <input 
                                type="number"
                                min="1"
                                required
                                :name="'items['+index+'][jumlah]'"
                                x-model="item.jumlah"
                                placeholder="Qty"
                                class="w-16 border rounded-xl px-3 py-2"
                            >

                            {{-- REMOVE BUTTON --}}
                            <button 
                                type="button"
                                @click="removeItem(index)"
                                class="text-red-500 font-bold px-2"
                                x-show="items.length > 1"
                            >
                                ✕
                            </button>

                        </div>

                    </template>

                    {{-- ADD BUTTON --}}
                    <button 
                        type="button"
                        @click="addItem()"
                        class="text-sm text-blue-600 self-start"
                    >
                        + Tambah alat
                    </button>

                </div>

            </div>
            
            <hr class="border-t border-gray-300">
            
            {{-- ACTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
                
                <div></div>
                
                <div class="flex items-center gap-4">
                    
                <a 
                    href="{{ route('admin-peminjaman') }}"
                    type="button"
                    class="w-full text-center border border-gray-300 rounded-full px-6 py-3 hover:bg-gray-100 transition-all"
                    >
                    Batal
                </a>
                
                <button 
                    type="submit"
                    class="w-full border border-transparent bg-[#363062] rounded-full px-6 py-3 text-white hover:bg-transparent hover:border-[#363062] hover:text-[#363062] transition-all"
                    >
                    Simpan
            </button>
        </form>
    </div>
</div>

<script>
function alatForm(initialItems, allAlat) {
    
    // 1. Format items dari database terlebih dahulu
    let itemsData = Object.values(initialItems || [{
        alat_id: '',
        jumlah: 1
    }]).map(item => ({
        ...item,
        alat_id: item.alat_id?.toString()
    }));

    // 2. Ambil durasi bawaan dari Laravel
    // Pakai ?? '' supaya kalau null dia jadi string kosong
    let initDurasi = '{{ old('durasi', $peminjaman->durasi ?? '') }}';

    // 3. JIKA DURASI KOSONG, tebak durasi dari alat pertama yang dipinjam!
    if (!initDurasi && itemsData.length > 0 && itemsData[0].alat_id) {
        let alatTerpilih = allAlat.find(a => a.id.toString() === itemsData[0].alat_id);
        if (alatTerpilih) {
            initDurasi = alatTerpilih.durasi.toString();
        }
    }

    return {
        durasiDipilih: initDurasi,
        previousDurasi: initDurasi,
        allAlat: allAlat,
        items: itemsData,

        init() {
            this.$watch('durasiDipilih', (value) => {
                // skip render pertama
                if (this.previousDurasi === value) {
                    return;
                }

                // reset alat kalau user ganti durasi (bukan saat inisialisasi)
                this.items.forEach(item => {
                    item.alat_id = '';
                });

                this.previousDurasi = value;
            });
        },

        get filteredAlat() {
            if (!this.durasiDipilih) {
                return [];
            }
            return this.allAlat.filter(
                alat => alat.durasi == this.durasiDipilih
            );
        },

        addItem() {
            this.items.push({
                alat_id: '',
                jumlah: 1
            });
        },

        removeItem(index) {
            this.items.splice(index, 1);
        }
    }
}
</script>
@endsection