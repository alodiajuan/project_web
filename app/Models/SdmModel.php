<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SdmModel extends Authenticatable 
{
    use HasFactory;

    protected $table = 'm_sdm'; // Sesuaikan dengan nama tabel
    protected $primaryKey = 'sdm_id'; // Primary key
    protected $fillable = ['sdm_nama', 'nip', 'username', 'password', 'no_telepon', 'foto', 'prodi_id', 'level_id', 'created_at', 'updated_at'];
    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];

    // Relasi ke model Level
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
    
    // Relasi ke model Prodi
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(ProdiModel::class, 'prodi_id', 'prodi_id');
    }

    // Menggunakan getFotoAttribute untuk menghindari konflik
    protected function getFotoAttribute($foto)
    {
        return $foto ? url('/storage/images/' . $foto) : null;
    }

    public function getRoleName(): string
    {
        return $this->level ? $this->level->level_nama : 'Unknown';
    }

    public function hasRole($role): bool
    {
        return $this->level && $this->level->level_kode == $role;
    }

    public function getRole()
    {
        return $this->level ? $this->level->level_kode : null;
    }
}