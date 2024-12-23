<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskRequest;
use App\Models\TypeTask;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TugasController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Tugas',
            'list' => ['Home', 'Tugas']
        ];

        $page = (object) [
            'title' => 'Daftar tugas yang terdaftar dalam sistem'
        ];

        $activeMenu = 'tugas';

        $tasks = Task::where('id_dosen', Auth::id())->get();

        return view('tugas.index', compact('breadcrumb', 'page', 'tasks', 'activeMenu'));
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Tugas',
            'list' => ['Home', 'Tugas', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Form Tambah Tugas'
        ];

        $activeMenu = 'tugas';

        $jenis_tasks = TypeTask::all();
        $periods = Periode::all();

        return view('tugas.create', compact('breadcrumb', 'page', 'jenis_tasks', 'activeMenu', 'periods'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'bobot' => 'required|integer|min:1',
            'kuota' => 'required|integer|min:1',
            'semester' => 'required|integer|min:1|max:8',
            'id_jenis' => 'required|exists:type_task,id',
            'tipe' => 'required|in:file,url',
            'deadline' => 'required|date|after:today',
            'file' => 'nullable|file',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'id_dosen' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'bobot' => $request->bobot,
            'kuota' => $request->kuota,
            'semester' => $request->semester,
            'id_jenis' => $request->id_jenis,
            'tipe' => $request->tipe,
            'url' => $request->url,
            'deadline' => $request->deadline,
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('file'), $fileName);
            $data['file'] = 'file/' . $fileName;
        }

        Task::create($data);

        return redirect('/tugas')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Tugas',
            'list' => ['Home', 'Tugas', 'Edit']
        ];

        $page = (object) [
            'title' => 'Form Edit Tugas'
        ];

        $activeMenu = 'tugas';

        $task = Task::where('id', $id)->where('id_dosen', Auth::id())->firstOrFail();
        $jenis_tasks = TypeTask::all();
        $periods = Periode::all();

        return view('tugas.edit', compact('breadcrumb', 'page', 'task', 'jenis_tasks', 'activeMenu', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::where('id', $id)->where('id_dosen', Auth::id())->firstOrFail();

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'bobot' => 'required|integer|min:1',
            'kuota' => 'required|integer|min:1',
            'semester' => 'required|integer|min:1|max:8',
            'id_jenis' => 'required|exists:type_task,id',
            'tipe' => 'required|in:file,url',
            'deadline' => 'required|date|after:today',
            'file' => 'nullable|file',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'bobot' => $request->bobot,
            'kuota' => $request->kuota,
            'semester' => $request->semester,
            'id_jenis' => $request->id_jenis,
            'tipe' => $request->tipe,
            'url' => $request->url,
            'deadline' => $request->deadline,
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('file'), $fileName);
            $data['file'] = 'file/' . $fileName;
            unlink($task->file);
        }

        $task->update($data);

        return redirect('/tugas')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $task = Task::where('id', $id)->where('id_dosen', Auth::id())->firstOrFail();

        $task->delete();

        return redirect('/tugas')->with('success', 'Tugas berhasil dihapus.');
    }

    public function show($id)
    {
        $task = Task::where('id', $id)
            ->where('id_dosen', Auth::id())
            ->firstOrFail();

        $requests = TaskRequest::where('id_task', $task->id)
            ->with(['user', 'user.prodi', 'user.competence'])
            ->get();

        $breadcrumb = (object) [
            'title' => 'Detail Tugas',
            'list' => ['Home', 'Tugas', 'Detail']
        ];

        $activeMenu = "tugas";

        $page = (object) [
            'title' => 'Detail Tugas'
        ];

        return view('tugas.show', compact('breadcrumb', 'page', 'task', 'activeMenu', 'requests'));
    }

    public function approvedRequest($id)
    {
        $taskRequest = TaskRequest::findOrFail($id);
        $taskRequest->update(['status' => 'terima']);

        return redirect()->back()->with('success', 'Request telah diterima.');
    }

    public function declineRequest($id)
    {
        $taskRequest = TaskRequest::findOrFail($id);
        $taskRequest->update(['status' => 'tolak']);

        return redirect()->back()->with('success', 'Request telah ditolak.');
    }
}
