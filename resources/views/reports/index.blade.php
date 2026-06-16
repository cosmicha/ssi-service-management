@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-black text-slate-900">Reports</h1>
    <p class="text-slate-500 mt-1 mb-8">Operational reports for SSI service management.</p>

    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach([
            ['Incident Report','Ticket, severity, status, customer and branch.', route('reports.incidents')],
            ['Change Request Report','Hardware, firmware and configuration changes.', route('reports.changes')],
            ['Preventive Maintenance Report','PM execution and checklist completion.', route('reports.preventive')],
            ['Asset Report','Customer assets, status, warranty and ownership.', route('reports.assets')],
            ['Customer Report','Customer, branch, asset and ticket summary.', route('reports.customers')],
        ] as [$title,$desc,$url])
            <a href="{{ $url }}" class="bg-white rounded-3xl border shadow-sm p-6 hover:border-[#ff8a00] transition">
                <div class="text-xl font-black text-slate-900">{{ $title }}</div>
                <div class="text-slate-500 text-sm mt-2">{{ $desc }}</div>
                <div class="mt-5 text-[#ff8a00] font-black">Open Report →</div>
            </a>
        @endforeach
    </div>
</div>
@endsection
