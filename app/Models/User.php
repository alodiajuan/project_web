<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = [
        'usename',
        'password',
        'foto_profile',
        'nama',
        'semester',
        'id_kompetensi',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    public function competence()
    {
        return $this->belongsTo(Competence::class, 'id_kompetensi');
    }
}
