<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUtamaSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin_utama already exists
        $exists = DB::table('admins')
            ->where('username', 'adminutama')
            ->orWhere('email', 'adminutama@sijamu.go.id')
            ->exists();

        if (!$exists) {
            DB::table('admins')->insert([
                'opd_id'       => null, // Admin Utama tidak terikat OPD
                'username'     => 'adminutama',
                'password'     => Hash::make('admin12345'),
                'nama_lengkap' => 'Admin Utama SIJAMU',
                'email'        => 'adminutama@sijamu.go.id',
                'role'         => 'admin_utama',
                'is_aktif'     => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            $this->command->info('Admin Utama created: adminutama@sijamu.go.id / admin12345');
        } else {
            $this->command->info('Admin Utama already exists, skipping...');
        }
    }
}

