<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'task';
    protected $fillable = [
        'id_dosen',
        'judul',
        'deskripsi',
        'bobot',
        'semester',
        'id_jenis',
        'tipe'
    ];

    public function typeTask()
    {
        return $this->belongsTo(TypeTask::class, 'id_jenis');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'id_dosen');
    }
}
