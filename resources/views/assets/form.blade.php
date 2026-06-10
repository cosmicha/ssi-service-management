<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Customer</label>
        <select name="customer_id" class="w-full rounded-xl border-slate-300" required>
            <option value="">Select Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @selected(old('customer_id', $selectedCustomerId ?? $asset->customer_id ?? '') == $customer->id)>{{ $customer->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Category</label>
        <select name="asset_category_id" class="w-full rounded-xl border-slate-300">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('asset_category_id', $asset->asset_category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Region</label>
        <select name="customer_region_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Region</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}" @selected(old('customer_region_id', $asset->customer_region_id ?? '') == $region->id)>{{ $region->customer->name ?? '' }} - {{ $region->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Branch / Site</label>
        <select name="customer_branch_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Branch</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}" @selected(old('customer_branch_id', $selectedBranchId ?? $asset->customer_branch_id ?? '') == $branch->id)>{{ $branch->customer->name ?? '' }} - {{ $branch->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Asset Name</label>
        <input name="name" value="{{ old('name', $asset->name ?? '') }}" class="w-full rounded-xl border-slate-300" required>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Asset Code</label>
        <input name="asset_code" value="{{ old('asset_code', $asset->asset_code ?? '') }}" class="w-full rounded-xl border-slate-300" placeholder="Optional unique code">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Brand</label>
        <input name="brand" value="{{ old('brand', $asset->brand ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Model</label>
        <input name="model" value="{{ old('model', $asset->model ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Serial Number</label>
        <input name="serial_number" value="{{ old('serial_number', $asset->serial_number ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">IP Address / Host</label>
        <input name="ip_address" value="{{ old('ip_address', $asset->ip_address ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Purchase Date</label>
        <input type="date" name="purchase_date" value="{{ old('purchase_date', $asset->purchase_date ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Warranty Expiry</label>
        <input type="date" name="warranty_expiry" value="{{ old('warranty_expiry', $asset->warranty_expiry ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
        <select name="status" class="w-full rounded-xl border-slate-300">
            @foreach(['active'=>'Active','inactive'=>'Inactive','maintenance'=>'Maintenance','faulty'=>'Faulty','retired'=>'Retired'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $asset->status ?? 'active') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-slate-700 mb-1">Description / Configuration Notes</label>
        <textarea name="description" rows="4" class="w-full rounded-xl border-slate-300">{{ old('description', $asset->description ?? '') }}</textarea>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">Save Asset</button>
    <a href="{{ route('assets.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-xl font-semibold text-slate-700">Cancel</a>
</div>
