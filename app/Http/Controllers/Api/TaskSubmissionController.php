<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\TaskSubmission;
use App\Models\Task;
use App\Models\TaskRequest;
use Illuminate\Support\Facades\Storage;

class TaskSubmissionController extends Controller
{
    public function taskSubmissions()
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik', 'mahasiswa'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $submissions = TaskSubmission::with('task.dosen', 'mahasiswa')
            ->whereNull('acc_dosen')->orWhereNull('id_dosen')
            ->whereHas('task', function ($query) {
                $query->where('id_dosen', Auth::id());
            })->get();
        // dd($submissions);
        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data pengumpulan tugas',
            'data' => $submissions->map(function ($submission) {
                return [
                    'id' => $submission->id,
                    'judul' => $submission->task->judul,
                    'deskripsi' => $submission->task->deskripsi,
                    'mahasiswa' => $submission->mahasiswa->nama,
                    'tipe' => $submission->task->tipe,
                    'file' => url(rawurlencode($submission->file)),
                    'url' => $submission->url,
                ];
            }),
        ]);
    }

    public function approveSubmission(Request $request, $id)
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'nilai' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation error', 'errors' => $validator->errors()], 400);
        }

        $submission = TaskSubmission::find($id);

        if (!$submission) {
            return response()->json(['status' => false, 'message' => 'Submission not found'], 404);
        }

        $submission->update([
            'id_dosen' => $user->id,
            'acc_dosen' => "terima",
            'progress' => $request->nilai,
        ]);

        return response()->json(['status' => true, 'message' => 'Berhasil menyetujui pengumpulan tugas'], 200);
    }

    public function declineSubmission(Request $request, $id)
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $submission = TaskSubmission::find($id);

        if (!$submission) {
            return response()->json(['status' => false, 'message' => 'Submission not found'], 404);
        }

        $submission->update([
            'id_dosen' => $user->id,
            'acc_dosen' => "tolak",
        ]);

        return response()->json(['status' => true, 'message' => 'Berhasil menolak pengumpulan tugas'], 200);
    }

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

        $submissions = TaskSubmission::where('id_task', $id)->get();

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

    // Submission Task
    public function store(Request $request)
    {
        $user = Auth::user();
        $allowedRoles = ['mahasiswa'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'id_task' => 'required|exists:task,id',
            'submission' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation error', 'errors' => $validator->errors()], 400);
        }

        try {
            $filePath = null;
            if ($request->hasFile('file')) {

                $originalFileName = $request->file('file')->getClientOriginalName();
                $fileName = $user->id . '-' . time() . '-' . str_replace(' ', '-', $originalFileName);

                // Store file in the 'public' disk
                $filePath = $request->file('file')->storeAs('TaskSubmission', $fileName, 'public');
            }

            // Construct the full URL for the file
            $fileUrl = $filePath ? url(Storage::url($filePath)) : null;

            TaskSubmission::create([
                'id_task' => $request->id_task,
                'id_mahasiswa' => $user->id,
                'id_dosen' => null,
                'acc_dosen' => null,
                'file' => $fileUrl,
                'url' => $request->submission,
            ]);

            return response()->json(['status' => true, 'message' => 'Berhasil mengumpulkan tugas'], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to create task submission', 'error' => $e->getMessage()], 500);
        }
    }

    // Review Submission
    public function reviewSubmission(Request $request, $id)
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen'];

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

    // Request Task
    public function requestTask($id)
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik', 'mahasiswa'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $tasks = TaskRequest::where('id_task', $id)->whereNull('status')
            ->with(['user', 'user.prodi', 'user.competence'])
            ->get();

        // Menyiapkan data response dalam bentuk collection
        $responseData = [
            'status' => true,
            'message' => 'Berhasil mendapatkan data pengajuan pengerjaan tugas',
            'data' => $tasks->map(function ($task) {
                return [
                    'id' => $task->id,
                    'nama' => $task->user->nama,
                    'nama_kompetensi' => $task->user->competence->nama
                ];
            })
        ];

        return response()->json($responseData, 200);
    }

    public function approveRequest($id)
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $task = TaskRequest::find($id);

        if (!$task) {
            return response()->json(['status' => false, 'message' => 'Task not found'], 404);
        }

        $task->update([
            'status' => 'terima'
        ]);

        return response()->json(['status' => true, 'message' => 'Berhasil menyetujui pengajuan pengerjaan tugas'], 200);
    }

    public function declineRequest($id)
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $task = TaskRequest::find($id);

        if (!$task) {
            return response()->json(['status' => false, 'message' => 'Task not found'], 404);
        }

        $task->update([
            'status' => 'tolak'
        ]);

        return response()->json(['status' => true, 'message' => 'Berhasil menolak pengajuan pengerjaan tugas'], 200);
    }
}
