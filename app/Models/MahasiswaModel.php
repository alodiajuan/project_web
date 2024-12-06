<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tymon\JWTAuth\Contracts\JWTSubject;

class MahasiswaModel extends Authenticatable implements JWTSubject
{
    use HasFactory;
    
    public function getJWTIdentifier(){
        return $this->getKey();
    }
    public function getJWTCustomClaims(){
        return[];
    }

    // Nama tabel dan primary key
    protected $table = 'm_mahasiswa';
    protected $primaryKey = 'mahasiswa_id';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'username', 
        'password', 
        'mahasiswa_nama', 
        'foto', 
        'nim', 
        // 'kompetensi', 
        'semester', 
        'level_id', 
        'prodi_id', 
        'kompetensi_id', 
        'created_at', 
        'updated_at'
    ];

    // Kolom yang disembunyikan dari array atau JSON
    protected $hidden = ['password'];

    // Cast untuk password (hashed)
    protected $casts = [
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke tabel level
     * @return BelongsTo
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    /**
     * Relasi ke tabel prodi
     * @return BelongsTo
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(ProdiModel::class, 'prodi_id', 'prodi_id');
    }

    /**
     * Relasi ke tabel kompetensi
     * @return BelongsTo
     */
    public function kompetensi(): BelongsTo
    {
        return $this->belongsTo(KompetensiModel::class, 'kompetensi_id', 'kompetensi_id');
    }

    // Menggunakan getFotoAttribute untuk menghindari konflik
    protected function getFotoAttribute($foto)
    {
        return $foto ? url('/uploads/' . $foto) : null;
    }
}