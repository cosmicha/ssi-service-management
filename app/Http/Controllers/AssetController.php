<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Customer;
use App\Models\CustomerBranch;
use App\Models\CustomerRegion;
use App\Models\PreventiveExecution;
use App\Models\Incident;
use App\Models\ChangeRequest;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $customerId = $request->query('customer');
        $branchId = $request->query('branch');

        $assets = Asset::visibleTo(auth()->user())
            ->with(['customer', 'region', 'branch', 'category'])
            ->when($customerId, fn ($q) => $q->where('customer_id', $customerId))
            ->when($branchId, fn ($q) => $q->where('customer_branch_id', $branchId))
            ->latest()
            ->paginate(15);

        return view('assets.index', compact('assets', 'customerId', 'branchId'));
    }

    public function create(Request $request)
    {
        $customers =
            \App\Support\TenantScope::isInternal(auth()->user())
                ? Customer::orderBy('name')->get()
                : Customer::where('id', auth()->user()?->customer_id)->get();

        $regions =
            CustomerRegion::query()
                ->when(
                    auth()->user()?->customer_id,
                    fn($q) => $q->where(
                        'customer_id',
                        auth()->user()?->customer_id
                    )
                )
                ->with('customer')
                ->orderBy('name')
                ->get();

        $branches =
            CustomerBranch::query()
                ->when(
                    auth()->user()?->customer_id,
                    fn($q) => $q->where(
                        'customer_id',
                        auth()->user()?->customer_id
                    )
                )
                ->with(['customer','region'])
                ->orderBy('name')
                ->get();
        $categories = AssetCategory::where('status', 'active')->orderBy('name')->get();

        $selectedCustomerId = $request->query('customer');
        $selectedBranchId = $request->query('branch');

        return view('assets.create', compact(
            'customers',
            'regions',
            'branches',
            'categories',
            'selectedCustomerId',
            'selectedBranchId'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'customer_region_id' => ['nullable', 'exists:customer_regions,id'],
            'customer_branch_id' => ['nullable', 'exists:customer_branches,id'],
            'asset_category_id' => ['nullable', 'exists:asset_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'asset_code' => ['nullable', 'string', 'max:100', 'unique:assets,asset_code'],
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'ip_address' => ['nullable', 'string', 'max:100'],
            'purchase_date' => ['nullable', 'date'],
            'warranty_expiry' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive,maintenance,faulty,retired'],
            'description' => ['nullable', 'string'],
        ]);

        $asset = Asset::create($data);

        return redirect()->route('assets.show', $asset)
            ->with('success', 'Asset created successfully.');
    }

    public function show(Asset $asset)
    {
        $asset->load(['customer', 'region', 'branch', 'category', 'attachments']);

        $assetHistory = [
            'incidents' => \App\Models\Incident::with(['task.partUsages.item'])
                ->where('asset_id', $asset->id)
                ->latest()
                ->limit(10)
                ->get(),

            'changes' => \App\Models\ChangeRequest::with(['task.partUsages.item'])
                ->where('asset_id', $asset->id)
                ->latest()
                ->limit(10)
                ->get(),

            'tasks' => \App\Models\Task::with(['partUsages.item', 'assignee'])
                ->where('asset_id', $asset->id)
                ->latest()
                ->limit(20)
                ->get(),

            'usedParts' => \App\Models\TaskPartUsage::with(['item', 'task'])
                ->whereHas('task', function ($q) use ($asset) {
                    $q->where('asset_id', $asset->id);
                })
                ->latest()
                ->limit(20)
                ->get(),
        ];
        $asset->load(['customer', 'region', 'branch', 'category', 'attachments']);

        $pmExecutions = PreventiveExecution::with(['task', 'engineer'])
            ->whereHas('task', function ($q) use ($asset) {
                $q->where('asset_id', $asset->id);
            })
            ->latest()
            ->get();

        $incidents = Incident::with(['category', 'task'])
            ->where('asset_id', $asset->id)
            ->latest()
            ->get();

        $changeRequests = ChangeRequest::with(['category', 'task'])
            ->where('asset_id', $asset->id)
            ->latest()
            ->get();


        $assetTimeline = collect();

        foreach (($incidents ?? collect()) as $incident) {
            $assetTimeline->push([
                'date' => $incident->created_at,
                'type' => 'Incident',
                'title' => $incident->title,
                'description' => $incident->status,
                'url' => route('incidents.show', $incident),
            ]);
        }

        foreach (($changeRequests ?? collect()) as $change) {
            $assetTimeline->push([
                'date' => $change->created_at,
                'type' => 'Change Request',
                'title' => $change->title,
                'description' => $change->status,
                'url' => route('change-requests.show', $change),
            ]);
        }

        foreach (($pmExecutions ?? collect()) as $pm) {
            $assetTimeline->push([
                'date' => $pm->created_at,
                'type' => 'Preventive Maintenance',
                'title' => 'PM Execution',
                'description' => $pm->status ?? 'completed',
                'url' => route('preventive-executions.show', $pm),
            ]);
        }

        foreach (($assetHistory['tasks'] ?? collect()) as $task) {
            $assetTimeline->push([
                'date' => $task->created_at,
                'type' => 'Task',
                'title' => $task->title,
                'description' => $task->status,
                'url' => route('tasks.show', $task),
            ]);
        }

        foreach (($assetHistory['usedParts'] ?? collect()) as $usage) {
            $assetTimeline->push([
                'date' => $usage->used_at ?? $usage->created_at,
                'type' => 'Used Part',
                'title' => ($usage->item?->name ?? 'Part') . ' x' . $usage->quantity,
                'description' => $usage->task?->task_no ?? null,
                'url' => $usage->task ? route('tasks.show', $usage->task) : null,
            ]);
        }

        $assetTimeline = $assetTimeline
            ->filter(fn($item) => $item['date'])
            ->sortByDesc('date')
            ->values();


        return view('assets.show', compact(
            'asset',
            'pmExecutions',
            'incidents',
            'changeRequests',
            'assetHistory',
            'assetTimeline'
        ));
    }

    public function edit(Asset $asset)
    {
        $asset->load('attachments');

        $customers =
            \App\Support\TenantScope::isInternal(auth()->user())
                ? Customer::orderBy('name')->get()
                : Customer::where('id', auth()->user()?->customer_id)->get();

        $regions =
            CustomerRegion::query()
                ->when(
                    auth()->user()?->customer_id,
                    fn($q) => $q->where(
                        'customer_id',
                        auth()->user()?->customer_id
                    )
                )
                ->with('customer')
                ->orderBy('name')
                ->get();

        $branches =
            CustomerBranch::query()
                ->when(
                    auth()->user()?->customer_id,
                    fn($q) => $q->where(
                        'customer_id',
                        auth()->user()?->customer_id
                    )
                )
                ->with(['customer','region'])
                ->orderBy('name')
                ->get();
        $categories = AssetCategory::orderBy('name')->get();

        return view('assets.edit', compact(
            'asset',
            'customers',
            'regions',
            'branches',
            'categories'
        ));
    }

    public function update(Request $request, Asset $asset)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'customer_region_id' => ['nullable', 'exists:customer_regions,id'],
            'customer_branch_id' => ['nullable', 'exists:customer_branches,id'],
            'asset_category_id' => ['nullable', 'exists:asset_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'asset_code' => ['nullable', 'string', 'max:100', 'unique:assets,asset_code,' . $asset->id],
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'ip_address' => ['nullable', 'string', 'max:100'],
            'purchase_date' => ['nullable', 'date'],
            'warranty_expiry' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive,maintenance,faulty,retired'],
            'description' => ['nullable', 'string'],
        ]);

        $asset->update($data);

        return redirect()->route('assets.show', $asset)
            ->with('success', 'Asset updated successfully.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('assets.index')
            ->with('success', 'Asset deleted successfully.');
    }

    public function updateLifecycle(\Illuminate\Http\Request $request, \App\Models\Asset $asset)
    {
        $data = $request->validate([
            'lifecycle_status' => ['required', 'in:active,under_repair,standby,retired,disposed'],
            'lifecycle_notes' => ['nullable', 'string'],
        ]);

        $payload = [
            'lifecycle_status' => $data['lifecycle_status'],
            'lifecycle_notes' => $data['lifecycle_notes'] ?? null,
        ];

        if ($data['lifecycle_status'] === 'retired' && !$asset->retired_at) {
            $payload['retired_at'] = now();
        }

        if ($data['lifecycle_status'] === 'disposed' && !$asset->disposed_at) {
            $payload['disposed_at'] = now();
        }

        $asset->update($payload);

        return back()->with('success', 'Asset lifecycle updated.');
    }


    private function authorizeAssetAccess($asset): void
    {
        $allowed =
            \App\Models\Asset::visibleTo(auth()->user())
                ->where('id', $asset->id)
                ->exists();

        abort_unless($allowed, 403);
    }


}
