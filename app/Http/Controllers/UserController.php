<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function mahasiswa(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'mahasiswa';

        $prodi_id = $request->input('prodi_id');

        $mahasiswaQuery = User::with('prodi')->where('role', 'mahasiswa');

        if ($prodi_id) {
            $mahasiswaQuery->where('id_prodi', $prodi_id);
        }

        $mahasiswa = $mahasiswaQuery->get();

        $prodi = Prodi::all();

        return view('mahasiswa.index', compact('mahasiswa', 'prodi', 'breadcrumb', 'activeMenu'));
    }
}
