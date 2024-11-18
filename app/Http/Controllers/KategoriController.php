<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar kategori soal',
            'list' => ['Home', 'kategori']
        ];
        $page = (object)[
            'title' => 'Daftar kategori soal yang terdaftar dalam sistem'
        ];
        $activeMenu = 'kategori';
        $kategori = KategoriModel::all();  // Mengambil semua data kategori
        return view('kategori.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    // Menampilkan data kategori untuk DataTables
    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');
        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menambah kategori baru
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Kategori Soal',
            'list' => ['Home', 'kategori', 'tambah']
        ];
        $page = (object)[
            'title' => 'Tambah kategori soal baru'
        ];
        $activeMenu = 'kategori';
        return view('kategori.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100'
        ]);
        
        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    // Menampilkan detail kategori
    public function show(string $kategori_id)
    {
        $kategori = KategoriModel::find($kategori_id);
        if (!$kategori) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        $breadcrumb = (object)[
            'title' => 'Detail Kategori',
            'list' => ['Home', 'kategori', 'detail']
        ];
        $page = (object)[
            'title' => 'Detail kategori'
        ];
        $activeMenu = 'kategori';
        return view('kategori.show', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    // Menampilkan form untuk edit kategori
    public function edit(string $kategori_id)
    {
        $kategori = KategoriModel::find($kategori_id);
        if (!$kategori) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        $breadcrumb = (object)[
            'title' => 'Edit kategori',
            'list' => ['Home', 'kategori', 'edit']
        ];
        $page = (object)[
            'title' => 'Edit kategori'
        ];
        $activeMenu = 'kategori';
        return view('kategori.edit', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    // Mengupdate data kategori
    public function update(Request $request, string $kategori_id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' . $kategori_id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100'
        ]);

        $kategori = KategoriModel::find($kategori_id);
        if (!$kategori) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        $kategori->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diperbarui');
    }

    public function destroy(string $kategori_id)
    {
        $check = KategoriModel::find($kategori_id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }
        try {
            KategoriModel::destroy($kategori_id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // Menampilkan halaman confirm hapus
    public function confirm_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    // Menghapus data kategori dengan AJAX
    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriModel::where('kategori_id', $id)->first();
            if ($kategori) {
                $kategori->delete();
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

    // Ajax untuk Create
    public function create_ajax()
    {
        return view('kategori.create_ajax');
    }

    // Menyimpan kategori via Ajax
    public function store_ajax(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
                'kategori_nama' => 'required|string|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            KategoriModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil disimpan'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Permintaan tidak valid'
        ]);
    }

    // Menampilkan kategori via Ajax
    public function show_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.show_ajax', compact('kategori'));
    }

    // Mengedit kategori via Ajax
    public function edit_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.edit_ajax', compact('kategori'));
    }

    // Update kategori via Ajax
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
                'kategori_nama' => 'required|string|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $kategori = KategoriModel::find($id);
            if ($kategori) {
                $kategori->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Permintaan tidak valid'
        ]);
    }
}
