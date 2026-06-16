<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Incident;
use App\Models\PreventiveExecution;
use Illuminate\Http\Request;

class EngineerMobileController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $tasks = Task::with(['customer','branch','asset'])
            ->where(function ($q) use ($userId) {
                $q->where('assigned_to', $userId)
                  ->orWhere('engineer_id', $userId);
            })
            ->whereNotIn('status', ['completed','closed','cancelled'])
            ->latest()
            ->limit(20)
            ->get();

        $incidents = Incident::with(['customer','branch'])
            ->where(function ($q) use ($userId) {
                if (\Schema::hasColumn('incidents','assigned_to')) {
                    $q->orWhere('assigned_to', $userId);
                }
                if (\Schema::hasColumn('incidents','assigned_engineer_id')) {
                    $q->orWhere('assigned_engineer_id', $userId);
                }
            })
            ->whereIn('status', ['open','assigned','in_progress'])
            ->latest()
            ->limit(20)
            ->get();

        $pms = PreventiveExecution::with(['task.customer','task.branch','engineer','preventiveSchedule'])
            ->where(function ($q) use ($userId) {
                if (\Schema::hasColumn('preventive_executions','engineer_id')) {
                    $q->where('engineer_id', $userId);
                }
            })
            ->whereNotIn('status', ['done','completed','closed'])
            ->latest()
            ->limit(20)
            ->get();

        return view('mobile.engineer-dashboard', compact('tasks','incidents','pms'));
    }

    public function updateTask(Request $request, Task $task)
    {
        $data = $request->validate([
            'status' => ['nullable','string'],
            'note' => ['nullable','string'],
        ]);

        if (!empty($data['status'])) {
            $task->status = $data['status'];

            if ($data['status'] === 'in_progress' && \Schema::hasColumn('tasks','started_at') && !$task->started_at) {
                $task->started_at = now();
            }

            if (in_array($data['status'], ['completed','closed']) && \Schema::hasColumn('tasks','completed_at') && !$task->completed_at) {
                $task->completed_at = now();
            }

            $task->save();
        }

        if (!empty($data['note']) && method_exists($task, 'updates')) {
            $task->updates()->create([
                'user_id' => auth()->id(),
                'note' => $data['note'],
                'status' => $task->status,
            ]);
        }

        return back()->with('success', 'Task updated.');
    }
}
