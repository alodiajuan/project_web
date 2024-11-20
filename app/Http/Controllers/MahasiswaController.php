<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class authenticatable

class MahasiswaController extends Authenticatable
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar mahasiswa',
            'list' => ['Home', 'mahsiswa']
        ];
        $page = (object) [
            'title' => 'Daftar mahasiswa yang terdaftar dalam sistem'
        ];

        $activeMenu = 'mahasiswa';
        return view('mahasiswa.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list()
    {
        // Sesuaikan nama kolom yang ada pada database
        $mahasiswa = MahasiswaModel::with(['prodi'])->select('mahasiswa_id', 'mahasiswa_nama', 'nim', 'semester', 'kompetensi', 'foto', 'prodi_id', 'kompetensi_id');  // Sesuaikan nama kolom dengan yang ada di database
    
        // Tidak ada filter pada mahasiswa, karena sudah dihapus komentar
        return DataTables::of($mahasiswa)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('prodi', function($row) {
                return $row->prodi ? $row->prodi->prodi_nama : '-';
            })
            ->addColumn('aksi', function ($mahasiswa) { // menambahkan kolom aksi
                // Sesuaikan URL dengan ID yang sesuai
                $btn = '<a href="' . url('/mahasiswa/' . $mahasiswa->mahasiswa_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $mahasiswa->mahasiswa_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $mahasiswa->mahasiswa_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah HTML
            ->make(true);
    }
    

    public function create()
    {
        $breadcrummb = (object)[
            'title' => 'Tambah Mahasiswa',
            'list' => ['Home', 'Mahasiswa', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Mahasiswa Baru'
        ];
        $activeMenu = 'mahasiswa';

        $prodis = ProdiModel::all();
        $levels = LevelModel::all();

        return view('mahasiswa.create', ['breadcrumb' => $breadcrummb, 'page' => $page, 'activeMenu' => $activeMenu, 'mahasiswa' => $mahasiswa]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_kode' => 'required|string|min:3|unique:m_mahasiswa,mahasiswa_kode',
            'mahasiswa_nama' => 'required|string|max:100'
        ]);
        MahasiswaModel::create([
            'mahasiswa_kode' => $request->mahasiswa_kode,
            'mahasiswa_nama' => $request->mahasiswa_nama,
        ]);
        return redirect('/mahasiswa')->with('success', 'Data mahasiswa berhasil disimpan');
    }

    // Menampilkan halaman form tambah_ajax mahasiswa
    public function create_ajax()
    {
        $mahasiswa = MahasiswaModel::select('mahasiswa_id', 'mahasiswa_nama')->get();
        return view('mahasiswa.create_ajax')->with('mahasiswa', $mahasiswa);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'mahasiswa_kode' => 'required|string|min:3|unique:m_mahasiswa,mahasiswa_kode',
                'mahasiswa_nama' => 'required|string|max:100'
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

            MahasiswaModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data mahasiswa berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function show(string $mahasiswa_id)
    {
        $mahasiswa = MahasiswaModel::find($mahasiswa_id);

        $breadcrumb = (object)[
            'title' => 'Detail mahasiswa',
            'list' => ['Home', 'mahasiswa', 'detail']
        ];
        $page = (object)[
            'title' => 'Detail mahasiswa'
        ];
        $activeMenu = 'mahasiswa';
        return view('mahasiswa.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'mahasiswa' => $mahasiswa, 'activeMenu' => $activeMenu]);
    }

    public function show_ajax(string $id)
    {
        $mahasiswa = MahasiswaModel::find($id);
        return view('mahasiswa.show_ajax', ['mahasiswa' => $mahasiswa]);
    }

    public function edit(string $mahasiswa_id)
    {
        $mahasiswa = MahasiswaModel::find($mahasiswa_id);

        $breadcrumb = (object)[
            'title' => 'Edit mahasiswa',
            'list' => ['Home', 'mahasiswa', 'edit']
        ];
        $page = (object)[
            'title' => 'Edit mahasiswa'
        ];
        $activeMenu = 'mahasiswa';
        return view('mahasiswa.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'mahasiswa' => $mahasiswa]);
    }

    public function update(Request $request, string $mahasiswa_id)
    {
        $request->validate([
            'mahasiswa_kode' => 'required|string|max:5|unique:m_mahasiswa,mahasiswa_kode',
            'mahasiswa_nama' => 'required|string|max:100'
        ]);

        $mahasiswa = MahasiswaModel::find($mahasiswa_id);
        $mahasiswa->update([
            'mahasiswa_kode' => $request->mahasiswa_kode,
            'mahasiswa_nama' => $request->mahasiswa_nama
        ]);
        return redirect('/mahasiswa')->with('success', 'Data mahasiswa berhasil diubah');
    }

    // Menampilkan halaman form edit mahasiswa Ajax
    public function edit_ajax(string $id)
    {
        $mahasiswa = MahasiswaModel::find($id);
        return view('mahasiswa.edit_ajax', ['mahasiswa' => $mahasiswa]);
    }

    // Menyimpan perubahan data user Ajax
    public function update_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'mahasiswa_kode' => 'required|string|min:3|unique:m_mahasiswa,mahasiswa_kode,' . $id . ',mahasiswa_id',
                'mahasiswa_nama' => 'required|string|max:100'
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
            $check = MahasiswaModel::find($id);
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

    public function destroy(string $mahasiswa_id)
    {
        $check = MahasiswaModel::find($mahasiswa_id);
        if (!$check) {
            return redirect('/mahasiswa')->with('error', 'Data mahasiswa tidak ditemukan');
        }
        try {
            MahasiswaModel::destroy($mahasiswa_id);
            return redirect('/mahasiswa')->with('success', 'Data mahasiswa berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/mahasiswa')->with('error', 'Data mahasiswa gagal dhapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // Menampilkan halaman confirm hapus
    public function confirm_ajax(string $id)
    {
        $mahasiswa = MahasiswaModel::find($id);
        return view('mahasiswa.confirm_ajax', ['mahasiswa' => $mahasiswa]);
    }

    // Menghapus data mahasiswa dengan AJAX
    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $mahasiswa = MahasiswaModel::find($id);
            if ($mahasiswa) {
                $mahasiswa->delete();
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
        return view('mahasiswa.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_mahasiswa' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_mahasiswa'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'mahasiswa_kode' => $value['A'],
                            'mahasiswa_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    MahasiswaModel::insertOrIgnore($insert);
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
        $mahasiswa = MahasiswaModel::select('mahasiswa_kode', 'mahasiswa_nama')
            ->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); //ambil sheet yang aktif
        // Set Header Kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode mahasiswa');
        $sheet->setCellValue('C1', 'Nama mahasiswa');
        // Buat header menjadi bold
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $no = 1; // Nomor data dimulai dari 1
        $baris = 2; // Baris data dimulai dari baris ke-2
        foreach ($mahasiswa as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->mahasiswa_kode);
            $sheet->setCellValue('C' . $baris, $value->mahasiswa_nama);
            $baris++;
            $no++;
        }
        // Set ukuran kolom otomatis untuk semua kolom
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        // Set judul sheet
        $sheet->setTitle('Data mahasiswa');
        // Buat writer
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data mahasiswa ' . date('Y-m-d H:i:s') . '.xlsx';
        // Atur Header untuk Download File Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        // Simpan file dan kirim ke output
        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $mahasiswa = MahasiswaModel::select('mahasiswa_kode', 'mahasiswa_nama')
            ->get();
        $pdf = Pdf::loadView('mahasiswa.export_pdf', ['mahasiswa' => $mahasiswa]);
        $pdf->setPaper('a4', 'portrait'); //set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); //set true jika ada gambar
        $pdf->render();
        return $pdf->stream('Data mahasiswa ' . date('Y-m-d H:i:s') . '.pdf');
    }
}