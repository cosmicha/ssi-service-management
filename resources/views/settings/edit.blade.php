<x-app-layout>
<div class="mb-6">
    <h1 class="text-2xl font-black">Application Branding</h1>
    <p class="text-slate-500">Set SSI logo and company identity for admin and engineer users.</p>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-2xl border p-6 max-w-2xl">
<form method="POST" enctype="multipart/form-data" action="{{ route('settings.update') }}">
@csrf
@method('PUT')

<div class="space-y-4">
    <div>
        <label class="block text-sm font-semibold mb-1">Company Name</label>
        <input name="company_name" value="{{ $setting->company_name }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Application Name</label>
        <input name="app_name" value="{{ $setting->app_name }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">SSI Logo</label>
        <input type="file" name="logo" class="w-full rounded-xl border border-slate-300 p-2">

        @if($setting->logo_path)
            <img src="{{ asset('storage/' . $setting->logo_path) }}" class="mt-4 h-16 object-contain">
        @endif
    </div>
</div>

<button class="mt-6 px-5 py-2.5 bg-black text-white rounded-xl font-semibold">Save Branding</button>
</form>
</div>
</x-app-layout>
