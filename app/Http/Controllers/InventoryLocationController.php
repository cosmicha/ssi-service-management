<?php

namespace App\Http\Controllers;

use App\Models\InventoryLocation;
use Illuminate\Http\Request;

class InventoryLocationController extends Controller
{
    public function index()
    {
        return view('inventory-locations.index', [
            'locations' => InventoryLocation::latest()->paginate(20)
        ]);
    }

    public function create()
    {
        return view('inventory-locations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'code' => 'nullable',
            'location_type' => 'required',
            'address' => 'nullable',
            'status' => 'required'
        ]);

        InventoryLocation::create($data);

        return redirect()
            ->route('inventory-locations.index')
            ->with('success','Location created');
    }

    public function edit(InventoryLocation $inventoryLocation)
    {
        return view('inventory-locations.edit', [
            'location' => $inventoryLocation
        ]);
    }

    public function update(Request $request, InventoryLocation $inventoryLocation)
    {
        $data = $request->validate([
            'name' => 'required',
            'code' => 'nullable',
            'location_type' => 'required',
            'address' => 'nullable',
            'status' => 'required'
        ]);

        $inventoryLocation->update($data);

        return redirect()
            ->route('inventory-locations.index')
            ->with('success','Location updated');
    }

    public function destroy(InventoryLocation $inventoryLocation)
    {
        $inventoryLocation->delete();

        return back()->with('success','Location deleted');
    }
}
