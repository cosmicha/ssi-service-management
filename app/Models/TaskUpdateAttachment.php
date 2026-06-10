<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskUpdateAttachment extends Model
{
    protected $fillable = [
        'task_update_id',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    public function taskUpdate()
    {
        return $this->belongsTo(TaskUpdate::class, 'task_update_id');
    }
}
