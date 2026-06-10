@php
    $setting = \App\Models\AppSetting::current();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - {{ $setting->app_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#f7f4ef] flex items-center justify-center p-8">

<div class="w-full max-w-6xl bg-white rounded-[2rem] overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-2">

    <div class="relative bg-white p-12 flex flex-col justify-center min-h-[560px] border-r border-slate-100 overflow-hidden">
        <div class="relative z-10 flex items-center gap-6">
            @if($setting->logo_path)
                <div class="h-28 w-28 rounded-2xl bg-white shadow-xl border border-slate-100 flex items-center justify-center p-4">
                    <img src="{{ asset('storage/' . $setting->logo_path) }}" class="max-h-full max-w-full object-contain">
                </div>
            @else
                <div class="h-28 w-28 rounded-2xl bg-[#ff8a00] shadow-xl flex items-center justify-center text-black font-black text-3xl">
                    SSI
                </div>
            @endif

            <div>
                <h1 class="text-2xl font-black text-slate-950">
                    {{ $setting->company_name }}
                </h1>
                <p class="mt-2 text-[#ff7a00] text-2xl font-black italic">
                    {{ $setting->app_name }}
                </p>
            </div>
        </div>

        <div class="relative z-10 mt-10">
            <h2 class="text-3xl font-black text-slate-950 mb-4">
                Create your account
            </h2>

            <p class="text-lg leading-relaxed text-slate-600 max-w-xl">
                Register to submit incidents, track ticket progress, and access your company dashboard after approval.
            </p>

            <div class="mt-8 rounded-2xl border border-orange-100 bg-orange-50/40 p-6 flex gap-5 items-center max-w-xl">
                <div class="h-16 w-16 rounded-2xl bg-[#ff8a00] flex items-center justify-center text-white text-3xl font-black shrink-0">
                    ✓
                </div>
                <div>
                    <div class="font-black text-slate-950 text-lg">Admin approval required</div>
                    <p class="text-slate-600 mt-1">
                        New accounts require admin approval before they can access the full portal.
                    </p>
                </div>
            </div>
        </div>

        <div class="absolute -bottom-28 -left-16 w-[420px] h-[180px] bg-[#ff8a00] rounded-tr-[10rem]"></div>
    </div>

    <div class="p-10 lg:p-12 flex flex-col justify-center bg-white">
        <h2 class="text-4xl font-black text-slate-950 mb-3">Create account</h2>
        <p class="text-slate-500 text-lg mb-10">
            Register your access for the {{ $setting->app_name }} portal.
        </p>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-black text-slate-950 mb-2">Full Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Enter your full name"
                    class="w-full rounded-2xl border-slate-300 text-lg px-6 py-4 focus:border-[#ff8a00] focus:ring-[#ff8a00]"
                >
                @error('name')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-black text-slate-950 mb-2">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    placeholder="Enter your email address"
                    class="w-full rounded-2xl border-slate-300 text-lg px-6 py-4 focus:border-[#ff8a00] focus:ring-[#ff8a00]"
                >
                @error('email')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-black text-slate-950 mb-2">Password</label>
                <input
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Create a password"
                    class="w-full rounded-2xl border-slate-300 text-lg px-6 py-4 focus:border-[#ff8a00] focus:ring-[#ff8a00]"
                >
                @error('password')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-black text-slate-950 mb-2">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm your password"
                    class="w-full rounded-2xl border-slate-300 text-lg px-6 py-4 focus:border-[#ff8a00] focus:ring-[#ff8a00]"
                >
                @error('password_confirmation')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full rounded-2xl bg-[#ff7a00] hover:bg-[#ff8a00] text-white text-lg font-black py-5 shadow-xl shadow-orange-200 transition">
                Create Account
            </button>

            <div class="text-center text-slate-500">
                Already have an account?
                <a href="{{ route('login') }}" class="font-black text-[#ff7a00] hover:underline">
                    Login here
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
