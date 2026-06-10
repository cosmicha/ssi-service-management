<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCatalog extends Model
{
    protected $fillable = [
        'service_category_id',
        'name',
        'code',
        'description',
        'default_support_hour',
        'default_response_minutes',
        'default_resolution_minutes',
        'default_pm_frequency',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(ServiceContract::class);
    }
}
