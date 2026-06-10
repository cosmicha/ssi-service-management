<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold mb-1">Customer</label>
        <select name="customer_id" class="w-full rounded-xl border-slate-300" required>
            <option value="">Select Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @selected(old('customer_id', $selectedCustomerId ?? $region?->customer_id) == $customer->id)>{{ $customer->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Region Name</label>
        <input name="name" value="{{ old('name', $region->name ?? '') }}" class="w-full rounded-xl border-slate-300" required>
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Code</label>
        <input name="code" value="{{ old('code', $region->code ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Contact Person</label>
        <input name="contact_person" value="{{ old('contact_person', $region->contact_person ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Contact Email</label>
        <input type="email" name="contact_email" value="{{ old('contact_email', $region->contact_email ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Contact Phone</label>
        <input name="contact_phone" value="{{ old('contact_phone', $region->contact_phone ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">Save Region</button>
    <a href="{{ route('customer-regions.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-xl font-semibold">Cancel</a>
</div>
