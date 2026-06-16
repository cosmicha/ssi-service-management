<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
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

}
