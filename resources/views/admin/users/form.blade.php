@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-black mb-6">
        {{ $user->exists ? 'Edit User' : 'Add User' }}
    </h1>

    <form method="POST" action="{{ $user->exists ? route('admin.users.update',$user) : route('admin.users.store') }}" class="bg-white rounded-3xl border shadow-sm p-6 space-y-5">
        @csrf
        @if($user->exists)
            @method('PUT')
        @endif

        <div>
            <label class="font-bold">Name</label>
            <input name="name" value="{{ old('name',$user->name) }}" class="w-full rounded-xl border-slate-300">
        </div>

        <div>
            <label class="font-bold">Email</label>
            <input name="email" value="{{ old('email',$user->email) }}" class="w-full rounded-xl border-slate-300">
        </div>

        <div>
            <label class="font-bold">Password {{ $user->exists ? '(leave blank to keep)' : '' }}</label>
            <input name="password" type="password" class="w-full rounded-xl border-slate-300">
        </div>

        <div>
            <label class="font-bold">Role</label>
            <select name="role" class="w-full rounded-xl border-slate-300">
                @foreach(['admin','service_manager','dispatcher','engineer','customer_admin','customer'] as $role)
                    <option value="{{ $role }}" @selected(old('role',$user->role)===$role)>{{ $role }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="font-bold">Customer</label>
            <select name="customer_id" class="w-full rounded-xl border-slate-300">
                <option value="">Internal / All Customers</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" @selected(old('customer_id',$user->customer_id)==$customer->id)>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="font-bold">Customer Access Scope</label>
            <select name="customer_access_scope" class="w-full rounded-xl border-slate-300">
                <option value="ho" @selected(old('customer_access_scope',$user->customer_access_scope)==='ho')>HO / All Branches</option>
                <option value="branch" @selected(old('customer_access_scope',$user->customer_access_scope)==='branch')>Branch Only</option>
            </select>
        </div>

        <div>
            <label class="font-bold">Branch</label>
            <select name="customer_branch_id" class="w-full rounded-xl border-slate-300">
                <option value="">-</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" @selected(old('customer_branch_id',$user->customer_branch_id)==$branch->id)>
                        {{ $branch->customer?->name }} - {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <label class="flex gap-2 items-center">
            <input type="checkbox" name="is_approved" value="1" @checked(old('is_approved',$user->is_approved ?? true))>
            <span class="font-bold">Approved</span>
        </label>

        <button class="px-6 py-3 rounded-2xl bg-[#ff8a00] font-black">
            Save User
        </button>
    </form>
</div>
@endsection
