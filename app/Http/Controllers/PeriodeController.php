<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeriodeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Periode',
            'list' => ['Home', 'Periode']
        ];

        $page = (object) [
            'title' => 'Daftar Periode yang terdaftar dalam sistem'
        ];

        $activeMenu = 'periode';

        $periode = Periode::all();

        return view('periode.index', compact('breadcrumb', 'page', 'activeMenu', 'periode'));
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Periode',
            'list' => ['Home', 'Periode', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Periode Baru'
        ];

        $activeMenu = 'periode';

        return view('periode.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:ganjil,genap',
            'semester' => 'required|integer|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Periode::create($request->all());

        return redirect("/periode")->with('success', 'Periode berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Periode',
            'list' => ['Home', 'Periode', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Periode yang dipilih'
        ];

        $activeMenu = 'periode';

        $periode = Periode::findOrFail($id);

        return view('periode.edit', compact('breadcrumb', 'page', 'activeMenu', 'periode'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:ganjil,genap',
            'semester' => 'required|integer|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $periode = Periode::findOrFail($id);
        $periode->update($request->all());

        return redirect("/periode")->with('success', 'Periode berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $periode = Periode::findOrFail($id);
        $periode->delete();

        return redirect("/periode")->with('success', 'Periode berhasil dihapus.');
    }
}
