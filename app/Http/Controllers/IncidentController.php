<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Customer;
use App\Models\CustomerBranch;
use App\Models\CustomerRegion;
use App\Models\Incident;
use App\Models\IncidentCategory;
use App\Models\IncidentAttachment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IncidentController extends Controller
{
    public function index()
    {
        $incidents = Incident::with(['customer','branch','asset','category','task'])
            ->latest()
            ->paginate(15);

        return view('incidents.index', compact('incidents'));
    }

    public function create()
    {
        return view('incidents.create', [
            'customers' => Customer::orderBy('name')->get(),
            'regions' => CustomerRegion::with('customer')->orderBy('name')->get(),
            'branches' => CustomerBranch::with('customer')->orderBy('name')->get(),
            'assets' => Asset::with(['customer','branch'])->orderBy('name')->get(),
            'categories' => IncidentCategory::where('status','active')->orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['nullable','exists:customers,id'],
            'customer_region_id' => ['nullable','exists:customer_regions,id'],
            'customer_branch_id' => ['nullable','exists:customer_branches,id'],
            'asset_id' => ['nullable','exists:assets,id'],
            'incident_category_id' => ['nullable','exists:incident_categories,id'],
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'severity' => ['required','in:low,medium,high,critical'],
            'reported_by' => ['nullable','string','max:255'],
            'reported_at' => ['nullable','date'],
            'status' => ['required','in:open,assigned,in_progress,resolved,closed'],
            'assigned_to' => ['nullable','exists:users,id'],
            'has_sla' => ['nullable'],
            'response_minutes' => ['nullable','integer','min:1'],
            'resolution_minutes' => ['nullable','integer','min:1'],
            'attachments.*' => ['nullable','file','max:20480'],
        ]);

        $reportedAt = isset($data['reported_at']) && $data['reported_at']
            ? \Carbon\Carbon::parse($data['reported_at'])
            : now();

        $customer = !empty($data['customer_id'])
            ? \App\Models\Customer::find($data['customer_id'])
            : null;

        $slaRule = null;

        if ($customer) {
            $slaRule = \App\Models\CustomerSla::where('customer_id', $customer->id)
                ->where('severity', $data['severity'] ?? 'medium')
                ->where('is_active', true)
                ->first();
        }

        $hasSla = (bool) $slaRule;

        $responseMinutes = $slaRule?->response_minutes;
        $resolutionMinutes = $slaRule?->resolution_minutes;

        $incident = Incident::create([
            ...collect($data)->except([
                'assigned_to',
                'has_sla',
                'response_minutes',
                'resolution_minutes',
                'attachments',
            ])->toArray(),
            'incident_no' => \App\Support\NumberGenerator::generate('TKT'),
            'reported_at' => $reportedAt,
            'response_due_at' => $hasSla ? $reportedAt->copy()->addMinutes($responseMinutes) : null,
            'resolution_due_at' => $hasSla ? $reportedAt->copy()->addMinutes($resolutionMinutes) : null,
            'sla_status' => $hasSla ? 'on_track' : 'no_sla',
        ]);

        foreach ($request->file('attachments', []) as $file) {
            $path = $file->store('incident-attachments', 'public');

            $incident->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'uploaded_by' => auth()->id(),
            ]);
        }

        $task = Task::create([
            'task_no' => 'COR-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)),
            'task_type' => 'corrective',
            'customer_id' => $incident->customer_id,
            'customer_region_id' => $incident->customer_region_id,
            'customer_branch_id' => $incident->customer_branch_id,
            'asset_id' => $incident->asset_id,
            'incident_id' => $incident->id,
            'assigned_to' => $data['assigned_to'] ?? null,
            'created_by' => auth()->id(),
            'title' => $incident->title,
            'description' => $incident->description,
            'priority' => $incident->severity === 'critical' ? 'critical' : ($incident->severity === 'high' ? 'high' : 'medium'),
            'status' => isset($data['assigned_to']) && $data['assigned_to'] ? 'assigned' : 'open',
            'planned_date' => now()->toDateString(),
        ]);

        $incident->update(['task_id' => $task->id]);

        return redirect()->route('incidents.show', $incident)
            ->with('success', 'Incident created and corrective task generated.');
    }

    public function show(Incident $incident)
    {
        $incident->load(['customer','branch','asset','category','task.assignee','task.updates.user','task.updates.attachments','attachments.uploader']);

        return view('incidents.show', compact('incident'));
    }

    public function edit(Incident $incident)
    {
        return view('incidents.edit', [
            'incident' => $incident,
            'customers' => Customer::orderBy('name')->get(),
            'regions' => CustomerRegion::with('customer')->orderBy('name')->get(),
            'branches' => CustomerBranch::with('customer')->orderBy('name')->get(),
            'assets' => Asset::with(['customer','branch'])->orderBy('name')->get(),
            'categories' => IncidentCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Incident $incident)
    {
        $data = $request->validate([
            'customer_id' => ['nullable','exists:customers,id'],
            'customer_region_id' => ['nullable','exists:customer_regions,id'],
            'customer_branch_id' => ['nullable','exists:customer_branches,id'],
            'asset_id' => ['nullable','exists:assets,id'],
            'incident_category_id' => ['nullable','exists:incident_categories,id'],
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'severity' => ['required','in:low,medium,high,critical'],
            'reported_by' => ['nullable','string','max:255'],
            'reported_at' => ['nullable','date'],
            'status' => ['required','in:open,assigned,in_progress,resolved,closed'],
            'attachments.*' => ['nullable','file','max:20480'],
        ]);

        if ($data['status'] === 'resolved' && !$incident->resolved_at) {
            $data['resolved_at'] = now();
        }

        if ($data['status'] === 'closed' && !$incident->closed_at) {
            $data['closed_at'] = now();
        }

        $incident->update(collect($data)->except('attachments')->toArray());

        foreach ($request->file('attachments', []) as $file) {
            $path = $file->store('incident-attachments', 'public');

            $incident->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'uploaded_by' => auth()->id(),
            ]);
        }

        return redirect()->route('incidents.show', $incident)
            ->with('success', 'Incident updated.');
    }

    public function destroyAttachment(IncidentAttachment $attachment)
    {
        $attachment->delete();

        return back()->with('success', 'Attachment removed.');
    }

    public function destroy(Incident $incident)
    {
        $incident->delete();

        return redirect()->route('incidents.index')->with('success', 'Incident deleted.');
    }
}
