<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetenceController extends Controller
{
    // Mendapatkan semua data kompetensi
    public function index()
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik', 'mahasiswa'];

        // Cek otorisasi
        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 403);
        }

        $competences = Competence::all();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan semua kompetensi',
            'data' => $competences,
        ]);
    }
}
