<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop sesi_jam column if exists
        Schema::table('reservasi', function (Blueprint $table) {
            if (Schema::hasColumn('reservasi', 'sesi_jam')) {
                $table->dropColumn('sesi_jam');
            }
        });

        // Add jam_kunjungan column with TIME type if it doesn't exist
        Schema::table('reservasi', function (Blueprint $table) {
            if (!Schema::hasColumn('reservasi', 'jam_kunjungan')) {
                $table->time('jam_kunjungan')->nullable()->after('tanggal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            if (Schema::hasColumn('reservasi', 'jam_kunjungan')) {
                $table->dropColumn('jam_kunjungan');
            }
        });

        Schema::table('reservasi', function (Blueprint $table) {
            if (!Schema::hasColumn('reservasi', 'sesi_jam')) {
                $table->string('sesi_jam', 25)->nullable()->after('tanggal');
            }
        });
    }
};

