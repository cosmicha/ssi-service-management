<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerSla;
use Illuminate\Http\Request;

class CustomerSlaController extends Controller
{
    public function edit(Customer $customer)
    {
        foreach (['critical','high','medium','low'] as $severity) {
            CustomerSla::firstOrCreate([
                'customer_id' => $customer->id,
                'severity' => $severity,
            ], [
                'response_minutes' => null,
                'resolution_minutes' => null,
                'is_active' => false,
            ]);
        }

        $slas = CustomerSla::where('customer_id', $customer->id)
            ->orderByRaw("CASE severity WHEN 'critical' THEN 1 WHEN 'high' THEN 2 WHEN 'medium' THEN 3 WHEN 'low' THEN 4 ELSE 5 END")
            ->get();

        return view('customer-slas.edit', compact('customer', 'slas'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'sla' => ['required', 'array'],
            'sla.*.response_minutes' => ['nullable', 'integer', 'min:1'],
            'sla.*.resolution_minutes' => ['nullable', 'integer', 'min:1'],
            'sla.*.is_active' => ['nullable'],
        ]);

        foreach ($data['sla'] as $severity => $row) {
            CustomerSla::updateOrCreate([
                'customer_id' => $customer->id,
                'severity' => $severity,
            ], [
                'response_minutes' => $row['response_minutes'] ?? null,
                'resolution_minutes' => $row['resolution_minutes'] ?? null,
                'is_active' => !empty($row['is_active']),
            ]);
        }

        return redirect()->route('customer-slas.edit', $customer)
            ->with('success', 'SLA matrix updated.');
    }
}
