<?php
namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\ProdiModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AdminController extends Controller
{
   public function index()
   {
       $breadcrumb = (object) [
           'title' => 'Daftar Admin', 
           'list' => ['Home', 'Admin']
       ];
       $page = (object) [
           'title' => 'Daftar Admin yang terdaftar dalam sistem'
       ];
       $activeMenu = 'admin';

       return view('admin.index', compact('breadcrumb', 'page', 'activeMenu'));
   }

   public function list()
   {
       $admins = AdminModel::with(['prodi', 'level'])->select(['admin_id', 'admin_nama', 'nip', 'username', 'no_telepon', 'prodi_id', 'level_id']);
       
       return DataTables::of($admins)
           ->addIndexColumn()
           ->addColumn('prodi', function($row){
               return $row->prodi->prodi_nama ?? '-';
           })
           ->addColumn('level', function($row){
               return $row->level->level_nama ?? '-'; 
           })
           ->addColumn('aksi', function($row){
               $btn = '<a href="'.url('admin/'.$row->admin_id).'" class="btn btn-sm btn-info">Detail</a> ';
               $btn .= '<a href="'.url('admin/'.$row->admin_id.'/edit').'" class="btn btn-sm btn-warning">Edit</a> ';
               $btn .= '<button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('.$row->admin_id.')">Hapus</button>';
               return $btn;
           })
           ->rawColumns(['aksi'])
           ->make(true);
   }

   public function create()
   {
       $breadcrumb = (object) [
           'title' => 'Tambah Admin',
           'list' => ['Home', 'Admin', 'Tambah']
       ];
       $page = (object) [
           'title' => 'Tambah Admin Baru'
       ];
       $activeMenu = 'admin';

       $prodis = ProdiModel::all();
       $levels = LevelModel::all();
       
       return view('admin.create', compact('breadcrumb', 'page', 'activeMenu', 'prodis', 'levels'));
   }

   public function store(Request $request)
   {
       $validated = $request->validate([
           'admin_nama' => 'required',
           'nip' => 'required|unique:m_admin',
           'username' => 'required|unique:m_admin',
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

       AdminModel::create($validated);
       return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan');
   }

   public function store_ajax(Request $request) 
   {
       $validated = $request->validate([
           'admin_nama' => 'required',
           'nip' => 'required|unique:m_admin',
           'username' => 'required|unique:m_admin',
           'password' => 'required',
           'no_telepon' => 'required',
           'prodi_id' => 'required',
           'level_id' => 'required'
       ]);

       try {
           AdminModel::create($validated);
           return response()->json([
               'status' => true,
               'message' => 'Admin berhasil ditambahkan'
           ]);
       } catch (\Exception $e) {
           return response()->json([
               'status' => false,
               'message' => 'Gagal menambahkan admin',
               'msgField' => $e->getMessage()
           ]);
       }
   }

   public function show($id)
   {
       $breadcrumb = (object) [
           'title' => 'Detail Admin',
           'list' => ['Home', 'Admin', 'Detail']
       ];
       $page = (object) [
           'title' => 'Detail Data Admin'
       ];
       $activeMenu = 'admin';

       $admin = AdminModel::with(['prodi', 'level'])->findOrFail($id);
       return view('admin.show', compact('breadcrumb', 'page', 'activeMenu', 'admin'));
   }

   public function edit($id)
   {
       $breadcrumb = (object) [
           'title' => 'Edit Admin',
           'list' => ['Home', 'Admin', 'Edit']
       ];
       $page = (object) [
           'title' => 'Edit Data Admin'
       ];
       $activeMenu = 'admin';

       $admin = AdminModel::findOrFail($id);
       $prodis = ProdiModel::all();
       $levels = LevelModel::all();

       return view('admin.edit', compact('breadcrumb', 'page', 'activeMenu', 'admin', 'prodis', 'levels'));
   }

   public function update(Request $request, $id)
   {
       $admin = AdminModel::findOrFail($id);
       $validated = $request->validate([
           'admin_nama' => 'required',
           'nip' => 'required|unique:m_admin,nip,'.$id.',admin_id',
           'username' => 'required|unique:m_admin,username,'.$id.',admin_id',
           'no_telepon' => 'required',
           'prodi_id' => 'required',
           'level_id' => 'required',
           'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
       ]);

       if($request->hasFile('foto')) {
           if($admin->foto) {
               unlink(public_path('uploads/'.$admin->foto));
           }
           $foto = $request->file('foto');
           $filename = time() . '.' . $foto->getClientOriginalExtension();
           $foto->move(public_path('uploads'), $filename);
           $validated['foto'] = $filename;
       }

       $admin->update($validated);
       return redirect()->route('admin.index')->with('success', 'Admin berhasil diupdate');
   }

   public function update_ajax(Request $request, $id)
   {
       $admin = AdminModel::findOrFail($id);
       $validated = $request->validate([
           'admin_nama' => 'required',
           'nip' => 'required|unique:m_admin,nip,'.$id.',admin_id',
           'username' => 'required|unique:m_admin,username,'.$id.',admin_id',
           'no_telepon' => 'required',
           'prodi_id' => 'required',
           'level_id' => 'required'
       ]);

       try {
           $admin->update($validated);
           return response()->json([
               'status' => true,
               'message' => 'Admin berhasil diupdate'
           ]);
       } catch (\Exception $e) {
           return response()->json([
               'status' => false,
               'message' => 'Gagal mengupdate admin',
               'msgField' => $e->getMessage()
           ]);
       }
   }

   public function destroy($id)
   {
       try {
           $admin = AdminModel::findOrFail($id);
           if($admin->foto) {
               unlink(public_path('uploads/'.$admin->foto));
           }
           $admin->delete();
           return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus');
       } catch (\Exception $e) {
           return redirect()->route('admin.index')->with('error', 'Gagal menghapus admin');
       }
   }

   public function confirm_ajax($id) 
   {
       $admin = AdminModel::with(['prodi', 'level'])->find($id);
       
       if($admin) {
           return response()->json([
               'status' => true,
               'data' => $admin
           ]);
       }

       return response()->json([
           'status' => false,
           'message' => 'Data admin tidak ditemukan'
       ]);
   }

   public function import_ajax(Request $request)
   {
       $request->validate([
           'file_admin' => 'required|mimes:xlsx'
       ]);

       try {
           $file = $request->file('file_admin');
           $spreadsheet = IOFactory::load($file->getPathname());
           $worksheet = $spreadsheet->getActiveSheet();
           $rows = $worksheet->toArray();
           array_shift($rows);

           foreach($rows as $row) {
               AdminModel::create([
                   'admin_nama' => $row[0],
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
               'msgField' => ['file_admin' => [$e->getMessage()]]
           ]);
       }
   }
}