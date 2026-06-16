@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900">User Management</h1>
            <p class="text-slate-500 mt-1">Manage admin, engineer, and customer access.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-5 py-3 rounded-2xl bg-[#ff8a00] font-black">
            Add User
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-2xl bg-green-50 text-green-700">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-3xl border shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="text-left p-4">Name</th>
                    <th class="text-left p-4">Email</th>
                    <th class="text-left p-4">Role</th>
                    <th class="text-left p-4">Customer</th>
                    <th class="text-left p-4">Scope</th>
                    <th class="text-right p-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr class="border-t">
                    <td class="p-4 font-bold">{{ $u->name }}</td>
                    <td class="p-4">{{ $u->email }}</td>
                    <td class="p-4">{{ $u->role }}</td>
                    <td class="p-4">{{ $u->customer?->name ?? '-' }}</td>
                    <td class="p-4">{{ $u->customer_access_scope ?? '-' }}</td>
                    <td class="p-4 text-right">
                        <a href="{{ route('admin.users.edit',$u) }}" class="text-blue-600 font-bold">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
</div>
@endsection
