<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Incident;
use App\Models\ChangeRequest;
use App\Models\PreventiveSchedule;
use App\Models\Task;
use App\Support\NumberGenerator;
use Illuminate\Http\Request;

class CustomerPortalController extends Controller
{
    private function user()
    {
        abort_unless(auth()->check(), 403);

        return auth()->user();
    }

    private function applyBranchAccess($query)
    {
        $user = $this->user();

        if (($user->customer_access_scope ?? 'ho') === 'branch') {
            $query->where('customer_branch_id', $user->customer_branch_id);
        }

        return $query;
    }

    private function customerAssets()
    {
        $user = $this->user();

        return Asset::where('customer_id', $user->customer_id)
            ->when(($user->customer_access_scope ?? 'ho') === 'branch', function ($q) use ($user) {
                $q->where('customer_branch_id', $user->customer_branch_id);
            });
    }

    public function dashboard()
    {
        $user = $this->user();

        if (!$user->customer_id) {
            return view('customer-portal.no-customer');
        }

        $assetQuery = $this->customerAssets();

        $incidentQuery = Incident::where('customer_id', $user->customer_id);
        $changeQuery = ChangeRequest::where('customer_id', $user->customer_id);

        $this->applyBranchAccess($incidentQuery);
        $this->applyBranchAccess($changeQuery);

        return view('customer-portal.dashboard', [
            'assetCount' => (clone $assetQuery)->count(),
            'openIncidents' => (clone $incidentQuery)->whereNotIn('status', ['resolved','closed'])->count(),
            'pendingChanges' => (clone $changeQuery)->whereIn('status', ['draft','submitted','approved','scheduled','in_progress'])->count(),
            'pmSchedules' => PreventiveSchedule::whereIn('asset_id', (clone $assetQuery)->pluck('id'))->count(),
            'recentIncidents' => (clone $incidentQuery)->with(['asset','task'])->latest()->limit(8)->get(),
        ]);
    }

    public function createIncident()
    {
        $assets = $this->customerAssets()->orderBy('name')->get();

        return view('customer-portal.create-incident', compact('assets'));
    }

    public function storeIncident(Request $request)
    {
        $user = $this->user();

        $data = $request->validate([
            'asset_id' => ['nullable','exists:assets,id'],
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'severity' => ['required','in:low,medium,high,critical'],
            'attachments.*' => ['nullable','file','max:20480'],
        ]);

        $asset = !empty($data['asset_id']) ? Asset::find($data['asset_id']) : null;

        if ($asset) {
            abort_unless($asset->customer_id == $user->customer_id, 403);

            if (($user->customer_access_scope ?? 'ho') === 'branch') {
                abort_unless($asset->customer_branch_id == $user->customer_branch_id, 403);
            }
        }

        $incident = Incident::create([
            'incident_no' => NumberGenerator::generate('TKT'),
            'customer_id' => $user->customer_id,
            'customer_branch_id' => $asset?->customer_branch_id ?? $user->customer_branch_id,
            'customer_region_id' => $asset?->customer_region_id,
            'asset_id' => $asset?->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'severity' => $data['severity'],
            'status' => 'open',
            'reported_by' => $user->name,
            'reported_at' => now(),
            'sla_status' => 'no_sla',
        ]);

        $task = Task::create([
            'task_no' => NumberGenerator::generate('TSK'),
            'task_type' => 'corrective',
            'customer_id' => $incident->customer_id,
            'customer_branch_id' => $incident->customer_branch_id,
            'customer_region_id' => $incident->customer_region_id,
            'asset_id' => $incident->asset_id,
            'incident_id' => $incident->id,
            'title' => $incident->title,
            'description' => $incident->description,
            'priority' => $incident->severity === 'critical' ? 'critical' : 'medium',
            'status' => 'open',
            'created_by' => $user->id,
        ]);

        $incident->update(['task_id' => $task->id]);

        foreach ($request->file('attachments', []) as $file) {
            $path = $file->store('incident-attachments', 'public');

            $incident->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'uploaded_by' => $user->id,
            ]);
        }

        return redirect()->route('customer.portal.incidents')->with('success', 'Ticket created.');
    }

    public function createChange()
    {
        $assets = $this->customerAssets()->orderBy('name')->get();

        return view('customer-portal.create-change', compact('assets'));
    }

    public function storeChange(Request $request)
    {
        $user = $this->user();

        $data = $request->validate([
            'asset_id' => ['nullable','exists:assets,id'],
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'business_reason' => ['nullable','string'],
            'risk_level' => ['required','in:low,medium,high'],
        ]);

        $asset = !empty($data['asset_id']) ? Asset::find($data['asset_id']) : null;

        if ($asset) {
            abort_unless($asset->customer_id == $user->customer_id, 403);

            if (($user->customer_access_scope ?? 'ho') === 'branch') {
                abort_unless($asset->customer_branch_id == $user->customer_branch_id, 403);
            }
        }

        ChangeRequest::create([
            'change_no' => NumberGenerator::generate('CR'),
            'customer_id' => $user->customer_id,
            'customer_branch_id' => $asset?->customer_branch_id ?? $user->customer_branch_id,
            'customer_region_id' => $asset?->customer_region_id,
            'asset_id' => $asset?->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'business_reason' => $data['business_reason'] ?? null,
            'risk_level' => $data['risk_level'],
            'status' => 'submitted',
            'requested_by' => $user->name,
            'requested_date' => now(),
        ]);

        return redirect()->route('customer.portal.changes')->with('success', 'Change request submitted.');
    }
}
