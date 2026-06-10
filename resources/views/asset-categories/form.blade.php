<div class="grid grid-cols-1 gap-4">
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Category Name</label>
        <input name="name"
               value="{{ old('name', $category->name ?? '') }}"
               class="w-full rounded-xl border-slate-300"
               placeholder="Firewall, Router, Switch, Server, Application, Service"
               required>
        @error('name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
        <textarea name="description"
                  rows="3"
                  class="w-full rounded-xl border-slate-300"
                  placeholder="Short explanation for this asset category">{{ old('description', $category->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
        <select name="status" class="w-full rounded-xl border-slate-300">
            <option value="active" @selected(old('status', $category->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $category->status ?? 'active') === 'inactive')>Inactive</option>
        </select>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">Save Category</button>
    <a href="{{ route('asset-categories.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-xl font-semibold text-slate-700">Cancel</a>
</div>
