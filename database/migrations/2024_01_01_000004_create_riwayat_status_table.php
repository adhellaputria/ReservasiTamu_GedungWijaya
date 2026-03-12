<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('riwayat_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reservasi_id');
            $table->enum('status_lama', ['Menunggu','Disetujui','Ditolak','Hadir'])->nullable();
            $table->enum('status_baru', ['Menunggu','Disetujui','Ditolak','Hadir']);
            $table->text('keterangan')->nullable();
            $table->unsignedInteger('oleh_admin')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('reservasi_id')->references('id')->on('reservasi')->onDelete('cascade');
            $table->foreign('oleh_admin')->references('id')->on('admins')->onDelete('set null');
        });
    }
    public function down(): void { Schema::dropIfExists('riwayat_status'); }
};
