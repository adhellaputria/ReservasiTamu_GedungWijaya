<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Modify the role enum to include 'admin_utama'
        DB::statement("ALTER TABLE admins MODIFY COLUMN role ENUM('admin_opd', 'superadmin', 'lobi', 'admin_utama') DEFAULT 'admin_opd'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE admins MODIFY COLUMN role ENUM('admin_opd', 'superadmin', 'lobi') DEFAULT 'admin_opd'");
    }
};

