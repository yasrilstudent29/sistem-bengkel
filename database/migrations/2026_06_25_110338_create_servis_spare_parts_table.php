<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servis_spare_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servis_id')->constrained('servis')->onDelete('cascade');
            $table->foreignId('spare_part_id')->constrained('spare_parts')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_satuan', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servis_spare_parts');
    }
};