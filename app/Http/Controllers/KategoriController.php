<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TypeTask;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Kategori Tugas',
            'list' => ['Home', 'Kategori Tugas']
        ];
        $page = (object)[
            'title' => 'Daftar kategori tugas yang terdaftar dalam sistem'
        ];
        $activeMenu = 'kategori-tugas';

        $typeTasks = TypeTask::all();

        return view('kategori-tugas.index', compact('breadcrumb', 'page', 'activeMenu', 'typeTasks'));
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Kategori Tugas',
            'list' => ['Home', 'Kategori Tugas', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Form untuk menambah kategori tugas baru'
        ];
        $activeMenu = 'kategori-tugas';

        return view('kategori-tugas.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        TypeTask::create([
            'nama' => $request->nama
        ]);

        return redirect('/kategori-tugas')->with('success', 'Kategori tugas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $breadcrumb = (object)[
            'title' => 'Edit Kategori Tugas',
            'list' => ['Home', 'Kategori Tugas', 'Edit']
        ];
        $page = (object)[
            'title' => 'Form untuk mengubah kategori tugas'
        ];
        $activeMenu = 'kategori-tugas';

        $typeTask = TypeTask::findOrFail($id);

        return view('kategori-tugas.edit', compact('breadcrumb', 'page', 'activeMenu', 'typeTask'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $typeTask = TypeTask::findOrFail($id);
        $typeTask->update([
            'nama' => $request->nama
        ]);

        return redirect('/kategori-tugas')->with('success', 'Kategori tugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $typeTask = TypeTask::findOrFail($id);
        $typeTask->delete();

        return redirect('/kategori-tugas')->with('success', 'Kategori tugas berhasil dihapus.');
    }
}