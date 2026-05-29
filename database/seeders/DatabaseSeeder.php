<?php

namespace Database\Seeders;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Log;
use App\Models\Peminjaman;
use App\Models\Pengguna;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    private array $peminjamanCounter = [];

    private array $pengembalianCounter = [];

    public function run(): void
    {
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $this->seedUsers();
        $adminId = Pengguna::where('username', 'budiadmin')->first()->id;
        $petugasIds = Pengguna::where('role', 'petugas')->pluck('id')->toArray();
        $peminjamIds = Pengguna::where('role', 'peminjam')->pluck('id')->toArray();

        $this->seedCategories();
        $kategoriIds = Kategori::pluck('id', 'nama_kategori')->toArray();

        $alatData = $this->seedAlat($kategoriIds);
        $alatIds = $alatData['ids'];
        $alatDurasi = $alatData['durasis'];

        $this->seedPeminjamanAndReturns(
            $peminjamIds,
            $petugasIds,
            $alatIds,
            $alatDurasi,
            $adminId
        );

        $this->seedActivityLogs($adminId, $petugasIds, $peminjamIds);

        $this->updateLastActivity($peminjamIds, $petugasIds, $adminId);
    }

    private function seedUsers(): void
    {
        $users = [
            ['budiadmin', 'Budi Admin', 'admin', 'budiadmin123@gmail.com'],
            ['budipetugas', 'Budi Petugas', 'petugas', 'budipetugas123@gmail.com'],
            ['sitipetugas', 'Siti Rahma', 'petugas', 'sitipetugas@gmail.com'],
            ['budiTarmiji', 'Budi Tarmiji', 'peminjam', 'buditarmiji123@gmail.com'],
            ['aniputri', 'Ani Putri', 'peminjam', 'aniputri@gmail.com'],
            ['riskiamalia', 'Riskia Amalia', 'peminjam', 'riskiamalia@gmail.com'],
            ['dianpratama', 'Dian Pratama', 'peminjam', 'dianpratama@gmail.com'],
            ['widyautami', 'Widya Utami', 'peminjam', 'widyautami@gmail.com'],
            ['agungpras', 'Agung Prasetyo', 'peminjam', 'agungprasetyo@gmail.com'],
            ['dewiastuti', 'Dewi Astuti', 'peminjam', 'dewiastuti@gmail.com'],
            ['irfanhakim', 'Irfan Hakim', 'peminjam', 'irfanhakim@gmail.com'],
            ['srimulyani', 'Sri Mulyani', 'peminjam', 'srimulyani@gmail.com'],
            ['hermansyah', 'Hermansyah', 'peminjam', 'hermansyah@gmail.com'],
            ['fitrianingsih', 'Fitrianingsih', 'peminjam', 'fitrianingsih@gmail.com'],
            ['bayusaputra', 'Bayu Saputra', 'peminjam', 'bayusaputra@gmail.com'],
        ];

        foreach ($users as [$username, $nama, $role, $email]) {
            Pengguna::firstOrCreate(
                ['username' => $username],
                [
                    'nama_lengkap' => $nama,
                    'role' => $role,
                    'email' => $email,
                    'password' => '12345678',
                ]
            );
        }
    }

    private function seedCategories(): void
    {
        $categories = [
            ['KTG-001', 'Elektronik', '#363062'],
            ['KTG-002', 'Perkakas', '#F99417'],
            ['KTG-003', 'Kebersihan', '#4D4C7D'],
            ['KTG-004', 'Alat Tulis', '#2A2952'],
        ];

        foreach ($categories as [$kode, $nama, $warna]) {
            Kategori::firstOrCreate(
                ['kode_kategori' => $kode],
                ['nama_kategori' => $nama, 'warna' => $warna]
            );
        }
    }

    private function seedAlat(array $kategoriIds): array
    {
        $kategoriMap = [
            'Elektronik' => $kategoriIds['Elektronik'],
            'Perkakas' => $kategoriIds['Perkakas'],
            'Kebersihan' => $kategoriIds['Kebersihan'],
            'Alat Tulis' => $kategoriIds['Alat Tulis'],
        ];

        $alatList = [
            ['E001', 'Elektronik', 'Proyektor Epson', 15, 120],
            ['E002', 'Elektronik', 'Laptop Dell', 12, 180],
            ['E003', 'Elektronik', 'Kamera DSLR', 8, 90],
            ['E004', 'Elektronik', 'Speaker Aktif', 20, 60],
            ['P001', 'Perkakas', 'Bor Listrik', 10, 120],
            ['P002', 'Perkakas', 'Gerinda Tangan', 6, 90],
            ['P003', 'Perkakas', 'Mesin Las', 4, 180],
            ['P004', 'Perkakas', 'Gergaji Mesin', 8, 60],
            ['K001', 'Kebersihan', 'Vacuum Cleaner', 7, 60],
            ['K002', 'Kebersihan', 'Mesin Cuci', 5, 120],
            ['K003', 'Kebersihan', 'Blower', 9, 30],
            ['A001', 'Alat Tulis', 'Printer', 6, 90],
            ['A002', 'Alat Tulis', 'Scanner', 4, 60],
            ['A003', 'Alat Tulis', 'Whiteboard', 8, 120],
        ];

        $ids = [];
        $durasis = [];

        foreach ($alatList as [$kode, $kategoriNama, $nama, $stok, $durasi]) {
            $alat = Alat::firstOrCreate(
                ['kode_alat' => $kode],
                [
                    'kategori_id' => $kategoriMap[$kategoriNama],
                    'nama_alat' => $nama,
                    'stok' => $stok,
                    'durasi' => $durasi,
                ]
            );
            $ids[$kode] = $alat->id;
            $durasis[$alat->id] = $durasi;
        }

        return ['ids' => $ids, 'durasis' => $durasis];
    }

    private function seedPeminjamanAndReturns(
        array $peminjamIds,
        array $petugasIds,
        array $alatIds,
        array $alatDurasi,
        int $adminId
    ): void {
        $now = Carbon::now();
        $peminjamanRecords = [];
        $detailRecords = [];
        $pengembalianRecords = [];
        $detailPengembalianRecords = [];
        $updateStok = []; // Track alat stok changes for active peminjaman

        $statusDistribution = [
            'selesai' => 0,
            'dipinjam' => 0,
            'menunggu' => 0,
            'ditolak' => 0,
            'jatuh_tempo' => 0,
            'terlambat' => 0,
        ];

        // Generate peminjaman for Jan-Apr (mostly completed)
        for ($month = 1; $month <= 4; $month++) {
            $count = $month === 2 ? 7 : 8;
            for ($i = 0; $i < $count; $i++) {
                $day = rand(3, 27);
                $hour = rand(8, 16);
                $minute = rand(0, 59);
                $pengajuan = Carbon::create(2026, $month, $day, $hour, $minute);

                $isDitolak = rand(1, 8) === 1;
                $status = $isDitolak ? 'ditolak' : 'selesai';

                $peminjamId = $peminjamIds[array_rand($peminjamIds)];
                $petugasId = $petugasIds[array_rand($petugasIds)];
                $selectedDurasi = $this->pickDuration();
                $deadline = (clone $pengajuan)->addMinutes($selectedDurasi);
                $tanggalSetujui = $isDitolak ? null : (clone $pengajuan)->addMinutes(rand(5, 120));

                $kode = $this->generateKodePeminjaman($pengajuan);

                $peminjamanId = DB::table('peminjaman')->insertGetId([
                    'kode_peminjaman' => $kode,
                    'peminjam_id' => $peminjamId,
                    'petugas_id' => $isDitolak ? null : $petugasId,
                    'status' => $status,
                    'durasi' => $selectedDurasi,
                    'deadline' => $status === 'selesai' ? $deadline : null,
                    'tanggal_pengajuan' => $pengajuan,
                    'tanggal_disetujui' => $tanggalSetujui,
                    'created_at' => $pengajuan,
                    'updated_at' => $pengajuan,
                ]);

                $validAlatIds = array_keys(array_filter($alatDurasi, fn($d) => $d == $selectedDurasi));
                shuffle($validAlatIds);
                $numItems = min(rand(1, 3), count($validAlatIds));

                for ($j = 0; $j < $numItems; $j++) {
                    $alatId = $validAlatIds[$j];
                    $jumlah = rand(1, 2);

                    $detailId = DB::table('detail_peminjaman')->insertGetId([
                        'peminjaman_id' => $peminjamanId,
                        'alat_id' => $alatId,
                        'jumlah' => $jumlah,
                        'created_at' => $pengajuan,
                        'updated_at' => $pengajuan,
                    ]);

                    if ($status === 'selesai') {
                        $detailRecords[] = [
                            'id' => $detailId,
                            'peminjaman_id' => $peminjamanId,
                            'alat_id' => $alatId,
                            'jumlah' => $jumlah,
                        ];
                    }
                }

                // Create returns for completed ones
                if ($status === 'selesai') {
                    $selesaiDate = (clone $deadline)->addMinutes(rand(-30, 60));
                    $kodePg = $this->generateKodePengembalian($selesaiDate);

                    $pengembalianId = DB::table('pengembalian')->insertGetId([
                        'kode_pengembalian' => $kodePg,
                        'peminjaman_id' => $peminjamanId,
                        'petugas_id' => $petugasId,
                        'status' => 'selesai',
                        'tanggal_pengembalian' => $selesaiDate,
                        'tanggal_verifikasi' => (clone $selesaiDate)->addMinutes(rand(10, 180)),
                        'created_at' => $selesaiDate,
                        'updated_at' => $selesaiDate,
                    ]);

                    $hasRusak = rand(1, 6) === 1;

                    foreach ($detailRecords as $det) {
                        if ($det['peminjaman_id'] !== $peminjamanId) {
                            continue;
                        }

                        $kondisi = $hasRusak && rand(1, 3) === 1 ? 'rusak' : 'lolos';
                        $catatan = $kondisi === 'rusak'
                            ? fake()->randomElement([
                                'Kabel putus',
                                'Body penyok',
                                'Tidak bisa menyala',
                                'Tombol rusak',
                                'Gagang longgar',
                                'LCD retak',
                            ])
                            : null;

                        DB::table('detail_pengembalian')->insert([
                            'pengembalian_id' => $pengembalianId,
                            'detail_peminjaman_id' => $det['id'],
                            'jumlah_kembali' => $det['jumlah'],
                            'kondisi' => $kondisi,
                            'catatan_kondisi' => $catatan,
                            'created_at' => $selesaiDate,
                            'updated_at' => $selesaiDate,
                        ]);
                    }
                }

                $statusDistribution[$status]++;
            }
        }

        // Generate May peminjaman (mix of statuses)
        $mayCount = 18;
        for ($i = 0; $i < $mayCount; $i++) {
            $day = rand(1, 29);
            $hour = rand(8, 16);
            $minute = rand(0, 59);
            $pengajuan = Carbon::create(2026, 5, $day, $hour, $minute);

            if ($pengajuan->gt($now)) {
                continue;
            }

            $rand = rand(1, 10);
            $status = match (true) {
                $rand <= 4 => 'selesai',
                $rand <= 6 => 'dipinjam',
                $rand <= 7 => 'jatuh_tempo',
                $rand === 8 => 'menunggu',
                default => 'ditolak',
            };

            $peminjamId = $peminjamIds[array_rand($peminjamIds)];
            $petugasId = $petugasIds[array_rand($petugasIds)];
            $selectedDurasi = $this->pickDuration();

            $tanggalSetujui = null;
            $deadline = null;

            if (in_array($status, ['selesai', 'dipinjam', 'jatuh_tempo'])) {
                $tanggalSetujui = (clone $pengajuan)->addMinutes(rand(5, 60));
                $deadline = (clone $tanggalSetujui)->addMinutes($selectedDurasi);

                if ($status === 'dipinjam' && $deadline->lt($now)) {
                    $status = 'jatuh_tempo';
                }
                if ($status === 'jatuh_tempo' && $deadline->copy()->addMinutes(10)->lt($now)) {
                    $status = 'terlambat';
                }
            }

            $kode = $this->generateKodePeminjaman($pengajuan);

            $peminjamanId = DB::table('peminjaman')->insertGetId([
                'kode_peminjaman' => $kode,
                'peminjam_id' => $peminjamId,
                'petugas_id' => in_array($status, ['menunggu', 'ditolak']) ? null : $petugasId,
                'status' => $status,
                'durasi' => $selectedDurasi,
                'deadline' => $deadline,
                'tanggal_pengajuan' => $pengajuan,
                'tanggal_disetujui' => $tanggalSetujui,
                'created_at' => $pengajuan,
                'updated_at' => $pengajuan,
            ]);

            $validAlatIds = array_keys(array_filter($alatDurasi, fn($d) => $d == $selectedDurasi));
            shuffle($validAlatIds);
            $numItems = min(rand(1, 3), count($validAlatIds));
            $detailIds = [];

            for ($j = 0; $j < $numItems; $j++) {
                $alatId = $validAlatIds[$j];
                $jumlah = rand(1, 2);

                $detailId = DB::table('detail_peminjaman')->insertGetId([
                    'peminjaman_id' => $peminjamanId,
                    'alat_id' => $alatId,
                    'jumlah' => $jumlah,
                    'created_at' => $pengajuan,
                    'updated_at' => $pengajuan,
                ]);

                $detailIds[] = [
                    'id' => $detailId,
                    'alat_id' => $alatId,
                    'jumlah' => $jumlah,
                ];
            }

            // Create returns for selesai ones
            if ($status === 'selesai') {
                $selesaiDate = (clone $deadline)->addMinutes(rand(-15, 45));
                $kodePg = $this->generateKodePengembalian($selesaiDate);

                $pengembalianId = DB::table('pengembalian')->insertGetId([
                    'kode_pengembalian' => $kodePg,
                    'peminjaman_id' => $peminjamanId,
                    'petugas_id' => $petugasId,
                    'status' => 'selesai',
                    'tanggal_pengembalian' => $selesaiDate,
                    'tanggal_verifikasi' => (clone $selesaiDate)->addMinutes(rand(10, 120)),
                    'created_at' => $selesaiDate,
                    'updated_at' => $selesaiDate,
                ]);

                $hasRusak = rand(1, 5) === 1;

                foreach ($detailIds as $det) {
                    $kondisi = $hasRusak && rand(1, 3) === 1 ? 'rusak' : 'lolos';
                    $catatan = $kondisi === 'rusak'
                        ? fake()->randomElement([
                            'Kabel putus',
                            'Body penyok',
                            'Tidak bisa menyala',
                            'Tombol rusak',
                            'Gagang longgar',
                            'LCD retak',
                            'Goresan di bodi',
                            'Konektor longgar',
                        ])
                        : null;

                    DB::table('detail_pengembalian')->insert([
                        'pengembalian_id' => $pengembalianId,
                        'detail_peminjaman_id' => $det['id'],
                        'jumlah_kembali' => $det['jumlah'],
                        'kondisi' => $kondisi,
                        'catatan_kondisi' => $catatan,
                        'created_at' => $selesaiDate,
                        'updated_at' => $selesaiDate,
                    ]);
                }
            }

            $statusDistribution[$status]++;
        }

        // Force some current-time records for realistic active statuses
        $now = Carbon::now();

        // 2 active 'dipinjam' with long duration so deadline is far in the future
        for ($i = 0; $i < 2; $i++) {
            $peminjamId = $peminjamIds[array_rand($peminjamIds)];
            $petugasId = $petugasIds[array_rand($petugasIds)];
            $pengajuan = (clone $now)->subMinutes(rand(5, 20));
            $tanggalSetujui = (clone $pengajuan)->addMinutes(rand(2, 5));
            $selectedDurasi = 480;
            $deadline = (clone $tanggalSetujui)->addMinutes($selectedDurasi);

            $kode = $this->generateKodePeminjaman($pengajuan);
            $peminjamanId = DB::table('peminjaman')->insertGetId([
                'kode_peminjaman' => $kode,
                'peminjam_id' => $peminjamId,
                'petugas_id' => $petugasId,
                'status' => 'dipinjam',
                'durasi' => $selectedDurasi,
                'deadline' => $deadline,
                'tanggal_pengajuan' => $pengajuan,
                'tanggal_disetujui' => $tanggalSetujui,
                'created_at' => $pengajuan,
                'updated_at' => $pengajuan,
            ]);
            $validAlatIds = array_keys(array_filter($alatDurasi, fn($d) => $d == $selectedDurasi));
            shuffle($validAlatIds);
            $numItems = min(rand(1, 2), count($validAlatIds));
            for ($j = 0; $j < $numItems; $j++) {
                DB::table('detail_peminjaman')->insert([
                    'peminjaman_id' => $peminjamanId,
                    'alat_id' => $validAlatIds[$j],
                    'jumlah' => rand(1, 2),
                    'created_at' => $pengajuan,
                    'updated_at' => $pengajuan,
                ]);
            }
            $statusDistribution['dipinjam']++;
        }

        // 1 'jatuh_tempo' (deadline passed but < 10 min ago)
        $selectedDurasi = $this->pickDuration();
        $peminjamId = $peminjamIds[array_rand($peminjamIds)];
        $petugasId = $petugasIds[array_rand($petugasIds)];
        $deadline = (clone $now)->subMinutes(rand(1, 8));
        $tanggalSetujui = (clone $deadline)->subMinutes($selectedDurasi);
        $pengajuan = (clone $tanggalSetujui)->subMinutes(rand(2, 5));
        $kode = $this->generateKodePeminjaman($pengajuan);
        $peminjamanId = DB::table('peminjaman')->insertGetId([
            'kode_peminjaman' => $kode,
            'peminjam_id' => $peminjamId,
            'petugas_id' => $petugasId,
            'status' => 'jatuh_tempo',
            'durasi' => $selectedDurasi,
            'deadline' => $deadline,
            'tanggal_pengajuan' => $pengajuan,
            'tanggal_disetujui' => $tanggalSetujui,
            'created_at' => $pengajuan,
            'updated_at' => $pengajuan,
        ]);
        $validAlatIds = array_keys(array_filter($alatDurasi, fn($d) => $d == $selectedDurasi));
        shuffle($validAlatIds);
        DB::table('detail_peminjaman')->insert([
            'peminjaman_id' => $peminjamanId,
            'alat_id' => $validAlatIds[0],
            'jumlah' => 1,
            'created_at' => $pengajuan,
            'updated_at' => $pengajuan,
        ]);

        // 2 'menunggu' (no petugas approval)
        for ($i = 0; $i < 2; $i++) {
            $peminjamId = $peminjamIds[array_rand($peminjamIds)];
            $pengajuan = (clone $now)->subMinutes(rand(10, 120));
            $kode = $this->generateKodePeminjaman($pengajuan);
            $selectedDurasi = $this->pickDuration();
            $peminjamanId = DB::table('peminjaman')->insertGetId([
                'kode_peminjaman' => $kode,
                'peminjam_id' => $peminjamId,
                'petugas_id' => null,
                'status' => 'menunggu',
                'durasi' => $selectedDurasi,
                'deadline' => null,
                'tanggal_pengajuan' => $pengajuan,
                'tanggal_disetujui' => null,
                'created_at' => $pengajuan,
                'updated_at' => $pengajuan,
            ]);
            $validAlatIds = array_keys(array_filter($alatDurasi, fn($d) => $d == $selectedDurasi));
            shuffle($validAlatIds);
            DB::table('detail_peminjaman')->insert([
                'peminjaman_id' => $peminjamanId,
                'alat_id' => $validAlatIds[0],
                'jumlah' => rand(1, 2),
                'created_at' => $pengajuan,
                'updated_at' => $pengajuan,
            ]);
            $statusDistribution['menunggu']++;
        }

        // Add log entries for these forced records
        $forcedPeminjaman = DB::table('peminjaman')
            ->whereIn('status', ['dipinjam', 'jatuh_tempo', 'menunggu'])
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        foreach ($forcedPeminjaman as $p) {
            $peminjamName = Pengguna::find($p->peminjam_id)?->nama_lengkap ?? 'Unknown';
            $petugasName = $p->petugas_id ? (Pengguna::find($p->petugas_id)?->nama_lengkap ?? 'Petugas') : null;

            if ($p->status === 'menunggu') {
                DB::table('log')->insert([
                    'user_id' => $p->peminjam_id,
                    'role' => 'peminjam',
                    'modul' => 'peminjaman',
                    'aksi' => 'create',
                    'target' => $p->kode_peminjaman,
                    'keterangan' => "Pengajuan peminjaman {$p->kode_peminjaman} oleh {$peminjamName}",
                    'status' => 'success',
                    'created_at' => $p->created_at,
                    'updated_at' => $p->created_at,
                ]);
            } else {
                DB::table('log')->insert([
                    'user_id' => $p->petugas_id,
                    'role' => 'petugas',
                    'modul' => 'peminjaman',
                    'aksi' => 'approve',
                    'target' => $p->kode_peminjaman,
                    'keterangan' => "Peminjaman {$p->kode_peminjaman} oleh {$peminjamName} telah disetujui oleh {$petugasName}",
                    'status' => 'success',
                    'created_at' => $p->created_at,
                    'updated_at' => $p->created_at,
                ]);
            }
        }

        // Update status count for the forced 'jatuh_tempo' we added
        $statusDistribution['jatuh_tempo']++;

        echo 'Status distribution: ' . json_encode($statusDistribution) . PHP_EOL;
    }

    private function seedActivityLogs(
        int $adminId,
        array $petugasIds,
        array $peminjamIds
    ): void {
        $petugas1Id = $petugasIds[0];
        $petugas2Id = $petugasIds[1] ?? $petugasIds[0];

        $peminjamanList = DB::table('peminjaman')
            ->whereIn('status', ['selesai', 'dipinjam', 'jatuh_tempo', 'terlambat'])
            ->get(['id', 'kode_peminjaman', 'status', 'created_at', 'peminjam_id', 'petugas_id']);

        $logData = [];

        // Log peminjaman approvals
        foreach ($peminjamanList as $p) {
            $petugasName = Pengguna::find($p->petugas_id)?->nama_lengkap ?? 'System';
            $peminjamName = Pengguna::find($p->peminjam_id)?->nama_lengkap ?? 'Unknown';

            $logData[] = [
                'user_id' => $p->petugas_id ?? $adminId,
                'role' => 'petugas',
                'modul' => 'peminjaman',
                'aksi' => 'approve',
                'target' => $p->kode_peminjaman,
                'keterangan' => "Peminjaman {$p->kode_peminjaman} oleh {$peminjamName} telah disetujui oleh {$petugasName}",
                'status' => 'success',
                'created_at' => $p->created_at,
                'updated_at' => $p->created_at,
            ];
        }

        // Log returns verification
        $pengembalianList = DB::table('pengembalian')
            ->where('status', 'selesai')
            ->get(['id', 'kode_pengembalian', 'tanggal_verifikasi', 'petugas_id']);

        foreach ($pengembalianList as $pg) {
            $petugasName = Pengguna::find($pg->petugas_id)?->nama_lengkap ?? 'System';

            $logData[] = [
                'user_id' => $pg->petugas_id ?? $adminId,
                'role' => 'petugas',
                'modul' => 'pengembalian',
                'aksi' => 'verifikasi',
                'target' => $pg->kode_pengembalian,
                'keterangan' => "Pengembalian {$pg->kode_pengembalian} telah diverifikasi oleh {$petugasName}",
                'status' => 'success',
                'created_at' => $pg->tanggal_verifikasi,
                'updated_at' => $pg->tanggal_verifikasi,
            ];
        }

        // Log peminjaman creation by peminjam
        $allPeminjaman = DB::table('peminjaman')->get(['id', 'kode_peminjaman', 'created_at', 'peminjam_id']);
        foreach ($allPeminjaman as $p) {
            $peminjamName = Pengguna::find($p->peminjam_id)?->nama_lengkap ?? 'Unknown';

            $logData[] = [
                'user_id' => $p->peminjam_id,
                'role' => 'peminjam',
                'modul' => 'peminjaman',
                'aksi' => 'create',
                'target' => $p->kode_peminjaman,
                'keterangan' => "Pengajuan peminjaman {$p->kode_peminjaman} oleh {$peminjamName}",
                'status' => 'success',
                'created_at' => $p->created_at,
                'updated_at' => $p->created_at,
            ];
        }

        // Add some rejected logs
        $rejected = DB::table('peminjaman')->where('status', 'ditolak')
            ->get(['id', 'kode_peminjaman', 'created_at', 'peminjam_id']);
        foreach ($rejected as $p) {
            $peminjamName = Pengguna::find($p->peminjam_id)?->nama_lengkap ?? 'Unknown';

            $logData[] = [
                'user_id' => $adminId,
                'role' => 'petugas',
                'modul' => 'peminjaman',
                'aksi' => 'reject',
                'target' => $p->kode_peminjaman,
                'keterangan' => "Peminjaman {$p->kode_peminjaman} oleh {$peminjamName} ditolak",
                'status' => 'warning',
                'created_at' => $p->created_at,
                'updated_at' => $p->created_at,
            ];
        }

        // Admin CRUD logs
        $logData[] = [
            'user_id' => $adminId,
            'role' => 'admin',
            'modul' => 'user',
            'aksi' => 'create',
            'target' => 'aniputri',
            'keterangan' => 'Admin menambahkan pengguna baru Ani Putri',
            'status' => 'success',
            'created_at' => '2026-01-05 09:00:00',
            'updated_at' => '2026-01-05 09:00:00',
        ];

        $logData[] = [
            'user_id' => $adminId,
            'role' => 'admin',
            'modul' => 'kategori',
            'aksi' => 'create',
            'target' => 'KTG-001',
            'keterangan' => 'Admin menambahkan kategori Elektronik',
            'status' => 'success',
            'created_at' => '2026-01-02 08:30:00',
            'updated_at' => '2026-01-02 08:30:00',
        ];

        $logData[] = [
            'user_id' => $adminId,
            'role' => 'admin',
            'modul' => 'alat',
            'aksi' => 'create',
            'target' => 'E001',
            'keterangan' => 'Admin menambahkan alat Proyektor Epson',
            'status' => 'success',
            'created_at' => '2026-01-03 10:15:00',
            'updated_at' => '2026-01-03 10:15:00',
        ];

        $logData[] = [
            'user_id' => $adminId,
            'role' => 'admin',
            'modul' => 'alat',
            'aksi' => 'update',
            'target' => 'E002',
            'keterangan' => 'Admin memperbarui stok Laptop Dell dari 10 menjadi 12',
            'status' => 'success',
            'created_at' => '2026-03-15 14:20:00',
            'updated_at' => '2026-03-15 14:20:00',
        ];

        $logData[] = [
            'user_id' => $adminId,
            'role' => 'admin',
            'modul' => 'kategori',
            'aksi' => 'update',
            'target' => 'KTG-002',
            'keterangan' => 'Admin memperbarui warna kategori Perkakas',
            'status' => 'success',
            'created_at' => '2026-02-10 11:00:00',
            'updated_at' => '2026-02-10 11:00:00',
        ];

        // Error logs
        $logData[] = [
            'user_id' => null,
            'role' => 'system',
            'modul' => 'system',
            'aksi' => 'error',
            'target' => null,
            'keterangan' => 'Gagal menyimpan gambar alat: ukuran file melebihi batas 2MB',
            'status' => 'error',
            'created_at' => '2026-04-20 15:45:00',
            'updated_at' => '2026-04-20 15:45:00',
        ];

        $logData[] = [
            'user_id' => null,
            'role' => 'system',
            'modul' => 'system',
            'aksi' => 'timeout',
            'target' => null,
            'keterangan' => 'Session timeout untuk pengguna dianpratama',
            'status' => 'warning',
            'created_at' => '2026-05-15 12:30:00',
            'updated_at' => '2026-05-15 12:30:00',
        ];

        DB::table('log')->insert($logData);
    }

    private function updateLastActivity(
        array $peminjamIds,
        array $petugasIds,
        int $adminId
    ): void {
        $now = Carbon::now();

        // Admin & petugas online (within last 5 min)
        Pengguna::whereIn('id', array_merge([$adminId], $petugasIds))
            ->update(['last_activity' => $now->subMinutes(rand(1, 4))]);

        // Some peminjam online
        $onlinePeminjam = array_rand(array_flip($peminjamIds), min(4, count($peminjamIds)));
        Pengguna::whereIn('id', (array) $onlinePeminjam)
            ->update(['last_activity' => $now->subMinutes(rand(1, 3))]);

        // Others active today
        $offlinePeminjam = array_diff($peminjamIds, (array) $onlinePeminjam);
        foreach ($offlinePeminjam as $id) {
            Pengguna::where('id', $id)
                ->update(['last_activity' => $now->subHours(rand(2, 48))]);
        }
    }

    private function pickDuration(): int
    {
        return fake()->randomElement([30, 60, 90, 120, 180]);
    }

    private function generateKodePeminjaman(Carbon $date): string
    {
        $ym = $date->format('ym');
        if (!isset($this->peminjamanCounter[$ym])) {
            $this->peminjamanCounter[$ym] = 0;
        }
        $this->peminjamanCounter[$ym]++;

        return 'INV-PJ-' . $ym . '-' . str_pad($this->peminjamanCounter[$ym], 3, '0', STR_PAD_LEFT);
    }

    private function generateKodePengembalian(Carbon $date): string
    {
        $ym = $date->format('ym');
        if (!isset($this->pengembalianCounter[$ym])) {
            $this->pengembalianCounter[$ym] = 0;
        }
        $this->pengembalianCounter[$ym]++;

        return 'INV-PG-' . $ym . '-' . str_pad($this->pengembalianCounter[$ym], 3, '0', STR_PAD_LEFT);
    }
}
