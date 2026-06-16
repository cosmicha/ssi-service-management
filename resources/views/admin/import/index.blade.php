@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-black text-slate-900">Import Center</h1>
    <p class="text-slate-500 mt-1 mb-6">Download XLSX templates, fill them, then upload back into the system.</p>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-2xl bg-green-50 text-green-700">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 rounded-2xl bg-red-50 text-red-700">{{ session('error') }}</div>
    @endif

    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach([
            'customers' => 'Customers',
            'branches' => 'Branches / Sites',
            'assets' => 'Assets',
            'inventory-items' => 'Inventory Items',
            'users' => 'Users / Accounts',
        ] as $type => $label)
        <div class="bg-white rounded-3xl border shadow-sm p-6">
            <div class="text-xl font-black">{{ $label }}</div>
            <div class="text-slate-500 text-sm mt-2">Bulk upload {{ strtolower($label) }} from XLSX.</div>

            <div class="flex gap-3 mt-5">
                <a href="{{ route('admin.import.template',$type) }}" class="px-4 py-2 rounded-xl bg-slate-100 font-bold">
                    Download Template
                </a>
            </div>

            <form method="POST" action="{{ route('admin.import.upload',$type) }}" enctype="multipart/form-data" class="mt-4 space-y-3">
                @csrf
                <input type="file" name="file" accept=".xlsx,.xls" class="w-full rounded-xl border-slate-300">
                <button class="px-5 py-2 rounded-xl bg-[#ff8a00] font-black">
                    Upload
                </button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
