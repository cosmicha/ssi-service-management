<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    
<div style="position:fixed;bottom:20px;right:20px;display:flex;gap:10px;z-index:999;">
    <a href="/devices" style="background:#2563eb;color:white;padding:10px 14px;border-radius:12px;text-decoration:none;font-weight:700;box-shadow:0 8px 20px rgba(37,99,235,.25);">Devices</a>
    <a href="/vendors" style="background:#0f172a;color:white;padding:10px 14px;border-radius:12px;text-decoration:none;font-weight:700;box-shadow:0 8px 20px rgba(15,23,42,.25);">Vendors</a>
</div>


<div style="position:fixed;bottom:20px;right:20px;display:flex;flex-direction:column;gap:10px;z-index:9999;">
    <a href="/devices" style="background:#2563eb;color:white;padding:12px 16px;border-radius:12px;text-decoration:none;font-weight:700;box-shadow:0 8px 20px rgba(37,99,235,.3);">
        Devices
    </a>

    <a href="/vendors" style="background:#0f172a;color:white;padding:12px 16px;border-radius:12px;text-decoration:none;font-weight:700;box-shadow:0 8px 20px rgba(15,23,42,.3);">
        Vendors
    </a>

    <a href="/problem-logs" style="background:#16a34a;color:white;padding:12px 16px;border-radius:12px;text-decoration:none;font-weight:700;box-shadow:0 8px 20px rgba(22,163,74,.3);">
        Tickets
    </a>
</div>

</body>
</html>
