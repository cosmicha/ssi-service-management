<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\ChangeRequest;
use App\Models\Incident;
use App\Models\PreventiveExecution;
use App\Models\Task;

class CustomerPortalV2Controller extends Controller
{
    public function dashboard()
    {
        $customerId = auth()->user()?->customer_id;

        $assets = Asset::where('customer_id', $customerId)->count();

        $openIncidents = Incident::where('customer_id', $customerId)
            ->whereIn('status', ['open','assigned','in_progress'])
            ->count();

        $openChanges = ChangeRequest::where('customer_id', $customerId)
            ->whereIn('status', ['open','assigned','in_progress'])
            ->count();

        $tasks = Task::with(['asset','branch'])
            ->where('customer_id', $customerId)
            ->latest()
            ->limit(10)
            ->get();

        $incidents = Incident::with(['branch','category'])
            ->where('customer_id', $customerId)
            ->latest()
            ->limit(10)
            ->get();

        return view('customer-portal.v2.dashboard', compact(
            'assets','openIncidents','openChanges','tasks','incidents'
        ));
    }

    public function assets()
    {
        $customerId = auth()->user()?->customer_id;

        $items = Asset::with(['branch','category'])
            ->where('customer_id', $customerId)
            ->orderBy('name')
            ->paginate(20);

        return view('customer-portal.v2.assets', compact('items'));
    }

    public function tickets()
    {
        $customerId = auth()->user()?->customer_id;

        $items = Incident::with(['branch','category'])
            ->where('customer_id', $customerId)
            ->latest()
            ->paginate(20);

        return view('customer-portal.v2.tickets', compact('items'));
    }
}
