<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskPhoto;
use Illuminate\Http\Request;

class TaskPhotoController extends Controller
{
    public function store(
        Request $request,
        Task $task
    )
    {
        $data = $request->validate([
            'photo_type' => 'required',
            'photo' => 'required|image',
            'notes' => 'nullable',
        ]);

        $path = $request
            ->file('photo')
            ->store(
                'task-photos',
                'public'
            );

        TaskPhoto::create([
            'task_id' => $task->id,
            'photo_type' => $data['photo_type'],
            'photo_path' => $path,
            'notes' => $data['notes'] ?? null,
            'uploaded_by' => auth()->id(),
        ]);

        return back();
    }
}
