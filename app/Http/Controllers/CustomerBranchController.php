<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerBranch;
use App\Models\CustomerRegion;
use Illuminate\Http\Request;

class CustomerBranchController extends Controller
{
    public function index(Request $request)
    {
        $customerId = $request->query('customer');

        $branches = CustomerBranch::with(['customer', 'region'])
            ->when($customerId, fn ($q) => $q->where('customer_id', $customerId))
            ->latest()
            ->paginate(10);

        return view('customer-branches.index', compact('branches', 'customerId'));
    }

    public function create(Request $request)
    {
        $customers = Customer::orderBy('name')->get();
        $regions = CustomerRegion::orderBy('name')->get();
        $selectedCustomerId = $request->query('customer');

        return view('customer-branches.create', compact('customers', 'regions', 'selectedCustomerId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'customer_region_id' => ['nullable', 'exists:customer_regions,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:100'],
            'site_type' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        CustomerBranch::create($data);

        return redirect()->route('customer-branches.index', ['customer' => $data['customer_id']])
            ->with('success', 'Branch created successfully.');
    }

    public function edit(CustomerBranch $customerBranch)
    {
        $customers = Customer::orderBy('name')->get();
        $regions = CustomerRegion::orderBy('name')->get();

        return view('customer-branches.edit', compact('customerBranch', 'customers', 'regions'));
    }

    public function update(Request $request, CustomerBranch $customerBranch)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'customer_region_id' => ['nullable', 'exists:customer_regions,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:100'],
            'site_type' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $customerBranch->update($data);

        return redirect()->route('customer-branches.index', ['customer' => $data['customer_id']])
            ->with('success', 'Branch updated successfully.');
    }

    public function destroy(CustomerBranch $customerBranch)
    {
        $customerId = $customerBranch->customer_id;
        $customerBranch->delete();

        return redirect()->route('customer-branches.index', ['customer' => $customerId])
            ->with('success', 'Branch deleted successfully.');
    }
}
