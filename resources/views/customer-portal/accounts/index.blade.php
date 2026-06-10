<x-app-layout>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-black">Manage Accounts</h1>
        <p class="text-slate-500">Customer Admin can manage users under this company.</p>
    </div>
    <a href="{{ route('customer.portal.accounts.create') }}" class="px-4 py-2 bg-black text-white rounded-xl font-semibold">+ Add User</a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-2xl border overflow-hidden">
<table class="w-full text-sm">
<thead class="bg-slate-50">
<tr>
<th class="text-left px-5 py-3">Name</th>
<th class="text-left px-5 py-3">Email</th>
<th class="text-left px-5 py-3">Role</th>
<th class="text-left px-5 py-3">Location</th>
<th class="text-right px-5 py-3">Action</th>
</tr>
</thead>
<tbody class="divide-y">
@forelse($accounts as $account)
<tr>
<td class="px-5 py-4 font-black">{{ $account->name }}</td>
<td class="px-5 py-4">{{ $account->email }}</td>
<td class="px-5 py-4">{{ $account->role === 'customer_admin' ? 'Customer Admin' : 'Customer' }}</td>
<td class="px-5 py-4">
    {{ ($account->customer_access_scope ?? 'ho') === 'ho' ? 'HO / All Locations' : 'Branch: ' . ($account->customerBranch->name ?? '-') }}
</td>
<td class="px-5 py-4 text-right">
    <a href="{{ route('customer.portal.accounts.edit', $account) }}" class="text-blue-600 font-semibold">Edit</a>
</td>
</tr>
@empty
<tr><td colspan="5" class="px-5 py-10 text-center text-slate-500">No accounts.</td></tr>
@endforelse
</tbody>
</table>
</div>
</x-app-layout>
