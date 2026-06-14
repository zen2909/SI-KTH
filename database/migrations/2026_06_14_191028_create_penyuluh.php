<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyuluh', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('nama_lengkap', 255);
            $table->string('nip', 50)->nullable();
            $table->string('golongan_pangkat', 50)->nullable();
            $table->string('nik', 16)->unique();
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('no_telepon', 20);
            $table->string('email_pribadi', 255);
            $table->string('jabatan', 255)->nullable();
            $table->text('wilayah_kerja')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyuluh');
    }
};