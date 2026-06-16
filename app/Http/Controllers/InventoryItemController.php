<?php

namespace App\Http\Controllers;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    public function index()
    {
        return view('inventory-items.index', [
            'inventoryItems' => InventoryItem::with('category')
                ->latest()
                ->paginate(20),
        ]);
    }

    public function create()
    {
        return view('inventory-items.create', [
            'categories' => InventoryCategory::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inventory_category_id' => ['nullable', 'exists:inventory_categories,id'],
            'sku' => ['nullable', 'string', 'max:255', 'unique:inventory_items,sku'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'standard_cost' => ['nullable', 'numeric', 'min:0'],
            'minimum_stock' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            'description' => ['nullable', 'string'],
        ]);

        InventoryItem::create($data);

        return redirect()->route('inventory-items.index')->with('success', 'Inventory item created.');
    }

    public function edit(InventoryItem $inventoryItem)
    {
        return view('inventory-items.edit', [
            'item' => $inventoryItem,
            'categories' => InventoryCategory::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, InventoryItem $inventoryItem)
    {
        $data = $request->validate([
            'inventory_category_id' => ['nullable', 'exists:inventory_categories,id'],
            'sku' => ['nullable', 'string', 'max:255', 'unique:inventory_items,sku,' . $inventoryItem->id],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'standard_cost' => ['nullable', 'numeric', 'min:0'],
            'minimum_stock' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            'description' => ['nullable', 'string'],
        ]);

        $inventoryItem->update($data);

        return redirect()->route('inventory-items.index')->with('success', 'Inventory item updated.');
    }

    public function destroy(InventoryItem $inventoryItem)
    {
        $inventoryItem->delete();

        return redirect()->route('inventory-items.index')->with('success', 'Inventory item deleted.');
    }
}
