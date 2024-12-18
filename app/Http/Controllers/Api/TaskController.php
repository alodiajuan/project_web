<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\TypeTask;

class TaskController extends Controller
{
    /**
     * Create a new task.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only Admin, Dosen, and Tendik can create tasks.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'id_dosen' => 'required|exists:users,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'bobot' => 'required|numeric|min:0|max:100',
            'semester' => 'required|integer|min:1|max:8',
            'jenis' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    if (!isset($value['id']) || !TypeTask::where('id', $value['id'])->exists()) {
                        $fail('Invalid task type');
                    }
                }
            ],
            'tipe' => 'required|in:file,text,link'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $task = Task::create([
                'id_dosen' => $request->input('id_dosen'),
                'judul' => $request->input('judul'),
                'deskripsi' => $request->input('deskripsi'),
                'bobot' => $request->input('bobot'),
                'semester' => $request->input('semester'),
                'id_jenis' => $request->input('jenis')['id'],
                'tipe' => $request->input('tipe')
            ]);

            $task->load(['typeTask']);

            return response()->json([
                'success' => true,
                'message' => 'Task created successfully',
                'data' => $task
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Get all tasks.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Mohon login terlebih dahulu.'
            ], 401);
        }

        try {
            // Ambil semua tasks dengan relasi
            $tasks = Task::with(['typeTask', 'dosen'])
                ->get()
                ->map(function ($task) {
                    return [
                        'id' => $task->id,
                        // 'id_dosen' => $task->id_dosen,
                        'nama_dosen' => $task->dosen->nama ?? null,
                        'judul' => $task->judul,
                        'deskripsi' => $task->deskripsi,
                        'bobot' => $task->bobot,
                        'semester' => $task->semester,
                        'nama_jenis' => $task->typeTask->nama ?? null,
                        'tipe' => $task->tipe,
                        'created_at' => $task->created_at ? $task->created_at->toIso8601String() : null
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $tasks
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar tugas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
