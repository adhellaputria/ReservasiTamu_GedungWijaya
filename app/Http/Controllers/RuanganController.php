<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opd;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Opd::query();

        if ($request->q) {
            $query->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhere('kode', 'like', '%' . $request->q . '%');
        }

        $ruangan = $query->orderBy('nama')->get();

        return view('admin.ruangan.index', compact('ruangan'));
        
    }
    

    public function create()
    {
        return view('admin.ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'   => 'required|unique:opd,kode',
            'nama'   => 'required',
            'lantai' => 'required|integer',
        ]);

        Opd::create([
            'kode'      => $request->kode,
            'nama'      => $request->nama,
            'lantai'    => $request->lantai,
            'telepon'   => $request->telepon,
            'email_opd' => $request->email_opd,
            'is_aktif'  => 1
        ]);

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'OPD berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $opd = Opd::findOrFail($id);
        return view('admin.ruangan.edit', compact('opd'));
    }

    public function update(Request $request, $id)
    {
        $opd = Opd::findOrFail($id);

        $request->validate([
            'nama'   => 'required',
            'lantai' => 'required|integer',
        ]);

        $opd->update([
            'nama'      => $request->nama,
            'lantai'    => $request->lantai,
            'telepon'   => $request->telepon,
            'email_opd' => $request->email_opd,
            'is_aktif'  => $request->is_aktif,
        ]);

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'OPD berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $opd = Opd::findOrFail($id);

        // Optional: cek kalau masih ada reservasi
        if ($opd->reservasi()->count() > 0) {
            return back()->with('error', 'OPD tidak bisa dihapus karena masih memiliki reservasi.');
        }

        $opd->delete();

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'OPD berhasil dihapus.');
    }
}

