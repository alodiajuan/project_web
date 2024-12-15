<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Program Studi',
            'list' => ['Home', 'Prodi']
        ];

        $page = (object) [
            'title' => 'Daftar Prodi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'prodi';

        $prodi = Prodi::all();

        return view('prodi.index', compact('prodi', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Program Studi',
            'list' => ['Home', 'Prodi', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Data Program Studi'
        ];

        $activeMenu = 'prodi';

        return view('prodi.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Prodi::create([
            'nama' => $request->input('nama'),
        ]);

        return redirect('/prodi')->with('success', 'Program Studi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $breadcrumb = (object)[
            'title' => 'Edit Program Studi',
            'list' => ['Home', 'Prodi', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Data Program Studi'
        ];

        $activeMenu = 'prodi';

        $prodi = Prodi::findOrFail($id);

        return view('prodi.edit', compact('prodi', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $prodi = Prodi::findOrFail($id);
        $prodi->nama = $request->input('nama');
        $prodi->save();

        return redirect('/prodi')->with('success', 'Program Studi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $prodi = Prodi::findOrFail($id);
        $prodi->delete();

        return redirect('/prodi')->with('success', 'Program Studi berhasil dihapus.');
    }
}