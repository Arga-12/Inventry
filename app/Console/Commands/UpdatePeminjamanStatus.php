<?php

namespace App\Console\Commands;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:update-peminjaman-status')]
#[Description('Update status peminjaman otomatis')]
class UpdatePeminjamanStatus extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        // jadi jatuh tempo (hanya jika ada deadline)
        Peminjaman::where('status', 'dipinjam')
            ->whereNotNull('deadline') // Tambahkan ini biar aman
            ->where('deadline', '<=', $now)
            ->update(['status' => 'jatuh_tempo']);

        // jadi terlambat (setelah 10 menit dari deadline)
        Peminjaman::where('status', 'jatuh_tempo')
            ->whereNotNull('deadline') // Tambahkan ini juga
            ->where('deadline', '<=', $now->copy()->subMinutes(10))
            ->update(['status' => 'terlambat']);

        $this->info('Status peminjaman berhasil diperbarui.');
    }
}
