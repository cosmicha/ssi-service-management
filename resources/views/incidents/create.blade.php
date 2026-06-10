<x-app-layout>
<h1 class="text-2xl font-black mb-6">Add Incident</h1>
<div class="bg-white rounded-2xl border p-6">
<form method="POST" enctype="multipart/form-data" action="{{ route('incidents.store') }}">
@csrf
@include('incidents.form', ['incident'=>null])
</form>
</div>
</x-app-layout>
