<x-app-layout>

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-black">
            Inventory Locations
        </h1>

        <p class="text-slate-500">
            Warehouses, engineer stock, vehicles and customer sites.
        </p>
    </div>

    <a href="{{ route('inventory-locations.create') }}"
       class="px-5 py-3 bg-[#ff8a00] text-white rounded-xl font-black">
        Add Location
    </a>
</div>

<div class="bg-white rounded-3xl shadow overflow-hidden">

<table class="w-full">

<thead class="bg-slate-50">
<tr>
    <th class="p-4 text-left">Name</th>
    <th class="p-4 text-left">Code</th>
    <th class="p-4 text-left">Type</th>
    <th class="p-4 text-left">Status</th>
    <th class="p-4 text-right">Action</th>
</tr>
</thead>

<tbody>

@foreach($locations as $location)

<tr class="border-t">
    <td class="p-4 font-bold">
        {{ $location->name }}
    </td>

    <td class="p-4">
        {{ $location->code }}
    </td>

    <td class="p-4">
        {{ ucfirst($location->location_type) }}
    </td>

    <td class="p-4">
        {{ ucfirst($location->status) }}
    </td>

    <td class="p-4 text-right">
        <a href="{{ route('inventory-locations.edit',$location) }}"
           class="text-blue-600 font-bold">
            Edit
        </a>
    </td>
</tr>

@endforeach

</tbody>

</table>

</div>

</x-app-layout>
