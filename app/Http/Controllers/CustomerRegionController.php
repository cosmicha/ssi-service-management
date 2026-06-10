<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerRegion;
use Illuminate\Http\Request;

class CustomerRegionController extends Controller
{
    public function index(Request $request)
    {
        $customerId = $request->query('customer');

        $regions = CustomerRegion::with('customer')
            ->withCount('branches')
            ->when($customerId, fn ($q) => $q->where('customer_id', $customerId))
            ->latest()
            ->paginate(10);

        $customers = Customer::orderBy('name')->get();

        return view('customer-regions.index', compact('regions', 'customers', 'customerId'));
    }

    public function create(Request $request)
    {
        $customers = Customer::orderBy('name')->get();
        $selectedCustomerId = $request->query('customer');

        return view('customer-regions.create', compact('customers', 'selectedCustomerId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:100'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:100'],
        ]);

        CustomerRegion::create($data);

        return redirect()->route('customer-regions.index', ['customer' => $data['customer_id']])
            ->with('success', 'Region created successfully.');
    }

    public function edit(CustomerRegion $customerRegion)
    {
        $customers = Customer::orderBy('name')->get();

        return view('customer-regions.edit', compact('customerRegion', 'customers'));
    }

    public function update(Request $request, CustomerRegion $customerRegion)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:100'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:100'],
        ]);

        $customerRegion->update($data);

        return redirect()->route('customer-regions.index', ['customer' => $data['customer_id']])
            ->with('success', 'Region updated successfully.');
    }

    public function destroy(CustomerRegion $customerRegion)
    {
        $customerId = $customerRegion->customer_id;
        $customerRegion->delete();

        return redirect()->route('customer-regions.index', ['customer' => $customerId])
            ->with('success', 'Region deleted successfully.');
    }
}
