<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KompetensiController extends Controller
{
    public function index()
    {
        $kompetensi = Competence::all();

        $breadcrumb = (object) [
            'title' => 'Daftar Kompetensi',
            'list' => ['Home', 'Kompetensi']
        ];

        $page = (object) [
            'title' => 'Daftar Kompetensi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kompetensi';

        return view('kompetensi.index', compact('kompetensi', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kompetensi',
            'list' => ['Home', 'Kompetensi', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Kompetensi Baru'
        ];

        $activeMenu = 'kompetensi';

        return view('kompetensi.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/kompetensi/create')
                ->withErrors($validator)
                ->withInput();
        }

        Competence::create([
            'nama' => $request->nama,
        ]);

        return redirect('/kompetensi')->with('success', 'Kompetensi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kompetensi = Competence::findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Edit Kompetensi',
            'list' => ['Home', 'Kompetensi', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Kompetensi'
        ];

        $activeMenu = 'kompetensi';

        return view('kompetensi.edit', compact('kompetensi', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect("/kompetensi/edit/{$id}")
                ->withErrors($validator)
                ->withInput();
        }

        $kompetensi = Competence::findOrFail($id);
        $kompetensi->update([
            'nama' => $request->nama,
        ]);

        return redirect('/kompetensi')->with('success', 'Kompetensi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kompetensi = Competence::findOrFail($id);
        $kompetensi->delete();

        return redirect('/kompetensi')->with('success', 'Kompetensi berhasil dihapus.');
    }
}
