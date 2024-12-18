<?php

namespace App\Http\Controllers;

use App\Models\Compensation;
use App\Models\Task;
use App\Models\TaskRequest;
use App\Models\TaskSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        $user = Auth::user();

        if ($user->role == "admin") {
            $userCount = User::count();
            $requestCount = TaskRequest::whereHas('task', function ($query) use ($user) {
                $query->where('id_dosen', $user->id);
            })
                ->whereNull('status')
                ->count();
            $compensationCount = Compensation::count();
            $dataDashboard = [
                "primary" => [$userCount, "Users"],
                "second" => [$requestCount, "Requests"],
                "three" => [$compensationCount, "Compensations"]
            ];
        } else if ($user->role == "dosen" || $user->role == "tendik") {
            $taskCount = Task::where('id_dosen', $user->id)->count();
            $requestCount = TaskRequest::whereHas('task', function ($query) use ($user) {
                $query->where('id_dosen', $user->id);
            })
                ->whereNull('status')
                ->count();

            $submissionCount = TaskSubmission::whereHas('task', function ($query) use ($user) {
                $query->where('id_dosen', $user->id);
            })
                ->count();
            $dataDashboard = [
                "primary" => [$taskCount, "Tasks"],
                "second" => [$requestCount, "Requests"],
                "three" => [$submissionCount, "Submissions"]
            ];
        } else {
            $taskCount = Task::whereDoesntHave('taskSubmissions', function ($query) use ($user) {
                $query->where('id_mahasiswa', $user->id);
            })->count();
            $requestCount = TaskRequest::where('id_mahasiswa', $user->id)
                ->whereNull('status')
                ->count();
            $dataDashboard = [
                "primary" => [$taskCount, "Tasks"],
                "second" => [$requestCount, "Requests"],
                "three" => [$user->compensation - $user->alfa, "Compensations"]
            ];

            $tasks = Task::with(['dosen', 'taskSubmissions' => function ($query) {
                $query->where('id_mahasiswa', Auth::id())
                    ->where('progress', '<', 100);
            }])
                ->whereHas('taskSubmissions', function ($query) {
                    $query->where('id_mahasiswa', Auth::id())
                        ->where('progress', '<', 100);
                })
                ->get()->map(function ($task) {
                    $taskHasCompletedSubmission = $task->taskSubmissions->contains(function ($submission) {
                        return $submission->progress === 100;
                    });

                    if ($taskHasCompletedSubmission) {
                        return null;
                    }

                    $highestProgressSubmission = $task->taskSubmissions->sortByDesc('progress')->first();

                    return tap($task, function ($task) use ($highestProgressSubmission) {
                        if ($highestProgressSubmission) {
                            $task->highestProgressSubmission = $highestProgressSubmission;
                        }
                    });
                })->filter();

            return view('dashboard.index', [
                'breadcrumb' => $breadcrumb,
                'activeMenu' => $activeMenu,
                'data' => $dataDashboard,
                'tasks' => $tasks
            ]);
        }

        return view('dashboard.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, "data" => $dataDashboard]);
    }
}
