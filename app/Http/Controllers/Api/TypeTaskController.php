<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TypeTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeTaskController extends Controller
{
    // Mendapatkan semua data jenis tugas
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

        $typeTasks = TypeTask::all();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan semua jenis tugas',
            'data' => $typeTasks,
        ]);
    }
}
