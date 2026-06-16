@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-black">Change Request Report</h1>
            <p class="text-slate-500">Hardware, firmware, and configuration change report.</p>
        </div>
        <a href="{{ route('reports.export','changes') }}?{{ http_build_query(request()->all()) }}" class="px-5 py-3 rounded-2xl bg-slate-900 text-white font-black">Export CSV</a>
    </div>

    @include('reports._filters')

    <div class="bg-white rounded-3xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="p-4 text-left">Change No</th>
                    <th class="p-4 text-left">Title</th>
                    <th class="p-4 text-left">Customer</th>
                    <th class="p-4 text-left">Branch</th>
                    <th class="p-4 text-left">Category</th>
                    <th class="p-4 text-left">Severity</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                    <tr class="border-t">
                        <td class="p-4 font-bold">{{ $i->change_no ?? $i->id }}</td>
                        <td class="p-4">{{ $i->title }}</td>
                        <td class="p-4">{{ $i->customer?->name ?? '-' }}</td>
                        <td class="p-4">{{ $i->branch?->name ?? '-' }}</td>
                        <td class="p-4">{{ $i->category?->name ?? '-' }}</td>
                        <td class="p-4">{{ $i->severity }}</td>
                        <td class="p-4">{{ $i->status }}</td>
                        <td class="p-4">{{ $i->created_at?->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="p-6 text-center text-slate-500">No data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $items->links() }}</div>
</div>
@endsection
