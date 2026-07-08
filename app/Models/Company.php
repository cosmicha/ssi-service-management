<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'enable_email_notifications',
        'timezone',
        'working_hours',
        'sla_profile',
        'default_engineer_id',
        'whatsapp_group',
        'escalation_emails',
        'admin_notification_emails',
        'name',
        'sla_response_minutes',
        'sla_resolution_minutes',
        'sla_active',
        'notification_emails',
        'logo',
        'code',
        'logo_path',];

    protected $casts = [
        'sla_active' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function problemLogs()
    {
        return $this->hasMany(ProblemLog::class);
    }

    public function logoUrl(): ?string
    {
        if (!$this->logo_path) {
            return null;
        }

        return url('/storage/' . $this->logo_path);
    }

    public function parseNotificationEmails(?string $value): array
    {
        return \App\Support\EmailList::parse($value);
    }

    public function notificationEmailList(): array
    {
        if (isset($this->enable_email_notifications) && !$this->enable_email_notifications) {
            return [];
        }

        return collect()
            ->merge($this->parseNotificationEmails($this->notification_emails ?? null))
            ->merge($this->parseNotificationEmails($this->admin_notification_emails ?? null))
            ->unique()
            ->values()
            ->all();
    }

    public function escalationEmailList(): array
    {
        if (isset($this->enable_email_notifications) && !$this->enable_email_notifications) {
            return [];
        }

        return collect()
            ->merge($this->parseNotificationEmails($this->escalation_emails ?? null))
            ->unique()
            ->values()
            ->all();
    }

}
