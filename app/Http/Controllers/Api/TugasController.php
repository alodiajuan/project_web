<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TugasModel;
use App\Models\KategoriModel;
use App\Models\SdmModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TugasController extends Controller
{
    /**
     * Tampilkan daftar tugas untuk Beranda.
     * 
     * This method fetches data for the home screen, showing tasks and their basic details.
     */
    public function beranda(Request $request)
    {
        // Query to fetch tasks with categories and sdm data
        $query = TugasModel::with(['kategori', 'sdm']);

        // Optionally filter tasks based on provided parameters
        if ($request->has('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->has('sdm_id')) {
            $query->where('sdm_id', $request->sdm_id);
        }

        // Fetch tasks with pagination or as a full collection
        $tugas = $query->paginate(10); // Paginate results, can be adjusted as needed

        return response()->json([
            'success' => true,
            'data' => $tugas
        ]);
    }

    /**
     * Tampilkan daftar tugas.
     */
    public function index(Request $request)
    {
        $query = TugasModel::with(['kategori', 'sdm']);

        if ($request->has('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->has('sdm_id')) {
            $query->where('sdm_id', $request->sdm_id);
        }

        $tugas = $query->get();

        return response()->json([
            'success' => true,
            'data' => $tugas
        ]);
    }

    /**
     * Tampilkan detail tugas berdasarkan ID.
     */
    public function show($id)
    {
        $tugas = TugasModel::with(['kategori', 'sdm'])->find($id);

        if (!$tugas) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $tugas
        ]);
    }

    /**
     * Simpan data tugas baru.
     */
    public function store(Request $request)
    {
        $rules = [
            'tugas_kode' => 'required|string|max:20|unique:m_tugas',
            'tugas_nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jam_kompen' => 'required|integer',
            'status_dibuka' => 'required|in:dibuka,ditutup',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after:tanggal_mulai',
            'kategori_id' => 'required|integer|exists:m_kategori,kategori_id',
            'sdm_id' => 'required|integer|exists:m_sdm,sdm_id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $tugas = TugasModel::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil disimpan.',
            'data' => $tugas
        ]);
    }

    /**
     * Perbarui data tugas berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $tugas = TugasModel::find($id);

        if (!$tugas) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ditemukan.'
            ], 404);
        }

        $rules = [
            'tugas_kode' => 'sometimes|string|max:20|unique:m_tugas,tugas_kode,' . $id . ',tugas_id',
            'tugas_nama' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string',
            'jam_kompen' => 'sometimes|integer',
            'status_dibuka' => 'sometimes|in:dibuka,ditutup',
            'tanggal_mulai' => 'sometimes|date',
            'tanggal_akhir' => 'sometimes|date|after:tanggal_mulai',
            'kategori_id' => 'sometimes|integer|exists:m_kategori,kategori_id',
            'sdm_id' => 'sometimes|integer|exists:m_sdm,sdm_id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $tugas->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil diperbarui.',
            'data' => $tugas
        ]);
    }

    /**
     * Hapus tugas berdasarkan ID.
     */
    public function destroy($id)
    {
        $tugas = TugasModel::find($id);

        if (!$tugas) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ditemukan.'
            ], 404);
        }

        $tugas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus.'
        ]);
    }
}
