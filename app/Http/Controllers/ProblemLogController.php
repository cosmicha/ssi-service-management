<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ProblemLog;
use App\Models\User;
use App\Support\ProblemLogActivity;
use App\Support\TicketNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketUpdateMail;

class ProblemLogController extends Controller
{

    private function normalizeProblemLogStatus(?string $status): string
    {
        $status = strtolower(trim((string) $status));

        return match ($status) {
            'open' => 'open',
            'in_progress', 'in progress', 'progress', 'processing' => 'in_progress',
            'closed', 'resolved', 'done', 'complete', 'completed' => 'closed',
            default => 'open',
        };
    }

    public function index(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();

        $baseQuery = \App\Models\ProblemLog::with(['company', 'assignedEngineer', 'createdByUser'])
            ->orderByDesc('created_at');

        // Role scoping
        if (($user->role ?? null) === 'customer' && !empty($user->company_id)) {
            $baseQuery->where('company_id', $user->company_id);
        }

        // Common filters (used by summary + list)
        if ($request->filled('search')) {
            $search = trim((string) $request->search);

            $baseQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('ticket_number', 'like', "%{$search}%")
                  ->orWhere('engineer_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('priority')) {
            $baseQuery->where('priority', $request->priority);
        }

        if ($request->filled('company_id')) {
            $baseQuery->where('company_id', $request->company_id);
        }

        if ($request->filled('assigned_engineer_id')) {
            $baseQuery->where('assigned_engineer_id', $request->assigned_engineer_id);
        }

        if ($request->filled('date_from')) {
            $baseQuery->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $baseQuery->whereDate('created_at', '<=', $request->date_to);
        }

        // Summary data ignores STATUS, but respects all other active filters
        $summaryLogs = $baseQuery->get();

        if ($request->filled('response_sla')) {
            $responseSla = $request->response_sla;
            $summaryLogs = $summaryLogs->filter(function ($log) use ($responseSla) {
                return method_exists($log, 'responseSlaStatus') && $log->responseSlaStatus() === $responseSla;
            })->values();
        }

        if ($request->filled('resolution_sla')) {
            $resolutionSla = $request->resolution_sla;
            $summaryLogs = $summaryLogs->filter(function ($log) use ($resolutionSla) {
                return method_exists($log, 'resolutionSlaStatus') && $log->resolutionSlaStatus() === $resolutionSla;
            })->values();
        }

        // Ticket list respects ALL filters including status
        $problemLogs = $summaryLogs;

        if ($request->filled('status')) {
            $status = $request->status;
            $problemLogs = $problemLogs->filter(function ($log) use ($status) {
                return ($log->status ?? null) === $status;
            })->values();
        }

        $companies = \App\Models\Company::orderBy('name')->get();
        $engineers = \App\Models\User::where('role', 'engineer')->orderBy('name')->get();

        return view('problem-logs.index', compact(
            'problemLogs',
            'summaryLogs',
            'companies',
            'engineers'
        ));
    }

public function analytics()
    {
        $logs = \App\Models\ProblemLog::with(['company', 'assignedEngineer'])->get();

        $total = $logs->count();
        $open = $logs->where('status', 'open')->count();
        $progress = $logs->where('status', 'in_progress')->count();
        $closed = $logs->where('status', 'closed')->count();

        $responseBreached = $logs->filter(fn($l) => $l->responseSlaStatus() === 'breached')->count();
        $resolutionBreached = $logs->filter(fn($l) => $l->resolutionSlaStatus() === 'breached')->count();

        $avgResponse = $logs->filter(fn($l) => $l->responseDurationSeconds() !== null)
            ->avg(fn($l) => $l->responseDurationSeconds());

        $avgResolution = $logs->filter(fn($l) => $l->resolutionDurationSeconds() !== null)
            ->avg(fn($l) => $l->resolutionDurationSeconds());

        $byCompany = $logs->groupBy(fn($l) => optional($l->company)->name ?? 'Unknown')
            ->map(fn($items) => [
                'count' => $items->count(),
                'response_breached' => $items->filter(fn($i) => $i->responseSlaStatus() === 'breached')->count(),
                'resolution_breached' => $items->filter(fn($i) => $i->resolutionSlaStatus() === 'breached')->count(),
            ])
            ->sortByDesc('count');

        $byEngineer = $logs->groupBy(fn($l) => optional($l->assignedEngineer)->name ?? 'Unassigned')
            ->map(fn($items) => [
                'count' => $items->count(),
                'open' => $items->where('status', 'open')->count(),
                'in_progress' => $items->where('status', 'in_progress')->count(),
                'closed' => $items->where('status', 'closed')->count(),
            ])
            ->sortByDesc('count');

        $topBreachedCompanies = $logs->groupBy(fn($l) => optional($l->company)->name ?? 'Unknown')
            ->map(fn($items) => [
                'count' => $items->filter(fn($i) =>
                    $i->responseSlaStatus() === 'breached' || $i->resolutionSlaStatus() === 'breached'
                )->count(),
            ])
            ->sortByDesc('count')
            ->take(5);

        $topEngineers = $logs->groupBy(fn($l) => optional($l->assignedEngineer)->name ?? 'Unassigned')
            ->map(fn($items) => [
                'count' => $items->count(),
            ])
            ->sortByDesc('count')
            ->take(5);

        $closureRate = $total > 0 ? round(($closed / $total) * 100) : 0;

        $activeLogs = $logs->filter(fn($l) => in_array($l->status, ['open', 'in_progress']));

        $overdueNow = $activeLogs->filter(function ($l) {
            return $l->responseSlaStatus() === 'breached' || $l->resolutionSlaStatus() === 'breached';
        })->count();

        $agingBuckets = [
            '0-1 hour' => 0,
            '1-4 hours' => 0,
            '4-24 hours' => 0,
            '>24 hours' => 0,
        ];

        foreach ($activeLogs as $log) {
            $start = $log->opened_at ?: $log->created_at;
            if (!$start) {
                continue;
            }

            $hours = $start->diffInHours(now());

            if ($hours < 1) {
                $agingBuckets['0-1 hour']++;
            } elseif ($hours < 4) {
                $agingBuckets['1-4 hours']++;
            } elseif ($hours < 24) {
                $agingBuckets['4-24 hours']++;
            } else {
                $agingBuckets['>24 hours']++;
            }
        }

        $criticalTickets = $logs->filter(function ($l) {
            return $l->status !== 'closed' && (
                $l->priority === 'high' ||
                $l->responseSlaStatus() === 'breached' ||
                $l->resolutionSlaStatus() === 'breached'
            );
        })->sortByDesc(function ($l) {
            $score = 0;
            if ($l->priority === 'high') $score += 3;
            if ($l->responseSlaStatus() === 'breached') $score += 2;
            if ($l->resolutionSlaStatus() === 'breached') $score += 2;
            if ($l->status === 'in_progress') $score += 1;
            return $score;
        })->take(8)->values();

        $months = collect(range(5, 0))->map(function ($offset) {
            return now()->subMonths($offset)->format('Y-m');
        })->push(now()->format('Y-m'))->values();

        $monthlyTickets = $months->mapWithKeys(function ($month) use ($logs) {
            $count = $logs->filter(fn($l) => $l->created_at && $l->created_at->format('Y-m') === $month)->count();
            return [$month => $count];
        });

        $monthlyClosed = $months->mapWithKeys(function ($month) use ($logs) {
            $count = $logs->filter(fn($l) => $l->closed_at && $l->closed_at->format('Y-m') === $month)->count();
            return [$month => $count];
        });

        $monthlyBreaches = $months->mapWithKeys(function ($month) use ($logs) {
            $count = $logs->filter(function ($l) use ($month) {
                $sameMonth = $l->created_at && $l->created_at->format('Y-m') === $month;
                $breached = $l->responseSlaStatus() === 'breached' || $l->resolutionSlaStatus() === 'breached';
                return $sameMonth && $breached;
            })->count();
            return [$month => $count];
        });

        $topIssueCategories = $logs->groupBy(function ($l) {
            $title = strtolower(trim((string) $l->title));

            if (str_contains($title, 'network') || str_contains($title, 'internet')) return 'Network';
            if (str_contains($title, 'screen') || str_contains($title, 'display') || str_contains($title, 'tv')) return 'Display';
            if (str_contains($title, 'power') || str_contains($title, 'electric') || str_contains($title, 'mati')) return 'Power';
            if (str_contains($title, 'audio') || str_contains($title, 'sound')) return 'Audio';
            if (str_contains($title, 'player') || str_contains($title, 'device') || str_contains($title, 'hardware')) return 'Device';
            if (str_contains($title, 'cms') || str_contains($title, 'content')) return 'Content/CMS';

            return 'Other';
        })->map(fn($items) => $items->count())
          ->sortDesc()
          ->take(6);

        return view('analytics.index', compact(
            'total',
            'open',
            'progress',
            'closed',
            'responseBreached',
            'resolutionBreached',
            'avgResponse',
            'avgResolution',
            'byCompany',
            'byEngineer',
            'topBreachedCompanies',
            'topEngineers',
            'closureRate',
            'overdueNow',
            'agingBuckets',
            'criticalTickets',
            'monthlyTickets',
            'monthlyClosed',
            'monthlyBreaches',
            'topIssueCategories'
        ));
    }

    public function create()
    {
        return view('problem-logs.create', ['companies' => Company::orderBy('name')->get()]);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        $isCustomer = (($user->role ?? null) === 'customer');

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
            'company_id' => [$isCustomer ? 'nullable' : 'required', 'exists:companies,id'],
            'photo' => ['nullable', 'image', 'max:8192'],
        ]);

        $resolvedCompanyId = $isCustomer
            ? ($user->company_id ?: $this->fallbackCompanyId())
            : $request->company_id;

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $cleanTitle = preg_replace('/^\s*title\s*:\s*/i', '', (string) $request->title);
        $cleanDescription = preg_replace('/^\s*description\s*:\s*/i', '', (string) $request->description);

        $problemLog = ProblemLog::create([
            'title' => trim($cleanTitle),
            'description' => trim($cleanDescription),
            'status' => 'open',
            'priority' => $request->priority,
            'photo' => $photoPath,
            'opened_at' => now(),
            'ticket_number' => 'TKT' . strtoupper(substr(md5(uniqid('', true)), 0, 12)),
            'company_id' => $resolvedCompanyId,
            'created_by_user_id' => $user->id,
        ]);

        if (method_exists($problemLog, 'updates')) {
            try {
                $problemLog->updates()->create([
                    'user_id' => $user->id,
                    'action' => 'Ticket Created',
                    'message' => 'Ticket created successfully.',
                ]);
            } catch (\Throwable $e) {
            }
        }

        $this->sendTicketEmail(
            $problemLog,
            'New Ticket Created',
            'A new ticket has been created.'
        );

        try {
            app(\App\Services\OpenAiResolutionSuggestionService::class)->process($problemLog);
        } catch (\Throwable $e) {
            \Log::error('AI suggestion processing failed', [
                'problem_log_id' => $problemLog->id,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect('/problem-logs/' . $problemLog->id)->with('success', 'Problem log created successfully.');
    }

    public function show(ProblemLog $problemLog)
    {
        $problemLog->load([
            'company',
            'assignedEngineer',
            'createdByUser',
            'assignedByUser',
            'acknowledgedByUser',
            'closedByUser',
            'updates.user',
            'aiSuggestions.resolutionTemplate',
        ]);

        $groupedAiSuggestions = collect(
            $problemLog->aiSuggestions
                ->filter(fn ($s) => $s->resolutionTemplate)
                ->groupBy(function ($s) {
                    return $s->resolutionTemplate->canonical_group ?: ('single-' . $s->resolution_template_id);
                })
                ->map(function ($items) {
                    $sorted = $items->sortByDesc('similarity_score')->values();

                    return [
                        'primary' => $sorted->first(),
                        'alternatives' => $sorted->slice(1)->values(),
                    ];
                })
                ->values()
                ->all()
        );

        $engineers = User::where('role', 'engineer')
            ->orderBy('name')
            ->get();

        return view('problem-logs.show', compact('problemLog', 'engineers', 'groupedAiSuggestions'));
    }

    
    public function edit(ProblemLog $problemLog)
    {
        $problemLog->load(['company', 'assignedEngineer']);
        return view('problem-logs.edit', compact('problemLog') + ['companies' => Company::orderBy('name')->get()]);
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\ProblemLog $problemLog)
    {
        $user = auth()->user();
        $isCustomer = (($user->role ?? null) === 'customer');

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
            'company_id' => [$isCustomer ? 'nullable' : 'required', 'exists:companies,id'],
            'photo' => ['nullable', 'image', 'max:8192'],
        ]);

        $resolvedCompanyId = $isCustomer
            ? ($user->company_id ?: $problemLog->company_id ?: $this->fallbackCompanyId())
            : $request->company_id;

        $cleanTitle = preg_replace('/^\s*title\s*:\s*/i', '', (string) $request->title);
        $cleanDescription = preg_replace('/^\s*description\s*:\s*/i', '', (string) $request->description);

        $data = [
            'title' => trim($cleanTitle),
            'description' => trim($cleanDescription),
            'priority' => $request->priority,
            'company_id' => $resolvedCompanyId,
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $problemLog->update($data);

        return redirect('/problem-logs/' . $problemLog->id)->with('success', 'Problem log updated successfully.');
    }

    public function destroy(ProblemLog $problemLog)
    {
        $user = auth()->user();

        if (($user->role ?? '') !== 'admin') {
            abort(403, 'Only admin can delete tickets.');
        }

        try {
            if (!empty($problemLog->photo)) {
                Storage::disk('public')->delete($problemLog->photo);
            }

            if (!empty($problemLog->closed_photo)) {
                Storage::disk('public')->delete($problemLog->closed_photo);
            }
        } catch (\Throwable $e) {
            // ignore file delete errors
        }

        try {
            if (method_exists($problemLog, 'updates')) {
                $problemLog->updates()->delete();
            }
        } catch (\Throwable $e) {
            // ignore relation delete errors
        }

        $problemLog->delete();

        return redirect()->route('problem-logs.index')->with('success', 'Ticket deleted successfully.');
    }

    public function acknowledge(\App\Models\ProblemLog $problemLog)
    {
        $user = auth()->user();

        if (($user->role ?? null) === 'engineer' && empty($problemLog->assigned_engineer_id)) {
            $problemLog->assigned_engineer_id = $user->id;
            $problemLog->engineer_name = $user->name;
        }

        if (!$problemLog->acknowledged_at) {
            $problemLog->acknowledged_at = now();
        }

        if (!$problemLog->in_progress_at) {
            $problemLog->in_progress_at = now();
        }

        if (($problemLog->status ?? 'open') !== 'closed') {
            $problemLog->status = 'in_progress';
        }

        $problemLog->save();

        if (method_exists($problemLog, 'updates')) {
            try {
                $message = 'Ticket acknowledged.';
                if (($user->role ?? null) === 'engineer' && $problemLog->assigned_engineer_id == $user->id) {
                    $message = 'Ticket acknowledged by engineer and moved into progress.';
                }

                $problemLog->updates()->create([
                    'user_id' => $user->id,
                    'action' => 'Acknowledged',
                    'message' => $message,
                ]);
            } catch (\Throwable $e) {
            }
        }

        $this->sendTicketEmail(
            $problemLog,
            'Ticket Acknowledged',
            'Your ticket has been acknowledged.'
        );

        

        
        return back()->with('success', 'Ticket acknowledged successfully.');
    }

    public function assignEngineer(\Illuminate\Http\Request $request, \App\Models\ProblemLog $problemLog)
    {
        $request->validate([
            'assigned_engineer_id' => ['required', 'exists:users,id'],
        ]);

        $engineer = \App\Models\User::findOrFail($request->assigned_engineer_id);

        $problemLog->assigned_engineer_id = $engineer->id;
        $problemLog->engineer_name = $engineer->name;

        if (($problemLog->status ?? 'open') === null) {
            $problemLog->status = 'open';
        }

        $problemLog->save();

        if (method_exists($problemLog, 'updates')) {
            try {
                $problemLog->updates()->create([
                    'user_id' => auth()->id(),
                    'action' => 'Engineer Assigned',
                    'message' => 'Engineer assigned. Ticket is still waiting for acknowledgement.',
                ]);
            } catch (\Throwable $e) {
            }
        }

        $this->sendTicketEmail(
            $problemLog,
            'Engineer Assigned',
            'An engineer has been assigned to your ticket.'
        );

        

        
        return back()->with('success', 'Engineer assigned successfully.');
    }

    public function take(ProblemLog $problemLog)
    {
        $user = auth()->user();

        if ($user->role !== 'engineer') {
            abort(403);
        }

        $oldStatus = $problemLog->status;

        $problemLog->update([
            'assigned_engineer_id' => $user->id,
            'engineer_name' => $user->name,
            'assigned_by_user_id' => $problemLog->assigned_by_user_id ?: $user->id,
            'acknowledged_by_user_id' => $user->id,
            'acknowledged_at' => now(),
            'status' => 'in_progress',
            'in_progress_at' => $problemLog->in_progress_at ?: now(),
            'response_sla_breached' => $problemLog->response_due_at ? now()->gt($problemLog->response_due_at) : false,
        ]);

        ProblemLogActivity::add(
            $problemLog,
            'taken',
            'Ticket taken and acknowledged by ' . $user->name,
            $oldStatus,
            'in_progress',
            [
                'assigned_engineer_id' => $user->id,
                'assigned_engineer_name' => $user->name,
            ]
        );

        TicketNotificationService::send(
            $problemLog,
            'Ticket Taken',
            'An engineer has taken and acknowledged the ticket.'
        );

        

        
        return back()->with('success', 'Ticket taken and acknowledged.');
    }

    public function addUpdate(Request $request, ProblemLog $problemLog)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        ProblemLogActivity::add(
            $problemLog,
            'comment',
            $request->message,
            $problemLog->status,
            $problemLog->status,
            null,
            auth()->id()
        );

        TicketNotificationService::send(
            $problemLog,
            'Ticket Progress Updated',
            'A new progress update has been added to the ticket.'
        );

        $this->sendTicketEmail(
            $problemLog,
            'Ticket Updated',
            'There is a new update on your ticket.'
        );

        

        
        return back()->with('success', 'Progress update added.');
    }

    public function close(Request $request, ProblemLog $problemLog)
    {
        $current = $this->normalizeProblemLogStatus($problemLog->status ?? 'open');

        if ($current === 'closed') {
            return back()->with('success', 'Ticket already closed.');
        }

        $problemLog->status = 'closed';

        if (isset($problemLog->closed_at)) {
            $problemLog->closed_at = now();
        }

        if (isset($problemLog->resolved_at) && empty($problemLog->resolved_at)) {
            $problemLog->resolved_at = now();
        }

        $problemLog->save();

        return back()->with('success', 'Ticket closed successfully.');
    }

    public function export()
    {
        $logs = ProblemLog::with([
            'company',
            'assignedEngineer',
            'createdByUser',
            'assignedByUser',
            'acknowledgedByUser',
            'closedByUser',
        ])->get();

        $filename = "report.csv";
        $handle = fopen($filename, 'w+');

        fputcsv($handle, [
            'Ticket',
            'Title',
            'Description',
            'Company',
            'Status',
            'Priority',
            'Created By',
            'Assigned Engineer',
            'Assigned By',
            'Acknowledged By',
            'Closed By',
            'Created At',
            'Opened At',
            'Acknowledged At',
            'In Progress At',
            'Closed At',
            'Response Due At',
            'Resolution Due At',
            'Response Time',
            'Resolution Time',
            'Response SLA Breached',
            'Resolution SLA Breached',
            'Close Note',
            'Photo',
            'Closed Photo',
        ]);

        foreach ($logs as $log) {
            fputcsv($handle, [
                $log->ticket_number,
                $log->title,
                $log->description,
                optional($log->company)->name ?? '-',
                $log->status,
                $log->priority,
                optional($log->createdByUser)->name ?? '-',
                optional($log->assignedEngineer)->name ?? $log->engineer_name ?? '-',
                optional($log->assignedByUser)->name ?? '-',
                optional($log->acknowledgedByUser)->name ?? '-',
                optional($log->closedByUser)->name ?? '-',
                $log->created_at,
                $log->opened_at,
                $log->acknowledged_at,
                $log->in_progress_at,
                $log->closed_at,
                $log->response_due_at,
                $log->resolution_due_at,
                $log->responseDurationText(),
                $log->resolutionDurationText(),
                $log->responseSlaStatus() === 'breached' ? 'YES' : 'NO',
                $log->resolutionSlaStatus() === 'breached' ? 'YES' : 'NO',
                $log->close_note,
                $log->photo,
                $log->closed_photo,
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function engineerDashboard()
    {
        $user = auth()->user();

        if ($user->role !== 'engineer') {
            abort(403);
        }

        $assigned = ProblemLog::with(['company', 'assignedEngineer'])
            ->where('assigned_engineer_id', $user->id)
            ->latest()
            ->get();

        $available = ProblemLog::with(['company', 'assignedEngineer'])
            ->where('status', 'open')
            ->whereNull('acknowledged_at')
            ->latest()
            ->get();

        return view('engineer.dashboard', compact('assigned', 'available'));
    }

    public function takeTicket(\App\Models\ProblemLog $problemLog)
    {
        $user = auth()->user();

        if (($user->role ?? null) !== 'engineer') {
            

        
        return back()->with('error', 'Only engineer can take ticket.');
        }

        if (!empty($problemLog->assigned_engineer_id) && (int)$problemLog->assigned_engineer_id !== (int)$user->id) {
            

        
        return back()->with('error', 'This ticket is assigned to another engineer.');
        }

        $problemLog->assigned_engineer_id = $user->id;
        $problemLog->engineer_name = $user->name;

        if (!$problemLog->acknowledged_at) {
            $problemLog->acknowledged_at = now();
        }

        if (!$problemLog->in_progress_at) {
            $problemLog->in_progress_at = now();
        }

        if (($problemLog->status ?? 'open') !== 'closed') {
            $problemLog->status = 'in_progress';
        }

        $problemLog->save();

        if (method_exists($problemLog, 'updates')) {
            try {
                $problemLog->updates()->create([
                    'user_id' => $user->id,
                    'action' => 'Ticket Taken',
                    'message' => 'Ticket taken by assigned engineer and moved into progress.',
                ]);
            } catch (\Throwable $e) {
            }
        }

        $this->sendTicketEmail(
            $problemLog,
            'Ticket Taken',
            'An engineer has taken your ticket.'
        );

        

        
        return back()->with('success', 'Ticket taken successfully.');
    }


    protected function fallbackCompanyId(): ?int
    {
        return Company::where('sla_active', true)->orderBy('id')->value('id');
    }



    private function sendTicketEmail($problemLog, $title, $message)
    {
        try {
            $emails = [];

            // creator
            if ($problemLog->creator && $problemLog->creator->email) {
                $emails[] = $problemLog->creator->email;
            }

            // company email
            if ($problemLog->company && $problemLog->company->email) {
                $emails[] = $problemLog->company->email;
            }

            // notification_emails (comma separated)
            if ($problemLog->company && $problemLog->company->notification_emails) {
                $extra = explode(',', $problemLog->company->notification_emails);
                foreach ($extra as $e) {
                    $emails[] = trim($e);
                }
            }

            $emails = array_unique(array_filter($emails));

            if (!empty($emails)) {
                \Mail::to($emails)->send(
                    new \App\Mail\TicketUpdateMail($problemLog, $title, $message)
                );
            }

        } catch (\Throwable $e) {
            \Log::error('Ticket email notification failed', [
                'ticket_id' => $problemLog->id,
                'error' => $e->getMessage()
            ]);
        }
    }


    public function bulkAction(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:problem_logs,id'],
            'action' => ['required', 'in:delete,acknowledge,assign'],
            'assigned_engineer_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $user = auth()->user();
        $logs = \App\Models\ProblemLog::whereIn('id', $request->ids)->get();

        foreach ($logs as $problemLog) {
            if ($request->action === 'delete') {
                if (($user->role ?? '') === 'admin') {
                    $problemLog->delete();
                }
            }

            if ($request->action === 'acknowledge') {
                if (!$problemLog->acknowledged_at) {
                    $problemLog->acknowledged_at = now();
                }
                if (!$problemLog->in_progress_at) {
                    $problemLog->in_progress_at = now();
                }
                if (($problemLog->status ?? 'open') !== 'closed') {
                    $problemLog->status = 'in_progress';
                }
                $problemLog->save();
            }

            if ($request->action === 'assign' && $request->filled('assigned_engineer_id')) {
                $engineer = \App\Models\User::find($request->assigned_engineer_id);
                if ($engineer) {
                    $problemLog->assigned_engineer_id = $engineer->id;
                    $problemLog->engineer_name = $engineer->name;
                    $problemLog->assigned_by_user_id = $user->id;
                    $problemLog->save();
                }
            }
        }

        return back()->with('success', 'Bulk action completed.');
    }


    public function applyResolutionTemplate(\App\Models\ProblemLog $problemLog, \App\Models\ResolutionTemplate $resolutionTemplate)
    {
        $summary = trim((string) $resolutionTemplate->displaySummary());
        $title = trim((string) $resolutionTemplate->displayTitle());

        $kbCode = 'KB-' . str_pad((string) $resolutionTemplate->id, 4, '0', STR_PAD_LEFT);

        $prefill = $kbCode . ' | ' . $title;
        if ($summary !== '') {
            $prefill .= "\n\n" . $summary;
        }

        session()->flash('prefill_close_note', $prefill);
        session()->flash('prefill_template_id', $resolutionTemplate->id);
        session()->flash('prefill_resolution_title', $title);
        session()->flash('prefill_resolution_code', $kbCode);

        return redirect('/problem-logs/' . $problemLog->id . '#close-ticket')
            ->with('success', 'Solution applied to ticket. Review and close the ticket.');
    }

    

    private function inferKbCategory(string $text): string
    {
        $text = \Illuminate\Support\Str::lower($text);

        if (\Illuminate\Support\Str::contains($text, ['monitor', 'screen', 'display', 'tv', 'videotron'])) {
            return 'Display';
        }

        if (\Illuminate\Support\Str::contains($text, ['power', 'listrik', 'saklar', 'adaptor', 'mati total'])) {
            return 'Electrical';
        }

        if (\Illuminate\Support\Str::contains($text, ['network', 'internet', 'wifi', 'lan'])) {
            return 'Network';
        }

        if (\Illuminate\Support\Str::contains($text, ['cms', 'software', 'system', 'login'])) {
            return 'Software';
        }

        return 'Hardware';
    }

}
