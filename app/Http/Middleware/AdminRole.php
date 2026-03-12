<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminRole   // ⚠ HARUS AdminRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = session('admin_role');

        // Superadmin boleh akses semua
        if ($userRole === Admin::ROLE_SUPERADMIN) {
            return $next($request);
        }

        if (!in_array($userRole, $roles)) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}