<x-app-layout>
<h1 class="text-2xl font-black mb-6">Edit Service Category</h1>
<div class="bg-white rounded-2xl border p-6 max-w-2xl"><form method="POST" action="{{ route('service-categories.update', $serviceCategory) }}">@csrf @method('PUT') @include('service-categories.form', ['category'=>$serviceCategory])</form></div>
</x-app-layout>
