<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function index()
    {
        $taskSubmissions = TaskSubmission::with('task.dosen', 'mahasiswa')->whereHas('task', function($query) {
            $query->where('id_dosen', Auth::id());
        })->get();

        $breadcrumb = (object) [
            'title' => 'Daftar Pengajuan Tugas',
            'list' => ['Home', 'Pengajuan Tugas']
        ];

        $page = (object) [
            'title' => 'Daftar Pengumpulan Tugas yang diajukan oleh mahasiswa'
        ];

        $activeMenu = 'pengajuan';

        return view('pengajuan.index', compact('taskSubmissions', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function show($id)
    {
        $taskSubmission = TaskSubmission::with('task', 'mahasiswa.competence')->findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Detail Pengajuan Tugas',
            'list' => ['Home', 'Pengajuan Tugas', 'Detail Pengajuan']
        ];

        $page = (object) [
            'title' => 'Detail Pengumpulan Tugas'
        ];

        $activeMenu = 'pengajuan';

        return view('pengajuan.show', compact('taskSubmission', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function approve($id)
    {
        $taskSubmission = TaskSubmission::findOrFail($id);
        $taskSubmission->acc_dosen = 'terima';
        $taskSubmission->save();
        return back()->with('success', 'Pengumpulan tugas diterima.');
    }

    public function decline($id)
    {
        $taskSubmission = TaskSubmission::findOrFail($id);
        $taskSubmission->acc_dosen = 'tolak';
        $taskSubmission->save();
        return back()->with('success', 'Pengumpulan tugas ditolak.');
    }
}
