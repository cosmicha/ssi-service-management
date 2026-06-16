<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Support\NumberGenerator;
use App\Services\NotificationService;

class Task extends Model
{
    protected static function booted()
    {
        static::creating(function ($task) {

            if (!$task->task_no) {
                $task->task_no = NumberGenerator::generate('TSK');
            }

        });

        static::updated(function ($task) {

            if (
                $task->wasChanged('assigned_to')
                && $task->assigned_to
            ) {

                $task->loadMissing([
                    'assignee',
                    'customer',
                    'asset'
                ]);

                NotificationService::sendTaskAssigned(
                    $task
                );

            }

            if (
                $task->wasChanged('status')
                && strtolower($task->status ?? '') === 'completed'
            ) {

                $task->loadMissing([
                    'assignee',
                    'customer',
                    'branch',
                    'asset'
                ]);

                $message =
                    "WORK ORDER COMPLETED\n\n" .
                    "Task No : " . ($task->task_no ?? '-') . "\n" .
                    "Title : " . ($task->title ?? '-') . "\n" .
                    "Customer : " . ($task->customer?->name ?? '-') . "\n" .
                    "Site : " . ($task->branch?->name ?? '-') . "\n" .
                    "Asset : " . ($task->asset?->name ?? '-') . "\n" .
                    "Engineer : " . ($task->assignee?->name ?? '-') . "\n" .
                    "Completed At : " . now()->format('d M Y H:i') . "\n" .
                    "Status : COMPLETED";

                NotificationService::send(
                    '[SSI] Task Completed - ' . ($task->task_no ?? $task->id),
                    $message,
                    env('SSI_NOTIFICATION_EMAIL'),
                    url('/tasks/' . $task->id),
                    'View Work Order'
                );

            }

            if (
                $task->wasChanged('customer_signed_at')
                &&
                $task->customer_signed_at
            ) {

                $task->loadMissing([
                    'customer',
                    'branch',
                    'asset',
                    'assignee',
                ]);

                $message =
                    "CUSTOMER SIGN-OFF RECEIVED\n\n" .

                    "Task No : " .
                    ($task->task_no ?? '-') . "\n" .

                    "Customer : " .
                    ($task->customer?->name ?? '-') . "\n" .

                    "Site : " .
                    ($task->branch?->name ?? '-') . "\n" .

                    "Asset : " .
                    ($task->asset?->name ?? '-') . "\n\n" .

                    "Signed By : " .
                    ($task->customer_signoff_name ?? '-') . "\n" .

                    "Signed At : " .
                    optional($task->customer_signed_at)
                        ?->format('d M Y H:i') . "\n\n" .

                    "Comments\n" .
                    ($task->customer_signoff_notes ?? '-');

                NotificationService::send(
                    '[SSI] Customer Sign-Off - ' .
                    ($task->task_no ?? $task->id),

                    $message,

                    env('SSI_NOTIFICATION_EMAIL'),

                    url('/tasks/' . $task->id),

                    'View Work Order'
                );

            }

        });
    }

    protected $fillable = [
        'task_no',
        'task_type',
        'customer_id',
        'customer_region_id',
        'customer_branch_id',
        'asset_id',
        'preventive_schedule_id',
        'incident_id',
        'change_request_id',
        'assigned_to',
        'created_by',
        'title',
        'description',
        'priority',
        'status',
        'planned_date',
        'due_date',
        'started_at',
        'completed_at',
        'waiting_minutes',
        'work_paused_at',
        'work_started_at',
        'arrived_at',
        'travel_started_at',
        'dispatched_at',
        'dispatch_status',
        'work_minutes',
        'travel_minutes',
        'actual_finish_at',
        'actual_start_at',
        'planned_finish_at',
        'planned_start_at',
        'team_name',
        'assigned_vendor',
        'work_order_no',
        'customer_signed_at',
        'customer_signoff_notes',
        'customer_signoff_name',
    ];

    protected $casts = [
        'planned_date' => 'date',
        'due_date' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'actual_finish_at' => 'datetime',
        'work_paused_at' => 'datetime',
        'work_started_at' => 'datetime',
        'arrived_at' => 'datetime',
        'travel_started_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'actual_start_at' => 'datetime',
        'planned_finish_at' => 'datetime',
        'planned_start_at' => 'datetime',
        'customer_signed_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(CustomerRegion::class, 'customer_region_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(CustomerBranch::class, 'customer_branch_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function preventiveSchedule(): BelongsTo
    {
        return $this->belongsTo(PreventiveSchedule::class, 'preventive_schedule_id');
    }

    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class, 'incident_id');
    }

    public function changeRequest(): BelongsTo
    {
        return $this->belongsTo(ChangeRequest::class, 'change_request_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updates()
    {
        return $this->hasMany(TaskUpdate::class)
            ->latest();
    }


    public function workLogs()
    {
        return $this->hasMany(TaskWorkLog::class)
            ->orderBy('logged_at');
    }


    public function partUsages()
    {
        return $this->hasMany(\App\Models\TaskPartUsage::class);
    }


    public function taskPhotos()
    {
        return $this->hasMany(
            \App\Models\TaskPhoto::class
        );
    }



    public function scopeVisibleTo($query, $user)
    {
        $query = \App\Support\TenantScope::apply(
            $query,
            $user,
            'customer_id',
            'customer_branch_id'
        );

        if (
            $user
            && $user->role === 'engineer'
        ) {
            $query->where('assigned_to', $user->id);
        }

        return $query;
    }

}
