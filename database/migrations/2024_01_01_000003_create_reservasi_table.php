<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode', 12)->unique();
            $table->string('nama_tamu', 150);
            $table->string('no_hp', 20);
            $table->string('email_tamu', 100);
            $table->string('instansi', 150)->nullable();
            $table->unsignedInteger('opd_id');
            $table->string('petugas_dituju', 100)->nullable();
            $table->text('tujuan');
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->string('sesi_jam', 25);
            $table->string('dokumen_path', 255)->nullable();
            $table->string('dokumen_nama_asli', 255)->nullable();
            $table->enum('status', ['Menunggu','Disetujui','Ditolak','Hadir'])->default('Menunggu');
            $table->text('alasan_tolak')->nullable();
            $table->unsignedInteger('diproses_oleh')->nullable();
            $table->timestamp('waktu_diproses')->nullable();
            $table->timestamp('waktu_hadir')->nullable();
            $table->unsignedInteger('diverifikasi_oleh')->nullable();
            $table->boolean('email_konfirmasi_terkirim')->default(false);
            $table->boolean('email_notif_opd_terkirim')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('opd_id')->references('id')->on('opd')->onDelete('restrict');
            $table->foreign('diproses_oleh')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('diverifikasi_oleh')->references('id')->on('admins')->onDelete('set null');
            $table->index('kode');
            $table->index('status');
            $table->index('tanggal');
        });
    }
    public function down(): void { Schema::dropIfExists('reservasi'); }
};
