<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    protected $fillable = [
        'customer_id',
        'customer_region_id',
        'customer_branch_id',
        'asset_category_id',
        'name',
        'asset_code',
        'brand',
        'model',
        'serial_number',
        'ip_address',
        'purchase_date',
        'warranty_expiry',
        'status',
        'description',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(AssetAttachment::class);
    }

}
