<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;\nuse App\Support\NumberGenerator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PreventiveExecution extends Model
{
    protected $fillable = [\n        'pm_no',
        'task_id',
        'preventive_schedule_id',
        'engineer_id',
        'started_at',
        'completed_at',
        'overall_result',
        'summary',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(
            PreventiveSchedule::class,
            'preventive_schedule_id'
        );
    }

    public function engineer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'engineer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PreventiveExecutionItem::class);
    }
}
