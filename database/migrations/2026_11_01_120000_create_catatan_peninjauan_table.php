<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_peninjauan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')
                ->constrained('laporan')
                ->cascadeOnDelete();
            $table->foreignId('pemantau_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->text('isi_catatan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_peninjauan');
    }
};
