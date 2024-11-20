<?php
namespace App\Http\Controllers;

use App\Models\KompetensiModel;
use App\Models\MahasiswaModel; 
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
       
       return view('kompetensi.index', compact('breadcrumb', 'page', 'activeMenu'));
   }

   public function list()
   {
       // Ambil data kompetensi dengan relasi mahasiswa
       $kompetensi = KompetensiModel::with('mahasiswa')->select(['kompetensi_id', 'deskripsi', 'mahasiswa_id']);
   
       return DataTables::of($kompetensi)
           ->addIndexColumn() // Tambahkan nomor baris otomatis
           ->addColumn('mahasiswa', function ($row) {
               // Tampilkan nama mahasiswa jika ada, "-" jika tidak ada
               return $row->mahasiswa ? $row->mahasiswa->mahasiswa_nama : '-';
           })
           ->addColumn('aksi', function ($row) {
               // Tombol aksi untuk detail, edit, dan hapus
               $btn = '<a href="' . url('kompetensi/' . $row->kompetensi_id) . '" class="btn btn-sm btn-info">Detail</a> ';
               $btn .= '<button onclick="modalAction(\'' . url('/kompetensi/' . $row->kompetensi_id . '/edit') . '\')" class="btn btn-sm btn-warning">Edit</button> ';
               $btn .= '<button onclick="modalAction(\'' . url('/kompetensi/' . $row->kompetensi_id . '/delete') . '\')" class="btn btn-sm btn-danger">Hapus</button>';
               return $btn;
           })
           ->rawColumns(['aksi']) // Izinkan HTML pada kolom aksi
           ->make(true);
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
       
       $mahasiswas = MahasiswaModel::all();
       return view('kompetensi.create', compact('breadcrumb', 'page', 'activeMenu', 'mahasiswas'));
   }

   public function store(Request $request)
   {
       $validated = $request->validate([
           'deskripsi' => 'required',
           'mahasiswa_id' => 'required|exists:m_mahasiswa,mahasiswa_id'
       ]);

       KompetensiModel::create($validated);
       return redirect()->route('kompetensi.index')->with('success', 'Kompetensi berhasil ditambahkan');
   }

   public function store_ajax(Request $request)
   {
       $validated = $request->validate([
           'deskripsi' => 'required',
           'mahasiswa_id' => 'required|exists:m_mahasiswa,mahasiswa_id'
       ]);

       try {
           KompetensiModel::create($validated);
           return response()->json([
               'status' => true,
               'message' => 'Kompetensi berhasil ditambahkan'
           ]);
       } catch (\Exception $e) {
           return response()->json([
               'status' => false,
               'message' => 'Gagal menambahkan kompetensi',
               'msgField' => $e->getMessage()
           ]);
       }
   }

   public function show($id) 
   {
       $breadcrumb = (object) [
           'title' => 'Detail Kompetensi',
           'list' => ['Home', 'Kompetensi', 'Detail']
       ];
       $page = (object) [
           'title' => 'Detail Kompetensi'
       ];
       $activeMenu = 'kompetensi';

       $kompetensi = KompetensiModel::with('mahasiswa')->findOrFail($id);
       return view('kompetensi.show', compact('breadcrumb', 'page', 'activeMenu', 'kompetensi'));
   }

   public function edit($id)
   {
       $breadcrumb = (object) [
           'title' => 'Edit Kompetensi', 
           'list' => ['Home', 'Kompetensi', 'Edit']
       ];
       $page = (object) [
           'title' => 'Edit Kompetensi'
       ];
       $activeMenu = 'kompetensi';

       $kompetensi = KompetensiModel::findOrFail($id);
       $mahasiswas = MahasiswaModel::all();
       return view('kompetensi.edit', compact('breadcrumb', 'page', 'activeMenu', 'kompetensi', 'mahasiswas')); 
   }

   public function update(Request $request, $id)
   {
       $kompetensi = KompetensiModel::findOrFail($id);
       $validated = $request->validate([
           'deskripsi' => 'required',
           'mahasiswa_id' => 'required|exists:m_mahasiswa,mahasiswa_id'
       ]);
       
       $kompetensi->update($validated);
       return redirect()->route('kompetensi.index')->with('success', 'Kompetensi berhasil diupdate');
   }

   public function update_ajax(Request $request, $id)
   {
       $kompetensi = KompetensiModel::findOrFail($id);
       $validated = $request->validate([
           'deskripsi' => 'required',
           'mahasiswa_id' => 'required|exists:m_mahasiswa,mahasiswa_id'
       ]);

       try {
           $kompetensi->update($validated);
           return response()->json([
               'status' => true,
               'message' => 'Kompetensi berhasil diupdate'
           ]);
       } catch (\Exception $e) {
           return response()->json([
               'status' => false,
               'message' => 'Gagal mengupdate kompetensi',
               'msgField' => $e->getMessage() 
           ]);
       }
   }

   public function destroy($id)
   {
       try {
           $kompetensi = KompetensiModel::findOrFail($id);
           $kompetensi->delete();
           return redirect()->route('kompetensi.index')->with('success', 'Kompetensi berhasil dihapus');
       } catch (\Exception $e) {
           return redirect()->route('kompetensi.index')->with('error', 'Gagal menghapus kompetensi');
       }
   }

   public function confirm_ajax($id)
   {
       $kompetensi = KompetensiModel::with('mahasiswa')->find($id);
       
       if($kompetensi) {
           return response()->json([
               'status' => true,
               'data' => $kompetensi
           ]);
       }

       return response()->json([
           'status' => false,
           'message' => 'Data kompetensi tidak ditemukan'
       ]);
   }

   public function import_ajax(Request $request)
   {
       $request->validate([
           'file_kompetensi' => 'required|mimes:xlsx'
       ]);

       try {
           $file = $request->file('file_kompetensi');
           $spreadsheet = IOFactory::load($file->getPathname());
           $worksheet = $spreadsheet->getActiveSheet();
           $rows = $worksheet->toArray();
           array_shift($rows);

           foreach($rows as $row) {
               KompetensiModel::create([
                   'deskripsi' => $row[0],
                   'mahasiswa_id' => $row[1]
               ]);
           }

           return response()->json([
               'status' => true,
               'message' => 'Data berhasil diimport'
           ]);

       } catch (\Exception $e) {
           return response()->json([
               'status' => false,
               'message' => 'Gagal import data',
               'msgField' => ['file_kompetensi' => [$e->getMessage()]]
           ]);
       }
   }
}