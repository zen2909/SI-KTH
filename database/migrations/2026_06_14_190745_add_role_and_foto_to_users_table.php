<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Tambah kolom role (enum)
            $table->enum('role', ['admin', 'penyuluh', 'pimpinan'])
                ->after('password')
                ->default('penyuluh')
                ->notNullable();

            // Tambah kolom foto_profil (nullable)
            $table->string('foto_profil', 255)->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'foto_profil']);
        });
    }
};