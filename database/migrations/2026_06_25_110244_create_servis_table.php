<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained('kendaraan')->onDelete('cascade');
            $table->foreignId('mekanik_id')->constrained('mekanik')->onDelete('cascade');
            $table->date('tanggal_masuk');
            $table->date('tanggal_selesai')->nullable();
            $table->text('keluhan');
            $table->text('catatan_mekanik')->nullable();
            $table->enum('status', ['menunggu', 'proses', 'selesai', 'diambil'])->default('menunggu');
            $table->decimal('total_biaya', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servis');
    }
};