<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    use HasFactory;

    protected $table = 'task_submission';
    protected $fillable = [
        'id_mahasiswa',
        'id_task',
        'id_dosen',
        'acc_dosen',
        'file',
        'url'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'id_task');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'id_mahasiswa');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'id_dosen');
    }
}
