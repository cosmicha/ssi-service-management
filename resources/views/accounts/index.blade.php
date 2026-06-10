<x-app-layout>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-black">Account Management</h1>
        <p class="text-slate-500">Manage admin, engineer, and customer portal accounts.</p>
    </div>
    <a href="{{ route('accounts.create') }}" class="px-4 py-2 bg-black text-white rounded-xl font-semibold">+ Add Account</a>
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
    <th class="text-left px-5 py-3">Customer</th>
    <th class="text-right px-5 py-3">Action</th>
</tr>
</thead>
<tbody class="divide-y">
@forelse($users as $user)
<tr>
    <td class="px-5 py-4 font-bold">{{ $user->name }}</td>
    <td class="px-5 py-4">{{ $user->email }}</td>
    <td class="px-5 py-4 capitalize">{{ $user->role ?? 'admin' }}</td>
    <td class="px-5 py-4">{{ $user->customer->name ?? '-' }}</td>
    <td class="px-5 py-4 text-right">
        <a href="{{ route('accounts.edit', $user) }}" class="text-blue-600 font-semibold">Edit</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="px-5 py-10 text-center text-slate-500">No accounts.</td>
</tr>
@endforelse
</tbody>
</table>
</div>

<div class="mt-4">{{ $users->links() }}</div>
</x-app-layout>
