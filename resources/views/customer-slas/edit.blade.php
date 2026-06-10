<x-app-layout>
<div class="mb-6 flex items-start justify-between">
    <div>
        <h1 class="text-2xl font-black">SLA Matrix</h1>
        <p class="text-slate-500">{{ $customer->name }}</p>
    </div>

    <a href="{{ route('customers.show', $customer) }}" class="px-4 py-2 bg-white border rounded-xl font-semibold">
        Back to Customer
    </a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl border p-6">
<form method="POST" action="{{ route('customer-slas.update', $customer) }}">
@csrf
@method('PUT')

<table class="w-full text-sm">
<thead class="bg-slate-50">
<tr>
    <th class="text-left px-4 py-3">Severity</th>
    <th class="text-left px-4 py-3">Active</th>
    <th class="text-left px-4 py-3">Response Minutes</th>
    <th class="text-left px-4 py-3">Resolution Minutes</th>
</tr>
</thead>
<tbody class="divide-y">
@foreach($slas as $sla)
<tr>
    <td class="px-4 py-4 font-black capitalize">{{ $sla->severity }}</td>
    <td class="px-4 py-4">
        <input type="checkbox" name="sla[{{ $sla->severity }}][is_active]" value="1" @checked($sla->is_active)>
    </td>
    <td class="px-4 py-4">
        <input type="number" name="sla[{{ $sla->severity }}][response_minutes]" value="{{ $sla->response_minutes }}" class="w-full rounded-xl border-slate-300">
    </td>
    <td class="px-4 py-4">
        <input type="number" name="sla[{{ $sla->severity }}][resolution_minutes]" value="{{ $sla->resolution_minutes }}" class="w-full rounded-xl border-slate-300">
    </td>
</tr>
@endforeach
</tbody>
</table>

<button class="mt-6 px-5 py-2.5 bg-black text-white rounded-xl font-semibold">
    Save SLA Matrix
</button>
</form>
</div>
</x-app-layout>
