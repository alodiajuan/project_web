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
     * meminta request tugas dari daftar tugas yang ada
     */
    public function submitTaskRequest(Request $request)
    {
        $user = Auth::user();
        $allowedRoles = ['mahasiswa'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

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

            // Create the task request
            $taskRequest = TaskRequest::create([
                'id_task' => $request->id_task,
                'id_mahasiswa' => $request->id_mahasiswa,
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
     * Get all data task requests
     */
    public function getAllTaskRequests()
    {

        $user = Auth::user();
        $allowedRoles = ['mahasiswa', 'dosen', 'admin', 'tendik'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            // relasi dosen, jenis tugas, dan taskRequests
            $tasks = Task::with(['dosen', 'typeTask', 'taskRequests' => function ($query) {
                $query->where('status', 'terima');
            }])
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Tasks retrieved successfully',
                'data' => $tasks
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve tasks',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
