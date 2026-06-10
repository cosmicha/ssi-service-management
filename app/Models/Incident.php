<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\NumberGenerator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Incident extends Model
{
    protected static function booted()
    {
        static::creating(function ($incident) {

            if (empty($incident->ticket_no)) {
                $incident->ticket_no =
                    NumberGenerator::generate('TKT');
            }

        });
    }

    protected $fillable = [
        'incident_no',
        'customer_id',
        'customer_region_id',
        'customer_branch_id',
        'asset_id',
        'incident_category_id',
        'task_id',
        'title',
        'description',
        'severity',
        'reported_by',
        'reported_at',
        'sla_status',
        'first_response_at',
        'resolution_due_at',
        'response_due_at',
        'status',
        'resolved_at',
        'closed_at'
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'response_due_at' => 'datetime',
        'resolution_due_at' => 'datetime',
        'first_response_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(CustomerBranch::class,'customer_branch_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(IncidentCategory::class,'incident_category_id');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(IncidentAttachment::class);
    }

    public function updates()
    {
        return $this->hasMany(IncidentUpdate::class)
            ->latest();
    }

}
