<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProblemLogController;
use App\Http\Controllers\ProblemLogExportController;
use App\Http\Controllers\Admin\UserApprovalController;

Route::get('/', function () {
    return redirect('/problem-logs');
});

require __DIR__.'/auth.php';

Route::get('/waiting-approval', function () {
    return view('waiting');
})->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [UserApprovalController::class, 'index']);
    Route::get('/admin/companies/settings', [UserApprovalController::class, 'companySettings']);
    Route::post('/admin/companies', [UserApprovalController::class, 'storeCompany']);
    Route::put('/admin/companies/{company}', [UserApprovalController::class, 'updateCompany']);
    Route::delete('/admin/companies/{company}', [UserApprovalController::class, 'destroyCompany']);

    Route::post('/admin/users/{user}/approve', [UserApprovalController::class, 'approve']);
    Route::put('/admin/users/{user}', [UserApprovalController::class, 'update']);
    Route::delete('/admin/users/{user}', [UserApprovalController::class, 'destroy']);
});

Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/engineer/dashboard', [ProblemLogController::class, 'engineerDashboard']);
    Route::get('/problem-logs/export', [ProblemLogExportController::class, 'export'])->name('problem-logs.export');
    Route::post('/problem-logs/{problemLog}/acknowledge', [ProblemLogController::class, 'acknowledge']);
    Route::post('/problem-logs/{problemLog}/assign-engineer', [ProblemLogController::class, 'assignEngineer']);
    Route::post('/problem-logs/{problemLog}/take', [ProblemLogController::class, 'take']);
    Route::post('/problem-logs/{problemLog}/close', [ProblemLogController::class, 'close']);
    Route::post('/problem-logs/{problemLog}/updates', [ProblemLogController::class, 'addUpdate']);
Route::post('/problem-logs/delete/{problemLog}', [ProblemLogController::class, 'destroy'])->name('problem-logs.delete-post');
Route::resource('problem-logs', ProblemLogController::class);
Route::post('/problem-logs/{problemLog}/assign-engineer', [ProblemLogController::class, 'assignEngineer'])->name('problem-logs.assign-engineer');
Route::post('/problem-logs/{problemLog}/acknowledge', [ProblemLogController::class, 'acknowledge'])->name('problem-logs.acknowledge');
Route::post('/problem-logs/{problemLog}/take-ticket', [ProblemLogController::class, 'takeTicket'])->name('problem-logs.take-ticket');
});

Route::get('/analytics', [ProblemLogController::class, 'analytics']);

Route::get('/help', function () {
    return view('help.index');
});

Route::get('/sla-dashboard', [App\Http\Controllers\SlaDashboardController::class, 'index'])
    ->middleware(['auth', 'approved'])
    ->name('sla.dashboard');
Route::get('/resolution-library', [\App\Http\Controllers\ResolutionTemplateController::class, 'index'])->middleware(['auth'])->name('resolution-library.index');

Route::post('/ai/suggest-resolution', [\App\Http\Controllers\AiSuggestionController::class, 'suggest'])->middleware(['auth'])->name('ai.suggest-resolution');

Route::get('/resolution-library/{resolutionTemplate}/edit', [\App\Http\Controllers\ResolutionTemplateController::class, 'edit'])->middleware(['auth'])->name('resolution-library.edit');
Route::put('/resolution-library/{resolutionTemplate}', [\App\Http\Controllers\ResolutionTemplateController::class, 'update'])->middleware(['auth'])->name('resolution-library.update');
Route::post('/problem-logs/bulk-action', [\App\Http\Controllers\ProblemLogController::class, 'bulkAction'])->middleware(['auth'])->name('problem-logs.bulk-action');

Route::get('/resolution-library/{resolutionTemplate}', [\App\Http\Controllers\ResolutionTemplateController::class, 'show'])->middleware(['auth'])->name('resolution-library.show');

Route::delete('/resolution-library/{resolutionTemplate}', [\App\Http\Controllers\ResolutionTemplateController::class, 'destroy'])->middleware(['auth'])->name('resolution-library.destroy');

Route::post('/problem-logs/{problemLog}/apply-resolution-template/{resolutionTemplate}', [\App\Http\Controllers\ProblemLogController::class, 'applyResolutionTemplate'])->middleware(['auth'])->name('problem-logs.apply-resolution-template');

// ===== Vendor (ensure exists) =====
Route::resource('vendors', \App\Http\Controllers\VendorController::class)->middleware(['auth']);


Route::resource('devices', \App\Http\Controllers\DeviceController::class)->middleware(['auth']);
