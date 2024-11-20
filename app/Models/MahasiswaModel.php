<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_mahasiswa';
    protected $primaryKey = 'mahasiswa_id';
    protected $fillable = ['username', 'password', 'mahasiswa_nama', 'foto', 'nim', 'kompetensi', 'semester','level_id', 'prodi_id', 'kompetensi_id', 'created_at', 'updated_at'];
    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }    
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(ProdiModel::class, 'prodi_id', 'prodi_id');
    }
    public function kompetensi(): HasMany
    {
        return $this->hasMany(KompetensiModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }
    protected function foto(): Attribute{
        return Attribute::make(
            get: fn ($foto) => url('/storage/images/'.$foto),
        );
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
