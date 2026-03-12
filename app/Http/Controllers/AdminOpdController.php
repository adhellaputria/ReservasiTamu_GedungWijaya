<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Opd;

class AdminOpdController extends Controller
{
    public function index(Request $request)
    {
        $query = Admin::where('role', Admin::ROLE_ADMIN_OPD)
            ->with('opd');

        if ($request->q) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->q . '%')
                  ->orWhere('username', 'like', '%' . $request->q . '%')
                  ->orWhere('email', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->opd_id) {
            $query->where('opd_id', $request->opd_id);
        }

        $admins = $query->orderBy('nama_lengkap')->paginate(10);
        $opdList = Opd::orderBy('nama')->get();

        return view('admin.opd-admin.index', compact('admins', 'opdList'));
    }

    public function create()
    {
        $opdList = Opd::orderBy('nama')->get();
        return view('admin.opd-admin.create', compact('opdList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'username'     => 'required|unique:admins,username',
            'email'        => 'required|email|unique:admins,email',
            'password'     => 'required|min:6',
            'opd_id'       => 'required|exists:opd,id',
        ]);

        Admin::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => $request->password,
            'opd_id'       => $request->opd_id,
            'role'         => Admin::ROLE_ADMIN_OPD,
            'is_aktif'     => 1,
        ]);

        return redirect()
            ->route('admin.opd-admin.index')
            ->with('success', 'Admin OPD berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $admin = Admin::where('role', Admin::ROLE_ADMIN_OPD)->findOrFail($id);
        $opdList = Opd::orderBy('nama')->get();

        return view('admin.opd-admin.edit', compact('admin', 'opdList'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::where('role', Admin::ROLE_ADMIN_OPD)->findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'username'     => 'required|unique:admins,username,' . $admin->id,
            'email'        => 'required|email|unique:admins,email,' . $admin->id,
            'opd_id'       => 'required|exists:opd,id',
        ]);

        $admin->update([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'email'        => $request->email,
            'opd_id'       => $request->opd_id,
            'is_aktif'     => $request->is_aktif ?? 1,
        ]);

        if ($request->filled('password')) {
            $admin->update([
                'password' => $request->password
            ]);
        }

        return redirect()
            ->route('admin.opd-admin.index')
            ->with('success', 'Admin OPD berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $admin = Admin::where('role', Admin::ROLE_ADMIN_OPD)->findOrFail($id);
        $admin->delete();

        return redirect()
            ->route('admin.opd-admin.index')
            ->with('success', 'Admin OPD berhasil dihapus.');
    }
}