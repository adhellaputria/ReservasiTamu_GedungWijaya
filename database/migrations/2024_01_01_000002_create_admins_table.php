<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('opd_id');
            $table->string('username', 60)->unique();
            $table->string('password', 255);
            $table->string('nama_lengkap', 100);
            $table->string('email', 100)->nullable();
            $table->enum('role', ['admin_opd','superadmin','lobi'])->default('admin_opd');
            $table->boolean('is_aktif')->default(true);
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
            $table->foreign('opd_id')->references('id')->on('opd')->onDelete('restrict');
        });
    }
    public function down(): void { Schema::dropIfExists('admins'); }
};
