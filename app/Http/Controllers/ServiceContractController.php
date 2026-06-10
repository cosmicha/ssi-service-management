<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerBranch;
use App\Models\CustomerRegion;
use App\Models\ServiceCatalog;
use App\Models\ServiceContract;
use Illuminate\Http\Request;

class ServiceContractController extends Controller
{
    public function index(Request $request)
    {
        $contracts = ServiceContract::with(['customer','region','branch','catalog'])
            ->latest()
            ->paginate(15);

        return view('service-contracts.index', compact('contracts'));
    }

    public function create()
    {
        return view('service-contracts.create', [
            'customers' => Customer::orderBy('name')->get(),
            'regions' => CustomerRegion::with('customer')->orderBy('name')->get(),
            'branches' => CustomerBranch::with('customer')->orderBy('name')->get(),
            'catalogs' => ServiceCatalog::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        ServiceContract::create($request->validate([
            'customer_id' => ['required','exists:customers,id'],
            'customer_region_id' => ['nullable','exists:customer_regions,id'],
            'customer_branch_id' => ['nullable','exists:customer_branches,id'],
            'service_catalog_id' => ['nullable','exists:service_catalogs,id'],
            'contract_no' => ['nullable','string','max:100','unique:service_contracts,contract_no'],
            'name' => ['required','string','max:255'],
            'start_date' => ['nullable','date'],
            'end_date' => ['nullable','date'],
            'support_hour' => ['nullable','string','max:100'],
            'response_minutes' => ['nullable','integer'],
            'resolution_minutes' => ['nullable','integer'],
            'pm_frequency' => ['required','in:daily,weekly,monthly,quarterly,semester,yearly,none'],
            'scope' => ['nullable','string'],
            'exclusion' => ['nullable','string'],
            'status' => ['required','in:active,inactive,expired,draft'],
        ]));

        return redirect()->route('service-contracts.index')->with('success', 'Service contract created.');
    }

    public function edit(ServiceContract $serviceContract)
    {
        return view('service-contracts.edit', [
            'serviceContract' => $serviceContract,
            'customers' => Customer::orderBy('name')->get(),
            'regions' => CustomerRegion::with('customer')->orderBy('name')->get(),
            'branches' => CustomerBranch::with('customer')->orderBy('name')->get(),
            'catalogs' => ServiceCatalog::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, ServiceContract $serviceContract)
    {
        $serviceContract->update($request->validate([
            'customer_id' => ['required','exists:customers,id'],
            'customer_region_id' => ['nullable','exists:customer_regions,id'],
            'customer_branch_id' => ['nullable','exists:customer_branches,id'],
            'service_catalog_id' => ['nullable','exists:service_catalogs,id'],
            'contract_no' => ['nullable','string','max:100','unique:service_contracts,contract_no,' . $serviceContract->id],
            'name' => ['required','string','max:255'],
            'start_date' => ['nullable','date'],
            'end_date' => ['nullable','date'],
            'support_hour' => ['nullable','string','max:100'],
            'response_minutes' => ['nullable','integer'],
            'resolution_minutes' => ['nullable','integer'],
            'pm_frequency' => ['required','in:daily,weekly,monthly,quarterly,semester,yearly,none'],
            'scope' => ['nullable','string'],
            'exclusion' => ['nullable','string'],
            'status' => ['required','in:active,inactive,expired,draft'],
        ]));

        return redirect()->route('service-contracts.index')->with('success', 'Service contract updated.');
    }

    public function destroy(ServiceContract $serviceContract)
    {
        $serviceContract->delete();
        return redirect()->route('service-contracts.index')->with('success', 'Service contract deleted.');
    }
}
