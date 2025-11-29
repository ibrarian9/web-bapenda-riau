<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('anggota.index', compact('users'));
    }

    public function create()
    {
        return view('anggota.create', [
            'roles' => User::ROLES
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'role'     => 'required|in:Admin,Pimpinan,Petugas',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('anggota')
            ->with('success', 'Pengguna baru berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('anggota.edit', [
            'user'  => $user,
            'roles' => User::ROLES
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => "required|email|unique:users,email,{$user->id}",
            'role'  => 'required|in:Admin,Pimpinan,Petugas',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('anggota')
            ->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('anggota')
            ->with('success', 'Pengguna berhasil dihapus');
    }
}
