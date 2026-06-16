@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-black mb-6">My Assets</h1>
    <div class="bg-white rounded-3xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="p-4 text-left">Code</th>
                    <th class="p-4 text-left">Name</th>
                    <th class="p-4 text-left">Branch</th>
                    <th class="p-4 text-left">Category</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">QR</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $asset)
                    <tr class="border-t">
                        <td class="p-4 font-bold">{{ $asset->asset_code }}</td>
                        <td class="p-4">{{ $asset->name }}</td>
                        <td class="p-4">{{ $asset->branch?->name ?? '-' }}</td>
                        <td class="p-4">{{ $asset->category?->name ?? '-' }}</td>
                        <td class="p-4">{{ $asset->status }}</td>
                        <td class="p-4">
                            <a class="text-[#ff8a00] font-black" href="{{ route('assets.qr.show', $asset->qr_uuid ?? $asset->id) }}">Open</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-6 text-center text-slate-500">No assets.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $items->links() }}</div>
</div>
@endsection
