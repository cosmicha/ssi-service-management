<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskDispatchController extends Controller
{
    public function action(Request $request, Task $task)
    {
        $data = $request->validate([
            'action' => ['required', 'in:dispatch,start_travel,arrive,start_work,pause_work,complete'],
        ]);

        $action = $data['action'];
        $payload = [];
        $log = null;

        if ($action === 'dispatch') {
            $payload = [
                'dispatch_status' => 'dispatched',
                'dispatched_at' => $task->dispatched_at ?? now(),
                'status' => 'assigned',
            ];
            $log = 'Task dispatched.';
        }

        if ($action === 'start_travel') {
            $payload = [
                'dispatch_status' => 'traveling',
                'travel_started_at' => $task->travel_started_at ?? now(),
                'status' => 'in_progress',
            ];
            $log = 'Engineer started travel.';
        }

        if ($action === 'arrive') {
            $payload = [
                'dispatch_status' => 'onsite',
                'arrived_at' => $task->arrived_at ?? now(),
            ];

            if ($task->travel_started_at && !$task->travel_minutes) {
                $payload['travel_minutes'] = $task->travel_started_at->diffInMinutes(now());
            }

            $log = 'Engineer arrived onsite.';
        }

        if ($action === 'start_work') {
            $payload = [
                'dispatch_status' => 'working',
                'work_started_at' => $task->work_started_at ?? now(),
                'actual_start_at' => $task->actual_start_at ?? now(),
                'status' => 'in_progress',
            ];
            $log = 'Engineer started work.';
        }

        if ($action === 'pause_work') {
            $payload = [
                'dispatch_status' => 'paused',
                'work_paused_at' => now(),
                'status' => 'pending',
            ];
            $log = 'Work paused / pending.';
        }

        if ($action === 'complete') {
            $workMinutes = $task->work_minutes ?? 0;

            if ($task->work_started_at) {
                $workMinutes += $task->work_started_at->diffInMinutes(now());
            }

            $payload = [
                'dispatch_status' => 'completed',
                'actual_finish_at' => now(),
                'completed_at' => now(),
                'work_minutes' => $workMinutes,
                'status' => 'completed',
            ];
            $log = 'Work completed.';
        }

        $task->update($payload);

        if ($log) {
            $task->workLogs()->create([
                'user_id' => auth()->id(),
                'log_type' => $action,
                'description' => $log,
                'logged_at' => now(),
            ]);

            $task->updates()->create([
                'user_id' => auth()->id(),
                'update_type' => $action === 'complete' ? 'resolution' : 'work_log',
                'message' => $log,
                'old_status' => $task->getOriginal('status'),
                'new_status' => $task->status,
            ]);
        }

        return back()->with('success', 'Dispatch action updated.');
    }
}
