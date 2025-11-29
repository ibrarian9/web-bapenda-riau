<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login', [
            'roles' => User::ROLES
        ]);
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
            'role'     => ['required', 'in:' . implode(',', User::ROLES)]
        ]);

        // Ambil data berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user ada
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar.'
            ])->onlyInput('email');
        }

        // Validasi role harus sesuai dengan role di database
        if ($user->role !== $request->role) {
            return back()->withErrors([
                'role' => 'Role yang Anda pilih tidak sesuai dengan akun.'
            ])->onlyInput('email');
        }

        // Coba login
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            return match ($user->role) {
                'Admin'    => redirect()->route('dashboard'),
                'Pimpinan' => redirect()->route('pimpinan.dashboard'),
                'Petugas'  => redirect()->route('petugas.dashboard'),
                default    => redirect()->route('login')->withErrors([
                    'email' => 'Role tidak dikenali oleh sistem.'
                ])
            };
        }

        return back()->withErrors([
            'password' => 'Password salah.'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
