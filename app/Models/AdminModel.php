<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminModel extends Model
{
    use HasFactory;

    protected $table = 'm_admin'; // Sesuaikan dengan nama tabel
    protected $primaryKey = 'admin_id'; // Primary key
    protected $fillable = ['admin_nama', 'nip', 'username', 'password', 'no_telepon', 'foto', 'prodi_id','level_id'];
    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];

    // Contoh relasi ke model level jika ada tabel terkait
    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id');
    }
    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'prodi_id');
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
