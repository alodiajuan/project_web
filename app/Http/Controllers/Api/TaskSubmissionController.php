<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\TaskSubmission;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class TaskSubmissionController extends Controller
{
    // Mendapatkan semua data pengumpulan tugas berdasarkan id tugas
    public function getSubmissionsByTaskId($id)
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik', 'mahasiswa'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['status' => false, 'message' => 'Task not found'], 404);
        }

        $submissions = TaskSubmission::with('dosen') // relasi
            ->where('id_task', $id)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data pengumpulan tugas',
            'data' => [
                'available' => $submissions->isNotEmpty(),
                'submissions' => $submissions->map(function ($submission) use ($task) {
                    return [
                        'id' => $submission->id,
                        'judul' => $task->judul,
                        'deskripsi' => $task->deskripsi,
                        'dosen' => $submission->dosen ? $submission->dosen->nama : 'Unknown',
                        'status' => $submission->acc_dosen ? 'terima' : null,
                        'progress' => $submission->acc_dosen ? 100 : null,
                        'tipe' => $submission->tipe,
                        'file' => $submission->file,
                        'url' => $submission->url,
                    ];
                }),
            ],
        ]);
    }

    // Mendapatkan semua data pengumpulan tugas untuk SDM
    public function getSubmissionsForSdm()
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $submissions = TaskSubmission::with('task', 'mahasiswa')->get();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data pengumpulan tugas',
            'data' => $submissions->map(function ($submission) {
                return [
                    'id' => $submission->id,
                    'judul' => $submission->task->judul,
                    'deskripsi' => $submission->task->deskripsi,
                    'mahasiswa' => $submission->mahasiswa->nama,
                    'tipe' => $submission->tipe,
                    'file' => $submission->file,
                    'url' => $submission->url,
                ];
            }),
        ]);
    }

    //   ngumpulin tugas
    public function store(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = Auth::user();
        $allowedRoles = ['mahasiswa'];

        // Cek apakah pengguna terautentikasi dan memiliki peran yang sesuai
        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_task' => 'required|exists:task,id',  // Pastikan id_task valid
            'id_mahasiswa' => 'required|exists:mahasiswa,id',  // Pastikan mahasiswa valid
            'submission' => 'required|in:file,url',  // Pastikan submission adalah 'file' atau 'url'
            'file' => 'required_if:submission,file|file',  // Validasi file jika submission adalah 'file'
            'url' => 'required_if:submission,url|url',  // Validasi url jika submission adalah 'url'
        ]);

        // Jika validasi gagal, kirimkan error dengan pesan yang sesuai
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Inisialisasi variabel untuk menyimpan path file
        $filePath = null;

        // Proses file jika submission adalah 'file'
        if ($request->submission === 'file' && $request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . str_replace(' ', '-', $file->getClientOriginalName());

            // Pindahkan file ke folder public/file
            if ($file->move(public_path('file'), $fileName)) {
                $filePath = 'file/' . $fileName;  // Simpan path file
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to upload file'
                ], 500);
            }
        }

        // Simpan data submission tugas
        try {
            TaskSubmission::create([
                'id_task' => $request->id_task,
                'id_mahasiswa' => $user->id,
                'id_dosen' => null,  // Asumsikan dosen belum ada pada saat submit
                'acc_dosen' => null,  // Status acc_dosen masih null
                'progress' => 0,  // Progress di-set 0 pada saat tugas baru di-submit
                'file' => $filePath,  // Simpan path file, jika ada
                'url' => $request->submission === 'url' ? $request->url : null,  // Simpan URL, jika submission adalah 'url'
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Tugas berhasil dikumpulkan'
            ], 201);
        } catch (\Exception $e) {
            // Tangani jika ada error dalam penyimpanan data
            return response()->json([
                'status' => false,
                'message' => 'Failed to create task submission',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Review Submission
    public function reviewSubmission(Request $request, $id)
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'nilai' => 'nullable|numeric',
            'status' => 'required|string|in:terima,tolak',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation error', 'errors' => $validator->errors()], 400);
        }

        $submission = TaskSubmission::find($id);

        if (!$submission) {
            return response()->json(['status' => false, 'message' => 'Submission not found'], 404);
        }

        $submission->update([
            'acc_dosen' => $request->status === 'terima',
            'nilai' => $request->nilai,
        ]);

        return response()->json(['status' => true, 'message' => 'Berhasil review pengumpulan tugas'], 200);
    }

    // Mendapatkan data pengumpulan tugas berdasarkan id
    public function getSubmissionById($id)
    {
        $submission = TaskSubmission::with('task', 'mahasiswa')->find($id);

        if (!$submission) {
            return response()->json(['status' => false, 'message' => 'Submission not found'], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data pengumpulan tugas',
            'data' => [
                'id' => $submission->id,
                'judul' => $submission->task->judul,
                'mahasiswa' => $submission->mahasiswa->nama,
                'kompetensi' => $submission->task->kompetensi,
                'tipe' => $submission->tipe,
                'file' => $submission->file,
                'url' => $submission->url,
            ],
        ]);
    }
}
