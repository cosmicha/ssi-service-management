<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskWorkLogController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $data = $request->validate([
            'description' => ['required', 'string'],
            'log_type' => ['nullable', 'string', 'max:100'],
        ]);

        $task->workLogs()->create([
            'user_id' => auth()->id(),
            'log_type' => $data['log_type'] ?? 'activity',
            'description' => $data['description'],
            'logged_at' => now(),
        ]);

        return back()->with('success', 'Work log added.');
    }
}
