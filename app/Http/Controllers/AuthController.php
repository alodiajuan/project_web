<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::guard('mahasiswa')->check() || Auth::guard('sdm')->check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $role = $request->input('role');
            
            if ($role == 'MHS') {
                if (Auth::guard('mahasiswa')->attempt(['nim' => $request->username, 'password' => $request->password])) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login Berhasil',
                        'redirect' => url('/')
                    ]);
                }
            } else {
                if (Auth::guard('sdm')->attempt(['nip' => $request->username, 'password' => $request->password])) {
                    $user = Auth::guard('sdm')->user();
                    if ($user->level && $user->level->level_kode === $role) {
                        return response()->json([
                            'status' => true,
                            'message' => 'Login Berhasil',
                            'redirect' => url('/')
                        ]);
                    }
                    Auth::guard('sdm')->logout();
                }
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
        Auth::guard('mahasiswa')->logout();
        Auth::guard('sdm')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}