<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskUpdate extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'update_type',
        'message',
        'old_status',
        'new_status',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(TaskUpdateAttachment::class);
    }
}
