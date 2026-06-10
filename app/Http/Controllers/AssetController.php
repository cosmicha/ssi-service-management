<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Customer;
use App\Models\CustomerBranch;
use App\Models\CustomerRegion;
use App\Models\PreventiveExecution;
use App\Models\Incident;
use App\Models\ChangeRequest;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $customerId = $request->query('customer');
        $branchId = $request->query('branch');

        $assets = Asset::with(['customer', 'region', 'branch', 'category'])
            ->when($customerId, fn ($q) => $q->where('customer_id', $customerId))
            ->when($branchId, fn ($q) => $q->where('customer_branch_id', $branchId))
            ->latest()
            ->paginate(15);

        return view('assets.index', compact('assets', 'customerId', 'branchId'));
    }

    public function create(Request $request)
    {
        $customers = Customer::orderBy('name')->get();
        $regions = CustomerRegion::with('customer')->orderBy('name')->get();
        $branches = CustomerBranch::with(['customer', 'region'])->orderBy('name')->get();
        $categories = AssetCategory::where('status', 'active')->orderBy('name')->get();

        $selectedCustomerId = $request->query('customer');
        $selectedBranchId = $request->query('branch');

        return view('assets.create', compact(
            'customers',
            'regions',
            'branches',
            'categories',
            'selectedCustomerId',
            'selectedBranchId'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'customer_region_id' => ['nullable', 'exists:customer_regions,id'],
            'customer_branch_id' => ['nullable', 'exists:customer_branches,id'],
            'asset_category_id' => ['nullable', 'exists:asset_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'asset_code' => ['nullable', 'string', 'max:100', 'unique:assets,asset_code'],
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'ip_address' => ['nullable', 'string', 'max:100'],
            'purchase_date' => ['nullable', 'date'],
            'warranty_expiry' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive,maintenance,faulty,retired'],
            'description' => ['nullable', 'string'],
        ]);

        $asset = Asset::create($data);

        return redirect()->route('assets.show', $asset)
            ->with('success', 'Asset created successfully.');
    }

    public function show(Asset $asset)
    {
        $asset->load(['customer', 'region', 'branch', 'category', 'attachments']);

        $pmExecutions = PreventiveExecution::with(['task', 'engineer'])
            ->whereHas('task', function ($q) use ($asset) {
                $q->where('asset_id', $asset->id);
            })
            ->latest()
            ->get();

        $incidents = Incident::with(['category', 'task'])
            ->where('asset_id', $asset->id)
            ->latest()
            ->get();

        $changeRequests = ChangeRequest::with(['category', 'task'])
            ->where('asset_id', $asset->id)
            ->latest()
            ->get();

        return view('assets.show', compact(
            'asset',
            'pmExecutions',
            'incidents',
            'changeRequests'
        ));
    }

    public function edit(Asset $asset)
    {
        $asset->load('attachments');

        $customers = Customer::orderBy('name')->get();
        $regions = CustomerRegion::with('customer')->orderBy('name')->get();
        $branches = CustomerBranch::with(['customer', 'region'])->orderBy('name')->get();
        $categories = AssetCategory::orderBy('name')->get();

        return view('assets.edit', compact(
            'asset',
            'customers',
            'regions',
            'branches',
            'categories'
        ));
    }

    public function update(Request $request, Asset $asset)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'customer_region_id' => ['nullable', 'exists:customer_regions,id'],
            'customer_branch_id' => ['nullable', 'exists:customer_branches,id'],
            'asset_category_id' => ['nullable', 'exists:asset_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'asset_code' => ['nullable', 'string', 'max:100', 'unique:assets,asset_code,' . $asset->id],
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'ip_address' => ['nullable', 'string', 'max:100'],
            'purchase_date' => ['nullable', 'date'],
            'warranty_expiry' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive,maintenance,faulty,retired'],
            'description' => ['nullable', 'string'],
        ]);

        $asset->update($data);

        return redirect()->route('assets.show', $asset)
            ->with('success', 'Asset updated successfully.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('assets.index')
            ->with('success', 'Asset deleted successfully.');
    }
}
