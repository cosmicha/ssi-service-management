<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskUpdate;
use Illuminate\Http\Request;

class TaskUpdateController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $data = $request->validate([
            'update_type' => ['required', 'in:comment,status_change,assignment,work_log,resolution'],
            'status' => ['nullable', 'in:open,assigned,in_progress,pending,completed,cancelled'],
            'message' => ['nullable', 'string'],
            'attachments.*' => ['nullable', 'file', 'max:20480'],
        ]);

        $newStatus = $task->status;

        if ($data['update_type'] === 'resolution') {
            $newStatus = 'completed';
        } elseif ($data['update_type'] === 'status_change') {
            $newStatus = $data['status'] ?? $task->status;
        }

        $update = TaskUpdate::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'update_type' => $data['update_type'],
            'message' => $data['message'] ?? null,
            'old_status' => $task->status,
            'new_status' => $newStatus,
        ]);

        if ($task->incident) {
            $incident = $task->incident;

            $hasSla = $incident->response_due_at || $incident->resolution_due_at;

            if ($hasSla && !$incident->first_response_at) {
                $incident->first_response_at = now();

                if ($incident->response_due_at && now()->gt($incident->response_due_at)) {
                    $incident->sla_status = 'breached';
                }
            }

            if ($newStatus === 'completed') {
                if ($hasSla) {
                    if ($incident->resolution_due_at && now()->gt($incident->resolution_due_at)) {
                        $incident->sla_status = 'breached';
                    } else {
                        $incident->sla_status = 'met';
                    }
                } else {
                    $incident->sla_status = 'no_sla';
                }

                if (!$incident->resolved_at) {
                    $incident->resolved_at = now();
                }

                $incident->status = 'resolved';
            }

            $incident->save();
        }

        if ($newStatus !== $task->status) {
            $payload = ['status' => $newStatus];

            if ($newStatus === 'in_progress' && !$task->started_at) {
                $payload['started_at'] = now();
            }

            if ($newStatus === 'completed' && !$task->completed_at) {
                $payload['completed_at'] = now();
            }

            $task->update($payload);
        }

        foreach ($request->file('attachments', []) as $file) {
            $path = $file->store('task-updates', 'public');

            $update->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        return back()->with('success', 'Task update added.');
    }
}
