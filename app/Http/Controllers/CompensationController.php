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
            'title' => 'Daftar Kompetensi',
            'list' => ['Home', 'Kompetensi']
        ];

        $page = (object) [
            'title' => 'Daftar Kompetensi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kompetensi';

        $taskSubmissions = TaskSubmission::with(['task', 'dosen', 'compensations'])
            ->where('id_mahasiswa', Auth::id())
            ->get();

        return view('compensation.index', compact('taskSubmissions', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function show($id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Kompetensi',
            'list' => ['Home', 'Kompetensi', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail dari Kompetensi Tugas'
        ];

        $activeMenu = 'kompetensi';

        $taskSubmission = TaskSubmission::with('task', 'dosen', 'compensations')->findOrFail($id);

        return view('compensation.show', compact('taskSubmission', 'breadcrumb', 'page', 'activeMenu'));
    }
}
