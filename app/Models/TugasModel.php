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
        'tugas_kode', 'tugas_nama', 'deskripsi', 'jam_kompen', 'status_dibuka', 'tanggal_mulai',
        'tanggal_akhir', 'sdm_id', 'kategori_id', 'created_at', 'updated_at', 'sdm_id', 'admin_id'];

    public function sdm()
    {
        return $this->belongsTo(SdmModel::class, 'sdm_id', 'sdm_id');
    }

    public function admin()
    {
        return $this->belongsTo(AdminModel::class, 'admin_id', 'admin_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }

    // Boot method untuk menambahkan event saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($tugas) {
            // Pastikan hanya salah satu dari sdm_id atau admin_id yang terisi
            if ($tugas->sdm_id && $tugas->admin_id) {
                throw new \Exception('Hanya salah satu antara SDM dan Admin yang boleh diisi.');
            }
        });
    }
}

