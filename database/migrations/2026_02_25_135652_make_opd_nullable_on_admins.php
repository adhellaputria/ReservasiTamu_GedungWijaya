<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {


            $table->dropForeign(['opd_id']);
            $table->unsignedInteger('opd_id')->nullable()->change();

            $table->foreign('opd_id')
                  ->references('id')
                  ->on('opd')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {

            $table->dropForeign(['opd_id']);

            // Balikin kalau perlu
            $table->unsignedInteger('opd_id')->nullable(false)->change();

            $table->foreign('opd_id')
                  ->references('id')
                  ->on('opd')
                  ->cascadeOnDelete();
        });
    }
};