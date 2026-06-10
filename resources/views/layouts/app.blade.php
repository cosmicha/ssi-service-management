<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#fbfaf8] text-[#111827]">
@php
    $setting = \App\Models\AppSetting::current();
    $setting->app_name = 'Service Management';

    $currentCustomer = null;

    if (Auth::check() && isset(Auth::user()->customer_id)) {
        $currentCustomer = \App\Models\Customer::find(Auth::user()->customer_id);
    }

    $isCustomerUser = Auth::check() && (Auth::user()->role ?? '') === 'customer';

    $displayCompany = $isCustomerUser && $currentCustomer
        ? $currentCustomer->name
        : $setting->company_name;

    $displayAppName = $isCustomerUser ? 'Service Portal' : 'Service Management';

    $displayLogo = $isCustomerUser && $currentCustomer && $currentCustomer->logo_path
        ? $currentCustomer->logo_path
        : $setting->logo_path;
@endphp

<div class="min-h-screen flex">
    @include('layouts.partials.sidebar')

    <div class="flex-1 min-w-0">
        <header class="h-[112px] bg-white border-b border-slate-200 px-10 flex items-center justify-between">
            <div class="flex items-center gap-4">
                @if($displayLogo)
                    <img src="{{ asset('storage/' . $displayLogo) }}" class="h-14 max-w-[180px] object-contain">
                @else
                    <div class="h-14 w-14 rounded-2xl bg-[#ff8a00] flex items-center justify-center font-black text-black text-xl">
                        SSI
                    </div>
                @endif

                <div>
                    <div class="text-sm font-medium text-slate-500 leading-tight">{{ $displayCompany }}</div>
                    <div class="text-2xl font-black text-slate-950 leading-tight">{{ $displayAppName }}</div>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-4 border-l border-slate-200 pl-8">
                <div class="h-11 w-11 rounded-xl bg-[#ff8a00] flex items-center justify-center text-black font-black">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <div class="text-xs text-slate-500">Welcome back,</div>
                    <div class="font-black text-slate-900">{{ Auth::user()->name ?? 'Service Management' }}</div>
                </div>
            </div>
        </header>

        <main class="p-8">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
