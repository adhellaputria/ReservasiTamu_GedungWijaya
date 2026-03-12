<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update any existing 'admin_utama' role to 'superadmin'
        DB::table('admins')
            ->where('role', 'admin_utama')
            ->update(['role' => 'superadmin']);

        // For SQLite, we don't need to drop foreign keys the same way
        // Change opd_id to nullable for superadmin
        Schema::table('admins', function (Blueprint $table) {
            $table->unsignedInteger('opd_id')->nullable()->change();
        });

        // Update the enum values - drop and recreate enum for SQLite
        Schema::table('admins', function (Blueprint $table) {
            // SQLite doesn't support changing enum, so we use text instead
            $table->text('role')->change();
        });
        
        // Update the values to match expected roles
        DB::table('admins')
            ->whereNotIn('role', ['superadmin', 'admin_opd'])
            ->update(['role' => 'admin_opd']);
    }

    public function down(): void
    {
        // Revert admin_utama
        DB::table('admins')
            ->where('role', 'superadmin')
            ->update(['role' => 'admin_utama']);
    }
};
