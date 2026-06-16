<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLocation extends Model
{
    protected $fillable = [
        'name','code','location_type','customer_branch_id','engineer_id','address','status'
    ];

    public function branch()
    {
        return $this->belongsTo(CustomerBranch::class, 'customer_branch_id');
    }

    public function engineer()
    {
        return $this->belongsTo(User::class, 'engineer_id');
    }

    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
}
