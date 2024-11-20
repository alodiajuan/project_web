<?php

namespace App\Http\Controllers;

use App\Models\TugasModel;
use App\Models\KategoriModel;
use App\Models\SdmModel;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class TugasController extends Controller
{
    // Menampilkan daftar tugas
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Tugas',
            'list' => ['Home', 'Tugas']
        ];
        $page = (object) [
            'title' => 'Daftar tugas yang telah dipublikasi',
        ];
        $activeMenu = 'tugas'; // Set menu yang sedang aktif
        $tugas = tugasModel::all(); // Ambil data tugas untuk filter tugas
        return view('tugas.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'tugas' => $tugas,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan detail tugas
    public function show(string $id)
    {
        $tugas = TugasModel::with('tugas')->find($id);
        if (!$tugas) {
            return redirect('/tugas')->with('error', 'Data tugas tidak ditemukan');
        }
        $breadcrumb = (object) [
            'title' => 'Detail tugas',
            'list' => ['Home', 'tugas', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail tugas',
        ];
        $activeMenu = 'tugas'; // Set menu yang sedang aktif
        return view('tugas.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'tugas' => $tugas,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan form create tugas dengan tugas
    public function create_ajax()
    {
        $tugas = tugasModel::select('tugas_id', 'tugas_nama')->get();
        return view('tugas.create_ajax')->with('tugas', $tugas);
    }

    // Ambil data tugas dalam bentuk JSON untuk DataTables
    public function list(Request $request)
    {
        $tugas = TugasModel::select('tugas_id', 'tugas_kode', 'tugas_nama', 'deskripsi', 'jam_kompen', 'status_dibuka', 'tanggal_mulai', 'tanggal_akhir', 'tugas_id', 'sdm_id', 'admin_id')
            ->with('tugas');

        // Filter berdasarkan tugas jika ada
        if ($request->tugas_id) {
            $tugas->where('tugas_id', $request->tugas_id);
        }

        return DataTables::of($tugas)
            ->addIndexColumn()
            ->addColumn('aksi', function ($tugas) {
                $btn = '<a href="' . url('/tugas/' . $tugas->tugas_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/tugas/' . $tugas->tugas_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/tugas/' . $tugas->tugas_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'tugas_kode' => 'required|string|min:3|unique:m_tugas,tugas_kode',
                'tugas_nama' => 'required|string|max:255', //nama harus diisi,
                'deskripsi' => 'required|string', // deskripsi opsional
                'jam_kompen' => 'required|integer', // jam_kompen wajib diisi dengan angka
                'status_dibuka' => 'required|boolean', // status_dibuka wajib diisi dengan nilai boolean
                'tanggal_mulai' => 'required|date', // tanggal_mulai wajib diisi dengan format tanggal
                'tanggal_akhir' => 'required|date|after:tanggal_mulai', // tanggal_akhir wajib diisi dan harus setelah tanggal_mulai
                'tugas_id' => 'required|integer|exists:m_tugas,tugas_id', // tugas_id wajib dan harus ada di tabel m_tugas
                'sdm_id' => 'nullable|integer|exists:m_sdm,sdm_id', // sdm_id opsional, harus berupa angka, dan harus ada di tabel m_sdm
                'admin_id' => 'nullable|integer|exists:m_admin,admin_id', // admin_id opsional, harus berupa angka, dan harus ada di tabel m_admin
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
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
        // cek apakah request dari ajax
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

    // Menampilkan halaman form edit tugas ajax
    public function edit_ajax(string $id)
    {
        $tugas = TugasModel::find($id);
        $tugas = tugasModel::select('tugas_id', 'tugas_nama')->get();
        return view('tugas.edit_ajax', ['tugas' => $tugas, 'tugas' => $tugas]);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'tugas_kode' => 'required|string|min:3|unique:m_tugas,tugas_kode',
                'tugas_nama' => 'required|string|max:255', //nama harus diisi,
                'deskripsi' => 'required|string', // deskripsi opsional
                'jam_kompen' => 'required|integer', // jam_kompen wajib diisi dengan angka
                'status_dibuka' => 'required|boolean', // status_dibuka wajib diisi dengan nilai boolean
                'tanggal_mulai' => 'required|date', // tanggal_mulai wajib diisi dengan format tanggal
                'tanggal_akhir' => 'required|date|after:tanggal_mulai', // tanggal_akhir wajib diisi dan harus setelah tanggal_mulai
                'tugas_id' => 'required|integer|exists:m_tugas,tugas_id', // tugas_id wajib dan harus ada di tabel m_tugas
                'sdm_id' => 'nullable|integer|exists:m_sdm,sdm_id', // sdm_id opsional, harus berupa angka, dan harus ada di tabel m_sdm
                'admin_id' => 'nullable|integer|exists:m_admin,admin_id', // admin_id opsional, harus berupa angka, dan harus ada di tabel m_admin
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'    => false, // response status, false: error/gagal, true: berhasil
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(), // pesan error validasi
                ]);
            }
            TugasModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data tugas berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function import()
    {
        return view('tugas.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
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
            $file = $request->file('file_tugas'); // ambil file dari request
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
                            'tugas_kode' => $value['A'],
                            'tugas_nama' => $value['A'], //nama harus diisi,
                            'deskripsi' => $value['B'], // deskripsi opsional
                            'jam_kompen' => $value['C'], // jam_kompen wajib diisi dengan angka
                            'status_dibuka' => $value['D'], // status_dibuka wajib diisi dengan nilai boolean
                            'tanggal_mulai' => $value['E'], // tanggal_mulai wajib diisi dengan format tanggal
                            'tanggal_akhir' => $value['F'], // tanggal_akhir wajib diisi dan harus setelah tanggal_mulai
                            'tugas_id' => $value['G'], // tugas_id wajib dan harus ada di tabel m_tugas
                            'sdm_id' => $value['H'], // sdm_id opsional, harus berupa angka, dan harus ada di tabel m_sdm
                            'admin_id' => $value['I'], // admin_id opsional, harus berupa angka, dan harus ada di tabel m_admin
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
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
        //ambil data tugas yang akan di export
        $tugas = TugasModel::select('tugas_id', 'tugas_kode', 'tugas_nama', 'deskripsi', 'jam_kompen', 'status_dibuka', 'tanggal_mulai', 'tanggal_akhir', 'tugas_id', 'sdm_id', 'admin_id')
            ->orderBy('tugas_id')    
            ->with('tugas')
            ->get();
    
        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); //ambil sheet yang aktif
    
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Tugas');
        $sheet->setCellValue('C1', 'Nama Tugas');
        $sheet->setCellValue('D1', 'Jam Kompen');
        $sheet->setCellValue('E1', 'Status');
        $sheet->setCellValue('F1', 'Periode');
        $sheet->setCellValue('G1', 'tugas');
        $sheet->getStyle('A1:G1')->getFont()->setBold(true); // Bold header
    
        $no = 1;
        $baris = 2;
        foreach ($tugas as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->tugas_kode);
            $sheet->setCellValue('C' . $baris, $value->tugas_nama);
            $sheet->setCellValue('D' . $baris, $value->jam_kompen);
            $sheet->setCellValue('E' . $baris, $value->status_dibuka ? 'Dibuka' : 'Ditutup');
            $sheet->setCellValue('F' . $baris, $value->tanggal_mulai . ' - ' . $value->tanggal_akhir);
            $sheet->setCellValue('G' . $baris, $value->tugas->tugas_nama); // ambil nama tugas
            $baris++;
            $no++;
        }
    
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
    
        $sheet->setTitle('Data tugas'); // set title sheet
    
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data tugas ' . date('Y-m-d H:i:s') . '.xlsx';
    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
    
        $writer->save('php://output');
        exit;
    }
    

    public function export_pdf()
    {
        set_time_limit(120);

        $tugas = TugasModel::select('tugas_id', 'tugas_kode', 'tugas_nama', 'deskripsi', 'jam_kompen', 'status_dibuka', 'tanggal_mulai', 'tanggal_akhir', 'tugas_id', 'sdm_id', 'admin_id')
            ->orderBy('tugas_id')    
            ->with('tugas')
            ->get();
    

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('tugas.export_pdf', ['tugas' => $tugas]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data tugas ' . date('Y-m-d H:i:s') . '.pdf');
        // ini_set (set_time_limit(3600), 3600);

    }
}
