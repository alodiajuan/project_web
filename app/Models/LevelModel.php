<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelModel extends Model
{
    use HasFactory;

    protected $table = 'm_level';
    protected $primaryKey = 'level_id';
    protected $fillable = ['level_kode', 'level_nama'];

    public function sdm(): HasMany
    {
        return $this->hasMany(SdmModel::class, 'level_id', 'level_id');
    }
    public function mahasiswa(): HasMany
    {
        return $this->hasMany(MahasiswaModel::class, 'level_id', 'level_id');
    }
}