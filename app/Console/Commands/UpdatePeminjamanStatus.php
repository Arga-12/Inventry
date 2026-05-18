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

        // jadi jatuh tempo
        Peminjaman::where('status', 'dipinjam')
            ->where('deadline', '<=', $now)
            ->update([
                'status' => 'jatuh_tempo'
            ]);

        // jadi terlambat setelah 10 menit
        Peminjaman::where('status', 'jatuh_tempo')
            ->where('deadline', '<=', $now->copy()->subMinutes(10))
            ->update([
                'status' => 'terlambat'
            ]);

        $this->info('Status peminjaman berhasil diperbarui.');
    }
}