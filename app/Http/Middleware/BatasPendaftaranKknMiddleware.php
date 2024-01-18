<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BatasPendaftaranKknMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $mahasiswa = Auth::guard('authuser')->user()->mahasiswa;
        if ($mahasiswa->kknMahasiswa !== null) {
            return redirect()->route('daftar-kkn.index')->with('error_message_not_found', 'Anda sudah mendaftar KKN.');
        }

        return $next($request);
    }
}