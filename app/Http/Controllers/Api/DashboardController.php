<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use App\Models\TaskRequest;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function StudentDashboard(Request $request)
    {
        try {
            $user = Auth::user();
            $allowedRoles = ['mahasiswa'];

            // Validasi otorisasi
            if (!$user || !in_array($user->role, $allowedRoles)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal otorisasi'
                ], 403);
            }

            $totalTasks = Task::count();
            $totalRequests = TaskRequest::where('id_mahasiswa', $user->id)->count();
            $totalCompensations = TaskSubmission::where('id_mahasiswa', $user->id)->count();

            // Mengambil progress tugas mahasiswa
            $progress = Task::with(['taskSubmissions' => function ($query) use ($user) {
                $query->where('id_mahasiswa', $user->id);
            }, 'dosen'])
                ->get()
                ->map(function ($task) {
                    $submission = $task->taskSubmissions->first();

                    return [
                        'id' => $task->id,
                        'judul' => $task->judul,
                        'dosen' => $task->dosen->nama,
                        'status' => $submission ? $submission->acc_dosen : null,
                        'progress' => $submission ? $submission->progress : null,
                        'tipe' => $task->tipe,
                        'file' => $task->file ? route('download.task', ['filename' => urlencode($task->file)]) : null,
                        'url' => $task->url
                    ];
                });

            return response()->json([
                'status' => true,
                'message' => 'Mendapatkan data dashboard mahasiswa berhasil',
                'data' => [
                    'total_tasks' => $totalTasks,
                    'total_requests' => $totalRequests,
                    'total_compensations' => $totalCompensations,
                    'progress' => $progress
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error in student dashboard', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data dashboard',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function SdmDashboard(Request $request)
    {
        try {
            $user = auth()->user();

            $totalTasks = Task::where('id_dosen', $user->id)->count();
            $totalRequests = TaskRequest::whereHas('task', function ($query) use ($user) {
                $query->where('id_dosen', $user->id);
            })->count();
            $totalSubmissions = TaskSubmission::where('id_dosen', $user->id)->count();

            return response()->json([
                'status' => true,
                'message' => 'Mendapatkan data dashboard sdm berhasil',
                'data' => [
                    'total_tasks' => $totalTasks,
                    'total_requests' => $totalRequests,
                    'total_submissions' => $totalSubmissions
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error in staff dashboard', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data dashboard',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
