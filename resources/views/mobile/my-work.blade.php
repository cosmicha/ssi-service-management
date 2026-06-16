<x-app-layout>

<div class="max-w-3xl mx-auto">

    <div class="rounded-[2rem] bg-black text-white p-8 mb-6">

        <div class="text-[#ff8a00] font-black uppercase tracking-widest text-xs">
            Technician Workspace
        </div>

        <h1 class="text-3xl font-black mt-2">
            My Work
        </h1>

        <div class="text-white/60 mt-2">
            {{ $tasks->count() }} active tasks assigned
        </div>

    </div>

    <div class="space-y-4">

        @foreach($tasks as $task)

        <a href="{{ route('tasks.show',$task) }}"
           class="block bg-white border rounded-3xl p-5 shadow-sm hover:border-[#ff8a00]">

            <div class="flex justify-between">

                <div>
                    <div class="font-black">
                        {{ $task->task_no }}
                    </div>

                    <div class="text-lg font-bold mt-1">
                        {{ $task->title }}
                    </div>

                    <div class="text-sm text-slate-500 mt-2">
                        {{ $task->customer?->name }}
                    </div>

                    <div class="text-sm text-slate-500">
                        {{ $task->asset?->asset_code }}
                    </div>
                </div>

                <div>
                    <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-black">
                        {{ strtoupper($task->status) }}
                    </span>
                </div>

            </div>

        </a>

        @endforeach

    </div>

</div>

</x-app-layout>
