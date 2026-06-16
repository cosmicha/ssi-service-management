<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    protected $fillable = [
        'inventory_item_id','inventory_location_id','task_id','asset_id','user_id',
        'transaction_type','quantity','unit_cost','notes','transaction_at'
    ];

    protected $casts = [
        'transaction_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    public function location()
    {
        return $this->belongsTo(InventoryLocation::class, 'inventory_location_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
