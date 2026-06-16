<?php

namespace App\Http\Controllers;

use App\Models\Task;

class WorkOrderPdfController extends Controller
{
    public function show(Task $task)
    {
        $task->load(['customer','branch','asset','assignee','updates']);
        return view('tasks.work-order-pdf', compact('task'));
    }
}
