<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function me(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'profile';

        $user = Auth::user();
        $role = $user->role;

        $prodi = Prodi::all();

        $kompetensi = Competence::all();

        return view('profile', compact('user', 'prodi', 'kompetensi', 'role', 'activeMenu', 'breadcrumb'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());
        $role = $user->role;

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'foto_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|string|min:8',
            'semester' => $role === 'mahasiswa' ? 'required|integer|min:1|max:14' : 'nullable|integer|min:1|max:14',
            'id_kompetensi' => $role === 'mahasiswa' ? 'required|exists:competence,id' : 'nullable|exists:competence,id',
            'id_prodi' => $role === 'mahasiswa' ? 'required|exists:prodi,id' : 'nullable|exists:prodi,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->nama = $request->input('nama');
        $user->username = $request->input('username');

        if ($request->hasFile('foto_profile')) {

            if ($user->foto_profile && file_exists(public_path($user->foto_profile))) {
                unlink(public_path($user->foto_profile));
            }


            $file = $request->file('foto_profile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/foto_profile'), $fileName);
            $user->foto_profile = 'uploads/foto_profile/' . $fileName;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($role === 'mahasiswa') {
            $user->semester = $request->input('semester');
            $user->id_kompetensi = $request->input('id_kompetensi');
            $user->id_prodi = $request->input('id_prodi');
        }

        $user->save();

        return redirect("/profile")->with('success', 'Profil berhasil diperbarui.');
    }

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
            'alfa' => 'required|integer',
            'compensation' => 'required|integer',
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
            'alfa' => 'required|integer',
            'compensation' => 'required|integer',
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

    public function sdm(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'sdm';

        $sdm = User::whereIn('role', ['admin', 'dosen', 'tendik'])->get();

        return view('sdm.index', compact('sdm', 'breadcrumb', 'activeMenu'));
    }

    public function sdmEdit(Request $request, $id)
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'sdm';

        $sdm = User::find($id);

        return view('sdm.edit', compact('sdm', 'breadcrumb', 'activeMenu'));
    }

    public function sdmCreate(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'sdm';

        return view('sdm.create', compact('breadcrumb', 'activeMenu'));
    }

    public function sdmStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => 'required|max:12|unique:users',
            'role' => 'required',
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
            'foto_profile' => $photo_filename,
            'role' => $request->input('role'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect("/sdm")->with('success', 'Data sdm berhasil ditambahkan.');
    }

    public function sdmUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => 'required|max:16',
            'role' => 'required',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $sdm = User::findOrFail($id);

        $sdm->nama = $request->input('nama');
        $sdm->username = $request->input('username');
        $sdm->role = $request->input('role');

        if ($request->filled('password')) {
            $sdm->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('foto_profile')) {
            if ($sdm->foto_profile && file_exists(public_path('images/' . $sdm->foto_profile))) {
                unlink(public_path('images/' . $sdm->foto_profile));
            }

            $photo = $request->file('foto_profile');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $filename);

            $sdm->foto_profile = $filename;
        }

        $sdm->save();

        return redirect('/sdm')->with('success', 'Data sdm berhasil diperbarui.');
    }

    public function sdmDestroy($id)
    {
        $sdm = User::findOrFail($id);

        if ($sdm->foto_profile && file_exists(public_path('images/' . $sdm->foto_profile))) {
            unlink(public_path('images/' . $sdm->foto_profile));
        }

        $sdm->delete();

        return redirect('/sdm')->with('success', 'Data sdm berhasil dihapus.');
    }
}
