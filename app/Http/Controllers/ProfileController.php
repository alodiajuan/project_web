<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaModel;
use App\Models\SdmModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan profil pengguna berdasarkan guard
    public function index()
    {
        if (Auth::guard('mahasiswa')->check()) {
            $profile = MahasiswaModel::findOrFail(Auth::guard('mahasiswa')->id());
            $userType = 'mahasiswa';
        } elseif (Auth::guard('sdm')->check()) {
            $profile = SdmModel::findOrFail(Auth::guard('sdm')->id());
            $userType = 'sdm';
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Anda harus login terlebih dahulu']);
        }

        // Breadcrumb untuk halaman profil
        $breadcrumb = (object) [
            'title' => 'Data Profil',
            'list' => [
                ['name' => 'Home', 'url' => url('/')],
                ['name' => 'Profil', 'url' => url('/profile')],
            ],
        ];
        $activeMenu = 'profile';

        return view('profile', compact('profile', 'userType'), [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
        ]);
    }

    // Update profil berdasarkan guard
    public function update(Request $request)
    {
        // Identifikasi pengguna berdasarkan guard
        if (Auth::guard('mahasiswa')->check()) {
            $profile = MahasiswaModel::findOrFail(Auth::guard('mahasiswa')->id());
            $userType = 'mahasiswa';
            $validationRules = [
                'username' => 'required|string|min:3|unique:m_mahasiswa,username,' . $profile->mahasiswa_id . ',mahasiswa_id',
                'mahasiswa_nama' => 'required|string|max:100',
                'nim' => 'required|string|size:10',
                'semester' => 'required|integer|between:1,8',
                'kompetensi_id' => 'nullable|exists:m_kompetensi,kompetensi_id',
                'prodi_id' => 'required|exists:m_prodi,prodi_id',
                'old_password' => 'nullable|string',
                'password' => 'nullable|min:5',
                'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            ];
        } elseif (Auth::guard('sdm')->check()) {
            $profile = SdmModel::findOrFail(Auth::guard('sdm')->id());
            $userType = 'sdm';
            $validationRules = [
                'username' => 'required|string|min:3|unique:m_sdm,username,' . $profile->sdm_id . ',sdm_id',
                'sdm_nama' => 'required|string|max:100',
                'nip' => 'required|string|size:13',
                'no_telepon' => 'required|string|max:15',
                'level_id' => 'required|exists:m_level,level_id',
                'prodi_id' => 'required|exists:m_prodi,prodi_id',
                'old_password' => 'nullable|string',
                'password' => 'nullable|min:5',
                'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            ];
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Anda harus login terlebih dahulu']);
        }
    
        // Validasi input
        $validatedData = $request->validate($validationRules);
    
        // Perbarui data dasar
        $profile->fill($validatedData);
    
        // Perbarui password jika disediakan
        if ($request->filled('old_password')) {
            if (Hash::check($request->old_password, $profile->password)) {
                $profile->password = Hash::make($request->password);
            } else {
                return back()
                    ->withErrors(['old_password' => 'Password lama salah'])
                    ->withInput();
            }
        }
    
        // Perbarui foto profil jika diunggah
        if ($request->hasFile('foto')) {
            if ($profile->foto && Storage::exists('public/photos/' . $profile->foto)) {
                Storage::delete('public/photos/' . $profile->foto);
            }
    
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/photos', $fileName);
            $profile->foto = $fileName;
        }
    
        $profile->save();
    
        return back()->with('status', 'Profil berhasil diperbarui');
    }
}

