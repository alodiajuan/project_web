<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }

        // dd(csrf_token());
        // dd($request->all());

        return redirect()->back()->withErrors(['error' => 'Invalid Email or Password.']);;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('success', 'You have been logged out.');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Excel::import(new UsersImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data berhasil diimport!');
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data. Silakan coba lagi.');
        }
    }

    public function export(Request $request)
    {
        try {
            $role = $request->get('role', 'mahasiswa');

            if ($role == 'mahasiswa') {
                $users = User::with(['competence', 'prodi'])
                    ->where('role', 'mahasiswa')
                    ->get();
            } else {
                $users = User::with(['competence', 'prodi'])
                    ->whereIn('role', ['admin', 'dosen', 'tendik'])
                    ->get();
            }

            return Excel::download(new UsersExport($users), 'users.xlsx');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengekspor data. Silakan coba lagi.');
        }
    }
}
