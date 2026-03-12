<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule: Auto mark tidak hadir setiap hari jam 00:01 (setelah hari reservasi terlewati)
Schedule::command('reservasi:auto-tidak-hadir')->dailyAt('00:01');
