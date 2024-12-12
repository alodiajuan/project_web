<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KompetensiModel extends Model
{
    protected $table = 'm_kompetensi';
    protected $primaryKey = 'kompetensi_id';
    protected $fillable = ['kompetensi_id', 'deskripsi', 'mahasiswa_id'];

    public function mahasiswa()
    {
        return $this->hasMany(MahasiswaModel::class, 'mahasiswa_id');
    }
}