<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelModel extends Model
{
    protected $table = 'm_level';        // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'level_id';  //Mendefinisikan primary key dari tabel yang digunakan
    protected $fillable = ['level_id', 'level_kode', 'level_nama'];

    public function mahasiswa(): HasMany
    {
        return $this->hasMany(MahasiswaModel::class);
    }
    public function admin(): HasMany
    {
        return $this->hasMany(AdminModel::class);
    }
    public function sdm(): HasMany
    {
        return $this->hasMany(SdmModel::class);
    }


}
