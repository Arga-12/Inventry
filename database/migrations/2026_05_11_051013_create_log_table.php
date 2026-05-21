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
        Schema::create('log', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('user')
                ->nullOnDelete();

            $table->string('role')->nullable();

            $table->string('modul');
            $table->string('aksi');

            $table->string('target')->nullable();
            $table->text('keterangan')->nullable();

            $table->enum('status', ['success', 'warning', 'error'])
                ->default('success');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log');
    }
};
