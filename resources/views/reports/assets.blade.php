@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-black">Asset Report</h1>
            <p class="text-slate-500">Customer asset registry report.</p>
        </div>
        <a href="{{ route('reports.export','assets') }}?{{ http_build_query(request()->all()) }}" class="px-5 py-3 rounded-2xl bg-slate-900 text-white font-black">Export CSV</a>
    </div>

    @include('reports._filters')

    <div class="bg-white rounded-3xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="p-4 text-left">Code</th>
                    <th class="p-4 text-left">Name</th>
                    <th class="p-4 text-left">Customer</th>
                    <th class="p-4 text-left">Branch</th>
                    <th class="p-4 text-left">Category</th>
                    <th class="p-4 text-left">Brand</th>
                    <th class="p-4 text-left">Model</th>
                    <th class="p-4 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                    <tr class="border-t">
                        <td class="p-4 font-bold">{{ $i->asset_code }}</td>
                        <td class="p-4">{{ $i->name }}</td>
                        <td class="p-4">{{ $i->customer?->name ?? '-' }}</td>
                        <td class="p-4">{{ $i->branch?->name ?? '-' }}</td>
                        <td class="p-4">{{ $i->category?->name ?? '-' }}</td>
                        <td class="p-4">{{ $i->brand ?? '-' }}</td>
                        <td class="p-4">{{ $i->model ?? '-' }}</td>
                        <td class="p-4">{{ $i->status }}</td>
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
