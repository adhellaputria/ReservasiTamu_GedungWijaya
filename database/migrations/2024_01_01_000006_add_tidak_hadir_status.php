<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // First, update any existing records that might have 'Tidak Hadir' to a valid status
        // Then modify the enum to include 'Tidak Hadir'
        Schema::table('reservasi', function (Blueprint $table) {
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak', 'Hadir', 'Tidak Hadir'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak', 'Hadir'])->change();
        });
    }
};

