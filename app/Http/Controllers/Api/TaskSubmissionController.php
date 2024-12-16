<?php

namespace App\Http\Controllers\Api;

use App\Models\TaskSubmission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskSubmissionController extends Controller
{
    public function store(Request $request)
    {

        $user = Auth::user();
        $allowedRoles = ['admin', 'dosen', 'tendik', 'mahasiswa'];

        if (!$user || !in_array($user->role, $allowedRoles)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only Admin, Dosen, Mahasiswa, and Tendik can create tasks.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'id_task' => 'required|exists:task,id',
            'file' => 'required|file|max:50240',
            'url' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            
            $fileName = 'task_submission_' . time() . '.' . $request->file->extension();
            $filePath = $request->file->storeAs('public/TaskSubmission', $fileName);

            $fileUrl = Storage::url($filePath);


           $taskSubmission = TaskSubmission::create([
                'id_task' => $request->id_task,
                'id_mahasiswa' => Auth::id(),
                'id_dosen' => null, 
                'acc_dosen' => false,
                'file' => $fileUrl,
                'url' => $request->url
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task submission created successfully',
                'data' => $taskSubmission
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task submission',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
