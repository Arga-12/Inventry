<div x-data="keranjangPeminjaman()" x-init="init()" id="keranjangContainer">

    {{-- ============================================================ --}}
    {{-- DESKTOP: sidebar tetap, muncul di >= lg --}}
    {{-- ============================================================ --}}
    <aside class="hidden lg:flex flex-col w-80 h-screen shrink-0 bg-[#F5F5F5] border-l border-gray-300 z-20">
        <div class="flex flex-col">
            {{-- Header sidebar --}}
            <div class="flex flex-col bg-[#ededed] items-stretch gap-2 p-4">
                <h1 class="font-bold text-black leading-none">Keranjang Peminjaman</h1>
                <h2 class="text-sm font-regular text-gray-500 leading-none">Daftar alat & barang yang akan Anda pinjam:</h2>
            </div>
        </div>

        {{-- List belanjaan --}}
        <div class="flex-1 overflow-y-auto flex flex-col gap-4 p-4 w-full">

            {{-- Info Durasi yang Dipilih --}}
            <div class="flex flex-col gap-2" x-show="selectedDurasi !== null && items.length > 0">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Durasi peminjaman dipilih:</span>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#363062]" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/>
                                <path d="M12 7v5l3 3"/>
                            </g>
                        </svg>
                        <span class="text-sm font-semibold text-[#363062]" x-text="formatDurasi(selectedDurasi)"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500 bg-[#363062]/5 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#363062] flex-shrink-0" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v5m0 5a9 9 0 1 1 0-18a9 9 0 0 1 0 18m.05-13v.1h-.1V8z" />
                    </svg>
                    <span>Anda hanya dapat meminjam alat dengan durasi yang sama</span>
                </div>
            </div>

            {{-- Empty state --}}
            <div class="flex flex-col items-center h-full justify-center text-center py-8" x-show="items.length === 0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <p class="text-gray-500 font-medium">Keranjang kosong</p>
                <p class="text-xs text-gray-400 mt-1">Belum ada alat yang dipilih</p>
            </div>

            <template x-for="item in items" :key="item.id">
                <div class="flex items-center justify-between w-full bg-white rounded-xl p-2 shadow-sm">
                    <div class="flex gap-2 h-full items-center flex-1">
                        <div class="w-10 h-10 overflow-hidden rounded-xl flex-shrink-0">
                            <img :src="item.gambar || '/images/id1.jpg'" class="w-full h-full object-cover" />
                        </div>
                        <div class="flex flex-col justify-between items-stretch">
                            <span class="text-sm text-[#363062] font-semibold" x-text="item.nama_alat"></span>
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4D4C7D]" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/>
                                        <path d="M12 7v5l3 3"/>
                                    </g>
                                </svg>
                                <span class="text-xs text-[#4D4C7D]" x-text="formatDurasi(item.durasi)"></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="updateQuantity(item.id, 'decrement')"
                                :disabled="item.quantity <= 1"
                                class="h-8 w-8 flex items-center justify-center p-1 rounded-full border transition-all duration-200"
                                :class="item.quantity <= 1 ? 'bg-gray-200 border-gray-300 cursor-not-allowed' : 'bg-[#4D4C7D] border-transparent hover:bg-transparent hover:border-[#363062] group'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="item.quantity <= 1 ? 'text-gray-400' : 'text-white group-hover:text-[#363062]'" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M18 12.998H6a1 1 0 0 1 0-2h12a1 1 0 0 1 0 2"/>
                            </svg>
                        </button>
                        <span class="text-[#363062] w-6 text-center font-medium" x-text="item.quantity"></span>
                        <button @click="updateQuantity(item.id, 'increment')"
                                :disabled="item.quantity >= item.stok"
                                class="h-8 w-8 flex items-center justify-center p-1 rounded-full border transition-all duration-200"
                                :class="item.quantity >= item.stok ? 'bg-gray-200 border-gray-300 cursor-not-allowed' : 'bg-[#4D4C7D] border-transparent hover:bg-transparent hover:border-[#363062] group'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="item.quantity >= item.stok ? 'text-gray-400' : 'text-white group-hover:text-[#363062]'" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2"/>
                            </svg>
                        </button>
                        <button @click="removeItem(item.id)"
                                class="h-8 w-8 flex items-center justify-center p-1 bg-red-500 rounded-full border border-transparent hover:bg-transparent hover:border-red-500 group transition-all duration-200 ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white group-hover:text-red-500" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6zM19 4h-3.5l-1-1h-5l-1 1H5v2h14z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        {{-- Footer struk peminjaman --}}
        <div class="p-4 border-t border-gray-300 bg-white" x-show="items.length > 0" x-cloak>
            <div class="flex flex-col items-start gap-2 w-full">
                <span class="font-bold text-black">Struk Peminjaman</span>
                <hr class="border-0 border-t border-gray-300 w-full" />
                <div class="flex justify-between items-center w-full">
                    <span class="text-sm text-black font-semibold">Total alat dipinjam</span>
                    <span class="text-sm text-black font-light" x-text="totalItems"></span>
                </div>
                <div class="flex justify-between items-center w-full">
                    <span class="text-sm text-black font-semibold">Durasi peminjaman</span>
                    <span class="text-sm text-black font-light" x-text="selectedDurasi ? formatDurasi(selectedDurasi) : '-'"></span>
                </div>
                <hr class="border-0 border-t border-gray-300 w-full" />
                <button @click="submitPeminjaman"
                        :disabled="!selectedDurasi"
                        class="h-10 w-full rounded-full border transition-all duration-200"
                        :class="selectedDurasi ? 'bg-[#363062] text-white border-transparent hover:bg-transparent hover:text-[#363062] hover:border-[#363062]' : 'bg-gray-300 text-gray-500 cursor-not-allowed'">
                    Ajukan peminjaman
                </button>
            </div>
        </div>
    </aside>


    {{-- ============================================================ --}}
    {{-- MOBILE: tombol floating + panel slide-in (hanya di < lg) --}}
    {{-- ============================================================ --}}

    {{-- Tombol floating keranjang — kanan bawah, tidak tumpang tindih dengan header/burger --}}
    <div class="lg:hidden fixed bottom-6 right-6 z-50">
        <button @click="mobileOpen = true"
                class="relative flex items-center justify-center h-14 w-14 rounded-full bg-[#363062] text-white shadow-lg hover:bg-[#4D4C7D] transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path fill="currentColor" d="M17 18a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2c0-1.11.89-2 2-2M1 2h3.27l.94 2H20a1 1 0 0 1 1 1c0 .17-.05.34-.12.5l-3.58 6.47c-.34.61-1 1.03-1.75 1.03H8.1l-.9 1.63l-.03.12a.25.25 0 0 0 .25.25H19v2H7a2 2 0 0 1-2-2c0-.35.09-.68.24-.96l1.36-2.45L3 4H1zm6 16a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2c0-1.11.89-2 2-2m9-7l2.78-5H6.14l2.36 5z"/>
            </svg>
            {{-- Badge jumlah item --}}
            <span x-show="totalItems > 0"
                  x-text="totalItems"
                  class="absolute -top-1 -right-1 h-5 w-5 flex items-center justify-center rounded-full bg-red-500 text-white text-xs font-bold leading-none"></span>
        </button>
    </div>

    {{-- Panel slide-in mobile --}}
    <div class="lg:hidden fixed inset-0 z-50 pointer-events-none">

        {{-- Overlay --}}
        <div x-show="mobileOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-black/50 pointer-events-auto"
             @click="mobileOpen = false"></div>

        {{-- Panel --}}
        <div x-show="mobileOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="absolute right-0 top-0 h-full w-80 max-w-[90vw] bg-[#F5F5F5] shadow-xl flex flex-col pointer-events-auto">

            {{-- Header panel mobile --}}
            <div class="flex items-center justify-between bg-[#ededed] p-4 shrink-0">
                <div class="flex flex-col gap-1">
                    <h1 class="font-bold text-black leading-none">Keranjang Peminjaman</h1>
                    <h2 class="text-sm text-gray-500 leading-none">Daftar alat & barang yang akan Anda pinjam:</h2>
                </div>
                <button @click="mobileOpen = false"
                        class="p-2 rounded-full hover:bg-gray-200 transition shrink-0 ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#363062]" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z"/>
                    </svg>
                </button>
            </div>

            {{-- List belanjaan mobile --}}
            <div class="flex-1 overflow-y-auto flex flex-col gap-4 p-4">

                {{-- Info Durasi --}}
                <div class="flex flex-col gap-2" x-show="selectedDurasi !== null && items.length > 0">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Durasi peminjaman dipilih:</span>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#363062]" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/>
                                    <path d="M12 7v5l3 3"/>
                                </g>
                            </svg>
                            <span class="text-sm font-semibold text-[#363062]" x-text="formatDurasi(selectedDurasi)"></span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500 bg-[#363062]/5 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#363062] flex-shrink-0" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v5m0 5a9 9 0 1 1 0-18a9 9 0 0 1 0 18m.05-13v.1h-.1V8z" />
                        </svg>
                        <span>Anda hanya dapat meminjam alat dengan durasi yang sama</span>
                    </div>
                </div>

                {{-- Empty state --}}
                <div class="flex flex-col items-center h-full justify-center text-center py-8" x-show="items.length === 0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <p class="text-gray-500 font-medium">Keranjang kosong</p>
                    <p class="text-xs text-gray-400 mt-1">Belum ada alat yang dipilih</p>
                </div>


                <template x-for="item in items" :key="item.id">
                    <div class="flex items-center justify-between w-full bg-white rounded-xl p-2 shadow-sm">
                        <div class="flex gap-2 h-full items-center flex-1">
                            <div class="w-10 h-10 overflow-hidden rounded-xl flex-shrink-0">
                                <img :src="item.gambar || '/images/id1.jpg'" class="w-full h-full object-cover" />
                            </div>
                            <div class="flex flex-col justify-between items-stretch">
                                <span class="text-sm text-[#363062] font-semibold" x-text="item.nama_alat"></span>
                                <div class="flex gap-1 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4D4C7D]" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/>
                                            <path d="M12 7v5l3 3"/>
                                        </g>
                                    </svg>
                                    <span class="text-xs text-[#4D4C7D]" x-text="formatDurasi(item.durasi)"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button @click="updateQuantity(item.id, 'decrement')"
                                    :disabled="item.quantity <= 1"
                                    class="h-8 w-8 flex items-center justify-center p-1 rounded-full border transition-all duration-200"
                                    :class="item.quantity <= 1 ? 'bg-gray-200 border-gray-300 cursor-not-allowed' : 'bg-[#4D4C7D] border-transparent hover:bg-transparent hover:border-[#363062] group'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="item.quantity <= 1 ? 'text-gray-400' : 'text-white group-hover:text-[#363062]'" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M18 12.998H6a1 1 0 0 1 0-2h12a1 1 0 0 1 0 2"/>
                                </svg>
                            </button>
                            <span class="text-[#363062] w-6 text-center font-medium" x-text="item.quantity"></span>
                            <button @click="updateQuantity(item.id, 'increment')"
                                    :disabled="item.quantity >= item.stok"
                                    class="h-8 w-8 flex items-center justify-center p-1 rounded-full border transition-all duration-200"
                                    :class="item.quantity >= item.stok ? 'bg-gray-200 border-gray-300 cursor-not-allowed' : 'bg-[#4D4C7D] border-transparent hover:bg-transparent hover:border-[#363062] group'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="item.quantity >= item.stok ? 'text-gray-400' : 'text-white group-hover:text-[#363062]'" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2"/>
                                </svg>
                            </button>
                            <button @click="removeItem(item.id)"
                                    class="h-8 w-8 flex items-center justify-center p-1 bg-red-500 rounded-full border border-transparent hover:bg-transparent hover:border-red-500 group transition-all duration-200 ml-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white group-hover:text-red-500" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6zM19 4h-3.5l-1-1h-5l-1 1H5v2h14z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Footer struk peminjaman mobile --}}
            <div class="p-4 border-t border-gray-300 bg-white shrink-0" x-show="items.length > 0" x-cloak>
                <div class="flex flex-col items-start gap-2 w-full">
                    <span class="font-bold text-black">Struk Peminjaman</span>
                    <hr class="border-0 border-t border-gray-300 w-full" />
                    <div class="flex justify-between items-center w-full">
                        <span class="text-sm text-black font-semibold">Total alat dipinjam</span>
                        <span class="text-sm text-black font-light" x-text="totalItems"></span>
                    </div>
                    <div class="flex justify-between items-center w-full">
                        <span class="text-sm text-black font-semibold">Durasi peminjaman</span>
                        <span class="text-sm text-black font-light" x-text="selectedDurasi ? formatDurasi(selectedDurasi) : '-'"></span>
                    </div>
                    <hr class="border-0 border-t border-gray-300 w-full" />
                    <button @click="submitPeminjaman"
                            :disabled="!selectedDurasi"
                            class="h-10 w-full rounded-full border transition-all duration-200"
                            :class="selectedDurasi ? 'bg-[#363062] text-white border-transparent hover:bg-transparent hover:text-[#363062] hover:border-[#363062]' : 'bg-gray-300 text-gray-500 cursor-not-allowed'">
                        Ajukan peminjaman
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>


@push('scripts')
<script>
    function keranjangPeminjaman() {
        return {
            items: [],
            totalItems: 0,
            groupedByDurasi: [],
            selectedDurasi: null,
            mobileOpen: false,

            init() {
                const savedCart = localStorage.getItem('peminjaman_cart');
                let hasItems = false;

                if (savedCart) {
                    const cart = JSON.parse(savedCart);
                    this.items = cart.items || [];
                    this.totalItems = cart.total_items || 0;
                    this.groupedByDurasi = cart.grouped_by_durasi || [];
                    hasItems = this.items.length > 0;

                    if (this.items.length === 0) {
                        localStorage.removeItem('peminjaman_cart');
                    }
                }

                const urlParams = new URLSearchParams(window.location.search);
                const durasiCartParam = urlParams.get('durasi_cart');
                const hasDurasiCart = urlParams.has('durasi_cart');

                if (hasDurasiCart && !hasItems) {
                    window.location.href = window.location.pathname;
                    return;
                }

                if (hasDurasiCart && hasItems && durasiCartParam) {
                    this.selectedDurasi = parseInt(durasiCartParam);
                } else if (!hasDurasiCart && hasItems && this.items.length > 0) {
                    this.selectedDurasi = this.items[0].durasi;
                    const newUrl = `${window.location.pathname}?durasi_cart=${this.selectedDurasi}`;
                    window.history.replaceState({}, '', newUrl);
                } else {
                    this.selectedDurasi = null;
                }

                window.keranjangInstance = this;
            },

            saveToLocalStorage() {
                if (this.items.length === 0) {
                    localStorage.removeItem('peminjaman_cart');
                    return;
                }

                localStorage.setItem('peminjaman_cart', JSON.stringify({
                    items: this.items,
                    total_items: this.totalItems,
                    grouped_by_durasi: this.groupedByDurasi
                }));
            },

            formatDurasi(minutes) {
                if (!minutes) return '-';
                const hours = Math.floor(minutes / 60);
                const mins = minutes % 60;
                if (hours === 0) return mins + ' Menit';
                if (mins === 0) return hours + ' Jam';
                return hours + ' Jam ' + mins + ' Menit';
            },

            recalculateSummary() {
                this.totalItems = this.items.reduce((sum, item) => sum + item.quantity, 0);

                const groups = {};
                this.items.forEach(item => {
                    const durasi = item.durasi;
                    if (!groups[durasi]) {
                        groups[durasi] = {
                            durasi: durasi,
                            durasi_text: this.formatDurasi(durasi),
                            total_quantity: 0,
                            items: []
                        };
                    }
                    groups[durasi].total_quantity += item.quantity;
                    groups[durasi].items.push(item);
                });
                this.groupedByDurasi = Object.values(groups);
                this.saveToLocalStorage();
            },

            addToCart(alat) {
                if (this.selectedDurasi && alat.durasi !== this.selectedDurasi) {
                    alert(`Maaf, Anda hanya bisa meminjam alat dengan durasi ${this.formatDurasi(this.selectedDurasi)}.\nAlat "${alat.nama_alat}" memiliki durasi ${this.formatDurasi(alat.durasi)}.`);
                    return;
                }

                if (!this.selectedDurasi) {
                    this.selectedDurasi = alat.durasi;
                    this.items.push({
                        id: alat.id,
                        nama_alat: alat.nama_alat,
                        durasi: alat.durasi,
                        gambar: alat.gambar,
                        stok: alat.stok,
                        quantity: 1
                    });

                    this.recalculateSummary();
                    this.saveToLocalStorage();
                    window.location.href = `{{ route('peminjam-alat') }}?durasi_cart=${alat.durasi}`;
                    return;
                }

                const existingItem = this.items.find(item => item.id === alat.id);

                if (existingItem) {
                    if (existingItem.quantity + 1 > alat.stok) {
                        alert(`Stok ${alat.nama_alat} tidak mencukupi (tersisa ${alat.stok})`);
                        return;
                    }
                    existingItem.quantity++;
                } else {
                    if (1 > alat.stok) {
                        alert(`Stok ${alat.nama_alat} tidak mencukupi`);
                        return;
                    }
                    this.items.push({
                        id: alat.id,
                        nama_alat: alat.nama_alat,
                        durasi: alat.durasi,
                        gambar: alat.gambar,
                        stok: alat.stok,
                        quantity: 1
                    });
                }

                this.recalculateSummary();
            },

            updateQuantity(alatId, action) {
                const item = this.items.find(i => i.id === alatId);
                if (!item) return;

                if (action === 'increment') {
                    if (item.quantity + 1 > item.stok) {
                        alert(`Stok ${item.nama_alat} tidak mencukupi (tersisa ${item.stok})`);
                        return;
                    }
                    item.quantity++;
                } else if (action === 'decrement') {
                    if (item.quantity > 1) {
                        item.quantity--;
                    } else {
                        this.removeItem(alatId);
                        return;
                    }
                }

                this.recalculateSummary();
            },

            removeItem(alatId) {
                const index = this.items.findIndex(i => i.id === alatId);
                if (index !== -1) {
                    this.items.splice(index, 1);
                    this.recalculateSummary();

                    if (this.items.length === 0) {
                        this.selectedDurasi = null;
                        this.mobileOpen = false;
                        localStorage.removeItem('peminjaman_cart');
                        window.location.href = window.location.pathname;
                    }
                }
            },

            submitPeminjaman() {
                if (this.items.length === 0) {
                    alert('Keranjang masih kosong');
                    return;
                }

                if (!this.selectedDurasi) {
                    alert('Silakan pilih durasi peminjaman terlebih dahulu');
                    return;
                }

                const totalBarang = this.totalItems;
                const durasi = this.formatDurasi(this.selectedDurasi);
                const confirmMsg = `Anda akan meminjam ${totalBarang} alat dengan durasi ${durasi}. Lanjutkan?`;

                if (confirm(confirmMsg)) {
                    fetch('{{ route("peminjam-alat-store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            cart: {
                                items: this.items,
                                total_items: this.totalItems,
                                grouped_by_durasi: this.groupedByDurasi
                            },
                            selected_durasi: this.selectedDurasi
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(`HTTP ${response.status}: ${text.substring(0, 200)}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert(data.message + '\nKode: ' + data.data.kode_peminjaman);
                            this.items = [];
                            this.totalItems = 0;
                            this.groupedByDurasi = [];
                            this.selectedDurasi = null;
                            this.mobileOpen = false;
                            this.saveToLocalStorage();
                            window.location.href = '{{ route("peminjam-alat") }}';
                        } else {
                            alert('Gagal: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan: ' + error.message);
                    });
                }
            }
        }
    }

    window.addToCartGlobal = function(alatData) {
        if (window.keranjangInstance) {
            window.keranjangInstance.addToCart(alatData);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggleFilterBtn');
        const filterPanel = document.getElementById('filterPanel');

        if (toggleBtn && filterPanel) {
            toggleBtn.addEventListener('click', function() {
                filterPanel.classList.toggle('hidden');
            });

            @if(request('kategori') || request('search'))
                filterPanel.classList.remove('hidden');
            @else
                filterPanel.classList.add('hidden');
            @endif
        }
    });
</script>
@endpush
