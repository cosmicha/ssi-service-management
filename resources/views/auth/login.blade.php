@php
    $setting = \App\Models\AppSetting::current();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting->app_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#f7f4ef] flex items-center justify-center p-8">

<div class="w-full max-w-6xl bg-white rounded-[2rem] overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-2">

    <div class="relative bg-white p-12 flex flex-col justify-center min-h-[620px]">
        <div>
            @if($setting->logo_path)
                <img src="{{ asset('storage/' . $setting->logo_path) }}" class="h-28 object-contain mb-8">
            @else
                <div class="h-24 w-24 rounded-3xl bg-[#ff8a00] flex items-center justify-center text-black font-black text-3xl mb-8">
                    SSI
                </div>
            @endif

            <h1 class="text-3xl font-black text-black">
                {{ $setting->company_name }}
            </h1>

            <p class="mt-2 text-[#ff8a00] text-xl italic">
                {{ $setting->app_name }}
            </p>
        </div>

        <div class="absolute bottom-0 right-0 w-[360px] h-[220px] bg-[#ff8a00] rounded-tl-[8rem]"></div>
    </div>

    <div class="p-12 lg:p-16 flex flex-col justify-center">
        <h2 class="text-4xl font-black text-slate-950 mb-2">Login</h2>
        <p class="text-slate-500 mb-8">Sign in to continue.</p>

        @if(session('status'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-xl border-slate-300 px-4 py-3">
                @error('email')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full rounded-xl border-slate-300 px-4 py-3">
                @error('password')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300">
                    Remember me
                </label>

                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-bold text-[#ff8a00]">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button class="w-full py-3 rounded-xl bg-[#ff8a00] text-white font-black">
                Login
            </button>
        </form>

        @if(Route::has('register'))
            <div class="mt-6">
                <a href="{{ route('register') }}"
                   class="block w-full text-center py-3 rounded-xl border border-slate-300 font-black text-slate-800 hover:bg-orange-50">
                    Register
                </a>
            </div>
        @endif
    </div>

</div>

</body>
</html>
