<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<div>
    <label class="block font-semibold mb-1">Name</label>
    <input name="name" value="{{ old('name', $account->name ?? '') }}" class="w-full rounded-xl border-slate-300" required>
</div>

<div>
    <label class="block font-semibold mb-1">Email</label>
    <input type="email" name="email" value="{{ old('email', $account->email ?? '') }}" class="w-full rounded-xl border-slate-300" required>
</div>

<div>
    <label class="block font-semibold mb-1">Password {{ isset($account) ? '(leave blank if unchanged)' : '' }}</label>
    <input type="password" name="password" class="w-full rounded-xl border-slate-300" {{ isset($account) ? '' : 'required' }}>
</div>

<div>
    <label class="block font-semibold mb-1">Role</label>
    <select name="role" class="w-full rounded-xl border-slate-300">
        <option value="customer" @selected(old('role', $account->role ?? 'customer') === 'customer')>Customer</option>
        <option value="customer_admin" @selected(old('role', $account->role ?? '') === 'customer_admin')>Customer Admin</option>
    </select>
</div>

<div>
    <label class="block font-semibold mb-1">Location Access</label>
    <select name="customer_access_scope" class="w-full rounded-xl border-slate-300">
        <option value="ho" @selected(old('customer_access_scope', $account->customer_access_scope ?? 'ho') === 'ho')>HO / All Locations</option>
        <option value="branch" @selected(old('customer_access_scope', $account->customer_access_scope ?? '') === 'branch')>Branch Only</option>
    </select>
</div>

<div>
    <label class="block font-semibold mb-1">Branch</label>
    <select name="customer_branch_id" class="w-full rounded-xl border-slate-300">
        <option value="">No Branch / HO</option>
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}" @selected(old('customer_branch_id', $account->customer_branch_id ?? '') == $branch->id)>
                {{ $branch->name }}
            </option>
        @endforeach
    </select>
</div>
</div>

<button class="mt-6 px-5 py-2.5 bg-black text-white rounded-xl font-semibold">Save Account</button>
