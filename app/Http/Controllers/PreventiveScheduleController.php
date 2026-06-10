<?php

namespace App\Http\Controllers;

use App\Models\ChecklistTemplate;
use App\Models\PreventiveSchedule;
use App\Models\ServiceContract;
use App\Models\Asset;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PreventiveScheduleController extends Controller
{
    public function index()
    {
        $schedules = PreventiveSchedule::with([
            'contract',
            'asset',
            'template',
            'assignee'
        ])->latest()->paginate(20);

        return view('preventive-schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('preventive-schedules.create', [
            'contracts' => ServiceContract::orderBy('name')->get(),
            'assets' => Asset::orderBy('name')->get(),
            'templates' => ChecklistTemplate::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        PreventiveSchedule::create($request->validate([
            'service_contract_id' => ['nullable','exists:service_contracts,id'],
            'asset_id' => ['nullable','exists:assets,id'],
            'checklist_template_id' => ['nullable','exists:checklist_templates,id'],
            'assigned_to' => ['nullable','exists:users,id'],
            'name' => ['required'],
            'frequency' => ['required'],
            'start_date' => ['nullable','date'],
            'next_run_date' => ['nullable','date'],
            'due_days' => ['nullable','integer'],
            'notes' => ['nullable'],
            'status' => ['required'],
        ]));

        return redirect()->route('preventive-schedules.index')
            ->with('success','Schedule created.');
    }

    public function generateTask(PreventiveSchedule $preventiveSchedule)
    {
        $task = Task::create([
            'task_no' => \App\Support\NumberGenerator::generate('TSK'),
            'task_type' => 'preventive',
            'assigned_to' => $preventiveSchedule->assigned_to,
            'asset_id' => $preventiveSchedule->asset_id,
            'preventive_schedule_id' => $preventiveSchedule->id,
            'title' => $preventiveSchedule->name,
            'description' => 'Generated from Preventive Schedule',
            'priority' => 'medium',
            'status' => 'assigned',
            'planned_date' => now()->toDateString(),
            'created_by' => auth()->id(),
        ]);

        $preventiveSchedule->update([
            'last_run_date' => now()->toDateString(),
        ]);

        return redirect()->route('tasks.show', $task)
            ->with('success','PM Task generated.');
    }
}
