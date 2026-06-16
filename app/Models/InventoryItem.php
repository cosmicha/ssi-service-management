<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'inventory_category_id',
        'sku',
        'name',
        'brand',
        'model',
        'manufacturer',
        'part_number',
        'vendor',
        'barcode',
        'serial_number',
        'asset_type',
        'unit',
        'standard_cost',
        'minimum_stock',
        'status',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(InventoryCategory::class, 'inventory_category_id');
    }

    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function currentStock(): int
    {
        return (int) $this->transactions()->sum('quantity');
    }

    public function stockByLocation($locationId): int
    {
        return (int) $this->transactions()
            ->where('inventory_location_id', $locationId)
            ->sum('quantity');
    }
}
