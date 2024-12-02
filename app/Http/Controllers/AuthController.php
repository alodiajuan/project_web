<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/'); // redirect ke halaman home jika sudah login
        }
        return view('auth.login');
    }

    public function register()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('auth.register')
            ->with('level', $level);
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id'  => 'required|integer',
                'username'  => 'required|string|min:3|unique:m_user,username',
                'nama'      => 'required|string|max:100',
                'password'  => 'required|min:6'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(),
                ]);
            }
            
            Model::create([
                'level_id' => $request->level_id,
                'username' => $request->username,
                'nama'     => $request->nama,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'status'    => true,
                'message'   => 'Data user berhasil disimpan',
                'redirect' => url('login')
            ]);
        }

        return redirect('login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                session([
                    'profile_img_path' => Auth::user()->foto,
                    'user_id' => Auth::user()->user_id
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
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
