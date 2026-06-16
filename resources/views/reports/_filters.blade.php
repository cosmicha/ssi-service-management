<form method="GET" class="bg-white rounded-3xl border shadow-sm p-5 mb-6 grid md:grid-cols-5 gap-4 items-end">
    <div>
        <label class="text-sm font-bold text-slate-600">Customer</label>
        <select name="customer_id" class="w-full rounded-xl border-slate-300">
            <option value="">All Customers</option>
            @foreach($customers ?? [] as $customer)
                <option value="{{ $customer->id }}" @selected(request('customer_id') == $customer->id)>
                    {{ $customer->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="text-sm font-bold text-slate-600">Status</label>
        <input name="status" value="{{ request('status') }}" class="w-full rounded-xl border-slate-300" placeholder="open, assigned, closed">
    </div>

    <div>
        <label class="text-sm font-bold text-slate-600">From</label>
        <input type="date" name="from" value="{{ request('from') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="text-sm font-bold text-slate-600">To</label>
        <input type="date" name="to" value="{{ request('to') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div class="flex gap-2">
        <button class="px-5 py-3 rounded-2xl bg-[#ff8a00] font-black">Filter</button>
        <a href="{{ url()->current() }}" class="px-5 py-3 rounded-2xl bg-slate-100 font-black">Reset</a>
    </div>
</form>
