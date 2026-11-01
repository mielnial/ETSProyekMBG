<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelapor_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->foreignId('distribusi_id')
                ->constrained('distribusi')
                ->restrictOnDelete();
            $table->dateTime('waktu_kejadian');
            $table->unsignedInteger('jumlah_terdampak');
            $table->text('gejala');
            $table->text('uraian');
            $table->string('status')->default('dikirim');
            $table->string('bukti_path')->nullable();
            $table->string('bukti_nama_asli')->nullable();
            $table->timestamps();

            $table->index(
                ['pelapor_id', 'distribusi_id', 'status'],
                'laporan_pelapor_distribusi_status_idx'
            );
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};