<x-app-layout>

<h1 class="text-3xl font-black mb-6">
Add Location
</h1>

<div class="bg-white rounded-3xl p-6 shadow">

<form method="POST"
action="{{ route('inventory-locations.store') }}">

@csrf

@include('inventory-locations.form')

</form>

</div>

</x-app-layout>
