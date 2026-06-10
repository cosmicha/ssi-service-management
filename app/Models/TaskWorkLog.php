<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskWorkLog extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'log_type',
        'description',
        'logged_at',
    ];

    protected $casts = [
        'logged_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
