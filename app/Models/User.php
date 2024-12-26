<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'users';
    protected $fillable = [
        'nama',
        'username',
        'id_prodi',
        'id_kompetensi',
        'semester',
        'alfa',
        'compensation',
        'foto_profile',
        'password',
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

    public function taskRequests()
    {
        return $this->hasMany(TaskRequest::class, 'id_mahasiswa');
    }

    public function hasRequestedTask($task)
    {
        return $this->taskRequests()->where('id_task', $task->id)->exists();
    }
}
