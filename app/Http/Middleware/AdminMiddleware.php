<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login dan memiliki peran 'admin'
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            // Jika tidak, arahkan kembali dengan pesan error atau tampilkan 403
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk mengakses halaman ini.');
            // Atau bisa juga redirect ke halaman lain:
            // return redirect('/dashboard')->with('error', 'Anda tidak memiliki izin.');
        }

        return $next($request);
    }
}