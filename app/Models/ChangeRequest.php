<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\NumberGenerator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChangeRequest extends Model
{
    protected static function booted()
    {
        static::creating(function ($change) {
            if (empty($change->change_no)) {
                $change->change_no = NumberGenerator::generate('CR');
            }
        });
    }

    protected $fillable = [
        'change_no',
        'customer_id',
        'customer_region_id',
        'customer_branch_id',
        'asset_id',
        'change_category_id',
        'task_id',
        'title',
        'description',
        'business_reason',
        'risk_level',
        'implementation_plan',
        'rollback_plan',
        'requested_by',
        'requested_date',
        'approved_by',
        'approved_at',
        'implementation_date',
        'verification_notes',
        'status',
    ];

    protected $casts = [
        'requested_date' => 'datetime',
        'approved_at' => 'datetime',
        'implementation_date' => 'datetime',
    ];

    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function region(): BelongsTo { return $this->belongsTo(CustomerRegion::class, 'customer_region_id'); }
    public function branch(): BelongsTo { return $this->belongsTo(CustomerBranch::class, 'customer_branch_id'); }
    public function asset(): BelongsTo { return $this->belongsTo(Asset::class); }
    public function category(): BelongsTo { return $this->belongsTo(ChangeCategory::class, 'change_category_id'); }
    public function task(): BelongsTo { return $this->belongsTo(Task::class); }
    public function approver(): BelongsTo { return $this->belongsTo(User::class, 'approved_by'); }

    public function attachments(): HasMany
    {
        return $this->hasMany(ChangeAttachment::class);
    }
}
