<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    // Mendapatkan semua data prodi
    public function index()
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik', 'mahasiswa'];

        // Cek otorisasi
        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $prodis = Prodi::all();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan semua prodi',
            'data' => $prodis,
        ]);
    }
}
