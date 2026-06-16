<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{


    protected static function booted()
    {
        static::creating(function ($asset) {

            if (!$asset->qr_uuid) {
                $asset->qr_uuid = (string) Str::uuid();
            }

        });
    }


    protected $fillable = [
        'customer_id',
        'customer_region_id',
        'customer_branch_id',
        'asset_category_id',
        'name',
        'asset_code',
        'qr_uuid',
        'brand',
        'model',
        'serial_number',
        'ip_address',
        'purchase_date',
        'warranty_expiry',
        'status',
        'lifecycle_notes',
        'disposed_at',
        'retired_at',
        'lifecycle_status',
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


    protected $casts = [
        'disposed_at' => 'datetime',
        'retired_at' => 'datetime',
    ];

    public function scopeVisibleTo($query, $user)
    {
        return \App\Support\TenantScope::apply(
            $query,
            $user,
            'customer_id',
            'customer_branch_id'
        );
    }

    public function incidents()
    {
        return $this->hasMany(\App\Models\Incident::class);
    }

    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class);
    }

}
