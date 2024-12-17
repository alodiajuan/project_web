<?php

namespace App\Http\Controllers;

use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompensationController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kompensasi',
            'list' => ['Home', 'Kompensasi']
        ];

        $page = (object) [
            'title' => 'Daftar Kompensasi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kompensasi';

        $taskSubmissions = TaskSubmission::with(['task.dosen', 'compensations'])
            ->where('id_mahasiswa', Auth::id())
            ->get();

        return view('compensation.index', compact('taskSubmissions', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function show($id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Kompensasi',
            'list' => ['Home', 'Kompensasi', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail dari Kompensasi Tugas'
        ];

        $activeMenu = 'kompensasi';

        $taskSubmission = TaskSubmission::with('task.dosen', 'compensations')->findOrFail($id);

        return view('compensation.show', compact('taskSubmission', 'breadcrumb', 'page', 'activeMenu'));
    }
}
