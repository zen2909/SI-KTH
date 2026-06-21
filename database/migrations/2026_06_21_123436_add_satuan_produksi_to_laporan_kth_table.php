<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_kth', function (Blueprint $table) {
            $table->string('satuan_produksi', 20)->nullable()->after('potensi_produksi');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_kth', function (Blueprint $table) {
            $table->dropColumn('satuan_produksi');
        });
    }
};