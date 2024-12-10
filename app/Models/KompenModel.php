<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KompenModel extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'm_kompen';

    // Primary key
    protected $primaryKey = 'kompen_id';

    // Kolom yang dapat diisi
    protected $fillable = [
        'status',
        'tanggal_kompen',
        'chatbox',
        'tugas_id',
        'mahasiswa_id',
    ];

    // Format otomatis untuk tipe data tertentu
    protected $casts = [
        'tanggal_kompen' => 'date',
    ];

    /**
     * Relasi ke tabel `m_tugas` (One-to-One atau BelongsTo)
     */
    public function tugas(): BelongsTo
    {
        return $this->belongsTo(TugasModel::class, 'tugas_id', 'tugas_id')
            ->withDefault(); // Menghindari null values untuk relasi
    }

    /**
     * Relasi ke tabel `m_mahasiswa` (One-to-One atau BelongsTo)
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }

    /**
     * Accessor untuk memformat nilai kolom status
     */
    public function getStatusAttribute($value): string
    {
        return ucfirst($value); // Contoh: 'proses' menjadi 'Proses'
    }

    /**
     * Scope untuk mencari data berdasarkan mahasiswa
     */
    public function scopeByMahasiswa($query, $mahasiswa_id)
    {
        return $query->where('mahasiswa_id', $mahasiswa_id);
    }

    /**
     * Scope untuk mencari data yang sedang diproses
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'proses')
            ->whereDate('tanggal_kompen', '<=', now());
    }
}