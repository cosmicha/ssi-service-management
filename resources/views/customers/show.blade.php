<x-app-layout>
    <div class="mb-6 flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900">{{ $customer->name }}</h1>
            <p class="text-slate-500 mt-1">{{ $customer->code }} • {{ $customer->industry ?? 'No industry set' }}</p>
        </div>
        <a href="{{ route('customers.edit', $customer) }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">Edit Customer</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="text-sm text-slate-500">Regions</div>
            <div class="text-3xl font-black mt-2">{{ $customer->regions_count }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="text-sm text-slate-500">Branches / Sites</div>
            <div class="text-3xl font-black mt-2">{{ $customer->branches_count }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="text-sm text-slate-500">Status</div>
            <div class="text-3xl font-black mt-2 capitalize">{{ $customer->status }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <h2 class="text-lg font-black text-slate-900 mb-4">Customer Operations Scope</h2>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            <a href="/customer-regions?customer={{ $customer->id }}" class="p-4 rounded-xl border border-slate-200 hover:bg-slate-50 font-semibold">Regions</a>
            <a href="/customer-branches?customer={{ $customer->id }}" class="p-4 rounded-xl border border-slate-200 hover:bg-slate-50 font-semibold">Branches</a>
            <a href="#" class="p-4 rounded-xl border border-slate-200 text-slate-400 font-semibold">Users</a>
            <a href="#" class="p-4 rounded-xl border border-slate-200 text-slate-400 font-semibold">Contracts</a>
            <a href="#" class="p-4 rounded-xl border border-slate-200 text-slate-400 font-semibold">Reports</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
        <h2 class="text-lg font-black mb-4">Customer Structure</h2>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            <a href="{{ route('customer-regions.create', ['customer' => $customer->id]) }}"
               class="p-4 rounded-xl border font-bold hover:bg-orange-50">
                + Add Region
            </a>

            <a href="{{ route('customer-branches.create', ['customer' => $customer->id]) }}"
               class="p-4 rounded-xl border font-bold hover:bg-orange-50">
                + Add Branch
            </a>

            <a href="{{ route('customer-branches.index', ['customer' => $customer->id]) }}"
               class="p-4 rounded-xl border font-bold hover:bg-orange-50">
                View Branches
            </a>

            <a href="{{ route('assets.index', ['customer' => $customer->id]) }}"
               class="p-4 rounded-xl border font-bold hover:bg-orange-50">
                View Assets
            </a>

            <a href="{{ route('customer-slas.edit', $customer) }}"
               class="p-4 rounded-xl border font-bold hover:bg-orange-50">
                SLA Matrix
            </a>

            <a href="{{ route('accounts.index') }}"
               class="p-4 rounded-xl border font-bold hover:bg-orange-50">
                View Users
            </a>
        </div>
    </div>

</x-app-layout>
