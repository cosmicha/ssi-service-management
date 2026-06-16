@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-black mb-6">My Tickets</h1>
    <div class="bg-white rounded-3xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="p-4 text-left">Ticket</th>
                    <th class="p-4 text-left">Title</th>
                    <th class="p-4 text-left">Branch</th>
                    <th class="p-4 text-left">Category</th>
                    <th class="p-4 text-left">Severity</th>
                    <th class="p-4 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $incident)
                    <tr class="border-t">
                        <td class="p-4 font-bold">{{ $incident->incident_no ?? $incident->ticket_no ?? $incident->id }}</td>
                        <td class="p-4">{{ $incident->title }}</td>
                        <td class="p-4">{{ $incident->branch?->name ?? '-' }}</td>
                        <td class="p-4">{{ $incident->category?->name ?? '-' }}</td>
                        <td class="p-4">{{ $incident->severity }}</td>
                        <td class="p-4">{{ $incident->status }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-6 text-center text-slate-500">No tickets.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $items->links() }}</div>
</div>
@endsection
