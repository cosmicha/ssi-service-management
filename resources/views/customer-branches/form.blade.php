<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold mb-1">Customer</label>
        <select name="customer_id" class="w-full rounded-xl border-slate-300" required>
            <option value="">Select Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @selected(old('customer_id', $selectedCustomerId ?? $branch?->customer_id) == $customer->id)>{{ $customer->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Region</label>
        <select name="customer_region_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Region</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}" @selected(old('customer_region_id', $branch->customer_region_id ?? '') == $region->id)>{{ $region->customer->name ?? '' }} - {{ $region->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Branch / Site Name</label>
        <input name="name" value="{{ old('name', $branch->name ?? '') }}" class="w-full rounded-xl border-slate-300" required>
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Code</label>
        <input name="code" value="{{ old('code', $branch->code ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Site Type</label>
        <input name="site_type" placeholder="Branch, HO, Warehouse, Store" value="{{ old('site_type', $branch->site_type ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Status</label>
        <select name="status" class="w-full rounded-xl border-slate-300">
            <option value="active" @selected(old('status', $branch->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $branch->status ?? 'active') === 'inactive')>Inactive</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">City</label>
        <input name="city" value="{{ old('city', $branch->city ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Province</label>
        <input name="province" value="{{ old('province', $branch->province ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Latitude</label>
        <input name="latitude" value="{{ old('latitude', $branch->latitude ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Longitude</label>
        <input name="longitude" value="{{ old('longitude', $branch->longitude ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Contact Person</label>
        <input name="contact_person" value="{{ old('contact_person', $branch->contact_person ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Contact Email</label>
        <input type="email" name="contact_email" value="{{ old('contact_email', $branch->contact_email ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Contact Phone</label>
        <input name="contact_phone" value="{{ old('contact_phone', $branch->contact_phone ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold mb-1">Address</label>
        <textarea name="address" rows="3" class="w-full rounded-xl border-slate-300">{{ old('address', $branch->address ?? '') }}</textarea>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">Save Branch</button>
    <a href="{{ route('customer-branches.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-xl font-semibold">Cancel</a>
</div>
