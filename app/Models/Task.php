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
        'kuota',
        'file',
        'url',
        'deadline',
        'semester',
        'id_jenis',
        'tipe'
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'semester', 'semester');
    }

    public function taskRequests()
    {
        return $this->hasMany(TaskRequest::class, 'id_task');
    }

    public function taskSubmissions()
    {
        return $this->hasMany(TaskSubmission::class, 'id_task');
    }

    public function compensations()
    {
        return $this->hasMany(Compensation::class, 'id_task');
    }

    public function typeTask()
    {
        return $this->belongsTo(TypeTask::class, 'id_jenis');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'id_dosen');
    }
}
