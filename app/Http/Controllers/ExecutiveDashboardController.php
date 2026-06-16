<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\ChangeRequest;
use App\Models\Customer;
use App\Models\Incident;
use App\Models\InventoryItem;
use App\Models\PreventiveExecution;
use App\Models\Task;
use Carbon\Carbon;

class ExecutiveDashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $monthStart = $now->copy()->startOfMonth();

        $totalCustomers = Customer::count();
        $totalAssets = Asset::count();

        $openIncidents = Incident::whereIn('status', ['open', 'assigned'])->count();

        $criticalIncidents = Incident::where('severity', 'critical')
            ->whereIn('status', ['open', 'assigned'])
            ->count();

        $openChanges = ChangeRequest::whereIn('status', ['open', 'assigned'])->count();

        $openTasks = Task::whereNotIn('status', ['completed', 'closed', 'cancelled'])->count();

        $pmTotal = PreventiveExecution::count();

        $pmDone = PreventiveExecution::whereIn('status', ['done', 'completed'])->count();

        $pmCompliance = $pmTotal > 0
            ? round(($pmDone / $pmTotal) * 100, 1)
            : 100;

        $incidentTotal = Incident::count();

        $slaMet = Incident::where(function ($q) {
                $q->where('resolution_sla_status', 'met')
                  ->orWhere('sla_status', 'on_track');
            })
            ->count();

        $slaCompliance = $incidentTotal > 0
            ? round(($slaMet / $incidentTotal) * 100, 1)
            : 100;

        $lowStock = class_exists(InventoryItem::class)
            ? InventoryItem::get()->filter(fn ($item) => method_exists($item, 'currentStock')
                ? $item->currentStock() <= ($item->minimum_stock ?? 0)
                : (($item->quantity ?? 0) <= ($item->minimum_stock ?? 0))
            )->count()
            : 0;

        $incidentTrend = Incident::selectRaw("strftime('%Y-%m', created_at) as period, count(*) as total")
            ->where('created_at', '>=', $now->copy()->subMonths(6))
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $incidentCategory = Incident::with('category')
            ->get()
            ->groupBy(fn ($incident) => $incident->category?->name ?? ucfirst($incident->category ?? 'Uncategorized'))
            ->map(fn ($items) => $items->count())
            ->sortDesc()
            ->take(6);

        $topCustomers = Incident::with('customer')
            ->get()
            ->groupBy(fn ($incident) => $incident->customer?->name ?? 'Unknown Customer')
            ->map(fn ($items) => $items->count())
            ->sortDesc()
            ->take(8);

        $engineerPerformance = Task::with('assignee')
            ->whereNotNull('assigned_to')
            ->get()
            ->groupBy(fn ($task) => $task->assignee?->name ?? 'Unassigned')
            ->map(function ($tasks) {
                $total = $tasks->count();
                $completed = $tasks->whereIn('status', ['completed', 'closed'])->count();

                return [
                    'total' => $total,
                    'completed' => $completed,
                    'rate' => $total > 0 ? round(($completed / $total) * 100, 1) : 0,
                ];
            })
            ->sortByDesc('total')
            ->take(8);

        $criticalOpenIncidents = Incident::with(['customer', 'branch'])
            ->whereIn('status', ['open', 'assigned'])
            ->whereIn('severity', ['critical', 'high'])
            ->latest()
            ->limit(8)
            ->get();

        $upcomingPm = PreventiveExecution::with(['task.customer', 'task.branch', 'engineer', 'preventiveSchedule'])
            ->whereIn('status', ['not_done', 'document_on_progress', 'pending', 'in_progress'])
            ->latest()
            ->limit(8)
            ->get();

        $monthlyIncidents = Incident::where('created_at', '>=', $monthStart)->count();
        $monthlyResolved = Incident::whereIn('status', ['resolved', 'closed'])
            ->where('updated_at', '>=', $monthStart)
            ->count();

        return view('executive.dashboard', compact(
            'totalCustomers',
            'totalAssets',
            'openIncidents',
            'criticalIncidents',
            'openChanges',
            'openTasks',
            'pmCompliance',
            'slaCompliance',
            'lowStock',
            'incidentTrend',
            'incidentCategory',
            'topCustomers',
            'engineerPerformance',
            'criticalOpenIncidents',
            'upcomingPm',
            'monthlyIncidents',
            'monthlyResolved'
        ));
    }
}
