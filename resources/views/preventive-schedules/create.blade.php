<x-app-layout>

<h1 class="text-2xl font-black mb-6">
    Add Preventive Schedule
</h1>

<div class="bg-white rounded-2xl border p-6">

<form method="POST"
      action="{{ route('preventive-schedules.store') }}">

@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

<div>
<label class="block text-sm font-semibold mb-1">
Schedule Name
</label>

<input name="name"
       class="w-full rounded-xl border-slate-300"
       required>
</div>

<div>
<label class="block text-sm font-semibold mb-1">
Frequency
</label>

<select name="frequency"
        class="w-full rounded-xl border-slate-300">

<option value="daily">Daily</option>
<option value="weekly">Weekly</option>
<option value="monthly" selected>Monthly</option>
<option value="quarterly">Quarterly</option>
<option value="semester">Semester</option>
<option value="yearly">Yearly</option>

</select>
</div>

<div>
<label class="block text-sm font-semibold mb-1">
Contract
</label>

<select name="service_contract_id"
        class="w-full rounded-xl border-slate-300">

<option value="">Select Contract</option>

@foreach($contracts as $contract)
<option value="{{ $contract->id }}">
{{ $contract->name }}
</option>
@endforeach

</select>
</div>

<div>
<label class="block text-sm font-semibold mb-1">
Asset
</label>

<select name="asset_id"
        class="w-full rounded-xl border-slate-300">

<option value="">Select Asset</option>

@foreach($assets as $asset)
<option value="{{ $asset->id }}">
{{ $asset->name }}
</option>
@endforeach

</select>
</div>

<div>
<label class="block text-sm font-semibold mb-1">
Checklist Template
</label>

<select name="checklist_template_id"
        class="w-full rounded-xl border-slate-300">

<option value="">Select Template</option>

@foreach($templates as $template)
<option value="{{ $template->id }}">
{{ $template->name }}
</option>
@endforeach

</select>
</div>

<div>
<label class="block text-sm font-semibold mb-1">
Engineer
</label>

<select name="assigned_to"
        class="w-full rounded-xl border-slate-300">

<option value="">Select Engineer</option>

@foreach($users as $user)
<option value="{{ $user->id }}">
{{ $user->name }}
</option>
@endforeach

</select>
</div>

<div>
<label class="block text-sm font-semibold mb-1">
Next Run Date
</label>

<input type="date"
       name="next_run_date"
       class="w-full rounded-xl border-slate-300">
</div>

<div>
<label class="block text-sm font-semibold mb-1">
Status
</label>

<select name="status"
        class="w-full rounded-xl border-slate-300">
<option value="active">Active</option>
<option value="paused">Paused</option>
<option value="inactive">Inactive</option>
</select>
</div>

</div>

<div class="mt-6">
<button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">
Save Schedule
</button>
</div>

</form>

</div>

</x-app-layout>
