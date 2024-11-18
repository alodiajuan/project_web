<?php

namespace App\Http\Controllers;

use App\Models\KompetensiModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;

class KompetensiController extends Controller
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
        
        // Pastikan untuk menggunakan model yang benar
        $kompetensis = KompetensiModel::with('mahasiswa')->paginate(10);
        
        return view('kompetensi.index', compact('breadcrumb', 'page', 'activeMenu', 'kompetensis'));
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kompetensi',
            'list' => ['Home', 'Kompetensi', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah Kompetensi baru'
        ];
        $activeMenu = 'kompetensi';

        $mahasiswas = MahasiswaModel::all();
        
        return view('kompetensi.create', compact('breadcrumb', 'page', 'activeMenu', 'mahasiswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required',
            'mahasiswa_id' => 'required|exists:m_mahasiswa,mahasiswa_id',
        ]);

        // Simpan data ke dalam tabel m_kompetensi
        KompetensiModel::create($request->all());
        
        return redirect()->route('kompetensi.index')->with('success', 'Kompetensi berhasil ditambahkan');
    }

    public function show(KompetensiModel $kompetensi)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Kompetensi',
            'list' => ['Home', 'Kompetensi', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail Kompetensi'
        ];
        $activeMenu = 'kompetensi';

        return view('kompetensi.show', compact('breadcrumb', 'page', 'activeMenu', 'kompetensi'));
    }

    public function edit(KompetensiModel $kompetensi)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Kompetensi',
            'list' => ['Home', 'Kompetensi', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit Kompetensi'
        ];
        $activeMenu = 'kompetensi';

        $mahasiswas = MahasiswaModel::all();
        
        return view('kompetensi.edit', compact('breadcrumb', 'page', 'activeMenu', 'kompetensi', 'mahasiswas'));
    }

    public function update(Request $request, KompetensiModel $kompetensi)
    {
        $request->validate([
            'deskripsi' => 'required',
            'mahasiswa_id' => 'required|exists:m_mahasiswa,mahasiswa_id',
        ]);

        // Perbarui data di tabel m_kompetensi
        $kompetensi->update($request->all());
        
        return redirect()->route('kompetensi.index')->with('success', 'Kompetensi berhasil diubah');
    }

    public function destroy(KompetensiModel $kompetensi)
    {
        try {
            // Hapus data dari tabel m_kompetensi
            $kompetensi->delete();
            return redirect()->route('kompetensi.index')->with('success', 'Kompetensi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('kompetensi.index')->with('error', 'Kompetensi gagal dihapus karena masih terkait dengan data lain');
        }
    }
}
