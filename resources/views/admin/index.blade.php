@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-black text-slate-900">Administration</h1>
    <p class="text-slate-500 mt-1 mb-8">Master data, user access, and bulk upload tools.</p>

    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach([
            ['User Management','Manage admin, engineer, and customer accounts.', route('admin.users.index')],
            ['Import Center','Upload customers, branches, assets, inventory, and users from XLSX.', route('admin.import.index')],
            ['Customers','Add and manage customers.', route('customers.index')],
            ['Branches / Sites','Manage customer branches and sites.', route('customer-branches.index')],
            ['Assets','Add and manage assets.', route('assets.index')],
            ['Inventory','Manage inventory items and stock.', route('inventory.dashboard')],
            ['Checklist Templates','Manage PM checklist templates.', route('checklist-templates.index')],
            ['Preventive Schedules','Manage preventive maintenance schedules.', route('preventive-schedules.index')],
        ] as [$title,$desc,$url])
            <a href="{{ $url }}" class="bg-white rounded-3xl border shadow-sm p-6 hover:border-[#ff8a00] transition">
                <div class="text-xl font-black text-slate-900">{{ $title }}</div>
                <div class="text-slate-500 text-sm mt-2">{{ $desc }}</div>
                <div class="mt-5 text-[#ff8a00] font-black">Open →</div>
            </a>
        @endforeach
    </div>
</div>
@endsection
