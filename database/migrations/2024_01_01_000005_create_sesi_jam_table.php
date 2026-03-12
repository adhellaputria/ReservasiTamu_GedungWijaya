<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sesi_jam', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('label', 25);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->boolean('hanya_senin_kamis')->default(false);
            $table->boolean('is_aktif')->default(true);
        });
    }
    public function down(): void { Schema::dropIfExists('sesi_jam'); }
};
