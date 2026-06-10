<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerBranch extends Model
{
    protected $fillable = [
        'customer_id',
        'customer_region_id',
        'name',
        'code',
        'site_type',
        'address',
        'city',
        'province',
        'latitude',
        'longitude',
        'contact_person',
        'contact_email',
        'contact_phone',
        'status',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(CustomerRegion::class, 'customer_region_id');
    }
}
