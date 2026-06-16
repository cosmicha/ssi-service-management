<?php

namespace App\Http\Controllers;

use App\Models\PreventiveExecution;
use App\Models\PreventiveExecutionItem;
use App\Models\Task;

class PreventiveExecutionController extends Controller
{
    public function start(Task $task)
    {
        $execution = PreventiveExecution::firstOrCreate(
            [
                'task_id' => $task->id,
            ],
            [
                'preventive_schedule_id' => $task->preventive_schedule_id,
                'engineer_id' => auth()->id(),
                'started_at' => now(),
            ]
        );

        if (
            $task->preventiveSchedule &&
            $task->preventiveSchedule->template
        ) {

            foreach (
                $task->preventiveSchedule
                    ->template
                    ->items as $item
            ) {

                PreventiveExecutionItem::firstOrCreate(
                    [
                        'preventive_execution_id' => $execution->id,
                        'checklist_template_item_id' => $item->id,
                    ]
                );
            }
        }

        return redirect()->route(
            'preventive-executions.show',
            $execution
        );
    }

    public function show(
        PreventiveExecution $preventiveExecution
    ) {

        $preventiveExecution->load([
            'task.updates.user',
            'task.updates.attachments',
            'items.checklistItem'
        ]);

        return view(
            'preventive-executions.show',
            compact('preventiveExecution')
        );
    }

    public function save(\Illuminate\Http\Request $request, PreventiveExecution $preventiveExecution)
    {
        foreach ($request->items ?? [] as $itemId => $data) {

            $item = PreventiveExecutionItem::find($itemId);

            if (!$item) {
                continue;
            }

            $payload = [
                'result' => $data['result'] ?? null,
                'remarks' => $data['remarks'] ?? null,
                'value_text' => $data['value_text'] ?? null,
            ];

            if ($request->hasFile("items.$itemId.photo")) {
                $payload['photo_path'] = $request
                    ->file("items.$itemId.photo")
                    ->store('preventive-evidence', 'public');
            }

            $item->update($payload);
        }

        return back()->with(
            'success',
            'Checklist saved.'
        );
    }

    public function complete(
        \Illuminate\Http\Request $request,
        PreventiveExecution $preventiveExecution
    )
    {
        $preventiveExecution->update([
            'overall_result' => $request->overall_result,
            'summary' => $request->summary,
            'completed_at' => now(),
        ]);

        if ($preventiveExecution->task) {

            $preventiveExecution->task->update([
                'status' => 'done',
            ]);
        }

        return redirect()
            ->route(
                'preventive-executions.show',
                $preventiveExecution
            )
            ->with(
                'success',
                'Preventive Maintenance completed.'
            );
    }
    public function removeEvidence(PreventiveExecutionItem $item)
    {
        $item->update([
            'photo_path' => null,
        ]);

        return back()->with('success', 'Evidence removed.');
    }
}
