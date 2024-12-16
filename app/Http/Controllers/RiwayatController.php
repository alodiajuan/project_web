<?php

namespace App\Http\Controllers;

use App\Models\Compensation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $compensations = Compensation::with('task', 'mahasiswa', 'dosen')->get();

        $breadcrumb = (object) [
            'title' => 'Riwayat Kompensasi',
            'list' => ['Home', 'Riwayat Kompensasi']
        ];

        $page = (object) [
            'title' => 'Daftar Kompensasi Tugas yang Terdaftar'
        ];

        $activeMenu = 'riwayat';

        return view('riwayat.index', compact('compensations', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function show($id)
    {
        $compensation = Compensation::with('task', 'mahasiswa', 'dosen')->findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kompensasi Tugas',
            'list' => ['Home', 'Riwayat Kompensasi', 'Detail Kompensasi']
        ];

        $page = (object) [
            'title' => 'Detail Kompensasi Tugas'
        ];

        $activeMenu = 'riwayat';

        return view('riwayat.show', compact('compensation', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function download($id)
    {
        $compensation = Compensation::findOrFail($id);

        $compensation = Compensation::with([
            'dosen:id,nama,username',
            'mahasiswa:id,nama,username',
            'task:id,judul,bobot',
        ])->find($id);

        if (!$compensation) {
            abort(404, 'Compensation record not found');
        }

        $kaprodi = ["nama" => "Hendra Pradibta, SE., M.Se", "nip" => "198305212006041003"];


        $pdf = Pdf::loadView('riwayat.pdf', compact('compensation', 'kaprodi'))
            ->setPaper('a4', 'landscape')
            ->set_option('isHtml5ParserEnabled', true)
            ->setOption('dpi', 96);

        return $pdf->download('kompensasi.pdf');
    }
}
