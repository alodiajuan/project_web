<?php
namespace App\Http\Controllers;

use App\Models\SdmModel;
use App\Models\ProdiModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SdmController extends Controller
{
   public function index()
   {
       $breadcrumb = (object) [
           'title' => 'Daftar sdm', 
           'list' => ['Home', 'sdm']
       ];
       $page = (object) [
           'title' => 'Daftar sdm yang terdaftar dalam sistem'
       ];

       $activeMenu = 'sdm';
       return view('sdm.index', compact('breadcrumb', 'page', 'activeMenu'));
   }

   public function list(Request $request)
   {
       $sdm = SdmModel::select('sdm_id', 'sdm_nama', 'nip', 'username', 'password', 'no_telepon', 'foto', 'prodi_id', 'level_id')
           ->with('prodi', 'level');

       if ($request->level_id) {
           $sdm->where('level_id', $request->level_id);
       } elseif ($request->prodi_id) {
           $sdm->where('prodi_id', $request->prodi_id);
       }

       return DataTables::of($sdm)
           ->addIndexColumn()
           ->addColumn('aksi', function ($sdm) {
               $btn = '<a href="' . url('sdm/' . $sdm->sdm_id) . '" class="btn btn-sm btn-info">Detail</a> ';
               $btn .= '<button onclick="modalAction(\'' . url('/sdm/' . $sdm->sdm_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
               $btn .= '<button onclick="modalAction(\'' . url('/sdm/' . $sdm->sdm_id . '/delete_ajax') . '\')" class="btn btn-warning btn-sm">Hapus</button> ';
               return $btn;
           })
           ->rawColumns(['aksi'])
           ->make(true);
   }

   public function create()
   {
       $breadcrumb = (object) [
           'title' => 'Tambah sdm',
           'list' => ['Home', 'sdm', 'Tambah']
       ];
       $page = (object) [
           'title' => 'Tambah sdm Baru'
       ];
       $activeMenu = 'sdm';

       $prodis = ProdiModel::all();
       $levels = LevelModel::all();
       
       return view('sdm.create', compact('breadcrumb', 'page', 'activeMenu', 'prodis', 'levels'));
   }

   public function store(Request $request)
   {
       $validated = $request->validate([
           'sdm_nama' => 'required',
           'nip' => 'required|unique:m_sdm',
           'username' => 'required|unique:m_sdm',
           'password' => 'required',
           'no_telepon' => 'required',
           'prodi_id' => 'required',
           'level_id' => 'required',
           'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
       ]);

       if($request->hasFile('foto')) {
           $foto = $request->file('foto');
           $filename = time() . '.' . $foto->getClientOriginalExtension();
           $foto->move(public_path('uploads'), $filename);
           $validated['foto'] = $filename;
       }

       SdmModel::create($validated);
       return redirect()->route('sdm.index')->with('success', 'sdm berhasil ditambahkan');
   }

   public function store_ajax(Request $request) 
   {
       $validated = $request->validate([
           'sdm_nama' => 'required',
           'nip' => 'required|unique:m_sdm',
           'username' => 'required|unique:m_sdm',
           'password' => 'required',
           'no_telepon' => 'required',
           'prodi_id' => 'required',
           'level_id' => 'required'
       ]);

       try {
           SdmModel::create($validated);
           return response()->json([
               'status' => true,
               'message' => 'sdm berhasil ditambahkan'
           ]);
       } catch (\Exception $e) {
           return response()->json([
               'status' => false,
               'message' => 'Gagal menambahkan sdm',
               'msgField' => $e->getMessage()
           ]);
       }
   }

   public function show($id)
   {
       $breadcrumb = (object) [
           'title' => 'Detail sdm',
           'list' => ['Home', 'sdm', 'Detail']
       ];
       $page = (object) [
           'title' => 'Detail Data sdm'
       ];
       $activeMenu = 'sdm';

       $sdm = SdmModel::with(['prodi', 'level'])->findOrFail($id);
       return view('sdm.show', compact('breadcrumb', 'page', 'activeMenu', 'sdm'));
   }

   public function edit($id)
   {
       $breadcrumb = (object) [
           'title' => 'Edit sdm',
           'list' => ['Home', 'sdm', 'Edit']
       ];
       $page = (object) [
           'title' => 'Edit Data sdm'
       ];
       $activeMenu = 'sdm';

       $sdm = SdmModel::findOrFail($id);
       $prodis = ProdiModel::all();
       $levels = LevelModel::all();

       return view('sdm.edit', compact('breadcrumb', 'page', 'activeMenu', 'sdm', 'prodis', 'levels'));
   }

   public function update(Request $request, $id)
   {
       $sdm = SdmModel::findOrFail($id);
       $validated = $request->validate([
           'sdm_nama' => 'required',
           'nip' => 'required|unique:m_sdm,nip,'.$id.',sdm_id',
           'username' => 'required|unique:m_sdm,username,'.$id.',sdm_id',
           'no_telepon' => 'required',
           'prodi_id' => 'required',
           'level_id' => 'required',
           'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
       ]);

       if($request->hasFile('foto')) {
           if($sdm->foto) {
               unlink(public_path('uploads/'.$sdm->foto));
           }
           $foto = $request->file('foto');
           $filename = time() . '.' . $foto->getClientOriginalExtension();
           $foto->move(public_path('uploads'), $filename);
           $validated['foto'] = $filename;
       }

       $sdm->update($validated);
       return redirect()->route('sdm.index')->with('success', 'sdm berhasil diupdate');
   }

   public function update_ajax(Request $request, $id)
   {
       $sdm = SdmModel::findOrFail($id);
       $validated = $request->validate([
           'sdm_nama' => 'required',
           'nip' => 'required|unique:m_sdm,nip,'.$id.',sdm_id',
           'username' => 'required|unique:m_sdm,username,'.$id.',sdm_id',
           'no_telepon' => 'required',
           'prodi_id' => 'required',
           'level_id' => 'required'
       ]);

       try {
           $sdm->update($validated);
           return response()->json([
               'status' => true,
               'message' => 'sdm berhasil diupdate'
           ]);
       } catch (\Exception $e) {
           return response()->json([
               'status' => false,
               'message' => 'Gagal mengupdate sdm',
               'msgField' => $e->getMessage()
           ]);
       }
   }

   public function destroy($id)
   {
       try {
           $sdm = SdmModel::findOrFail($id);
           if($sdm->foto) {
               unlink(public_path('uploads/'.$sdm->foto));
           }
           $sdm->delete();
           return redirect()->route('sdm.index')->with('success', 'sdm berhasil dihapus');
       } catch (\Exception $e) {
           return redirect()->route('sdm.index')->with('error', 'Gagal menghapus sdm');
       }
   }

   public function confirm_ajax($id) 
   {
       $sdm = SdmModel::with(['prodi', 'level'])->find($id);
       
       if($sdm) {
           return response()->json([
               'status' => true,
               'data' => $sdm
           ]);
       }

       return response()->json([
           'status' => false,
           'message' => 'Data sdm tidak ditemukan'
       ]);
   }

   public function import_ajax(Request $request)
   {
       $request->validate([
           'file_sdm' => 'required|mimes:xlsx'
       ]);

       try {
           $file = $request->file('file_sdm');
           $spreadsheet = IOFactory::load($file->getPathname());
           $worksheet = $spreadsheet->getActiveSheet();
           $rows = $worksheet->toArray();
           array_shift($rows);

           foreach($rows as $row) {
               SdmModel::create([
                   'sdm_nama' => $row[0],
                   'nip' => $row[1], 
                   'username' => $row[2],
                   'password' => bcrypt($row[3]),
                   'no_telepon' => $row[4],
                   'prodi_id' => $row[5],
                   'level_id' => $row[6]
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
               'msgField' => ['file_sdm' => [$e->getMessage()]]
           ]);
       }
   }
}