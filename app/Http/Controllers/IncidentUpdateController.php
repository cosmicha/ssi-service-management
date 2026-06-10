<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\IncidentUpdate;
use Illuminate\Http\Request;

class IncidentUpdateController extends Controller
{
    public function store(Request $request, Incident $incident)
    {
        $data = $request->validate([
            'update_type' => ['required', 'in:comment,status_change,assignment,resolution'],
            'message' => ['nullable', 'string'],
            'status' => ['nullable', 'in:open,assigned,in_progress,resolved,closed'],
            'attachments.*' => ['nullable', 'file', 'max:20480'],
        ]);

        $newStatus = $data['status'] ?? $incident->status;

        $update = IncidentUpdate::create([
            'incident_id' => $incident->id,
            'user_id' => auth()->id(),
            'update_type' => $data['update_type'],
            'message' => $data['message'] ?? null,
            'old_status' => $incident->status,
            'new_status' => $newStatus,
        ]);

        if ($newStatus !== $incident->status) {
            $incident->update([
                'status' => $newStatus,
            ]);
        }

        foreach ($request->file('attachments', []) as $file) {
            $path = $file->store('incident-updates', 'public');

            $update->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        return back()->with('success', 'Update added.');
    }
}
