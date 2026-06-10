@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Customer Name</label>
        <input name="name" value="{{ old('name', $customer->name ?? '') }}" class="w-full rounded-xl border-slate-300" required>
        @error('name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Customer Code</label>
        <input name="code" value="{{ old('code', $customer->code ?? '') }}" class="w-full rounded-xl border-slate-300" required>
        @error('code') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Industry</label>
        <input name="industry" value="{{ old('industry', $customer->industry ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Customer Logo</label>
        <input type="file" name="logo" class="w-full rounded-xl border border-slate-300 p-2">

        @if(!empty($customer?->logo_path))
            <img src="{{ asset('storage/' . $customer->logo_path) }}" class="mt-3 h-12 object-contain">
        @endif
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
        <select name="status" class="w-full rounded-xl border-slate-300">
            @foreach(['active' => 'Active', 'inactive' => 'Inactive', 'prospect' => 'Prospect'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $customer->status ?? 'active') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Contact Person</label>
        <input name="contact_person" value="{{ old('contact_person', $customer->contact_person ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Contact Email</label>
        <input name="contact_email" type="email" value="{{ old('contact_email', $customer->contact_email ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Contact Phone</label>
        <input name="contact_phone" value="{{ old('contact_phone', $customer->contact_phone ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Contract Start</label>
        <input name="contract_start" type="date" value="{{ old('contract_start', $customer->contract_start ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Contract End</label>
        <input name="contract_end" type="date" value="{{ old('contract_end', $customer->contract_end ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-slate-700 mb-1">Address</label>
        <textarea name="address" rows="3" class="w-full rounded-xl border-slate-300">{{ old('address', $customer->address ?? '') }}</textarea>
    </div>
</div>

<div class="md:col-span-2 border rounded-2xl p-4 mt-2">
        <h3 class="font-black mb-3">Company SLA</h3>

        <label class="flex items-center gap-2 text-sm font-semibold mb-3">
            <input type="checkbox" name="sla_enabled" value="1" class="rounded border-slate-300"
                @checked(old('sla_enabled', $customer->sla_enabled ?? false))>
            Enable SLA for this company
        </label>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Response Minutes</label>
                <input type="number" name="response_minutes" value="{{ old('response_minutes', $customer->response_minutes ?? 30) }}" class="w-full rounded-xl border-slate-300">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Resolution Minutes</label>
                <input type="number" name="resolution_minutes" value="{{ old('resolution_minutes', $customer->resolution_minutes ?? 240) }}" class="w-full rounded-xl border-slate-300">
            </div>
        </div>
    </div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">Save Customer</button>
    <a href="{{ route('customers.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-xl font-semibold text-slate-700">Cancel</a>
</div>
