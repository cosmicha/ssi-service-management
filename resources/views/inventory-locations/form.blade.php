<div class="grid md:grid-cols-2 gap-5">

<div>
<label class="block mb-2 font-black">Location Name</label>
<input
name="name"
value="{{ old('name',$location->name ?? '') }}"
class="w-full rounded-xl border-slate-300">
</div>

<div>
<label class="block mb-2 font-black">Code</label>
<input
name="code"
value="{{ old('code',$location->code ?? '') }}"
class="w-full rounded-xl border-slate-300">
</div>

<div>
<label class="block mb-2 font-black">Type</label>

<select name="location_type"
class="w-full rounded-xl border-slate-300">

<option value="warehouse">Warehouse</option>
<option value="branch">Branch</option>
<option value="engineer">Engineer</option>
<option value="vehicle">Vehicle</option>

</select>

</div>

<div>
<label class="block mb-2 font-black">Status</label>

<select name="status"
class="w-full rounded-xl border-slate-300">

<option value="active">Active</option>
<option value="inactive">Inactive</option>

</select>

</div>

<div class="md:col-span-2">

<label class="block mb-2 font-black">
Address
</label>

<textarea
name="address"
rows="4"
class="w-full rounded-xl border-slate-300">{{ old('address',$location->address ?? '') }}</textarea>

</div>

</div>

<button
class="mt-6 px-5 py-3 bg-black text-white rounded-xl font-black">
Save
</button>
