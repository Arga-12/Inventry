<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('kode_peminjaman')->unique();

            $table->foreignId('peminjam_id')
                ->constrained('user')
                ->cascadeOnDelete();

            $table->foreignId('petugas_id')
                ->nullable()
                ->constrained('user')
                ->nullOnDelete();

            $table->enum('status', [
                'menunggu',
                'dipinjam',
                'jatuh_tempo',
                'terlambat',
                'selesai', // <- berubah jadi selesai kalau di tabel pengembalian udah di verif
                'ditolak',
            ])->default('menunggu');

            $table->integer('durasi')->nullable(); // <- dalam menit
            $table->timestamp('deadline')->nullable();

            $table->timestamp('tanggal_pengajuan')->nullable();
            $table->timestamp('tanggal_disetujui')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
