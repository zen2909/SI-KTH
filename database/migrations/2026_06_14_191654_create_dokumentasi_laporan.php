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
        Schema::create('dokumentasi_laporan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_laporan_kth');
            $table->string('file_path', 255);
            $table->string('keterangan', 255)->nullable();
            $table->unsignedBigInteger('uploaded_by');
            $table->timestamps();

            // Foreign key ke laporan_kth: jika laporan dihapus, dokumentasi ikut terhapus
            $table->foreign('id_laporan_kth')
                ->references('id')
                ->on('laporan_kth')
                ->onDelete('cascade');

            // Foreign key ke users: jika user dihapus, uploaded_by menjadi NULL
            $table->foreign('uploaded_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_laporan');
    }
};