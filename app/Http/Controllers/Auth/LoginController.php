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
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba login langsung
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // 3. Ambil user yang sudah login
            $user = Auth::user();

            // 4. Cek role dari database dan redirect
            return match ($user->role) {
                'admin'    => redirect()->route('dashboard'),
                'pimpinan' => redirect()->route('dashboard'),
                'petugas'  => redirect()->route('dashboard'),
                default    => redirect()->route('login')->withErrors([
                    'email' => 'Akun anda tidak memiliki akses yang valid.'
                ])
            };
        }

        // 5. Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
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
