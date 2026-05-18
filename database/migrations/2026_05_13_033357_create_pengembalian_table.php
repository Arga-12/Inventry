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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengembalian')->unique();

            $table->foreignId('peminjaman_id')
                ->unique()
                ->constrained('peminjaman')
                ->cascadeOnDelete();

            $table->foreignId('petugas_id')
                ->nullable()
                ->constrained('user')
                ->nullOnDelete();

            $table->enum('status', [
                'menunggu_verifikasi',
                'selesai'
            ])->default('menunggu_verifikasi');

            $table->timestamp('tanggal_pengembalian')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
