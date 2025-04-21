<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Menangani request yang masuk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect('login'); // Arahkan ke halaman login jika belum login
        }

        // Cek apakah role pengguna sesuai
        $user = Auth::user();
        if ($user->role !== $role) {
            return redirect('/'); // Arahkan ke halaman home jika role tidak sesuai
        }

        return $next($request); // Lanjutkan jika role sesuai
    }
}
