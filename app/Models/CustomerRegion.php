<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerRegion extends Model
{
    protected $fillable = [
        'customer_id',
        'name',
        'code',
        'contact_person',
        'contact_email',
        'contact_phone',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(CustomerBranch::class, 'customer_region_id');
    }
}
