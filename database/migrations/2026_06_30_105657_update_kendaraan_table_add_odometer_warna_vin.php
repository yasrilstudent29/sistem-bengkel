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
        Schema::table('kendaraan', function (Blueprint $table) {
            $table->dropColumn('nama_kendaraan');
            $table->integer('odometer')->default(0)->after('tahun');
            $table->string('warna')->nullable()->after('odometer');
            $table->string('vin', 30)->nullable()->after('plat_nomor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kendaraan', function (Blueprint $table) {
            $table->string('nama_kendaraan')->after('user_id');
            $table->dropColumn(['odometer', 'warna', 'vin']);
        });
    }
};