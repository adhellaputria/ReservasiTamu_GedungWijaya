<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware: AuthAdmin
 * Lindungi semua route admin dari akses tanpa login.
 *
 * Daftarkan di bootstrap/app.php (Laravel 12):
 *   ->withMiddleware(function (Middleware $middleware) {
 *       $middleware->alias(['auth.admin' => \App\Http\Middleware\AuthAdmin::class]);
 *   })
 */
class AuthAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('admin_logged_in')) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
