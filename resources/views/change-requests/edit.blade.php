<x-app-layout>
<h1 class="text-2xl font-black mb-6">Edit Change Request</h1>
<div class="bg-white rounded-2xl border p-6">
<form method="POST" enctype="multipart/form-data" action="{{ route('change-requests.update',$changeRequest) }}">
@csrf
@method('PUT')
@include('change-requests.form')
</form>
</div>
</x-app-layout>
