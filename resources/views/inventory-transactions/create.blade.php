<x-app-layout>

<h1 class="text-3xl font-black mb-6">
Stock Transaction
</h1>

<div class="bg-white rounded-3xl p-6 shadow">

<form method="POST"
action="{{ route('inventory-transactions.store') }}">

@csrf

<div class="grid md:grid-cols-2 gap-5">

<div>

<label class="block mb-2 font-black">
Item
</label>

<select
name="inventory_item_id"
class="w-full rounded-xl">

@foreach($items as $item)
<option value="{{ $item->id }}">
{{ $item->name }}
</option>
@endforeach

</select>

</div>

<div>

<label class="block mb-2 font-black">
Location
</label>

<select
name="inventory_location_id"
class="w-full rounded-xl">

@foreach($locations as $location)
<option value="{{ $location->id }}">
{{ $location->name }}
</option>
@endforeach

</select>

</div>

<div>

<label class="block mb-2 font-black">
Transaction Type
</label>

<select
name="transaction_type"
class="w-full rounded-xl">

<option value="in">Stock In</option>
<option value="out">Stock Out</option>
<option value="adjustment">Adjustment</option>
<option value="used">Used Part</option>

</select>

</div>

<div>

<label class="block mb-2 font-black">
Quantity
</label>

<input
type="number"
name="quantity"
value="1"
class="w-full rounded-xl">

</div>

<div class="md:col-span-2">

<label class="block mb-2 font-black">
Notes
</label>

<textarea
name="notes"
rows="4"
class="w-full rounded-xl"></textarea>

</div>

</div>

<button
class="mt-6 px-5 py-3 bg-black text-white rounded-xl font-black">

Save Transaction

</button>

</form>

</div>

</x-app-layout>
