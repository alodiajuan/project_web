<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Compensation;
use App\Models\TaskSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PengajuanController extends Controller
{
    public function index()
    {
        $taskSubmissions = TaskSubmission::with('task.dosen', 'mahasiswa')->whereHas('task', function ($query) {
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

    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "progress" => "required|integer|min:1|max:100"
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $taskSubmission = TaskSubmission::findOrFail($id);
        $progress = $request->progress;

        $taskSubmission->id_dosen = Auth::id();
        $taskSubmission->acc_dosen = 'terima';
        $taskSubmission->progress = $progress;

        if ($taskSubmission->save()) {
            if ($progress == 100) {
                Compensation::create([
                    'id_task' => $taskSubmission->id_task,
                    'id_submission' => $taskSubmission->id,
                    'id_dosen' => $taskSubmission->task->id_dosen,
                    'id_mahasiswa' => $taskSubmission->id_mahasiswa,
                    'bobot' => $taskSubmission->task->bobot,
                    'semester' => $taskSubmission->mahasiswa->semester,
                ]);

                $user = User::findOrFail($taskSubmission->id_mahasiswa);
                $user->update([
                    'alfa' => $user->alfa - $taskSubmission->task->bobot,
                    'compensation' => $user->compensation + $taskSubmission->task->bobot
                ]);
            }

            return back()->with('success', 'Pengumpulan tugas diterima.');
        }

        return back()->with('error', 'Gagal menyimpan pengajuan.');
    }

    public function decline($id)
    {
        $taskSubmission = TaskSubmission::findOrFail($id);
        $taskSubmission->id_dosen = Auth::id();
        $taskSubmission->acc_dosen = 'tolak';
        $taskSubmission->save();
        return back()->with('success', 'Pengumpulan tugas ditolak.');
    }
}
