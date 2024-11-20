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

    // Menentukan kolom mana yang dapat diisi (mass assignable)
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
        'admin_id',
    ];

    /**
     * Relasi dengan tabel SDM
     */
    public function sdm(): BelongsTo
    {
        return $this->belongsTo(SdmModel::class, 'sdm_id', 'sdm_id')
            ->withDefault(); // Mengembalikan nilai default jika null
    }

    /**
     * Relasi dengan tabel Admin
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(AdminModel::class, 'admin_id', 'admin_id')
            ->withDefault(); // Mengembalikan nilai default jika null
    }

    /**
     * Relasi dengan tabel Kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }

    /**
     * Boot method untuk menambahkan event saving
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($tugas) {
            // Pastikan hanya salah satu antara sdm_id atau admin_id yang diisi
            if ($tugas->sdm_id && $tugas->admin_id) {
                throw new \Exception('Hanya salah satu antara SDM atau Admin yang boleh diisi.');
            }
        });
    }

    /**
     * Format status dibuka ke dalam bentuk deskripsi
     */
    public function getStatusDibukaAttribute($value)
    {
        return $value ? 'Dibuka' : 'Ditutup';
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
        return $query->where('status_dibuka', true)
            ->whereDate('tanggal_mulai', '<=', now())
            ->whereDate('tanggal_akhir', '>=', now());
    }
}
