<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use App\Models\MahasiswaModel;
use App\Models\KompetensiModel;
use App\Models\ProdiModel;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    // Menampilkan halaman awal mahasiswa
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Mahasiswa',
            'list' => ['Home', 'Mahasiswa']
        ];

        $page = (object) [
            'title' => 'Daftar mahasiswa yang terdaftar dalam sistem'
        ];

        $activeMenu = 'mahasiswa'; // set menu sedang active

        $level = LevelModel::all(); // ambil data level untuk filter level

        return view('mahasiswa.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        $level = LevelModel::all();
        $kompetensi = KompetensiModel::all();
        $prodi = ProdiModel::all();
        return view('mahasiswa.create_ajax', ['level' => $level, 'kompetensi' => $kompetensi, 'prodi' => $prodi]);
    }

    // Menyimpan data mahasiswa baru menggunakan AJAX
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'mahasiswa_nama' => 'required|string|max:255', // sesuai dengan varchar(255) di SQL
                'nim' => 'required|string|unique:m_mahasiswa,nim', // sesuai dengan varchar(20) dan perlu UNIQUE constraint di SQL
                'username' => 'nullable|string|max:50', // sesuai dengan varchar(50) di SQL, nullable karena tidak wajib
                'kompetensi' => 'nullable|string|max:255', // sesuai dengan varchar(255) di SQL, nullable karena tidak wajib
                'semester' => 'nullable|integer|min:1|max:14', // sesuai dengan int di SQL, nullable karena tidak wajib
                'password' => 'required|string|min:5', // sesuai dengan varchar(255) di SQL, perlu NOT NULL di SQL
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // sesuai dengan varchar(255) di SQL, nullable karena tidak wajib
                'prodi_id' => 'required|integer', // sesuai dengan int dan NOT NULL di SQL
                'kompetensi_id' => 'nullable|integer', // sesuai dengan int di SQL, nullable karena tidak wajib
                'level_id' => 'nullable|integer', // sesuai dengan int di SQL, nullable karena tidak wajib
            ];            

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'errors' => $validator->errors(),
                ]);
            }

            $data = $request->except('foto', 'password');
            $data['password'] = bcrypt($request->password);

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('mahasiswa_foto', 'public');
            }

            MahasiswaModel::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Data mahasiswa berhasil disimpan',
            ]);
        }

        return redirect('/mahasiswa')->with('error', 'Hanya menerima request AJAX.');
    }

    // Mengambil data mahasiswa untuk DataTables
    public function list(Request $request)
    {
        $mahasiswa = MahasiswaModel::select('mahasiswa_id', 'mahasiswa_nama', 'nim', 'username', 'kompetensi', 'semester', 'foto', 'level_id', 'kompetensi_id', 'prodi_id')
            ->with('level');

        // Filter data mahasiswa berdasarkan level_id
        if ($request->level_id) {
            $mahasiswa->where('level_id', $request->level_id);
        }

        return DataTables::of($mahasiswa)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom:DT_RowIndex) 
            ->addColumn('aksi', function ($mahasiswa) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/mahasiswa/' . $mahasiswa->mahasiswa_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $mahasiswa->mahasiswa_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $mahasiswa->mahasiswa_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    // Menampilkan form edit mahasiswa dengan AJAX
    public function edit_ajax($id)
    {
        $mahasiswa = MahasiswaModel::find($id);
        if ($mahasiswa) {
            return response()->json([
                'status' => true,
                'data' => $mahasiswa,
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Data mahasiswa tidak ditemukan.',
        ]);
    }

    // Memperbarui data mahasiswa menggunakan AJAX
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nim' => 'required|string|unique:m_mahasiswa,nim,' . $id . ',mahasiswa_id',
                'mahasiswa_nama' => 'required|string|max:255',
                'kompetensi' => 'nullable|string|max:255',
                'semester' => 'nullable|integer|min:1|max:14',
                'password' => 'nullable|string|min:5',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'prodi_id' => 'required|integer',
                'kompetensi_id' => 'nullable|integer',
                'level_id' => 'nullable|integer',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'errors' => $validator->errors(),
                ]);
            }

            $mahasiswa = MahasiswaModel::find($id);

            if (!$mahasiswa) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data mahasiswa tidak ditemukan.',
                ]);
            }

            $data = $request->except('foto', 'password');
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }
            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('mahasiswa_foto', 'public');
            }

            $mahasiswa->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Data mahasiswa berhasil diperbarui.',
            ]);
        }

        return redirect('/mahasiswa')->with('error', 'Hanya menerima request AJAX.');
    }

    // Menghapus data mahasiswa menggunakan AJAX
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mahasiswa = MahasiswaModel::find($id);

            if (!$mahasiswa) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data mahasiswa tidak ditemukan.',
                ]);
            }

            $mahasiswa->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data mahasiswa berhasil dihapus.',
            ]);
        }

        return redirect('/mahasiswa')->with('error', 'Hanya menerima request AJAX.');
    }
}