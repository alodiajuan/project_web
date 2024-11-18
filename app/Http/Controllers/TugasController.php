<?php

namespace App\Http\Controllers;

use App\Models\TugasModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class TugasController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Tugas',
            'list' => ['Home', 'Tugas']
        ];
        $page = (object) [
            'title' => 'Daftar tugas yang terdaftar dalam sistem',
        ];
        $activeMenu = 'tugas';
        $kategori = KategoriModel::all();
        return view('tugas.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Tugas',
            'list' => ['Home', 'Tugas', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah tugas baru',
        ];
        $kategori = KategoriModel::all();
        $activeMenu = 'tugas';
        return view('tugas.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id'    => 'required|integer',
            'tugas_kode'     => 'required|string|min:3|unique:m_tugas,tugas_kode',
            'tugas_nama'     => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'jam_kompen'     => 'required|integer',
            'status_dibuka'  => 'required|boolean',
            'tanggal_mulai'  => 'required|date',
            'tanggal_akhir'  => 'required|date|after_or_equal:tanggal_mulai',
            'sdm_id'         => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tugas = TugasModel::create($request->all());

        if ($tugas) {
            return response()->json([
                'success' => true,
                'tugas' => $tugas,
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }

    public function show(string $id)
    {
        $tugas = TugasModel::with('kategori')->find($id);
        if (!$tugas) {
            return redirect('/tugas')->with('error', 'Data tugas tidak ditemukan');
        }
        $breadcrumb = (object) [
            'title' => 'Detail Tugas',
            'list' => ['Home', 'Tugas', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail tugas',
        ];
        $activeMenu = 'tugas';
        return view('tugas.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'tugas' => $tugas, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $tugas = TugasModel::find($id);
        $kategori = KategoriModel::all();
        if (!$tugas) {
            return redirect('/tugas')->with('error', 'Data tugas tidak ditemukan');
        }
        $breadcrumb = (object) [
            'title' => 'Edit Tugas',
            'list' => ['Home', 'Tugas', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit tugas',
        ];
        $activeMenu = 'tugas';
        return view('tugas.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'tugas' => $tugas, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tugas_kode'     => 'required|string|unique:m_tugas,tugas_kode,' . $id . ',tugas_id',
            'tugas_nama'     => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'jam_kompen'     => 'required|integer',
            'status_dibuka'  => 'required|boolean',
            'tanggal_mulai'  => 'required|date',
            'tanggal_akhir'  => 'required|date|after_or_equal:tanggal_mulai',
            'sdm_id'         => 'required|integer',
            'kategori_id'    => 'required|integer'
        ]);

        TugasModel::find($id)->update($request->all());
        return redirect('/tugas')->with('success', 'Data tugas berhasil diubah');
    }

    public function destroy(string $id)
    {
        $tugas = TugasModel::find($id);
        if (!$tugas) {
            return redirect('/tugas')->with('error', 'Data tugas tidak ditemukan');
        }
        try {
            TugasModel::destroy($id);
            return redirect('/tugas')->with('success', 'Data tugas berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/tugas')->with('error', 'Data tugas gagal dihapus karena terkait dengan data lain');
        }
    }

    // AJAX Functions Start Here

    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('tugas.create_ajax', ['kategori' => $kategori]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id'    => 'required|integer',
                'tugas_kode'     => 'required|string|min:3|unique:m_tugas,tugas_kode',
                'tugas_nama'     => 'required|string|max:255',
                'deskripsi'      => 'required|string',
                'jam_kompen'     => 'required|integer',
                'status_dibuka'  => 'required|boolean',
                'tanggal_mulai'  => 'required|date',
                'tanggal_akhir'  => 'required|date|after_or_equal:tanggal_mulai',
                'sdm_id'         => 'required|integer'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(),
                ]);
            }

            TugasModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data tugas berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function list(Request $request)
    {
        $tugas = TugasModel::select('tugas_id', 'kategori_id', 'tugas_kode', 'tugas_nama', 'jam_kompen', 'status_dibuka', 'tanggal_mulai', 'tanggal_akhir')
            ->with('kategori');

        if ($request->kategori_id) {
            $tugas->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($tugas)
            ->addIndexColumn()
            ->addColumn('status', function ($tugas) {
                return $tugas->status_dibuka ? 'Dibuka' : 'Ditutup';
            })
            ->addColumn('periode', function ($tugas) {
                return date('d/m/Y', strtotime($tugas->tanggal_mulai)) . ' - ' . date('d/m/Y', strtotime($tugas->tanggal_akhir));
            })
            ->addColumn('aksi', function ($tugas) {
                $btn = '<a href="' . url('/tugas/' . $tugas->tugas_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/tugas/' . $tugas->tugas_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/tugas/' . $tugas->tugas_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function edit_ajax(string $id)
    {
        $tugas = TugasModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('tugas.edit_ajax', ['tugas' => $tugas, 'kategori' => $kategori]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id'    => 'required|integer',
                'tugas_kode'     => 'required|string|min:3|unique:m_tugas,tugas_kode,' . $id . ',tugas_id',
                'tugas_nama'     => 'required|string|max:255',
                'deskripsi'      => 'required|string',
                'jam_kompen'     => 'required|integer',
                'status_dibuka'  => 'required|boolean',
                'tanggal_mulai'  => 'required|date',
                'tanggal_akhir'  => 'required|date|after_or_equal:tanggal_mulai',
                'sdm_id'         => 'required|integer'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = TugasModel::find($id);
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

    public function confirm_ajax(string $id)
    {
        $tugas = TugasModel::find($id);
        return view('tugas.confirm_ajax', ['tugas' => $tugas]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $tugas = TugasModel::find($id);
            if ($tugas) {
                $tugas->delete();
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

    public function import()
    {
        return view('tugas.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_tugas' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_tugas');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];

            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'kategori_id'    => $value['A'],
                            'tugas_kode'     => $value['B'],
                            'tugas_nama'     => $value['C'],
                            'deskripsi'      => $value['D'],
                            'jam_kompen'     => $value['E'],
                            'status_dibuka'  => $value['F'],
                            'tanggal_mulai'  => $value['G'],
                            'tanggal_akhir'  => $value['H'],
                            'sdm_id'         => $value['I'],
                            'created_at'     => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    TugasModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        $tugas = TugasModel::select('kategori_id', 'tugas_kode', 'tugas_nama', 'deskripsi', 'jam_kompen', 'status_dibuka', 'tanggal_mulai', 'tanggal_akhir', 'sdm_id')
            ->orderBy('kategori_id')
            ->with('kategori')
            ->get();