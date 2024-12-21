<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compensation extends Model
{
    use HasFactory;

    protected $table = 'compensation';
    protected $fillable = [
        'id_task',
        'id_submission',
        'id_dosen',
        'id_mahasiswa',
        'semester',
        'bobot'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'id_task');
    }

    public function submission()
    {
        return $this->belongsTo(TaskSubmission::class, 'id_submission');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'id_dosen');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'id_mahasiswa');
    }
}
