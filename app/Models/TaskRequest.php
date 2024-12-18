<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskRequest extends Model
{
    use HasFactory;

    protected $table = 'task_request';
    protected $fillable = [
        'id_task',
        'id_mahasiswa',
        'status'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'id_task');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_mahasiswa');
    }
}
