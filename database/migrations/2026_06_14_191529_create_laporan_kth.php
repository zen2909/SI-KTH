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
        Schema::create('laporan_kth', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kth');
            $table->unsignedBigInteger('id_penyuluh');
            $table->date('periode_laporan');
            $table->text('jenis_usaha')->nullable();
            $table->string('nib', 50)->nullable();
            $table->string('pirt', 50)->nullable();
            $table->string('sertifikat_halal_file', 255)->nullable();
            $table->string('merek_dagang', 100)->nullable();
            $table->text('potensi_produksi')->nullable();
            $table->decimal('nte_per_bulan', 12, 2)->nullable();
            $table->string('jangkauan_pemasaran', 255)->nullable();
            $table->text('kendala_usaha')->nullable();
            $table->text('kebutuhan_pengembangan')->nullable();
            $table->text('keterangan_tambahan')->nullable();
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])
                ->default('pending')
                ->notNullable();
            $table->text('catatan_revisi')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_kth')
                ->references('id')
                ->on('kth')
                ->onDelete('cascade');

            $table->foreign('id_penyuluh')
                ->references('id')
                ->on('penyuluh')
                ->onDelete('restrict'); // default restrict, bisa juga no action, tapi sesuai keinginan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kth');
    }
};