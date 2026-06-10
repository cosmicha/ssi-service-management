<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\ChangeCategory;
use App\Models\ChangeAttachment;
use App\Models\ChangeRequest;
use App\Models\Customer;
use App\Models\CustomerBranch;
use App\Models\CustomerRegion;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChangeRequestController extends Controller
{
    public function index()
    {
        $changes = ChangeRequest::with(['customer','branch','asset','category','task'])
            ->latest()
            ->paginate(15);

        return view('change-requests.index', compact('changes'));
    }

    public function create()
    {
        return view('change-requests.create', [
            'customers' => Customer::orderBy('name')->get(),
            'regions' => CustomerRegion::with('customer')->orderBy('name')->get(),
            'branches' => CustomerBranch::with('customer')->orderBy('name')->get(),
            'assets' => Asset::with(['customer','branch'])->orderBy('name')->get(),
            'categories' => ChangeCategory::where('status','active')->orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $change = ChangeRequest::create([
            ...collect($data)->except(['attachments','attachment_type'])->toArray(),
            'change_no' => \App\Support\NumberGenerator::generate('CR'),
            'requested_date' => $data['requested_date'] ?? now(),
        ]);

        $this->storeAttachments($request, $change);

        return redirect()->route('change-requests.show', $change)
            ->with('success', 'Change Request created.');
    }

    public function show(ChangeRequest $changeRequest)
    {
        $changeRequest->load([
            'customer','region','branch','asset','category',
            'task.assignee','task.updates.user','task.updates.attachments','approver','attachments.uploader'
        ]);

        return view('change-requests.show', compact('changeRequest'));
    }

    public function edit(ChangeRequest $changeRequest)
    {
        return view('change-requests.edit', [
            'changeRequest' => $changeRequest,
            'customers' => Customer::orderBy('name')->get(),
            'regions' => CustomerRegion::with('customer')->orderBy('name')->get(),
            'branches' => CustomerBranch::with('customer')->orderBy('name')->get(),
            'assets' => Asset::with(['customer','branch'])->orderBy('name')->get(),
            'categories' => ChangeCategory::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, ChangeRequest $changeRequest)
    {
        $data = $this->validated($request);

        $changeRequest->update(
            collect($data)->except(['attachments','attachment_type'])->toArray()
        );

        $this->storeAttachments($request, $changeRequest);

        return redirect()->route('change-requests.show', $changeRequest)
            ->with('success', 'Change Request updated.');
    }

    public function destroyAttachment(ChangeAttachment $attachment)
    {
        $attachment->delete();

        return back()->with('success', 'Attachment removed.');
    }

    public function destroy(ChangeRequest $changeRequest)
    {
        $changeRequest->delete();

        return redirect()->route('change-requests.index')
            ->with('success', 'Change Request deleted.');
    }

    public function submit(ChangeRequest $changeRequest)
    {
        $changeRequest->update(['status' => 'submitted']);

        return back()->with('success', 'Change Request submitted.');
    }

    public function approve(ChangeRequest $changeRequest)
    {
        $changeRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Change Request approved.');
    }

    public function reject(ChangeRequest $changeRequest)
    {
        $changeRequest->update(['status' => 'rejected']);

        return back()->with('success', 'Change Request rejected.');
    }

    public function generateTask(Request $request, ChangeRequest $changeRequest)
    {
        if ($changeRequest->task_id) {
            return redirect()->route('tasks.show', $changeRequest->task_id);
        }

        $task = Task::create([
            'task_no' => \App\Support\NumberGenerator::generate('TSK'),
            'task_type' => 'change',
            'customer_id' => $changeRequest->customer_id,
            'customer_region_id' => $changeRequest->customer_region_id,
            'customer_branch_id' => $changeRequest->customer_branch_id,
            'asset_id' => $changeRequest->asset_id,
            'change_request_id' => $changeRequest->id,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth()->id(),
            'title' => $changeRequest->title,
            'description' => $changeRequest->implementation_plan ?: $changeRequest->description,
            'priority' => $changeRequest->risk_level === 'high' ? 'high' : 'medium',
            'status' => $request->assigned_to ? 'assigned' : 'open',
            'planned_date' => now()->toDateString(),
            'due_date' => $changeRequest->implementation_date,
        ]);

        $changeRequest->update([
            'task_id' => $task->id,
            'status' => 'scheduled',
        ]);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Implementation task generated.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'customer_id' => ['nullable','exists:customers,id'],
            'customer_region_id' => ['nullable','exists:customer_regions,id'],
            'customer_branch_id' => ['nullable','exists:customer_branches,id'],
            'asset_id' => ['nullable','exists:assets,id'],
            'change_category_id' => ['nullable','exists:change_categories,id'],
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'business_reason' => ['nullable','string'],
            'risk_level' => ['required','in:low,medium,high'],
            'implementation_plan' => ['nullable','string'],
            'rollback_plan' => ['nullable','string'],
            'requested_by' => ['nullable','string','max:255'],
            'requested_date' => ['nullable','date'],
            'implementation_date' => ['nullable','date'],
            'verification_notes' => ['nullable','string'],
            'status' => ['required','in:draft,submitted,approved,scheduled,in_progress,completed,rejected'],
            'attachment_type' => ['nullable','in:supporting_document,implementation_plan,rollback_plan,diagram,config_backup,evidence'],
            'attachments.*' => ['nullable','file','max:20480'],
        ]);
    }

    private function storeAttachments(Request $request, ChangeRequest $change): void
    {
        foreach ($request->file('attachments', []) as $file) {
            $path = $file->store('change-attachments', 'public');

            $change->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'attachment_type' => $request->attachment_type ?: 'supporting_document',
                'uploaded_by' => auth()->id(),
            ]);
        }
    }
}
