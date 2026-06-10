<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold mb-1">Name</label>
        <input name="name" value="{{ old('name', $user->name ?? '') }}" class="w-full rounded-xl border-slate-300" required>
        @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full rounded-xl border-slate-300" required>
        @error('email') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Password {{ isset($user) ? '(leave blank if unchanged)' : '' }}</label>
        <input type="password" name="password" class="w-full rounded-xl border-slate-300" {{ isset($user) ? '' : 'required' }}>
        @error('password') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Role</label>
        <select name="role" class="w-full rounded-xl border-slate-300">
            @foreach(['admin'=>'Admin','engineer'=>'Engineer','customer'=>'Customer'] as $value => $label)
                <option value="{{ $value }}" @selected(old('role', $user->role ?? 'admin') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('role') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold mb-1">Customer / Company</label>
        <select name="customer_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @selected(old('customer_id', $user->customer_id ?? '') == $customer->id)>{{ $customer->name }}</option>
            @endforeach
        </select>
        <p class="text-xs text-slate-500 mt-1">Required only for customer portal accounts.</p>
        @error('customer_id') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2.5 bg-black text-white rounded-xl font-semibold">Save Account</button>
    <a href="{{ route('accounts.index') }}" class="px-5 py-2.5 bg-white border rounded-xl font-semibold">Cancel</a>
</div>
