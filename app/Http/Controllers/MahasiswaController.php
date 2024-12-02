<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\ProdiModel;
use App\Models\KompetensiModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MahasiswaController extends Controller
{
    // Menampilkan halaman awal mahasiswa
    public function index()
    {
        $prodi = ProdiModel::all(); // ambil data level untuk filter level

        $breadcrumb = (object)[
            'title' => 'Daftar Mahasiswa',
            'list' => ['Home', 'Mahasiswa']
        ];

        $page = (object) [
            'title' => 'Daftar mahasiswa yang terdaftar dalam sistem'
        ];

        $activeMenu = 'mahasiswa'; // set menu sedang active

        return view('mahasiswa.index', compact('prodi', 'breadcrumb', 'page', 'activeMenu'));
    }
    public function create_ajax()
    {
        $level = LevelModel::all();
        $kompetensi = KompetensiModel::all();
        $prodi = ProdiModel::all();
        return view('mahasiswa.create_ajax',  compact('level', 'kompetensi', 'prodi'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
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
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads'), $filename);
            $validated['foto'] = $filename;
        }

        MahasiswaModel::create($validated);
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function store_ajax(Request $request)
    {
        try {
            $validated = $request->validate([
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
            ]);

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $filename = time() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('uploads'), $filename);
                $validated['foto'] = $filename;
            }

            $validated['password'] = bcrypt($validated['password']);

            MahasiswaModel::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Mahasiswa berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan Mahasiswa',
                'msgField' => ['error' => [$e->getMessage()]]
            ]);
        }
    }
    
    // Mengambil data mahasiswa untuk DataTables
    public function list(Request $request)
    {
        $mahasiswa = MahasiswaModel::select('mahasiswa_id', 'mahasiswa_nama', 'nim', 'username', 'kompetensi', 'semester', 'foto', 'level_id', 'kompetensi_id', 'prodi_id')
            ->with('level', 'prodi', 'kompetensi');

        // Filter data mahasiswa berdasarkan level_id
        if ($request->level_id) {
            $mahasiswa->where('level_id', $request->level_id);
        } elseif ($request->prodi_id) {
            $mahasiswa->where('prodi_id', $request->prodi_id);
        } elseif ($request->kompetensi_id) {
            $mahasiswa->where('kompetensi_id', $request->kompetensi_id);
        } 

        return DataTables::of($mahasiswa)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom:DT_RowIndex) 
            ->addColumn('aksi', function ($mahasiswa) { // menambahkan kolom aksi
                $btn = '<a href="' . url('mahasiswa/' . $mahasiswa->mahasiswa_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $mahasiswa->mahasiswa_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $mahasiswa->mahasiswa_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    public function show($id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Mahasiswa',
            'list' => ['Home', 'mahasiswa', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail Data Mahasiswa'
        ];
        $activeMenu = 'mahasiswa';

        $mahasiswa = MahasiswaModel::with(['prodi', 'level'])->findOrFail($id);
        return view('mahasiswa.show', compact('breadcrumb', 'page', 'activeMenu', 'mahasiswa'));
    }

    public function edit_ajax(string $id)
    {
        $mahasiswa = MahasiswaModel::find($id);
        $prodi = ProdiModel::all();
        $level = LevelModel::all();
        $kompetensi = KompetensiModel::all();
        return view('mahasiswa.edit_ajax', compact('mahasiswa', 'prodi', 'level', 'kompetensi'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = MahasiswaModel::findOrFail($id);
        $validated = $request->validate([
            'mahasiswa_nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:m_mahasiswa,nim,' . $id . ',mahasiswa_id',
            'username' => 'nullable|string|max:50',
            'kompetensi' => 'nullable|string|max:255',
            'semester' => 'nullable|integer|min:1|max:14',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'prodi_id' => 'required|integer',
            'kompetensi_id' => 'nullable|integer',
            'level_id' => 'nullable|integer',
        ]);

        if ($request->hasFile('foto')) {
            if ($mahasiswa->foto) {
                unlink(public_path('uploads/' . $mahasiswa->foto));
            }
            $foto = $request->file('foto');
            $filename = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads'), $filename);
            $validated['foto'] = $filename;
        }

        $mahasiswa->update($validated);
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diupdate');
    }

    public function destroy($id)
    {
        try {
            $mahasiswa = MahasiswaModel::findOrFail($id);
            if ($mahasiswa->foto && file_exists(public_path('uploads/' . $mahasiswa->foto))) {
                unlink(public_path('uploads/' . $mahasiswa->foto));
            }
            $mahasiswa->delete();
            return response()->json([
                'status' => true,
                'message' => 'Mahasiswa berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus Mahasiswa'
            ]);
        }
    }

    public function import()
    {
        return view('mahasiswa.import');
    }

    public function import_ajax(Request $request)
    {
        $request->validate([
            'file_mahasiswa' => 'required|mimes:xlsx'
        ]);

        try {
            $file = $request->file('file_mahasiswa');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            array_shift($rows); // Hapus baris header

            foreach ($rows as $row) {
                MahasiswaModel::create([
                    'mahasiswa_nama' => $row[0],
                    'nim' => $row[1],
                    'username' => $row[2],
                    'password' => bcrypt($row[3]),
                    'kompetensi' => $row[4],
                    'semester' => $row[5],
                    'prodi_id' => $row[6],
                    'kompetensi_id' => $row[7],
                    'level_id' => $row[8]
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
                'msgField' => ['file_mahasiswa' => [$e->getMessage()]]
            ]);
        }
    }

    public function export_excel()
    {
        $mahasiswa = MahasiswaModel::with(['prodi', 'level'])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Mahasiswa');
        $sheet->setCellValue('C1', 'NIM');
        $sheet->setCellValue('D1', 'Username');
        $sheet->setCellValue('E1', 'Kompetensi');
        $sheet->setCellValue('F1', 'Semester');
        $sheet->setCellValue('G1', 'Program Studi');
        $sheet->setCellValue('H1', 'Level');

        // Isi data
        $row = 2;
        foreach ($mahasiswa as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->mahasiswa_nama);
            $sheet->setCellValue('C' . $row, $item->nim);
            $sheet->setCellValue('D' . $row, $item->username);
            $sheet->setCellValue('E' . $row, $item->kompetensi);
            $sheet->setCellValue('F' . $row, $item->semester);
            $sheet->setCellValue('G' . $row, $item->prodi->prodi_nama);
            $sheet->setCellValue('H' . $row, $item->level->level_nama);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data Mahasiswa.xlsx"');
        $writer->save('php://output');
    }
}
