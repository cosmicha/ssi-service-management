<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
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
        'notification_emails',
        'name',
        'logo_path',
        'code',
        'industry',
        'contact_person',
        'contact_email',
        'contact_phone',
        'address',
        'contract_start',
        'contract_end',
        'status',
        'resolution_minutes',
        'response_minutes',
        'sla_enabled',
    ];

    public function regions(): HasMany
    {
        return $this->hasMany(CustomerRegion::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(CustomerBranch::class);
    }

    public function slas()
    {
        return $this->hasMany(\App\Models\CustomerSla::class);
    }

    public function assets()
    {
        return $this->hasMany(\App\Models\Asset::class);
    }

    public function incidents()
    {
        return $this->hasMany(\App\Models\Incident::class);
    }

    public function changeRequests()
    {
        return $this->hasMany(\App\Models\ChangeRequest::class);
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
