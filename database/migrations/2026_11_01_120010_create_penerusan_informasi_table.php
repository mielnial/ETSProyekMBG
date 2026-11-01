<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penerusan_informasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')
                ->constrained('laporan')
                ->cascadeOnDelete();
            $table->foreignId('koordinator_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->string('pihak_tujuan');
            $table->text('keterangan')->nullable();
            $table->date('tanggal_diteruskan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerusan_informasi');
    }
};
