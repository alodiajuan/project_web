<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SdmController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) { // jika sudah login, redirect ke halaman home
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        // Memproses login
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                // Akses ke controller tertentu dapat dilakukan di sini jika dibutuhkan
                if ($user->role === 'admin') {
                    app(AdminController::class)->handleUserLogin($user);
                } elseif (in_array($user->role, ['dosen', 'tendik', 'kaprodi'])) {
                    app(SdmController::class)->handleUserLogin($user);
                } elseif ($user->role === 'mahasiswa') {
                    app(MahasiswaController::class)->handleUserLogin($user);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/'),
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal',
            ]);
        }

        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
