<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskAssignmentController extends Controller
{
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'assigned_to' => ['nullable', 'exists:users,id'],
            'assigned_vendor' => ['nullable', 'string', 'max:255'],
            'team_name' => ['nullable', 'string', 'max:255'],
            'planned_start_at' => ['nullable', 'date'],
            'planned_finish_at' => ['nullable', 'date'],
        ]);

        $oldAssignee = $task->assignee->name ?? 'Unassigned';

        $task->update([
            'assigned_to' => $data['assigned_to'] ?? null,
            'assigned_vendor' => $data['assigned_vendor'] ?? null,
            'team_name' => $data['team_name'] ?? null,
            'planned_start_at' => $data['planned_start_at'] ?? null,
            'planned_finish_at' => $data['planned_finish_at'] ?? null,
            'dispatch_status' => $data['assigned_to'] ? 'assigned' : ($task->dispatch_status ?? 'not_dispatched'),
            'status' => $data['assigned_to'] ? 'assigned' : $task->status,
            'dispatched_at' => $data['assigned_to'] ? ($task->dispatched_at ?? now()) : $task->dispatched_at,
        ]);

        $task->refresh();

        $newAssignee = $task->assignee->name ?? 'Unassigned';

        $task->workLogs()->create([
            'user_id' => auth()->id(),
            'log_type' => 'assignment',
            'description' => "Assignment updated: {$oldAssignee} → {$newAssignee}",
            'logged_at' => now(),
        ]);

        $task->updates()->create([
            'user_id' => auth()->id(),
            'update_type' => 'assignment',
            'message' => "Assignment updated: {$oldAssignee} → {$newAssignee}",
            'old_status' => $task->getOriginal('status'),
            'new_status' => $task->status,
        ]);

        return back()->with('success', 'Assignment updated.');
    }
}
