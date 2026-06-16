<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\InventoryItem;
use App\Models\InventoryLocation;
use App\Models\TaskPartUsage;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;

class TaskPartUsageController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $data = $request->validate([
            'inventory_item_id' => 'required',
            'inventory_location_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable'
        ]);

        $item = InventoryItem::findOrFail(
            $data['inventory_item_id']
        );

        $availableStock = $item->stockByLocation(
            $data['inventory_location_id']
        );

        if ($availableStock < $data['quantity']) {

            return back()
                ->withErrors([
                    'quantity' =>
                    'Insufficient stock. Available: ' .
                    $availableStock
                ]);

        }

        TaskPartUsage::create([
            'task_id' => $task->id,
            'inventory_item_id' => $data['inventory_item_id'],
            'inventory_location_id' => $data['inventory_location_id'],
            'quantity' => $data['quantity'],
            'notes' => $data['notes'] ?? null,
            'used_by' => auth()->id(),
            'used_at' => now(),
            'unit_cost' => $item->standard_cost ?? 0,
        ]);

        InventoryTransaction::create([
            'inventory_item_id' => $data['inventory_item_id'],
            'inventory_location_id' => $data['inventory_location_id'],
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'transaction_type' => 'used',
            'quantity' => $data['quantity'] * -1,
            'unit_cost' => $item->standard_cost ?? 0,
            'transaction_at' => now(),
            'notes' => 'Used on task #' . $task->id,
        ]);

        return back()->with(
            'success',
            'Part usage recorded.'
        );
    }
}
