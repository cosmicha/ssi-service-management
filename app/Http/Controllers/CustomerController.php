<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withCount(['regions', 'branches'])
            ->latest()
            ->paginate(10);

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:100', 'unique:customers,code'],
            'industry' => ['nullable', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'contract_start' => ['nullable', 'date'],
            'contract_end' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive,prospect'],
            'sla_enabled' => ['nullable'],
            'response_minutes' => ['nullable','integer','min:1'],
            'resolution_minutes' => ['nullable','integer','min:1'],
            'logo' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['sla_enabled'] = $request->boolean('sla_enabled');

        if (!$data['sla_enabled']) {
            $data['response_minutes'] = null;
            $data['resolution_minutes'] = null;
        }

        $data['sla_enabled'] = $request->boolean('sla_enabled');

        if (!$data['sla_enabled']) {
            $data['response_minutes'] = null;
            $data['resolution_minutes'] = null;
        }

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('customer-logos', 'public');
        }

        unset($data['logo']);

        Customer::create($data);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        $customer->loadCount(['regions', 'branches']);

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:100', 'unique:customers,code,' . $customer->id],
            'industry' => ['nullable', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'contract_start' => ['nullable', 'date'],
            'contract_end' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive,prospect'],
            'sla_enabled' => ['nullable'],
            'response_minutes' => ['nullable','integer','min:1'],
            'resolution_minutes' => ['nullable','integer','min:1'],
            'logo' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('customer-logos', 'public');
        }

        unset($data['logo']);

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
