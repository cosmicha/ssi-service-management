<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900">Add Checklist Template</h1>
        <p class="text-slate-500 mt-1">Create a preventive maintenance checklist template for an asset category.</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <form method="POST" action="{{ route('checklist-templates.store') }}">
            @csrf
            @include('checklist-templates.form', ['template' => null])
        </form>
    </div>
</x-app-layout>
