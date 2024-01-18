<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('authuser')->check()) {
            return redirect()->route('login');
        }

        $user = Auth::guard('authuser')->user();

        // Check the role of the user
        $allowedRoles = ['Admin', 'Dosen', 'Mahasiswa', 'Pimpinan', 'Staff'];
        if (in_array($user->role->role_name, $allowedRoles)) {
            return $next($request);
        } else {
            Session::flash('error_message', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            return redirect()->route('login');
        }
    }
}
