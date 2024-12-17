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
     * Submit a task request
     */
    public function submitTaskRequest(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'id_task' => 'required|exists:tasks,id',
            'id_mahasiswa' => 'required|exists:users,id',
            'status' => 'required|in:terima,tolak'
        ]);

        // Check validation
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Check if task request already exists
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
     * Approve or reject task request (for admin, dosen, tendik)
     */
    public function processTaskRequest(Request $request)
    {
        // Ensure only admin, dosen, or tendik can process
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'dosen', 'tendik'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'task_request_id' => 'required|exists:task_request,id',
            'action' => 'required|in:approve,reject'
        ]);

        // Check validation
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Find the task request
            $taskRequest = TaskRequest::findOrFail($request->task_request_id);

            // Update task request status based on action
            $taskRequest->status = $request->action === 'terima' ? 'terima' : 'tolak';
            $taskRequest->processed_by = $user->id;
            $taskRequest->save();

            return response()->json([
                'success' => true,
                'message' => 'Task request ' . $request->action . 'd successfully',
                'data' => $taskRequest
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process task request',
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
