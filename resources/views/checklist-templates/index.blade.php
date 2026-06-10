<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Checklist Templates</h1>
            <p class="text-slate-500 mt-1">Master checklist used to generate preventive maintenance tasks for engineers.</p>
        </div>
        <a href="{{ route('checklist-templates.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">+ Add Template</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-5 py-3">Template</th>
                    <th class="text-left px-5 py-3">Category</th>
                    <th class="text-left px-5 py-3">Frequency</th>
                    <th class="text-left px-5 py-3">Items</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-right px-5 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($templates as $template)
                    <tr>
                        <td class="px-5 py-4">
                            <a href="{{ route('checklist-templates.show', $template) }}" class="font-bold text-slate-900 hover:underline">{{ $template->name }}</a>
                            <div class="text-xs text-slate-500">{{ $template->description }}</div>
                        </td>
                        <td class="px-5 py-4">{{ $template->category->name ?? 'General' }}</td>
                        <td class="px-5 py-4 capitalize">{{ $template->frequency }}</td>
                        <td class="px-5 py-4">{{ $template->items_count }}</td>
                        <td class="px-5 py-4 capitalize">{{ $template->status }}</td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('checklist-templates.edit', $template) }}" class="font-semibold hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-slate-500">No checklist templates yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $templates->links() }}</div>
</x-app-layout>
