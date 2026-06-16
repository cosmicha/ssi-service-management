<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreventiveExecution extends Model
{
    protected $fillable = [
        'task_id',
        'preventive_schedule_id',
        'engineer_id',
        'status',
        'started_at',
        'completed_at',
        'notes',
        'result',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function preventiveSchedule()
    {
        return $this->belongsTo(PreventiveSchedule::class);
    }

    public function engineer()
    {
        return $this->belongsTo(User::class, 'engineer_id');
    }

    public function items()
    {
        return $this->hasMany(PreventiveExecutionItem::class);
    }
}
