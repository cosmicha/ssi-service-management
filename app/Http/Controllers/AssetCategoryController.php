<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;

class AssetCategoryController extends Controller
{
    public function index()
    {
        $categories = AssetCategory::withCount('assets')
            ->orderBy('name')
            ->paginate(20);

        return view('asset-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('asset-categories.create');
    }

    public function store(Request $request)
    {
        AssetCategory::create(
            $request->validate([
                'name' => ['required','string','max:255','unique:asset_categories,name'],
                'description' => ['nullable','string'],
                'status' => ['required','in:active,inactive'],
            ])
        );

        return redirect()->route('asset-categories.index')
            ->with('success','Category created.');
    }

    public function edit(AssetCategory $assetCategory)
    {
        return view('asset-categories.edit', compact('assetCategory'));
    }

    public function update(Request $request, AssetCategory $assetCategory)
    {
        $assetCategory->update(
            $request->validate([
                'name' => ['required','string','max:255','unique:asset_categories,name,'.$assetCategory->id],
                'description' => ['nullable','string'],
                'status' => ['required','in:active,inactive'],
            ])
        );

        return redirect()->route('asset-categories.index')
            ->with('success','Category updated.');
    }

    public function destroy(AssetCategory $assetCategory)
    {
        $assetCategory->delete();

        return redirect()->route('asset-categories.index')
            ->with('success','Category deleted.');
    }
}
