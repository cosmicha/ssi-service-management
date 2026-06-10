<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerSlaController;
use App\Http\Controllers\CustomerPortalController;
use App\Http\Controllers\CustomerPortalAccountController;
use App\Http\Controllers\CustomerRegionController;
use App\Http\Controllers\CustomerBranchController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetAttachmentController;
use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\ChecklistTemplateController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskWorkLogController;
use App\Http\Controllers\TaskDispatchController;
use App\Http\Controllers\TaskAssignmentController;
use App\Http\Controllers\TaskUpdateController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceCatalogController;
use App\Http\Controllers\ServiceContractController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\IncidentUpdateController;
use App\Http\Controllers\ChangeRequestController;
use App\Http\Controllers\PreventiveScheduleController;
use App\Http\Controllers\PreventiveExecutionController;
use App\Http\Controllers\AccountController;

Route::get('/', function () {
    return redirect()->secure('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'openTasks' => \App\Models\Task::whereNotIn('status', ['completed','cancelled'])->count(),
        'openIncidents' => \App\Models\Incident::whereNotIn('status', ['resolved','closed'])->count(),
        'criticalIncidents' => \App\Models\Incident::where('severity', 'critical')->whereNotIn('status', ['resolved','closed'])->count(),
        'slaBreached' => \App\Models\Incident::where('sla_status', 'breached')->whereNotIn('status', ['resolved','closed'])->count(),
        'slaNoSla' => \App\Models\Incident::where('sla_status', 'no_sla')->count(),
        'pendingChanges' => \App\Models\ChangeRequest::whereIn('status', ['draft','submitted','approved','scheduled','in_progress'])->count(),
        'pmDue' => \App\Models\PreventiveSchedule::where('status','active')->whereDate('next_run_date', '<=', now()->toDateString())->count(),
        'totalAssets' => \App\Models\Asset::count(),
        'recentTasks' => \App\Models\Task::with(['customer','asset','assignee'])->latest()->limit(8)->get(),
    ]);
})->name('dashboard');

Route::resource('customers', CustomerController::class);
Route::resource('customer-regions', CustomerRegionController::class)->except(['show']);
Route::resource('customer-branches', CustomerBranchController::class)->except(['show']);

Route::resource('asset-categories', AssetCategoryController::class)->except(['show']);
Route::resource('assets', AssetController::class);

Route::resource('checklist-templates', ChecklistTemplateController::class);
Route::post('checklist-templates/{checklistTemplate}/items', [ChecklistTemplateController::class, 'storeItem'])->name('checklist-templates.items.store');
Route::delete('checklist-templates/{checklistTemplate}/items/{item}', [ChecklistTemplateController::class, 'destroyItem'])->name('checklist-templates.items.destroy');

Route::resource('tasks', TaskController::class);
Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');

Route::resource('service-categories', ServiceCategoryController::class)->except(['show']);
Route::resource('service-catalogs', ServiceCatalogController::class)->except(['show']);
Route::resource('service-contracts', ServiceContractController::class)->except(['show']);

Route::view('/preventive-maintenance', 'dashboard')->name('preventive-maintenance.index');
Route::view('/change-requests', 'dashboard')->name('change-requests.index');
Route::view('/engineer-schedule', 'dashboard')->name('engineer-schedule.index');

require __DIR__.'/auth.php';


Route::resource('preventive-schedules', PreventiveScheduleController::class)
    ->except(['show']);

Route::post(
    'preventive-schedules/{preventiveSchedule}/generate-task',
    [PreventiveScheduleController::class, 'generateTask']
)->name('preventive-schedules.generate-task');


Route::post(
    'preventive-executions/start/{task}',
    [PreventiveExecutionController::class, 'start']
)->name('preventive-executions.start');

Route::get(
    'preventive-executions/{preventiveExecution}',
    [PreventiveExecutionController::class, 'show']
)->name('preventive-executions.show');


Route::post(
    'preventive-executions/{preventiveExecution}/save',
    [PreventiveExecutionController::class, 'save']
)->name('preventive-executions.save');

Route::post(
    'preventive-executions/{preventiveExecution}/complete',
    [PreventiveExecutionController::class, 'complete']
)->name('preventive-executions.complete');

Route::resource('incidents', IncidentController::class);

Route::resource('change-requests', ChangeRequestController::class);
Route::post('change-requests/{changeRequest}/submit', [ChangeRequestController::class, 'submit'])->name('change-requests.submit');
Route::post('change-requests/{changeRequest}/approve', [ChangeRequestController::class, 'approve'])->name('change-requests.approve');
Route::post('change-requests/{changeRequest}/reject', [ChangeRequestController::class, 'reject'])->name('change-requests.reject');
Route::post('change-requests/{changeRequest}/generate-task', [ChangeRequestController::class, 'generateTask'])->name('change-requests.generate-task');


Route::post(
    '/assets/{asset}/attachments',
    [AssetAttachmentController::class, 'store']
)->name('assets.attachments.store');

Route::delete(
    '/asset-attachments/{assetAttachment}',
    [AssetAttachmentController::class, 'destroy']
)->name('asset-attachments.destroy');


Route::delete(
    'incident-attachments/{attachment}',
    [IncidentController::class, 'destroyAttachment']
)->name('incidents.attachments.destroy');

Route::delete(
    'change-attachments/{attachment}',
    [ChangeRequestController::class, 'destroyAttachment']
)->name('change-attachments.destroy');

Route::delete(
    'preventive-execution-items/{item}/evidence',
    [PreventiveExecutionController::class, 'removeEvidence']
)->name('preventive-executions.evidence.destroy');

Route::get('/settings/branding', [AppSettingController::class, 'edit'])->name('settings.edit');
Route::put('/settings/branding', [AppSettingController::class, 'update'])->name('settings.update');

Route::post(
    '/incidents/{incident}/updates',
    [IncidentUpdateController::class, 'store']
)->name('incidents.updates.store');

Route::post(
    '/tasks/{task}/updates',
    [TaskUpdateController::class, 'store']
)->name('tasks.updates.store');

Route::get('/customer-portal', [CustomerPortalController::class, 'dashboard'])
    ->name('customer.portal.dashboard');

Route::resource('accounts', AccountController::class)->except(['show']);

Route::get('/customer-portal/assets', function () {
    $customerId = auth()->user()?->customer_id;

    if (!$customerId) {
        return redirect()->route('customer.portal.dashboard');
    }

    return view('customer-portal.assets', [
        'assets' => \App\Models\Asset::with(['category','branch'])
            ->where('customer_id', $customerId)
            ->latest()
            ->paginate(15),
    ]);
})->name('customer.portal.assets');

Route::get('/customer-portal/incidents', function () {
    $customerId = auth()->user()?->customer_id;

    if (!$customerId) {
        return redirect()->route('customer.portal.dashboard');
    }

    return view('customer-portal.incidents', [
        'incidents' => \App\Models\Incident::with(['asset','task'])
            ->where('customer_id', $customerId)
            ->latest()
            ->paginate(15),
    ]);
})->name('customer.portal.incidents');

Route::get('/customer-portal/changes', function () {
    $customerId = auth()->user()?->customer_id;

    if (!$customerId) {
        return redirect()->route('customer.portal.dashboard');
    }

    return view('customer-portal.changes', [
        'changes' => \App\Models\ChangeRequest::with(['asset','task'])
            ->where('customer_id', $customerId)
            ->latest()
            ->paginate(15),
    ]);
})->name('customer.portal.changes');

Route::get('/customer-portal/create-ticket', [CustomerPortalController::class, 'createIncident'])->name('customer.portal.incidents.create');
Route::post('/customer-portal/create-ticket', [CustomerPortalController::class, 'storeIncident'])->name('customer.portal.incidents.store');

Route::get('/customer-portal/create-change', [CustomerPortalController::class, 'createChange'])->name('customer.portal.changes.create');
Route::post('/customer-portal/create-change', [CustomerPortalController::class, 'storeChange'])->name('customer.portal.changes.store');


Route::resource('/customer-portal/accounts', CustomerPortalAccountController::class)
    ->names('customer.portal.accounts')
    ->parameters(['accounts' => 'account'])
    ->except(['show']);

Route::get('/customer-portal/assets/{asset}', function (\App\Models\Asset $asset) {
    $user = auth()->user();

    abort_unless($user && in_array($user->role, ['customer','customer_admin']), 403);
    abort_unless($asset->customer_id == $user->customer_id, 403);

    if ($user->role === 'customer' && ($user->customer_access_scope ?? 'ho') === 'branch') {
        abort_unless($asset->customer_branch_id == $user->customer_branch_id, 403);
    }

    $asset->load([
        'customer',
        'region',
        'branch',
        'category',
        'attachments',
    ]);

    $incidents = \App\Models\Incident::with(['task'])
        ->where('asset_id', $asset->id)
        ->latest()
        ->limit(10)
        ->get();

    $changes = \App\Models\ChangeRequest::with(['task'])
        ->where('asset_id', $asset->id)
        ->latest()
        ->limit(10)
        ->get();

    $pmExecutions = \App\Models\PreventiveExecution::with(['task'])
        ->whereHas('task', function ($q) use ($asset) {
            $q->where('asset_id', $asset->id);
        })
        ->latest()
        ->limit(10)
        ->get();

    return view('customer-portal.asset-show', compact(
        'asset',
        'incidents',
        'changes',
        'pmExecutions'
    ));
})->name('customer.portal.assets.show');

Route::get('/customer-portal/incidents/{incident}', function (\App\Models\Incident $incident) {
    $user = auth()->user();

    abort_unless($user && in_array($user->role, ['customer','customer_admin']), 403);
    abort_unless($incident->customer_id == $user->customer_id, 403);

    if ($user->role === 'customer' && ($user->customer_access_scope ?? 'ho') === 'branch') {
        abort_unless($incident->customer_branch_id == $user->customer_branch_id, 403);
    }

    $incident->load([
        'customer',
        'branch',
        'asset',
        'task.updates.user',
        'task.updates.attachments',
        'attachments.uploader',
    ]);

    return view('customer-portal.incident-show', compact('incident'));
})->name('customer.portal.incidents.show');

Route::post('/customer-portal/incidents/{incident}/comments', function (\Illuminate\Http\Request $request, \App\Models\Incident $incident) {
    $user = auth()->user();

    abort_unless($user && in_array($user->role, ['customer','customer_admin']), 403);
    abort_unless($incident->customer_id == $user->customer_id, 403);

    if ($user->role === 'customer' && ($user->customer_access_scope ?? 'ho') === 'branch') {
        abort_unless($incident->customer_branch_id == $user->customer_branch_id, 403);
    }

    abort_unless($incident->task, 404);

    $data = $request->validate([
        'message' => ['required','string'],
        'attachments.*' => ['nullable','file','max:20480'],
    ]);

    $update = \App\Models\TaskUpdate::create([
        'task_id' => $incident->task->id,
        'user_id' => $user->id,
        'update_type' => 'comment',
        'message' => $data['message'],
        'old_status' => $incident->task->status,
        'new_status' => $incident->task->status,
    ]);

    foreach ($request->file('attachments', []) as $file) {
        $path = $file->store('task-updates', 'public');

        $update->attachments()->create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);
    }

    return back()->with('success', 'Comment added.');
})->name('customer.portal.incidents.comments.store');

Route::get('/customer-portal/changes/{changeRequest}', function (\App\Models\ChangeRequest $changeRequest) {
    $user = auth()->user();

    abort_unless($user && in_array($user->role, ['customer','customer_admin']), 403);
    abort_unless($changeRequest->customer_id == $user->customer_id, 403);

    if ($user->role === 'customer' && ($user->customer_access_scope ?? 'ho') === 'branch') {
        abort_unless($changeRequest->customer_branch_id == $user->customer_branch_id, 403);
    }

    $changeRequest->load([
        'customer',
        'branch',
        'asset',
        'task.updates.user',
        'task.updates.attachments',
        'attachments.uploader',
    ]);

    return view('customer-portal.change-show', compact('changeRequest'));
})->name('customer.portal.changes.show');

Route::post('/customer-portal/changes/{changeRequest}/comments', function (\Illuminate\Http\Request $request, \App\Models\ChangeRequest $changeRequest) {
    $user = auth()->user();

    abort_unless($user && in_array($user->role, ['customer','customer_admin']), 403);
    abort_unless($changeRequest->customer_id == $user->customer_id, 403);

    if ($user->role === 'customer' && ($user->customer_access_scope ?? 'ho') === 'branch') {
        abort_unless($changeRequest->customer_branch_id == $user->customer_branch_id, 403);
    }

    abort_unless($changeRequest->task, 404);

    $data = $request->validate([
        'message' => ['required','string'],
        'attachments.*' => ['nullable','file','max:20480'],
    ]);

    $update = \App\Models\TaskUpdate::create([
        'task_id' => $changeRequest->task->id,
        'user_id' => $user->id,
        'update_type' => 'comment',
        'message' => $data['message'],
        'old_status' => $changeRequest->task->status,
        'new_status' => $changeRequest->task->status,
    ]);

    foreach ($request->file('attachments', []) as $file) {
        $path = $file->store('task-updates', 'public');

        $update->attachments()->create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);
    }

    return back()->with('success', 'Comment added.');
})->name('customer.portal.changes.comments.store');

Route::get('/customer-portal/pm', function () {
    $user = auth()->user();

    abort_unless($user && in_array($user->role, ['customer','customer_admin']), 403);

    $assetQuery = \App\Models\Asset::where('customer_id', $user->customer_id);

    if ($user->role === 'customer' && ($user->customer_access_scope ?? 'ho') === 'branch') {
        $assetQuery->where('customer_branch_id', $user->customer_branch_id);
    }

    $assetIds = $assetQuery->pluck('id');

    $schedules = \App\Models\PreventiveSchedule::with(['asset.branch'])
        ->whereIn('asset_id', $assetIds)
        ->where('status', 'active')
        ->orderBy('next_run_date')
        ->paginate(10, ['*'], 'schedules_page');

    $executions = \App\Models\PreventiveExecution::with(['task.asset.branch', 'engineer'])
        ->whereHas('task', function ($q) use ($assetIds) {
            $q->whereIn('asset_id', $assetIds);
        })
        ->latest()
        ->paginate(10, ['*'], 'executions_page');

    return view('customer-portal.pm', compact('schedules', 'executions'));
})->name('customer.portal.pm.index');

Route::get('/customer-portal/reports', function () {
    $user = auth()->user();

    abort_unless($user && in_array($user->role, ['customer','customer_admin']), 403);

    $incidentQuery = \App\Models\Incident::where('customer_id', $user->customer_id);
    $changeQuery = \App\Models\ChangeRequest::where('customer_id', $user->customer_id);
    $assetQuery = \App\Models\Asset::where('customer_id', $user->customer_id);

    if ($user->role === 'customer' && ($user->customer_access_scope ?? 'ho') === 'branch') {
        $incidentQuery->where('customer_branch_id', $user->customer_branch_id);
        $changeQuery->where('customer_branch_id', $user->customer_branch_id);
        $assetQuery->where('customer_branch_id', $user->customer_branch_id);
    }

    return view('customer-portal.reports', [
        'totalAssets' => (clone $assetQuery)->count(),
        'totalTickets' => (clone $incidentQuery)->count(),
        'openTickets' => (clone $incidentQuery)->whereNotIn('status', ['resolved','closed'])->count(),
        'closedTickets' => (clone $incidentQuery)->whereIn('status', ['resolved','closed'])->count(),
        'slaMet' => (clone $incidentQuery)->where('sla_status', 'met')->count(),
        'slaBreached' => (clone $incidentQuery)->where('sla_status', 'breached')->count(),
        'noSla' => (clone $incidentQuery)->where('sla_status', 'no_sla')->count(),
        'totalChanges' => (clone $changeQuery)->count(),
        'pendingChanges' => (clone $changeQuery)->whereIn('status', ['draft','submitted','approved','scheduled','in_progress'])->count(),
        'recentTickets' => (clone $incidentQuery)->with(['asset','branch'])->latest()->limit(10)->get(),
    ]);
})->name('customer.portal.reports');

Route::post('/tasks/{task}/worklogs', [TaskWorkLogController::class, 'store'])
    ->name('tasks.worklogs.store');

Route::post('/tasks/{task}/dispatch-action', [TaskDispatchController::class, 'action'])
    ->name('tasks.dispatch.action');

Route::get('/engineer', function () {
    $user = auth()->user();

    abort_unless($user && $user->role === 'engineer', 403);

    return view('engineer.dashboard', [
        'tasks' => \App\Models\Task::with(['customer','branch','asset'])
            ->where('assigned_to', $user->id)
            ->whereNotIn('status', ['completed','cancelled'])
            ->latest()
            ->paginate(15),
        'completedToday' => \App\Models\Task::where('assigned_to', $user->id)
            ->whereDate('completed_at', now()->toDateString())
            ->count(),
        'openCount' => \App\Models\Task::where('assigned_to', $user->id)
            ->whereNotIn('status', ['completed','cancelled'])
            ->count(),
    ]);
})->name('engineer.dashboard');

Route::put('/tasks/{task}/assignment', [TaskAssignmentController::class, 'update'])
    ->name('tasks.assignment.update');

Route::get('/customers/{customer}/sla', [CustomerSlaController::class, 'edit'])
    ->name('customer-slas.edit');

Route::put('/customers/{customer}/sla', [CustomerSlaController::class, 'update'])
    ->name('customer-slas.update');