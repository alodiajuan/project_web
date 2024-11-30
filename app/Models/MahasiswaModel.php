<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class MahasiswaModel extends Authenticatable
{
    use HasFactory;

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
        'kompetensi', 
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

    /**
     * Akses URL foto dari storage
     * @return Attribute
     */
    protected function foto(): Attribute
    {
        return Attribute::make(
            get: fn($foto) => $foto ? url('/storage/images/' . $foto) : null
        );
    }

    /**
     * Mendapatkan nama role dari tabel level
     * @return string
     */
    public function getRoleName(): string
    {
        return $this->level ? $this->level->level_nama : 'Unknown';
    }

    /**
     * Mengecek apakah user memiliki role tertentu
     * @param string $role
     * @return bool
     */
    public function hasRole($role): bool
    {
        return $this->level && $this->level->level_kode == $role;
    }

    /**
     * Mendapatkan kode role dari tabel level
     * @return string|null
     */
    public function getRole()
    {
        return $this->level ? $this->level->level_kode : null;
    }
}