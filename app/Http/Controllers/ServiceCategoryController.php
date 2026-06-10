<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::withCount('catalogs')->orderBy('name')->paginate(20);
        return view('service-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('service-categories.create');
    }

    public function store(Request $request)
    {
        ServiceCategory::create($request->validate([
            'name' => ['required','string','max:255','unique:service_categories,name'],
            'description' => ['nullable','string'],
            'status' => ['required','in:active,inactive'],
        ]));

        return redirect()->route('service-categories.index')->with('success', 'Service category created.');
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        return view('service-categories.edit', compact('serviceCategory'));
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $serviceCategory->update($request->validate([
            'name' => ['required','string','max:255','unique:service_categories,name,' . $serviceCategory->id],
            'description' => ['nullable','string'],
            'status' => ['required','in:active,inactive'],
        ]));

        return redirect()->route('service-categories.index')->with('success', 'Service category updated.');
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        $serviceCategory->delete();
        return redirect()->route('service-categories.index')->with('success', 'Service category deleted.');
    }
}
