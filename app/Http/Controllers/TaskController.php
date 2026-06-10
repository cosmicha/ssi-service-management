<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Customer;
use App\Models\CustomerBranch;
use App\Models\CustomerRegion;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $type = $request->query('type');

        $tasks = Task::with(['customer', 'branch', 'asset', 'assignee'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($type, fn ($q) => $q->where('task_type', $type))
            ->latest()
            ->paginate(15);

        return view('tasks.index', compact('tasks', 'status', 'type'));
    }

    public function create()
    {
        return view('tasks.create', [
            'customers' => Customer::orderBy('name')->get(),
            'regions' => CustomerRegion::with('customer')->orderBy('name')->get(),
            'branches' => CustomerBranch::with('customer')->orderBy('name')->get(),
            'assets' => Asset::with(['customer', 'branch'])->orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'task_type' => ['required', 'in:preventive,corrective,change,general,site_survey,implementation'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'customer_region_id' => ['nullable', 'exists:customer_regions,id'],
            'customer_branch_id' => ['nullable', 'exists:customer_branches,id'],
            'asset_id' => ['nullable', 'exists:assets,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high,critical'],
            'status' => ['required', 'in:open,assigned,in_progress,pending,completed,cancelled'],
            'planned_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
        ]);

        $data['task_no'] = \App\Support\NumberGenerator::generate('TSK');
        $data['created_by'] = auth()->id();

        $task = Task::create($data);

        return redirect()->route('tasks.show', $task)->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        if ((auth()->user()->role ?? null) === 'engineer') {
            abort_unless($task->assigned_to === auth()->id(), 403);
        }
        $task->load(['customer', 'region', 'branch', 'asset.category', 'assignee', 'creator', 'updates.user', 'updates.attachments', 'workLogs.user']);

        return view('tasks.show', ['task' => $task, 'engineers' => \App\Models\User::whereIn('role', ['engineer','admin'])->orderBy('name')->get()]);
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', [
            'task' => $task,
            'customers' => Customer::orderBy('name')->get(),
            'regions' => CustomerRegion::with('customer')->orderBy('name')->get(),
            'branches' => CustomerBranch::with('customer')->orderBy('name')->get(),
            'assets' => Asset::with(['customer', 'branch'])->orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'task_type' => ['required', 'in:preventive,corrective,change,general,site_survey,implementation'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'customer_region_id' => ['nullable', 'exists:customer_regions,id'],
            'customer_branch_id' => ['nullable', 'exists:customer_branches,id'],
            'asset_id' => ['nullable', 'exists:assets,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high,critical'],
            'status' => ['required', 'in:open,assigned,in_progress,pending,completed,cancelled'],
            'planned_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
        ]);

        if ($data['status'] === 'in_progress' && !$task->started_at) {
            $data['started_at'] = now();
        }

        if ($data['status'] === 'completed' && !$task->completed_at) {
            $data['completed_at'] = now();
        }

        $task->update($data);

        return redirect()->route('tasks.show', $task)->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $data = $request->validate([
            'status' => ['required', 'in:open,assigned,in_progress,pending,completed,cancelled'],
        ]);

        if ($data['status'] === 'in_progress' && !$task->started_at) {
            $data['started_at'] = now();
        }

        if ($data['status'] === 'completed' && !$task->completed_at) {
            $data['completed_at'] = now();
        }

        $task->update($data);

        return back()->with('success', 'Task status updated.');
    }
}
