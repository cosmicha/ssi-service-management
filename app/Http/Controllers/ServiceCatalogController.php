<?php

namespace App\Http\Controllers;

use App\Models\ServiceCatalog;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCatalogController extends Controller
{
    public function index()
    {
        $catalogs = ServiceCatalog::with('category')->withCount('contracts')->latest()->paginate(15);
        return view('service-catalogs.index', compact('catalogs'));
    }

    public function create()
    {
        $categories = ServiceCategory::where('status', 'active')->orderBy('name')->get();
        return view('service-catalogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $catalog = ServiceCatalog::create($request->validate([
            'service_category_id' => ['nullable','exists:service_categories,id'],
            'name' => ['required','string','max:255'],
            'code' => ['nullable','string','max:100','unique:service_catalogs,code'],
            'description' => ['nullable','string'],
            'default_support_hour' => ['nullable','string','max:100'],
            'default_response_minutes' => ['nullable','integer'],
            'default_resolution_minutes' => ['nullable','integer'],
            'default_pm_frequency' => ['required','in:daily,weekly,monthly,quarterly,semester,yearly,none'],
            'status' => ['required','in:active,inactive'],
        ]));

        return redirect()->route('service-catalogs.index')->with('success', 'Service catalog created.');
    }

    public function edit(ServiceCatalog $serviceCatalog)
    {
        $categories = ServiceCategory::orderBy('name')->get();
        return view('service-catalogs.edit', compact('serviceCatalog', 'categories'));
    }

    public function update(Request $request, ServiceCatalog $serviceCatalog)
    {
        $serviceCatalog->update($request->validate([
            'service_category_id' => ['nullable','exists:service_categories,id'],
            'name' => ['required','string','max:255'],
            'code' => ['nullable','string','max:100','unique:service_catalogs,code,' . $serviceCatalog->id],
            'description' => ['nullable','string'],
            'default_support_hour' => ['nullable','string','max:100'],
            'default_response_minutes' => ['nullable','integer'],
            'default_resolution_minutes' => ['nullable','integer'],
            'default_pm_frequency' => ['required','in:daily,weekly,monthly,quarterly,semester,yearly,none'],
            'status' => ['required','in:active,inactive'],
        ]));

        return redirect()->route('service-catalogs.index')->with('success', 'Service catalog updated.');
    }

    public function destroy(ServiceCatalog $serviceCatalog)
    {
        $serviceCatalog->delete();
        return redirect()->route('service-catalogs.index')->with('success', 'Service catalog deleted.');
    }
}
