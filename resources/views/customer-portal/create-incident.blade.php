<x-app-layout>
<h1 class="text-2xl font-black mb-6">Create Ticket</h1>
<div class="bg-white rounded-2xl border p-6">
<form method="POST" enctype="multipart/form-data" action="{{ route('customer.portal.incidents.store') }}">
@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<div><label class="block font-semibold mb-1">Asset</label><select name="asset_id" class="w-full rounded-xl border-slate-300"><option value="">No Asset</option>@foreach($assets as $asset)<option value="{{ $asset->id }}">{{ $asset->name }}</option>@endforeach</select></div>
<div><label class="block font-semibold mb-1">Severity</label><select name="severity" class="w-full rounded-xl border-slate-300"><option value="low">Low</option><option value="medium" selected>Medium</option><option value="high">High</option><option value="critical">Critical</option></select></div>
<div class="md:col-span-2"><label class="block font-semibold mb-1">Title</label><input name="title" class="w-full rounded-xl border-slate-300" required></div>
<div class="md:col-span-2"><label class="block font-semibold mb-1">Description</label><textarea name="description" rows="5" class="w-full rounded-xl border-slate-300"></textarea></div>
<div class="md:col-span-2"><label class="block font-semibold mb-1">Attachments</label><input type="file" name="attachments[]" multiple class="w-full rounded-xl border border-slate-300 p-2"></div>
</div>
<button class="mt-6 px-5 py-2.5 bg-black text-white rounded-xl font-semibold">Submit Ticket</button>
</form>
</div>
</x-app-layout>