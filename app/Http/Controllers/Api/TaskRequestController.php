<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskRequestController extends Controller
{
    /**
     * terima atau tolak request tugas
     */
    public function submitTaskRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_task' => 'required|exists:task,id',
            'id_mahasiswa' => 'required|exists:users,id',
            'status' => 'required|in:terima,tolak'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $existingRequest = TaskRequest::where('id_task', $request->id_task)
                ->where('id_mahasiswa', $request->id_mahasiswa)
                ->first();

            if ($existingRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task request already submitted'
                ], 400);
            }

            $taskRequest = TaskRequest::create([
                'id_task' => $request->id_task,
                'judul' => $request->input('judul'),
                'deskripsi' => $request->input('deskripsi'),
                'bobot' => $request->input('bobot'),
                'semester' => $request->input('semester'),
                'data' => [
                    'id' => $request->id,
                    'username' => $request->requestname,
                    'foto_profile' => $request->foto_profile ? $baseUrl . '/' . $request->foto_profile : null,
                    'nama' => $request->nama,
                    'semester' => $request->semester,
                    'kompetensi' => $request->competence->nama,
                    'prodi' => $request->prodi->nama,
                ],
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task request submitted successfully',
                'data' => $taskRequest
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit task request',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all task requests (for admin, dosen, tendik)
     */
    public function getAllTaskRequests()
    {
        // Ensure only admin, dosen, or tendik can access
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'dosen', 'tendik'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        try {
            $taskRequests = TaskRequest::with(['task', 'mahasiswa'])
                ->latest()
                ->paginate(10);

            return response()->json([
                'success' => true,
                'message' => 'Task requests retrieved successfully',
                'data' => $taskRequests
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve task requests',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
