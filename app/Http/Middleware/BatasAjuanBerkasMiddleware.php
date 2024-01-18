<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BatasAjuanBerkasMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $mahasiswa = Auth::guard('authuser')->user()->mahasiswa;
        if ($mahasiswa->kknMahasiswa->luaran !== null) {
            return redirect()->route('luaran.index')->with('error_message_not_found', 'Anda hanya bisa mengajukan berkas luaran sekali.');
        }

        return $next($request);
    }
}
