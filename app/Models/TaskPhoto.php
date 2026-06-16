<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPhoto extends Model
{
    protected $fillable = [
        'task_id',
        'photo_type',
        'photo_path',
        'notes',
        'uploaded_by',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class,'uploaded_by');
    }
}
