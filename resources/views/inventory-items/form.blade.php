<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-black mb-2">SKU</label>
        <input name="sku" value="{{ old('sku', $item->sku ?? '') }}" class="w-full rounded-xl border-slate-300" placeholder="CAP-35UF">
    </div>

    <div>
        <label class="block text-sm font-black mb-2">Category</label>
        <select name="inventory_category_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('inventory_category_id', $item->inventory_category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-black mb-2">Item Name</label>
        <input name="name" value="{{ old('name', $item->name ?? '') }}" class="w-full rounded-xl border-slate-300" required placeholder="Capacitor 35uF">
    </div>

    <div>
        <label class="block text-sm font-black mb-2">Brand</label>
        <input name="brand" value="{{ old('brand', $item->brand ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-black mb-2">Model</label>
        <input name="model" value="{{ old('model', $item->model ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-black mb-2">Unit</label>
        <input name="unit" value="{{ old('unit', $item->unit ?? 'pcs') }}" class="w-full rounded-xl border-slate-300" required>
    </div>

    <div>
        <label class="block text-sm font-black mb-2">Standard Cost</label>
        <input type="number" step="0.01" name="standard_cost" value="{{ old('standard_cost', $item->standard_cost ?? 0) }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-black mb-2">Minimum Stock</label>
        <input type="number" name="minimum_stock" value="{{ old('minimum_stock', $item->minimum_stock ?? 0) }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-black mb-2">Status</label>
        <select name="status" class="w-full rounded-xl border-slate-300">
            <option value="active" @selected(old('status', $item->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $item->status ?? '') === 'inactive')>Inactive</option>
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-black mb-2">Description</label>
        <textarea name="description" rows="4" class="w-full rounded-xl border-slate-300">{{ old('description', $item->description ?? '') }}</textarea>
    </div>
</div>

<button class="mt-6 px-5 py-3 rounded-xl bg-black text-white font-black">
    Save Item
</button>
