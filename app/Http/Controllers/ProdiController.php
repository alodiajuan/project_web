<?php

namespace App\Http\Controllers;

use App\Models\ProdiModel;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Program Studi',
            'list' => ['Home', 'Program Studi']
        ];
        $page = (object) [
            'title' => 'Daftar Program Studi yang terdaftar dalam sistem'
        ];
        $activeMenu = 'prodi';
        
        $prodi = ProdiModel::paginate(10);
        
        return view('prodi.index', compact('breadcrumb', 'page', 'activeMenu', 'prodi'));
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Program Studi',
            'list' => ['Home', 'Program Studi', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah Program Studi baru'
        ];
        $activeMenu = 'prodi';
        
        return view('prodi.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prodi_kode' => 'required|unique:m_prodi',
            'nama' => 'required|unique:m_prodi',
        ]);

        ProdiModel::create($request->all());
        
        return redirect()->route('prodi.index')->with('success', 'Program Studi berhasil ditambahkan');
    }

    public function show(ProdiModel $prodi)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Program Studi',
            'list' => ['Home', 'Program Studi', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail Program Studi'
        ];
        $activeMenu = 'prodi';

        return view('prodi.show', compact('breadcrumb', 'page', 'activeMenu', 'prodi'));
    }

    public function edit(ProdiModel $prodi)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Program Studi',
            'list' => ['Home', 'Program Studi', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit Program Studi'
        ];
        $activeMenu = 'prodi';
        
        return view('prodi.edit', compact('breadcrumb', 'page', 'activeMenu', 'prodi'));
    }

    public function update(Request $request, ProdiModel $prodi)
    {
        $request->validate([
            'prodi_kode' => 'required|unique:m_prodi,prodi_kode,' . $prodi->prodi_id . ',prodi_id',
            'nama' => 'required|unique:m_prodi,nama,' . $prodi->prodi_id . ',prodi_id',
        ]);

        $prodi->update($request->all());
        
        return redirect()->route('prodi.index')->with('success', 'Program Studi berhasil diubah');
    }

    public function destroy(ProdiModel $prodi)
    {
        try {
            $prodi->delete();
            return redirect()->route('prodi.index')->with('success', 'Program Studi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('prodi.index')->with('error', 'Program Studi gagal dihapus karena masih terkait dengan data lain');
        }
    }
}
