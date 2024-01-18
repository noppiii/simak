<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthUserController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ];
        $customeMessages = [
            'email.required' => 'Email harus diisi!!!',
            'email.email' => 'Email tidak sesuai format!!!',
            'password.required' => 'Password harus diisi!!!',
        ];
        $this->validate($request, $rules, $customeMessages);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('authuser')->attempt($credentials)) {
            $user = Auth::guard('authuser')->user();

            switch ($user->role->role_name) {
                case "Admin":
                    Session::flash('success_message', 'Berhasil Login');
                    return redirect()->route('admin-dashboard-pendaftaran');
                case "Staff":
                    Session::flash('success_message', 'Berhasil Login');
                    return redirect()->route('staff-dashboard-pendaftaran');
                case "Pimpinan":
                    Session::flash('success_message', 'Berhasil Login');
                    return redirect()->route('pimpinan-dashboard-pendaftaran');
                case "Dosen":
                    Session::flash('success_message', 'Berhasil Login');
                    return redirect()->route('dosen-dashboard-penilaian');
                case "Mahasiswa":
                    Session::flash('success_message', 'Berhasil Login');
                    return redirect()->route('mahasiswa-dashboard');
                default:
                    Session::flash('error_message', 'Anda tidak memiliki akses.');
                    return redirect()->back();
                    break;
            }
        } else {
            return redirect()->back()->with("error_message", "Email atau Password tidak sesuai. Silahkan masukan data dengan benar!!!!!");
        }
    }

    public function logout()
    {
        Auth::guard('authuser')->logout();
        Session::flash('success_message_logout', 'Berhasil Logout');
        return redirect()->route('home');
    }
}