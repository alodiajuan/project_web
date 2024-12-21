<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compensation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompensationController extends Controller
{
    // Mendapatkan semua data kompensasi
    public function index()
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik', 'mahasiswa'];

        // Cek otorisasi
        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Hanya pengguna yang berwenang yang dapat mengakses tugas.'
            ], 403);
        }

        $compensations = Compensation::with(['dosen', 'mahasiswa', 'task'])->get();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data kompensasi',
            'data' => $compensations->map(function ($compensation) {
                return [
                    'id' => $compensation->id,
                    'dosen' => $compensation->dosen->nama,
                    'mahasiswa' => $compensation->mahasiswa->nama,
                    'judul_tugas' => $compensation->task->judul,
                    'bobot' => $compensation->bobot,
                    'periode' => $compensation->semester,
                    'file' => url("compensations/{$compensation->id}"),
                ];
            }),
        ]);
    }

    // Mendapatkan data kompensasi berdasarkan ID
    public function show($id)
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik', 'mahasiswa'];

        // Cek otorisasi
        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Hanya pengguna yang berwenang yang dapat mengakses tugas.'
            ], 403);
        }

        $compensation = Compensation::with(['dosen', 'mahasiswa', 'task'])->find($id);

        if (!$compensation) {
            return response()->json(['status' => false, 'message' => 'Compensation not found'], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data kompensasi berdasarkan id',
            'data' => [
                'id' => $compensation->id,
                'dosen' => $compensation->dosen->nama,
                'mahasiswa' => $compensation->mahasiswa->nama,
                'judul_tugas' => $compensation->task->judul,
                'bobot' => $compensation->bobot,
                'periode' => $compensation->periode,
                'file' => url("compensations/{$compensation->id}"),
            ],
        ]);
    }
}
