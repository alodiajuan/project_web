<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\TypeTask;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


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
                'status' => false,
                'message' => 'Unauthorized. Only Admin, Dosen, and Tendik can create tasks.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'bobot' => 'required|numeric|min:0|max:100',
            'semester' => 'required|integer|min:1|max:8',
            'kuota' => 'required|integer|min:1',
            'file' => 'nullable|file|max:5024',
            'url' => 'required|url',
            'id_jenis' => 'required|exists:type_task,id',
            'tipe' => 'required|in:file,text,link',
            'deadline' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $filePath = null;
            if ($request->hasFile('file')) {

                $originalFileName = $request->file('file')->getClientOriginalName();
                $fileName = $user->id . '-' . time() . '-' . str_replace(' ', '-', $originalFileName);

                // Store file in the 'public' disk
                $filePath = $request->file('file')->storeAs('task', $fileName, 'public');
            }

            // Construct the full URL for the file
            $fileUrl = $filePath ? url(Storage::url($filePath)) : null;

            // Create the task
            $task = Task::create([
                'id_dosen' => $user->id,
                'judul' => $request->input('judul'),
                'deskripsi' => $request->input('deskripsi'),
                'bobot' => $request->input('bobot'),
                'semester' => $request->input('semester'),
                'kuota' => $request->input('kuota'),
                'file' => $fileUrl,
                'url' => $request->input('url'),
                'id_jenis' => $request->input('id_jenis'),
                'tipe' => $request->input('tipe'),
                'deadline' => $request->input('deadline')
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil membuat tugas baru',
                'data' => [
                    'id' => $task->id,
                    'judul' => $task->judul,
                    'deskripsi' => $task->deskripsi,
                    'bobot' => $task->bobot,
                    'semester' => $task->semester,
                    'kuota' => $task->kuota,
                    'file' => $task->file,
                    'url' => $task->url,
                    'id_jenis' => $task->id_jenis,
                    'tipe' => $task->tipe,
                    'deadline' => $task->deadline,
                    'created_at' => $task->created_at,
                    'updated_at' => $task->updated_at,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat tugas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all tasks for students.
     */
    public function getTasksForStudent()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Mohon login terlebih dahulu.'
            ], 401);
        }

        try {
            // Ambil semua tugas berdasarkan semester mahasiswa
            $tasks = Task::with(['dosen', 'TypeTask'])
                ->where('semester', $user->semester)
                ->get()
                ->map(function ($task) {
                    return [
                        'id' => $task->id,
                        'dosen' => $task->dosen->nama ?? 'Unknown',
                        'judul' => $task->judul,
                        'deskripsi' => $task->deskripsi,
                        'bobot' => $task->bobot,
                        'periode' => '2023/2024',
                        'jenis' => $task->TypeTask->nama ?? 'Unknown',
                        'status' => 'belum',
                        'file' => $task->file,
                        'url' => $task->url,
                        'tipe' => $task->tipe,
                        'deadline' => '07:30 12 Desember 2024'
                    ];
                });

            return response()->json([
                'status' => true,
                'message' => 'Berhasil mendapatkan semua tugas',
                'data' => $tasks
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                ' message' => 'Gagal mendapatkan tugas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all tasks for SDM.
     */
    public function getTasksForSdm()
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Hanya Admin, Dosen, dan Tendik yang dapat mengakses tugas.'
            ], 403);
        }

        try {
            // Ambil semua tugas berdasarkan id_dosen
            $tasks = Task::with(['dosen', 'typeTask'])
                ->where('id_dosen', $user->id)
                ->get()
                ->map(function ($task) {
                    return [
                        'id' => $task->id,
                        'dosen' => $task->dosen->nama ?? 'Unknown',
                        'judul' => $task->judul,
                        'deskripsi' => $task->deskripsi,
                        'bobot' => $task->bobot,
                        'periode' => '2023/2024',
                        'jenis' => $task->typeTask->nama ?? 'Unknown',
                        'status' => 'terima',
                        'file' => $task->file,
                        'url' => $task->url,
                        'tipe' => $task->tipe,
                        'deadline' => Carbon::parse($task->deadline)->format('H:i d F Y')
                    ];
                });

            return response()->json([
                'status' => true,
                'message' => 'Berhasil mendapatkan semua tugas',
                'data' => $tasks
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mendapatkan tugas untuk SDM',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a task.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik'];

        // dd($request->all());
        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Hanya Admin, Dosen, dan Tendik yang dapat memperbarui tugas.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'id_task' => 'sometimes|required|exists:task,id',
            'judul' => 'sometimes|required|string|max:255',
            'deskripsi' => 'sometimes|required|string',
            'bobot' => 'sometimes|required|numeric|min:0|max:100',
            'semester' => 'sometimes|required|integer|min:1|max:8',
            'kuota' => 'sometimes|required|integer|min:1',
            'file' => 'sometimes|nullable|file',
            'url' => 'sometimes|required|url',
            'id_jenis' => 'sometimes|required|exists:type_task,id',
            'tipe' => 'sometimes|required|in:file,text,link'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $task = Task::findOrFail($request->input('id_task'));
            if ($request->has('judul')) $task->judul = $request->input('judul');
            if ($request->has('deskripsi')) $task->deskripsi = $request->input('deskripsi');
            if ($request->has('bobot')) $task->bobot = $request->input('bobot');
            if ($request->has('semester')) $task->semester = $request->input('semester');
            if ($request->has('kuota')) $task->kuota = $request->input('kuota');
            if ($request->hasFile('file')) {
                $originalFileName = $request->file('file')->getClientOriginalName();
                $fileName = $user->id . '-' . time() . '-' . str_replace(' ', '-', $originalFileName);
                $filePath = $request->file('file')->storeAs('task', $fileName, 'public');
                $task->file = url(Storage::url($filePath));
            }
            if ($request->has('url')) $task->url = $request->input('url');
            if ($request->has('id_jenis')) $task->id_jenis = $request->input('id_jenis');
            if ($request->has('tipe')) $task->tipe = $request->input('tipe');

            $task->save();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil memperbarui tugas'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui tugas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a task by ID.
     */
    public function getTaskById($id)
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

        try {
            Log::info('Mencari task dengan ID: ' . $id);

            // Mengambil task berdasarkan ID
            $task = Task::with(['dosen', 'typeTask'])->find($id);

            // Cek apakah task ditemukan
            if (!$task) {
                Log::warning('Tugas tidak ditemukan untuk ID: ' . $id);
                return response()->json([
                    'status' => false,
                    'message' => 'Tugas tidak ditemukan',
                    'error' => 'No query results for model [App\\Models\\Task] {id}'
                ], 404);
            }

            $status = null;

            if ($user->role === 'admin' || $user->role === 'dosen' || $user->role === 'tendik') {
                $status = $task->status ?? 'terima';
            } elseif ($user->role === 'mahasiswa') {
                $status = null;
            }

            // Data untuk respons
            $responseData = [
                'id' => $task->id,
                'dosen' => $task->dosen->nama ?? 'Unknown',
                'judul' => $task->judul,
                'deskripsi' => $task->deskripsi,
                'bobot' => $task->bobot,
                'periode' => '2023/2024',
                'semester' => $task->semester,
                'jenis' => $task->typeTask->nama ?? 'Unknown',
                'id_jenis' => $task->id_jenis,
                'status' => $status,
                'file' => $task->file,
                'url' => $task->url,
                'tipe' => $task->tipe,
                'deadline' => Carbon::parse($task->deadline)->translatedFormat('H:i d F Y'),
            ];

            return response()->json([
                'status' => true,
                'message' => 'Berhasil mendapatkan tugas berdasarkan id',
                'data' => [$responseData]
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal mendapatkan tugas: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Gagal mendapatkan tugas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
