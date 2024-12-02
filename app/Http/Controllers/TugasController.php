<?php

namespace App\Http\Controllers;

use App\Models\TugasModel;
use App\Models\KategoriModel;
use App\Models\SdmModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class TugasController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Tugas',
            'list' => ['Home', 'Tugas']
        ];
        $page = (object) [
            'title' => 'Daftar tugas yang telah dipublikasi'
        ];

        $activeMenu = 'tugas';
        $tugas = TugasModel::all();
        return view('tugas.index', compact('breadcrumb', 'page', 'activeMenu', 'tugas'));
    }

    public function list(Request $request)
    {
        $tugas = TugasModel::with(['kategori', 'sdm'])->select(
            'tugas_id',
            'tugas_kode',
            'tugas_nama',
            'deskripsi',
            'jam_kompen',
            'status_dibuka',
            'tanggal_mulai',
            'tanggal_akhir',
            'kategori_id',
            'sdm_id'
        );

        return DataTables::of($tugas)
            ->addIndexColumn()
            ->addColumn('aksi', function ($tugas) {
                $btn = '<a href="' . url('tugas/' . $tugas->tugas_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/tugas/' . $tugas->tugas_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/tugas/' . $tugas->tugas_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->editColumn('status_dibuka', function ($tugas) {
                return $tugas->status_dibuka;
            })
            ->editColumn('tanggal_mulai', function ($tugas) {
                return date('Y-m-d', strtotime($tugas->tanggal_mulai));
            })
            ->editColumn('tanggal_akhir', function ($tugas) {
                return date('Y-m-d', strtotime($tugas->tanggal_akhir));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $kategori = KategoriModel::all();
        $sdm = SdmModel::all();
        return view('tugas.create_ajax', compact('kategori', 'sdm'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'tugas_kode' => 'required|string|max:20|unique:m_tugas',
                'tugas_nama' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'jam_kompen' => 'required|integer',
                'status_dibuka' => 'required|in:dibuka,ditutup',
                'tanggal_mulai' => 'required|date',
                'tanggal_akhir' => 'required|date|after:tanggal_mulai',
                'kategori_id' => 'required|integer',
                'sdm_id' => 'required|integer|exists:m_sdm,sdm_id'
            ];

            $messages = [
                'status_dibuka.in' => 'Status harus dibuka atau ditutup'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                TugasModel::create($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data tugas berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan data',
                    'msgField' => ['error' => [$e->getMessage()]]
                ]);
            }
        }
        return redirect('/');
    }

    public function show($id)
    {
        $tugas = TugasModel::with(['kategori', 'sdm'])->findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Detail Tugas',
            'list' => ['Home', 'Tugas', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail tugas'
        ];

        $activeMenu = 'tugas';

        return view('tugas.show', compact('breadcrumb', 'page', 'activeMenu', 'tugas'));
    }

    public function edit($id)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Tugas',
            'list' => ['Home', 'Tugas', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Data Tugas'
        ];

        $activeMenu = 'tugas';

        $tugas = TugasModel::with(['kategori', 'sdm'])->findOrFail($id);
        $kategori = KategoriModel::all();

        return view('tugas.edit', compact('tugas', 'kategori', 'page', 'breadcrumb', 'activeMenu'));
    }

    public function edit_ajax($id)
    {
        $tugas = TugasModel::with(['kategori', 'sdm'])->findOrFail($id);
        $kategori = KategoriModel::all();
        $sdm = SdmModel::all();

        return view('tugas.edit_ajax', compact('tugas', 'kategori', 'sdm'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'tugas_kode' => 'required|string|max:20|unique:m_tugas,tugas_kode,' . $id . ',tugas_id',
                'tugas_nama' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'jam_kompen' => 'required|integer',
                'status_dibuka' => 'required|in:dibuka,ditutup',
                'tanggal_mulai' => 'required|date',
                'tanggal_akhir' => 'required|date|after:tanggal_mulai',
                'kategori_id' => 'required|integer',
                'sdm_id' => 'required|integer|exists:m_sdm,sdm_id'
            ];

            $messages = [
                'status_dibuka.in' => 'Status harus dibuka atau ditutup'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                $tugas = TugasModel::findOrFail($id);
                $tugas->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengupdate data',
                    'msgField' => ['error' => [$e->getMessage()]]
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax($id)
    {
        $tugas = TugasModel::with(['kategori', 'sdm'])->findOrFail($id);
        return view('tugas.confirm_ajax', compact('tugas'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $tugas = TugasModel::findOrFail($id);
                $tugas->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menghapus data'
                ]);
            }
        }
        return redirect('/');
    }
}