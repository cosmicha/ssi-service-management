<x-app-layout>

<div class="flex justify-between items-center mb-6">

    <div>
        <h1 class="text-3xl font-black">
            Stock Movements
        </h1>

        <p class="text-slate-500">
            Inventory stock transaction history.
        </p>
    </div>

    <a href="/inventory-transactions/create"
       class="px-5 py-3 bg-[#ff8a00] text-white rounded-xl font-black">
        Add Transaction
    </a>

</div>

<div class="bg-white rounded-3xl shadow overflow-hidden">

<table class="w-full">

<thead class="bg-slate-50">
<tr>
    <th class="p-4 text-left">Date</th>
    <th class="p-4 text-left">Item</th>
    <th class="p-4 text-left">Location</th>
    <th class="p-4 text-left">Type</th>
    <th class="p-4 text-left">Qty</th>
</tr>
</thead>

<tbody>

@foreach($transactions as $trx)

<tr class="border-t">

<td class="p-4">
{{ $trx->created_at->format('d M Y') }}
</td>

<td class="p-4 font-bold">
{{ $trx->item?->name }}
</td>

<td class="p-4">
{{ $trx->location?->name }}
</td>

<td class="p-4">
{{ $trx->transaction_type }}
</td>

<td class="p-4 font-black">
{{ $trx->quantity }}
</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</x-app-layout>
