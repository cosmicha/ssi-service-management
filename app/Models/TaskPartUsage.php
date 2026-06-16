<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPartUsage extends Model
{
    protected $fillable = [
        'task_id','inventory_item_id','inventory_location_id','quantity','unit_cost','notes','used_by','used_at'
    ];

    protected $casts = [
        'used_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    public function location()
    {
        return $this->belongsTo(InventoryLocation::class, 'inventory_location_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'used_by');
    }
}
