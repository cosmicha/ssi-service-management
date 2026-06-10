<x-app-layout>

<div class="mb-6">
    <h1 class="text-2xl font-black">
        Preventive Execution
    </h1>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">
    {{ session('success') }}
</div>
@endif

<form method="POST"
      enctype="multipart/form-data"
      action="{{ route('preventive-executions.save',$preventiveExecution) }}">

@csrf

<div class="bg-white rounded-2xl border overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-slate-50">
<tr>
<th class="text-left px-5 py-3">Checklist</th>
<th class="text-left px-5 py-3">Result</th>
<th class="text-left px-5 py-3">Remarks</th>
<th class="text-left px-5 py-3">Photo Evidence</th>
</tr>
</thead>

<tbody class="divide-y">

@foreach($preventiveExecution->items as $item)

<tr>

<td class="px-5 py-4">
{{ $item->checklistItem->item_name ?? '' }}
</td>

<td class="px-5 py-4">

<select
name="items[{{ $item->id }}][result]"
class="rounded-lg border-slate-300">

<option value="">-</option>
<option value="pass">PASS</option>
<option value="warning">WARNING</option>
<option value="fail">FAIL</option>

</select>

</td>

<td class="px-5 py-4">

<input
name="items[{{ $item->id }}][remarks]"
value="{{ $item->remarks }}"
class="w-full rounded-lg border-slate-300">

</td>

<td class="px-5 py-4">
<input type="file"
       name="items[{{ $item->id }}][photo]"
       class="w-full text-sm">

@if($item->photo_path)
    <div class="flex gap-3 items-center mt-2">
        <a href="{{ asset('storage/' . $item->photo_path) }}"
           target="_blank"
           class="text-blue-600 text-xs font-semibold">
           View Evidence
        </a>

        <form method="POST" action="{{ route('preventive-executions.evidence.destroy', $item) }}">
            @csrf
            @method('DELETE')
            <button class="text-red-600 text-xs font-semibold">Remove</button>
        </form>
    </div>
@endif
</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="mt-4">

<button
class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">

Save Checklist

</button>

</div>

</form>

<hr class="my-8">

<form method="POST"
action="{{ route('preventive-executions.complete',$preventiveExecution) }}">

@csrf

<div class="bg-white rounded-2xl border p-6">

<h2 class="font-black mb-4">
Complete PM
</h2>

<select
name="overall_result"
class="w-full rounded-xl border-slate-300 mb-4">

<option value="pass">PASS</option>
<option value="warning">WARNING</option>
<option value="fail">FAIL</option>

</select>

<textarea
name="summary"
rows="4"
class="w-full rounded-xl border-slate-300"
placeholder="PM Summary"></textarea>

<button
class="mt-4 px-5 py-2.5 bg-green-600 text-white rounded-xl font-semibold">

Complete PM

</button>

</div>

</form>

@include('tasks._activity-panel', ['task' => $preventiveExecution->task])
</x-app-layout>
