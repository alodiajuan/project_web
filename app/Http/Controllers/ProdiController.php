<?php

namespace App\Http\Controllers;

use App\Models\ProdiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class ProdiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar prodi',
            'list' => ['Home', 'prodi']
        ];
        $page = (object) [
            'title' => 'Daftar prodi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'prodi';
        $prodi = ProdiModel::all();
        return view('prodi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'prodi' => $prodi, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $prodi = ProdiModel::select('prodi_id', 'prodi_kode', 'prodi_nama');
        // ftidak perlu ada filter pada prodi
        // if ($request->prodi_id) {
        //     $prodi->where('prodi_id', $request->prodi_id);
        // }

        return DataTables::of($prodi)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($prodi) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/prodi/' . $prodi->prodi_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {
        $breadcrummb = (object)[
            'title' => 'Tambah prodi',
            'list' => ['Home', 'prodi', 'tambah']
        ];

        $page = (object)[
            'title' => 'Tambah prodi baru'
        ];
        $activeMenu = 'prodi';
        $prodi = ProdiModel::all();
        return view('prodi.create', ['breadcrumb' => $breadcrummb, 'page' => $page, 'activeMenu' => $activeMenu, 'prodi' => $prodi]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'prodi_kode' => 'required|string|min:3|unique:m_prodi,prodi_kode',
            'prodi_nama' => 'required|string|max:100'
        ]);
        ProdiModel::create([
            'prodi_kode' => $request->prodi_kode,
            'prodi_nama' => $request->prodi_nama,
        ]);
        return redirect('/prodi')->with('success', 'Data prodi berhasil disimpan');
    }

    // Menampilkan halaman form tambah_ajax prodi
    public function create_ajax()
    {
        $prodi = ProdiModel::select('prodi_id', 'prodi_nama')->get();
        return view('prodi.create_ajax')->with('prodi', $prodi);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'prodi_kode' => 'required|string|min:3|unique:m_prodi,prodi_kode',
                'prodi_nama' => 'required|string|max:100'
            ];

            // use Illuminate\Support\Facades\Validation;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            ProdiModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data prodi berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function show(string $prodi_id)
    {
        $prodi = ProdiModel::find($prodi_id);

        $breadcrumb = (object)[
            'title' => 'Detail prodi',
            'list' => ['Home', 'prodi', 'detail']
        ];
        $page = (object)[
            'title' => 'Detail prodi'
        ];
        $activeMenu = 'prodi';
        return view('prodi.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'prodi' => $prodi, 'activeMenu' => $activeMenu]);
    }

    public function show_ajax(string $id)
    {
        $prodi = ProdiModel::find($id);
        return view('prodi.show_ajax', ['prodi' => $prodi]);
    }

    public function edit(string $prodi_id)
    {
        $prodi = ProdiModel::find($prodi_id);

        $breadcrumb = (object)[
            'title' => 'Edit prodi',
            'list' => ['Home', 'prodi', 'edit']
        ];
        $page = (object)[
            'title' => 'Edit prodi'
        ];
        $activeMenu = 'prodi';
        return view('prodi.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'prodi' => $prodi]);
    }

    public function update(Request $request, string $prodi_id)
    {
        $request->validate([
            'prodi_kode' => 'required|string|max:5|unique:m_prodi,prodi_kode',
            'prodi_nama' => 'required|string|max:100'
        ]);

        $prodi = ProdiModel::find($prodi_id);
        $prodi->update([
            'prodi_kode' => $request->prodi_kode,
            'prodi_nama' => $request->prodi_nama
        ]);
        return redirect('/prodi')->with('success', 'Data prodi berhasil diubah');
    }

    // Menampilkan halaman form edit prodi Ajax
    public function edit_ajax(string $id)
    {
        $prodi = ProdiModel::find($id);
        return view('prodi.edit_ajax', ['prodi' => $prodi]);
    }

    // Menyimpan perubahan data user Ajax
    public function update_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'prodi_kode' => 'required|string|min:3|unique:m_prodi,prodi_kode,' . $id . ',prodi_id',
                'prodi_nama' => 'required|string|max:100'
            ];

            // use Illuminate\Support\Facades\Validation;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
            $check = ProdiModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function destroy(string $prodi_id)
    {
        $check = ProdiModel::find($prodi_id);
        if (!$check) {
            return redirect('/prodi')->with('error', 'Data prodi tidak ditemukan');
        }
        try {
            ProdiModel::destroy($prodi_id);
            return redirect('/prodi')->with('success', 'Data prodi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/prodi')->with('error', 'Data prodi gagal dhapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // Menampilkan halaman confirm hapus
    public function confirm_ajax(string $id)
    {
        $prodi = ProdiModel::find($id);
        return view('prodi.confirm_ajax', ['prodi' => $prodi]);
    }

    // Menghapus data prodi dengan AJAX
    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $prodi = ProdiModel::find($id);
            if ($prodi) {
                $prodi->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}