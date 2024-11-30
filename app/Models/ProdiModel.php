<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProdiModel extends Model
{
    protected $table = 'm_prodi';
    protected $primaryKey = 'prodi_id';
    protected $fillable = ['prodi_id', 'prodi_kode', 'prodi_nama'];

    public function mahasiswa(): HasMany
    {
        return $this->hasMany(MahasiswaModel::class, 'prodi_id');
    }

    public function sdm(): HasMany
    {
        return $this->hasMany(SdmModel::class, 'prodi_id');
    }

}