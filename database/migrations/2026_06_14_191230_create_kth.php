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
        Schema::create('kth', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penyuluh');
            $table->string('nama_kth', 255);
            $table->enum('kelas_kth', ['Pemula', 'Madya', 'Utama']);
            $table->string('desa', 255);
            $table->string('kecamatan', 255);
            $table->string('kabupaten', 255)->default('Sumenep');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('nama_ketua', 255);
            $table->string('no_hp_ketua', 20);
            $table->string('nomor_register', 100)->nullable();
            $table->date('tanggal_register')->nullable();
            $table->enum('status_kth', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->year('tahun_tidak_aktif')->nullable(); // Hanya jika status Tidak Aktif
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('catatan_revisi')->nullable();
            $table->timestamps();

            // Foreign key ke tabel penyuluh
            $table->foreign('id_penyuluh')
                ->references('id')
                ->on('penyuluh')
                ->onDelete('restrict'); // Restrict delete jika masih ada kth terkait
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kth');
    }
};