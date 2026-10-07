<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        // Jika sudah login, redirect ke halaman sesuai role
        if (Session::has('user')) {
            return $this->redirectByRole(Session::get('user.role'));
        }
        return view('login');
    }

    /**
     * Proses login dari form.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $username = trim($request->input('username'));
        $password = $request->input('password');

        // Cari user di tabel 'user' berdasarkan username
        $user = DB::table('user')
            ->where('username', $username)
            ->first();

        if (!$user) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Username atau password salah.');
        }

        // Cek password (support plain text & hashed)
        $passwordValid = false;
        $storedPassword = $user->password ?? $user->Password ?? '';

        if (strlen($storedPassword) >= 60 && str_starts_with($storedPassword, '$2y$')) {
            // bcrypt hashed
            $passwordValid = password_verify($password, $storedPassword);
        } else {
            // plain text (fallback dev)
            $passwordValid = ($password === $storedPassword);
        }

        if (!$passwordValid) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Username atau password salah.');
        }

        // Normalisasi role dari database (lowercase)
        $userRole = strtolower($user->role);

        // Simpan session
        Session::put('user', [
            'id_user'  => $user->id_user,
            'nama'     => $user->nama,
            'role'     => $userRole,
            'username' => $user->username,
        ]);

        return $this->redirectByRole($userRole);
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Session::forget('user');
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }

    /**
     * Redirect berdasarkan role.
     */
    private function redirectByRole(string $role)
    {
        return match (strtolower($role)) {
            'kasir'                        => redirect('/kasir/antrian'),
            'owner', 'manajer', 'admin'   => redirect('/owner/menu'),
            default                        => redirect('/login')->with('error', 'Role tidak dikenali.'),
        };
    }
}
