<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskRequest;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Tugas',
            'list' => ['Home', 'Tugas']
        ];

        $page = (object) [
            'title' => 'Daftar Tugas yang terdaftar dalam sistem'
        ];

        $activeMenu = 'request';

        $tasks = Task::whereDoesntHave('compensations')
            ->orWhereHas('compensations')
            ->get();

        $tasks = $tasks->filter(function ($task) {
            $taskRequest = $task->taskRequests()
                ->where('id_mahasiswa', Auth::id())
                ->where('status', 'terima')
                ->first();

            if ($taskRequest) {
                $task->isRequested = $taskRequest;
                return $task;
            }

            return null;
        });

        return view('tasks.index', compact('tasks', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function tugas()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Tugas',
            'list' => ['Home', 'Tugas']
        ];

        $page = (object) [
            'title' => 'Daftar Tugas yang terdaftar dalam sistem'
        ];

        $activeMenu = 'tasks';

        $tasks = Task::whereDoesntHave('compensations')
            ->get();

        $tasks = $tasks->map(function ($task) {
            $taskRequest = $task->taskRequests()
                ->where('id_mahasiswa', Auth::id())
                ->where(function ($query) {
                    $query->where('status', 'tolak')
                        ->orWhereNull('status');
                })
                ->first();
            if (!$task->taskRequests->where('id_mahasiswa', Auth::id())->count() || $taskRequest) {
                $task->isRequested = $taskRequest;
                return $task;
            }

            return null;
        })->filter();

        return view('tasks.tugas', compact('tasks', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function detail($id)
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Tugas',
            'list' => ['Home', 'Tugas']
        ];

        $page = (object) [
            'title' => 'Daftar Tugas yang terdaftar dalam sistem'
        ];

        $activeMenu = 'tasks';

        $task = Task::with('dosen', 'periode')->findOrFail($id);

        $request = $task->taskRequests()
            ->where('id_mahasiswa', Auth::id())
            ->first();

        if ($request) {
            $task->isRequested = true;
            $task->requestStatus = $request->status;
        } else {
            $task->isRequested = false;
            $task->requestStatus = null;
        }

        return view('tasks.detail', compact('task', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function show($id)
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Tugas',
            'list' => ['Home', 'Tugas']
        ];

        $page = (object) [
            'title' => 'Daftar Tugas yang terdaftar dalam sistem'
        ];

        $activeMenu = 'request';

        $task = Task::with('dosen', 'periode')->findOrFail($id);
        $submissions = TaskSubmission::where('id_task', $task->id)
            ->where('id_mahasiswa', Auth::id())
            ->get();

        $available = true;

        foreach ($submissions as $submission) {
            if ($submission->progress === 100) {
                $available = false;
                break;
            }
        }

        $request = $task->taskRequests()
            ->where('id_mahasiswa', Auth::id())
            ->first();

        if ($request) {
            $task->isRequested = true;
            $task->requestStatus = $request->status;
        } else {
            $task->isRequested = false;
            $task->requestStatus = null;
        }

        return view('tasks.show', compact('task', 'submissions', 'available', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_task' => 'required|exists:task,id',
            'file' => 'nullable|file',
            'url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $task = Task::findOrFail($request->id_task);

        $data = [
            'id_task' => $request->id_task,
            'id_mahasiswa' => Auth::id(),
        ];

        if ($task->tipe == 'file' && $request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('submissions'), $fileName);
            $data['file'] = 'submissions/' . $fileName;
        } elseif ($task->tipe == 'url' && $request->url) {
            $data['url'] = $request->url;
        }

        TaskSubmission::create($data);

        return redirect()->back()->with('success', 'Tugas berhasil disubmit!');
    }

    public function request($id)
    {
        $task = Task::findOrFail($id);

        $existingRequest = TaskRequest::where('id_task', $task->id)
            ->where('id_mahasiswa', Auth::id())
            ->first();

        if ($existingRequest) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan permintaan untuk tugas ini.');
        }

        TaskRequest::create([
            'id_task' => $task->id,
            'id_mahasiswa' => Auth::id(),
            'status' => null,
        ]);

        return redirect()->back()->with('success', 'Permintaan tugas berhasil diajukan!');
    }
}
