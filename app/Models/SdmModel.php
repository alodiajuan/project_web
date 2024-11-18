<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class SdmModel extends Model
{
    use HasFactory;

    protected $table = 'm_sdm'; // Sesuaikan dengan nama tabel
    protected $primaryKey = 'sdm_id'; // Primary key
    protected $fillable = ['sdm_nama', 'nip', 'username', 'password', 'level_id'];
    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];

    // Contoh relasi ke model level jika ada tabel terkait
    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id');
    }

    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

    public function getRole()
    {
        return $this->level->level_kode;
    }
}
