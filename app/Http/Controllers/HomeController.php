<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Opd;

class HomeController extends Controller
{
    public function index()
    {
        $totalReservasi = Reservasi::count();
        $selesai = Reservasi::where('status', 'Hadir')->count();
        $totalOpd = Opd::where('is_aktif', 1)->count();
        $terbaru = Reservasi::latest()->take(5)->get();

        return view('home.index', compact(
            'totalReservasi',
            'selesai',
            'totalOpd',
            'terbaru' 
        ));
    }
}