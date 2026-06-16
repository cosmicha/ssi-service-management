<x-app-layout>

<div class="mb-6">
    <h1 class="text-3xl font-black">
        Stock Balance
    </h1>

    <p class="text-slate-500">
        Current inventory by location.
    </p>
</div>

<div class="bg-white rounded-3xl shadow overflow-auto">

<table class="w-full text-sm">

<thead class="bg-slate-50">

<tr>

<th class="p-4 text-left">
Item
</th>

@foreach($locations as $location)

<th class="p-4 text-center">
{{ $location->name }}
</th>

@endforeach

<th class="p-4 text-center">
Total
</th>

</tr>

</thead>

<tbody>

@foreach($items as $item)

<tr class="border-t">

<td class="p-4 font-bold">
{{ $item->name }}
</td>

@foreach($locations as $location)

<td class="p-4 text-center">

{{ $item->stockByLocation($location->id) }}

</td>

@endforeach

<td class="p-4 text-center font-black">

{{ $item->currentStock() }}

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</x-app-layout>
