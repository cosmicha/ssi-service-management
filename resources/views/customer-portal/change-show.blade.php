<x-app-layout>
<div class="mb-6 flex items-start justify-between">
    <div>
        <h1 class="text-2xl font-black">{{ $changeRequest->title }}</h1>
        <p class="text-slate-500 mt-1">
            {{ $changeRequest->change_no }}
            —
            {{ $changeRequest->customer->name ?? '-' }}
            —
            {{ $changeRequest->branch->name ?? 'HO / All Locations' }}
        </p>
    </div>

    <a href="{{ route('customer.portal.changes') }}" class="px-4 py-2 bg-white border rounded-xl font-semibold">
        Back to Changes
    </a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border p-5">
        <div class="text-sm text-slate-500">Status</div>
        <div class="text-lg font-black mt-2 capitalize">{{ str_replace('_',' ', $changeRequest->status) }}</div>
    </div>

    <div class="bg-white rounded-2xl border p-5">
        <div class="text-sm text-slate-500">Risk</div>
        <div class="text-lg font-black mt-2 capitalize">{{ $changeRequest->risk_level }}</div>
    </div>

    <div class="bg-white rounded-2xl border p-5">
        <div class="text-sm text-slate-500">Asset</div>
        <div class="text-lg font-black mt-2">{{ $changeRequest->asset->name ?? '-' }}</div>
    </div>

    <div class="bg-white rounded-2xl border p-5">
        <div class="text-sm text-slate-500">Location</div>
        <div class="text-lg font-black mt-2">{{ $changeRequest->branch->name ?? 'HO / All Locations' }}</div>
    </div>
</div>

<div class="bg-white rounded-2xl border p-6 mb-6">
    <h2 class="font-black mb-4">Change Details</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
        <div><span class="font-semibold">Requested By:</span> {{ $changeRequest->requested_by ?? '-' }}</div>
        <div><span class="font-semibold">Requested Date:</span> {{ $changeRequest->requested_date?->format('d M Y H:i') ?? '-' }}</div>
        <div><span class="font-semibold">Work Task:</span> {{ $changeRequest->task->task_no ?? '-' }}</div>
    </div>

    @if($changeRequest->business_reason)
        <div class="mb-4">
            <div class="font-semibold">Business Reason</div>
            <div class="text-slate-700 whitespace-pre-line">{{ $changeRequest->business_reason }}</div>
        </div>
    @endif

    <div>
        <div class="font-semibold">Description</div>
        <div class="text-slate-700 whitespace-pre-line">{{ $changeRequest->description ?? 'No description.' }}</div>
    </div>
</div>

<div class="bg-white rounded-2xl border p-6 mb-6">
    <h2 class="font-black mb-4">Add Comment / Follow Up</h2>

    <form method="POST" enctype="multipart/form-data" action="{{ route('customer.portal.changes.comments.store', $changeRequest) }}">
        @csrf

        <label class="block text-sm font-semibold mb-1">Message</label>
        <textarea name="message" rows="4" class="w-full rounded-xl border-slate-300" required></textarea>

        <label class="block text-sm font-semibold mb-1 mt-4">Attachments</label>
        <input type="file" name="attachments[]" multiple class="w-full rounded-xl border border-slate-300 p-2">

        <button class="mt-4 px-5 py-2.5 bg-black text-white rounded-xl font-semibold">
            Add Comment
        </button>
    </form>
</div>

<div class="bg-white rounded-2xl border p-6">
    <h2 class="font-black mb-4">Activity Timeline</h2>

    <div class="space-y-4">
        @forelse($changeRequest->task?->updates ?? [] as $update)
            <div class="rounded-2xl border p-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="font-black capitalize">{{ str_replace('_',' ', $update->update_type) }}</div>
                        <div class="text-xs text-slate-500">
                            {{ $update->user->name ?? '-' }}
                            •
                            {{ $update->created_at?->format('d M Y H:i') }}
                        </div>
                    </div>

                    @if($update->old_status !== $update->new_status)
                        <div class="text-xs font-bold px-3 py-1 rounded-full bg-orange-100 text-[#ff8a00]">
                            {{ str_replace('_',' ', $update->old_status) }} → {{ str_replace('_',' ', $update->new_status) }}
                        </div>
                    @endif
                </div>

                @if($update->message)
                    <div class="mt-3 whitespace-pre-line text-slate-700">{{ $update->message }}</div>
                @endif

                @if($update->attachments->count())
                    <div class="mt-4 space-y-2">
                        @foreach($update->attachments as $file)
                            <div class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2">
                                <div>
                                    <div class="font-semibold text-sm">{{ $file->file_name }}</div>
                                    <div class="text-xs text-slate-500">{{ $file->mime_type ?? '-' }}</div>
                                </div>

                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="text-blue-600 font-semibold text-sm">
                                    View / Download
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="text-slate-500">No activity yet.</div>
        @endforelse
    </div>
</div>
</x-app-layout>
