<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ProblemLog extends Model
{

    public function normalizedStatus(): string
    {
        $status = strtolower(trim((string) ($this->status ?? 'open')));

        return match ($status) {
            'open' => 'open',
            'in_progress', 'in progress', 'progress', 'processing' => 'in_progress',
            'closed', 'resolved', 'done', 'complete', 'completed' => 'closed',
            default => 'open',
        };
    }

    public function isClosable(): bool
    {
        return $this->normalizedStatus() !== 'closed';
    }

    protected $fillable = [
        'company_id',
        'created_by_user_id',
        'assigned_by_user_id',
        'acknowledged_by_user_id',
        'closed_by_user_id',
        'assigned_engineer_id',
        'ticket_number',
        'title',
        'description',
        'status',
        'priority',
        'photo',
        'engineer_name',
        'acknowledged_at',
        'opened_at',
        'in_progress_at',
        'closed_at',
        'close_note',
        'closed_photo',
        'response_due_at',
        'resolution_due_at',
        'response_sla_breached',
        'resolution_sla_breached',
    ];

    protected $casts = [
        'acknowledged_at' => 'datetime',
        'opened_at' => 'datetime',
        'in_progress_at' => 'datetime',
        'closed_at' => 'datetime',
        'response_due_at' => 'datetime',
        'resolution_due_at' => 'datetime',
        'response_sla_breached' => 'boolean',
        'resolution_sla_breached' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function assignedEngineer()
    {
        return $this->belongsTo(User::class, 'assigned_engineer_id');
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function assignedByUser()
    {
        return $this->belongsTo(User::class, 'assigned_by_user_id');
    }

    public function acknowledgedByUser()
    {
        return $this->belongsTo(User::class, 'acknowledged_by_user_id');
    }

    public function closedByUser()
    {
        return $this->belongsTo(User::class, 'closed_by_user_id');
    }

    public function updates()
    {
        return $this->hasMany(ProblemLogUpdate::class)->latest();
    }

    public function calculateResponseDueAt(): ?Carbon
    {
        if (!$this->company || !$this->company->sla_active) {
            return null;
        }

        $base = $this->opened_at ?: $this->created_at ?: now();

        return $base->copy()->addHours($this->responseSlaHours());
    }

    public function calculateResolutionDueAt(): ?Carbon
    {
        if (!$this->company || !$this->company->sla_active) {
            return null;
        }

        $base = $this->opened_at ?: $this->created_at ?: now();

        return $base->copy()->addHours($this->resolutionSlaHours());
    }


    public function responseDurationSeconds(): ?int
    {
        $start = $this->opened_at ?: $this->created_at;
        $end = $this->acknowledged_at ?: $this->in_progress_at;

        if (!$start || !$end) {
            return null;
        }

        return $start->diffInSeconds($end);
    }

    public function resolutionDurationSeconds(): ?int
    {
        if (!$this->in_progress_at || !$this->closed_at) {
            return null;
        }

        return $this->in_progress_at->diffInSeconds($this->closed_at);
    }

    public function responseSlaHours(): int
    {
        return (int) (optional($this->company)->sla_response_minutes ?? 0);
    }

    public function resolutionSlaHours(): int
    {
        return (int) (optional($this->company)->sla_resolution_minutes ?? 0);
    }

    public function responseDurationText(): string
    {
        if (!$this->created_at) {
            return '-';
        }

        $endTime = $this->acknowledged_at ?: now();
        $minutes = $this->created_at->diffInMinutes($endTime);

        if ($minutes < 60) {
            return $minutes . ' min';
        }

        $hours = floor($minutes / 60);
        $remaining = $minutes % 60;

        return $remaining > 0 ? "{$hours}h {$remaining}m" : "{$hours}h";
    }

    public function resolutionDurationText(): string
    {
        if (!$this->created_at) {
            return '-';
        }

        $endTime = $this->closed_at ?: now();
        $minutes = $this->created_at->diffInMinutes($endTime);

        if ($minutes < 60) {
            return $minutes . ' min';
        }

        $hours = floor($minutes / 60);
        $remaining = $minutes % 60;

        return $remaining > 0 ? "{$hours}h {$remaining}m" : "{$hours}h";
    }

    public static function formatDuration($start, $end): string
    {
        if (!$start || !$end) {
            return '-';
        }

        $seconds = $start->diffInSeconds($end);

        $days = floor($seconds / 86400);
        $hours = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        if ($days > 0) {
            return $days . 'd ' . $hours . 'h';
        }

        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }

        return $minutes . 'm';
    }

    public function responseSlaStatus(): string
    {
        $company = $this->effectiveCompany();
        if (!$company || !($company->sla_active ?? false) || !$this->responseSlaHours()) {
            return 'n/a';
        }

        if (!$this->created_at) {
            return 'n/a';
        }

        $endTime = $this->acknowledged_at ?: now();
        $minutes = $this->created_at->diffInMinutes($endTime);
        $limitMinutes = $this->responseSlaHours() * 60;

        return $minutes <= $limitMinutes ? 'ok' : 'breached';
    }

    public function resolutionSlaStatus(): string
    {
        $company = $this->effectiveCompany();
        if (!$company || !($company->sla_active ?? false) || !$this->resolutionSlaHours()) {
            return 'n/a';
        }

        if (!$this->created_at) {
            return 'n/a';
        }

        $endTime = $this->closed_at ?: now();
        $minutes = $this->created_at->diffInMinutes($endTime);
        $limitMinutes = $this->resolutionSlaHours() * 60;

        return $minutes <= $limitMinutes ? 'ok' : 'breached';
    }

    public function effectiveCompany()
    {
        if ($this->company) {
            return $this->company;
        }

        return \App\Models\Company::where('sla_active', true)->orderBy('id')->first();
    }


    public function resolution()
    {
        return $this->hasOne(\App\Models\ProblemLogResolution::class);
    }


    public function latestUpdate()
    {
        return $this->hasOne(\App\Models\ProblemLogUpdate::class)->latestOfMany();
    }

    public function dashboardProblemSummary()
    {
        $title = trim((string) $this->title);
        $desc = trim((string) $this->description);

        if ($title !== '' && $desc !== '') {
            return $title . ' — ' . \Illuminate\Support\Str::limit($desc, 90);
        }

        if ($title !== '') {
            return $title;
        }

        return \Illuminate\Support\Str::limit($desc, 90) ?: '-';
    }

    public function dashboardCurrentProcess()
    {
        if ($this->latestUpdate && !empty($this->latestUpdate->message)) {
            return $this->latestUpdate->message;
        }

        return match($this->status) {
            'open' => 'Waiting for acknowledge',
            'acknowledged' => 'Acknowledged by engineer',
            'in_progress' => 'Work in progress',
            'closed' => 'Resolved and closed',
            default => ucfirst(str_replace('_', ' ', (string) $this->status)),
        };
    }

    public function dashboardResolutionSummary()
    {
        try {
            if ($this->resolution && $this->resolution->template) {
                return $this->resolution->template->displayTitle();
            }

            if ($this->resolution && !empty($this->resolution->resolution_input)) {
                return \Illuminate\Support\Str::limit($this->resolution->resolution_input, 90);
            }
        } catch (\Throwable $e) {
        }

        if (!empty($this->close_note)) {
            return \Illuminate\Support\Str::limit($this->close_note, 90);
        }

        return '-';
    }


    public function aiSuggestions()
    {
        return $this->hasMany(\App\Models\ProblemLogAiSuggestion::class)->orderByDesc('similarity_score');
    }

}
