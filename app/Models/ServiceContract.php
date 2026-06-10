<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceContract extends Model
{
    protected $fillable = [
        'customer_id',
        'customer_region_id',
        'customer_branch_id',
        'service_catalog_id',
        'contract_no',
        'name',
        'start_date',
        'end_date',
        'support_hour',
        'response_minutes',
        'resolution_minutes',
        'pm_frequency',
        'scope',
        'exclusion',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
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

    public function catalog(): BelongsTo
    {
        return $this->belongsTo(ServiceCatalog::class, 'service_catalog_id');
    }
}
