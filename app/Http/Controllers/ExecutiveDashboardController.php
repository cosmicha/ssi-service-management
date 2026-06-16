<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Customer;
use App\Models\Incident;
use App\Models\Task;
use App\Models\InventoryItem;
use App\Models\PreventiveExecution;
use Illuminate\Support\Facades\DB;

class ExecutiveDashboardController extends Controller
{
    public function index()
    {
        $customerId = request('customer_id');

        $customers =
            Customer::orderBy('name')
                ->get();

        $user = auth()->user();

        $assetQuery =
            Asset::visibleTo($user);

        $incidentQuery =
            Incident::visibleTo($user);

        $taskQuery =
            Task::visibleTo($user);

        if ($customerId) {
            $assetQuery->where('customer_id', $customerId);
            $incidentQuery->where('customer_id', $customerId);
            $taskQuery->where('customer_id', $customerId);
        }

        $assets = (clone $assetQuery)->count();

        $openIncidents =
            (clone $incidentQuery)
                ->whereNotIn(
                    'status',
                    ['resolved','closed']
                )->count();

        $openTasks =
            (clone $taskQuery)
                ->whereNotIn(
                    'status',
                    ['completed','closed']
                )->count();

        $pmTotal = PreventiveExecution::count();

        $pmDone =
            PreventiveExecution::where(
                'status',
                'completed'
            )->count();

        $pmCompliance =
            $pmTotal > 0
                ? round(($pmDone / $pmTotal) * 100, 1)
                : 100;

        $totalIncidents =
            (clone $incidentQuery)->count();

        $slaAchievement =
            $totalIncidents
            ? round(
                (
                    clone $incidentQuery
                )->where(
                    'resolution_sla_status',
                    'met'
                )->count()
                /
                $totalIncidents
                * 100,
                1
            )
            : 100;

        $inventoryValue = 0;

        $incidentTrend =
            (clone $incidentQuery)->selectRaw("strftime('%m', created_at) as month, count(*) as total")
                ->groupBy('month')
                ->orderBy('month')
                ->get();

        $incidentCategory =
            (clone $incidentQuery)->with('category')
                ->get()
                ->groupBy(fn($incident) => $incident->category?->name ?? 'Uncategorized')
                ->map(fn($items) => $items->count());

        $topAssets =
            (clone $incidentQuery)->with('asset')
                ->whereNotNull('asset_id')
                ->get()
                ->groupBy(fn($incident) => $incident->asset?->name ?? 'Unknown Asset')
                ->map(fn($items) => $items->count())
                ->sortDesc()
                ->take(5);

        $engineerPerformance =
            (clone $taskQuery)->with('assignee')
                ->whereNotNull('assigned_to')
                ->get()
                ->groupBy(fn($task) => $task->assignee?->name ?? 'Unassigned')
                ->map(function ($tasks) {
                    $total = $tasks->count();
                    $completed = $tasks->where('status', 'completed')->count();

                    return $total > 0
                        ? round(($completed / $total) * 100, 1)
                        : 0;
                })
                ->sortDesc()
                ->take(5);

        
        $criticalIncidents =
            (clone $incidentQuery)->with([
                'customer',
                'branch',
                'asset'
            ])
            ->whereIn('severity', ['high','critical'])
            ->whereNotIn('status', ['resolved','closed'])
            ->latest()
            ->take(10)
            ->get();


        $mttaMinutes =
            Incident::whereNotNull('reported_at')
                ->whereNotNull('responded_at')
                ->get()
                ->avg(fn($i) =>
                    $i->reported_at->diffInMinutes($i->responded_at)
                ) ?? 0;

        $mttrMinutes =
            Incident::whereNotNull('reported_at')
                ->whereNotNull('resolved_at')
                ->get()
                ->avg(fn($i) =>
                    $i->reported_at->diffInMinutes($i->resolved_at)
                ) ?? 0;

        $mtta =
            $mttaMinutes >= 60
                ? round($mttaMinutes / 60, 1) . 'h'
                : round($mttaMinutes) . 'm';

        $mttr =
            $mttrMinutes >= 60
                ? round($mttrMinutes / 60, 1) . 'h'
                : round($mttrMinutes) . 'm';


        $customerRanking =
            (clone $incidentQuery)->with('customer')
                ->get()
                ->groupBy(fn($incident) =>
                    $incident->customer?->name ?? 'Unknown Customer'
                )
                ->map(fn($items) => $items->count())
                ->sortDesc()
                ->take(5);

        $branchRanking =
            (clone $incidentQuery)->with('branch')
                ->get()
                ->groupBy(fn($incident) =>
                    $incident->branch?->name ?? 'Unknown Site'
                )
                ->map(fn($items) => $items->count())
                ->sortDesc()
                ->take(5);


return view(
            'executive.dashboard',
            compact(
                'assets',
                'openIncidents',
                'openTasks',
                'pmCompliance',
                'slaAchievement',
                'inventoryValue',
                'incidentTrend',
                'incidentCategory',
                'topAssets',
                'engineerPerformance',
                'criticalIncidents',
                'mtta',
                'mttr',
                'customerRanking',
                'branchRanking',
                'customers',
                'customerId'
            )
        );
    }
}
