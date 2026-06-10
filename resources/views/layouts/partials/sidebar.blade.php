@php
    $setting = \App\Models\AppSetting::current();
    $role = Auth::user()->role ?? 'admin';
    $isCustomer = $role === 'customer';
    $customer = Auth::user()->customer ?? null;
@endphp

<aside class="w-[280px] shrink-0 bg-black text-white h-screen min-h-screen flex flex-col overflow-hidden">
    <div class="px-6 py-7 border-b border-white/10">
        <div class="flex items-center gap-3">
            @if($isCustomer && $customer?->logo_path)
                <img src="{{ asset('storage/' . $customer->logo_path) }}" class="h-12 w-12 object-contain">
            @elseif($setting->logo_path)
                <img src="{{ asset('storage/' . $setting->logo_path) }}" class="h-12 w-12 object-contain">
            @else
                <div class="h-12 w-12 rounded-2xl bg-[#ff8a00] text-black flex items-center justify-center font-black">
                    {{ $isCustomer ? strtoupper(substr($customer->name ?? 'C',0,2)) : 'SSI' }}
                </div>
            @endif

            <div>
                <div class="text-xs font-medium text-white/70">
                    {{ $isCustomer ? ($customer->name ?? 'Customer Portal') : 'PT Sinergi Solusi Informatika' }}
                </div>
                <div class="text-lg font-black leading-tight">
                    {{ $isCustomer ? 'Service Portal' : 'Service Management' }}
                </div>
            </div>
        </div>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto bg-black">
        @if($isCustomer)
            <a href="/customer-portal" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('customer-portal') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                <span class="text-lg">▦</span> My Dashboard
            </a>

            <a href="/customer-portal/incidents" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('customer-portal/incidents*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                <span class="text-lg">⚠</span> My Tickets
            </a>

            <a href="/customer-portal/assets" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('customer-portal/assets*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                <span class="text-lg">◉</span> My Assets
            </a>

            <a href="/customer-portal/changes" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('customer-portal/changes*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                <span class="text-lg">⇄</span> My Changes
            </a>

            <a href="/customer-portal/pm" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('customer-portal/pm*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                <span class="text-lg">▣</span> My PM
            </a>

            <a href="/customer-portal/reports" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('customer-portal/reports*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                <span class="text-lg">▥</span> Reports
            </a>

            @if(Auth::user()->role === 'customer_admin')
                <a href="/customer-portal/accounts" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('customer-portal/accounts*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                    <span class="text-lg">👥</span> Manage Accounts
                </a>
            @endif
        @else
            <a href="/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('dashboard') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                <span class="text-lg">▦</span> Dashboard
            </a>

            <a href="/tasks" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('tasks*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                <span class="text-lg">☑</span> Tasks
            </a>

            <a href="/incidents" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('incidents*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                <span class="text-lg">⚠</span> Incidents
            </a>

            <a href="/change-requests" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('change-requests*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                <span class="text-lg">⇄</span> Change Requests
            </a>

            <a href="/preventive-schedules" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('preventive-schedules*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                <span class="text-lg">▣</span> Preventive Maintenance
            </a>

            <a href="/assets" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('assets*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                <span class="text-lg">◉</span> Assets
            </a>

            @if($role === 'admin')
                <a href="/customers" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('customers*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                    <span class="text-lg">♙</span> Customers
                </a>

                <a href="/accounts" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('accounts*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                    <span class="text-lg">👤</span> Accounts
                </a>

                <a href="/service-contracts" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('service-contracts*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                    <span class="text-lg">◎</span> SLA Management
                </a>

                <a href="/checklist-templates" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('checklist-templates*') ? 'bg-[#ff8a00] text-white' : 'hover:bg-[#ff8a00] hover:text-black' }}">
                    <span class="text-lg">▤</span> Checklist Templates
                </a>
            @endif
        @endif
    </nav>

    <div class="shrink-0 px-4 py-5 border-t border-white/10 space-y-2 bg-black">
        @if($role === 'admin')
            <a href="/settings/branding" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-white hover:bg-[#ff8a00] hover:text-black">
                <span class="text-lg">⚙</span> Branding
            </a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-white hover:bg-[#ff8a00] hover:text-black">
                <span class="text-lg">↪</span> Logout
            </button>
        </form>
    </div>
</aside>
