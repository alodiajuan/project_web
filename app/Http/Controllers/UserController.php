<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function mahasiswa(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'mahasiswa';

        $prodi_id = $request->input('prodi_id');

        $mahasiswaQuery = User::with(['prodi', 'competence'])->where('role', 'mahasiswa');

        if ($prodi_id) {
            $mahasiswaQuery->where('id_prodi', $prodi_id);
        }

        $mahasiswa = $mahasiswaQuery->get();

        $prodi = Prodi::all();

        return view('mahasiswa.index', compact('mahasiswa', 'prodi', 'breadcrumb', 'activeMenu'));
    }

    public function mahasiswaEdit(Request $request, $id)
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'mahasiswa';

        $mahasiswa = User::with(['prodi', 'competence'])->where('id', $id)->first();
        $prodi = Prodi::all();
        $kompetensi = Competence::all();

        return view('mahasiswa.edit', compact('mahasiswa', 'kompetensi', 'prodi', 'breadcrumb', 'activeMenu'));
    }

    public function mahasiswaCreate(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'mahasiswa';

        $prodi = Prodi::all();
        $kompetensi = Competence::all();

        return view('mahasiswa.create', compact('kompetensi', 'prodi', 'breadcrumb', 'activeMenu'));
    }

    public function mahasiswaStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => 'required|max:12|unique:users',
            'prodi_id' => 'required|exists:prodi,id',
            'kompetensi' => 'nullable|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
            'foto_profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $photo_filename = null;

        if ($request->hasFile('foto_profile')) {
            $photo = $request->file('foto_profile');
            $photo_filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $photo_filename);
        }

        User::create([
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'id_prodi' => $request->input('prodi_id'),
            'id_kompetensi' => $request->input('kompetensi_id'),
            'semester' => $request->input('semester'),
            'foto_profile' => $photo_filename,
            'role' => 'mahasiswa',
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect("/mahasiswa")->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function mahasiswaUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => 'required|max:16',
            'prodi_id' => 'required|exists:prodi,id',
            'kompetensi' => 'nullable|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mahasiswa = User::findOrFail($id);

        $mahasiswa->nama = $request->input('nama');
        $mahasiswa->username = $request->input('username');
        $mahasiswa->id_prodi = $request->input('prodi_id');
        $mahasiswa->id_kompetensi = $request->input('kompetensi_id');
        $mahasiswa->semester = $request->input('semester');

        if ($request->filled('password')) {
            $mahasiswa->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('foto_profile')) {
            if ($mahasiswa->foto_profile && file_exists(public_path('images/' . $mahasiswa->foto_profile))) {
                unlink(public_path('images/' . $mahasiswa->foto_profile));
            }

            $photo = $request->file('foto_profile');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $filename);

            $mahasiswa->foto_profile = $filename;
        }

        $mahasiswa->save();

        return redirect('/mahasiswa')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function mahasiswaDestroy($id)
    {
        $mahasiswa = User::findOrFail($id);

        if ($mahasiswa->foto_profile && file_exists(public_path('images/' . $mahasiswa->foto_profile))) {
            unlink(public_path('images/' . $mahasiswa->foto_profile));
        }

        $mahasiswa->delete();

        return redirect('/mahasiswa')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
