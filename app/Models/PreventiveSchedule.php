<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreventiveSchedule extends Model
{
    protected $fillable = [
        'service_contract_id',
        'asset_id',
        'checklist_template_id',
        'assigned_to',
        'name',
        'frequency',
        'start_date',
        'next_run_date',
        'last_run_date',
        'due_days',
        'notes',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'next_run_date' => 'date',
        'last_run_date' => 'date',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(ServiceContract::class, 'service_contract_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(ChecklistTemplate::class, 'checklist_template_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
