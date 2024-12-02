<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TugasModel extends Model
{
    use HasFactory;

    protected $table = 'm_tugas';
    protected $primaryKey = 'tugas_id';

    protected $fillable = [
        'tugas_kode',
        'tugas_nama',
        'deskripsi',
        'jam_kompen',
        'status_dibuka',
        'tanggal_mulai',
        'tanggal_akhir',
        'kategori_id',
        'sdm_id',
    ];

    protected $casts = [
        'jam_kompen' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date'
    ];

    /**
     * Relasi dengan tabel SDM
     */
    public function sdm(): BelongsTo
    {
        return $this->belongsTo(SdmModel::class, 'sdm_id', 'sdm_id')
            ->withDefault();
    }

    /**
     * Relasi dengan tabel Kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }

    /**
     * Format status dibuka ke dalam bentuk deskripsi
     */
    public function getStatusDibukaAttribute($value)
    {
        return ucfirst($value); // Return 'Dibuka' atau 'Ditutup'
    }

    /**
     * Scope untuk mencari tugas berdasarkan kategori
     */
    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }

    /**
     * Scope untuk mencari tugas yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status_dibuka', 'dibuka')
            ->whereDate('tanggal_mulai', '<=', now())
            ->whereDate('tanggal_akhir', '>=', now());
    }
}