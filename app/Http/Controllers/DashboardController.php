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
            $totalBobot = Compensation::where('id_mahasiswa', $user->id)
                ->join('task', 'compensation.id_task', '=', 'task.id') // Bergabung dengan tabel task
                ->sum('task.bobot');
            $dataDashboard = [
                "primary" => [$taskCount, "Tasks"],
                "second" => [$requestCount, "Requests"],
                "three" => [$totalBobot, "Compensations"]
            ];
        }

        return view('dashboard.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, "data" => $dataDashboard]);
    }
}
