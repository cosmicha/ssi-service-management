<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSla extends Model
{
    protected $fillable = [
        'customer_id',
        'severity',
        'response_minutes',
        'resolution_minutes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
