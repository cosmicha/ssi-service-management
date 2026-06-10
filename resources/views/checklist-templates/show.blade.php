<x-app-layout>
    <div class="mb-6 flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900">{{ $checklistTemplate->name }}</h1>
            <p class="text-slate-500 mt-1">
                {{ $checklistTemplate->category->name ?? 'General' }} • {{ ucfirst($checklistTemplate->frequency) }}
            </p>
        </div>
        <a href="{{ route('checklist-templates.edit', $checklistTemplate) }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">Edit Template</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h2 class="font-black text-slate-900">Checklist Items</h2>
            </div>

            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-5 py-3">Order</th>
                        <th class="text-left px-5 py-3">Section</th>
                        <th class="text-left px-5 py-3">Item</th>
                        <th class="text-left px-5 py-3">Type</th>
                        <th class="text-left px-5 py-3">Required</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($checklistTemplate->items as $item)
                        <tr>
                            <td class="px-5 py-4">{{ $item->sort_order }}</td>
                            <td class="px-5 py-4">{{ $item->section ?? '-' }}</td>
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-900">{{ $item->item_name }}</div>
                                <div class="text-xs text-slate-500">{{ $item->instruction }}</div>
                            </td>
                            <td class="px-5 py-4">{{ $item->input_type }}</td>
                            <td class="px-5 py-4">{{ $item->is_required ? 'Yes' : 'No' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-slate-500">No checklist items yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h2 class="font-black text-slate-900 mb-4">Add Checklist Item</h2>

            <form method="POST" action="{{ route('checklist-templates.items.store', $checklistTemplate) }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Section</label>
                        <input name="section" class="w-full rounded-xl border-slate-300" placeholder="Health Check, Network, Backup">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Item Name</label>
                        <input name="item_name" class="w-full rounded-xl border-slate-300" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Instruction</label>
                        <textarea name="instruction" rows="3" class="w-full rounded-xl border-slate-300"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Input Type</label>
                        <select name="input_type" class="w-full rounded-xl border-slate-300">
                            <option value="pass_fail">Pass / Warning / Fail</option>
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="photo">Photo</option>
                            <option value="file">File</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Sort Order</label>
                        <input name="sort_order" type="number" value="0" class="w-full rounded-xl border-slate-300">
                    </div>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_required" value="1" checked>
                        <span class="text-sm font-semibold">Required</span>
                    </label>

                    <button class="w-full px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">Add Item</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
