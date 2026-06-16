<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\NumberGenerator;
use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Incident extends Model
{
    protected static function booted()
    {
        static::creating(function ($incident) {

            if (empty($incident->ticket_no)) {

                $number =
                    NumberGenerator::generate('TKT');

                $incident->ticket_no = $number;
                $incident->incident_no = $number;

            }

        });



        static::updated(function ($incident) {

            if ($incident->wasChanged('status')) {

                $incident->loadMissing([
                    'customer',
                    'branch',
                    'asset',
                    'category',
                    'task.assignee',
                ]);

                $status = strtoupper($incident->status ?? '-');

                $message =
                    "INCIDENT STATUS UPDATED\n\n" .
                    "Ticket No : " . ($incident->incident_no ?? '-') . "\n" .
                    "Title : " . ($incident->title ?? '-') . "\n" .
                    "Customer : " . ($incident->customer?->name ?? '-') . "\n" .
                    "Site : " . ($incident->branch?->name ?? '-') . "\n" .
                    "Asset : " . ($incident->asset?->name ?? '-') . "\n" .
                    "Severity : " . strtoupper($incident->severity ?? '-') . "\n" .
                    "Status : " . $status . "\n\n" .
                    "Description\n" .
                    ($incident->description ?? '-') . "\n\n" .
                    "Assigned Engineer : " . ($incident->task?->assignee?->name ?? '-');

                \App\Services\NotificationService::send(
                    '[SSI] Incident ' . $status . ' - ' . ($incident->incident_no ?? $incident->id),
                    $message,
                    env('SSI_NOTIFICATION_EMAIL'),
                    url('/incidents/' . $incident->id),
                    'View Incident'
                );

            }

        });

        static::created(function ($incident) {

            $incident->loadMissing([
                'customer',
                'branch',
                'asset',
                'category',
                'task.assignee',
            ]);

            $message =
                "INCIDENT CREATED\n\n" .
                "Ticket No : " . ($incident->incident_no ?? '-') . "\n" .
                "Customer : " . ($incident->customer?->name ?? '-') . "\n" .
                "Site : " . ($incident->branch?->name ?? '-') . "\n" .
                "Category : " . ($incident->category?->name ?? '-') . "\n" .
                "Asset : " . ($incident->asset?->name ?? '-') . "\n" .
                "Severity : " . strtoupper($incident->severity ?? '-') . "\n" .
                "Status : " . strtoupper($incident->status ?? '-') . "\n" .
                "Reported At : " . optional($incident->reported_at)->format('d M Y H:i') . "\n\n" .
                "Issue Summary\n" .
                ($incident->description ?? '-') . "\n\n" .
                "Assigned Engineer : " . ($incident->task?->assignee?->name ?? '-');

            NotificationService::send(
                '[SSI] New Incident - ' . ($incident->incident_no ?? $incident->id),
                $message,
                env('SSI_NOTIFICATION_EMAIL'),
                url('/incidents/' . $incident->id),
                'View Incident'
            );

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
        'sla_breached_at',
        'resolution_sla_status',
        'response_sla_status',
        'responded_at',
        'response_due_at',
        'status',
        'resolved_at',
        'closed_at'
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'response_due_at' => 'datetime',
        'resolution_due_at' => 'datetime',
        'sla_breached_at' => 'datetime',
        'responded_at' => 'datetime',
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


    public function scopeVisibleTo($query, $user)
    {
        return \App\Support\TenantScope::apply(
            $query,
            $user,
            'customer_id',
            'customer_branch_id'
        );
    }

}
