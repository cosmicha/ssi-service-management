<x-app-layout>
<h1 class="text-2xl font-black mb-6">Add Account</h1>

<div class="bg-white rounded-2xl border p-6">
<form method="POST" action="{{ route('accounts.store') }}">
@csrf
@include('accounts.form')
</form>
</div>
</x-app-layout>
