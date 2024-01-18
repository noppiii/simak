<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class MahasiswaAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('authuser')->user();

        if ($user && $user->role->role_name === 'Mahasiswa') {
            return $next($request);
        }

        Session::flash('error_message', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        return redirect()->route('login');
    }
}