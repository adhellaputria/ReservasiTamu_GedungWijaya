<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN UTAMA (SUPERADMIN)
        |--------------------------------------------------------------------------
        */
        $this->call([
            AdminUtamaSeeder::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | DATA OPD (Sesuai Gedung Wijaya)
        |--------------------------------------------------------------------------
        */

        $opds = [

            // LANTAI 2
            ['kode'=>'BANGDA',      'nama'=>'Bagian Pembangunan Daerah',          'lantai'=>2],
            ['kode'=>'DISDAGKOP',   'nama'=>'Disdagkop UKM',                      'lantai'=>2],

            // LANTAI 3
            ['kode'=>'PMD',         'nama'=>'Dinas PMD',                          'lantai'=>3],
            ['kode'=>'PPKB',        'nama'=>'Dinas PPKB & P3A',                   'lantai'=>3],

            // LANTAI 4
            ['kode'=>'DLH',         'nama'=>'Dinas Lingkungan Hidup',             'lantai'=>4],
            ['kode'=>'DISPERNAKER', 'nama'=>'Dispernaker',                        'lantai'=>4],

            // LANTAI 5
            ['kode'=>'PANGAN',      'nama'=>'Dinas Pangan',                       'lantai'=>5],
            ['kode'=>'KOMINFO',     'nama'=>'Dinas Kominfo',                      'lantai'=>5],

            // LANTAI 6
            ['kode'=>'PERUMAHAN',   'nama'=>'Dinas Perumahan dan KP',             'lantai'=>6],
            ['kode'=>'BKPP',        'nama'=>'BKPP',                                'lantai'=>6],

            // LANTAI 7
            ['kode'=>'PORA',        'nama'=>'Dinas Pemuda dan Olahraga',          'lantai'=>7],
            ['kode'=>'INSPEKTORAT', 'nama'=>'Inspektorat',                        'lantai'=>7],
            ['kode'=>'KESBANGPOL',  'nama'=>'Kesbangpol',                         'lantai'=>7],
        ];

        foreach ($opds as $opd) {
            DB::table('opd')->updateOrInsert(
                ['kode' => $opd['kode']],
                [
                    'nama'       => $opd['nama'],
                    'lantai'     => $opd['lantai'],
                    'email_opd'  => strtolower($opd['kode']).'@sijamu.go.id',
                    'telepon'    => '-',
                    'kepala'     => '-',
                    'is_aktif'   => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN OPD
        |--------------------------------------------------------------------------
        */

        foreach ($opds as $opd) {

            $opdId = DB::table('opd')
                ->where('kode', $opd['kode'])
                ->value('id');

            DB::table('admins')->updateOrInsert(
                ['username' => 'admin.'.strtolower($opd['kode'])],
                [
                    'opd_id'       => $opdId,
                    'password'     => Hash::make('pass123'),
                    'nama_lengkap' => 'Admin '.$opd['nama'],
                    'email'        => 'admin.'.strtolower($opd['kode']).'@sijamu.go.id',
                    'role'         => 'admin_opd',
                    'is_aktif'     => 1,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]
            );
        }

        $this->command->info(' Seeder selesai ');
        $this->command->info('Superadmin: adminutama@sijamu.go.id / admin12345');
        $this->command->info('Admin OPD: admin.kodeopd / pass123');
    }
}