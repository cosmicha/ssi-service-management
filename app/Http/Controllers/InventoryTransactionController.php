<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryLocation;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;

class InventoryTransactionController extends Controller
{
    public function index()
    {
        return view('inventory-transactions.index', [
            'transactions' => InventoryTransaction::with([
                'item',
                'location',
                'user'
            ])
            ->latest()
            ->paginate(50),
        ]);
    }

    public function create()
    {
        return view('inventory-transactions.create', [
            'items' => InventoryItem::orderBy('name')->get(),
            'locations' => InventoryLocation::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inventory_item_id' => 'required',
            'inventory_location_id' => 'required',
            'transaction_type' => 'required',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable',
        ]);

        $qty = $data['quantity'];

        if (
            in_array(
                $data['transaction_type'],
                ['out','used','transfer_out']
            )
        ) {
            $qty = $qty * -1;
        }

        InventoryTransaction::create([
            'inventory_item_id' => $data['inventory_item_id'],
            'inventory_location_id' => $data['inventory_location_id'],
            'transaction_type' => $data['transaction_type'],
            'quantity' => $qty,
            'notes' => $data['notes'] ?? null,
            'transaction_at' => now(),
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('inventory-transactions.index')
            ->with('success','Transaction saved');
    }
}
