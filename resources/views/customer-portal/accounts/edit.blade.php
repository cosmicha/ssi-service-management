<x-app-layout>
<h1 class="text-2xl font-black mb-6">Edit Customer User</h1>
<div class="bg-white rounded-2xl border p-6">
<form method="POST" action="{{ route('customer.portal.accounts.update', $account) }}">
@csrf
@method('PUT')
@include('customer-portal.accounts.form')
</form>
</div>
</x-app-layout>
