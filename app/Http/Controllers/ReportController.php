<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\ChangeRequest;
use App\Models\Customer;
use App\Models\Incident;
use App\Models\PreventiveExecution;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index', [
            'customers' => Customer::orderBy('name')->get(),
        ]);
    }

    public function incidents(Request $request)
    {
        $query = Incident::with(['customer','branch','asset','category','task'])
            ->latest();

        $this->applyCommonFilters($query, $request);

        $items = $query->paginate(25)->withQueryString();

        return view('reports.incidents', [
            'items' => $items,
            'customers' => Customer::orderBy('name')->get(),
            'filters' => $request->all(),
        ]);
    }

    public function changes(Request $request)
    {
        $query = ChangeRequest::with(['customer','branch','asset','category','task'])
            ->latest();

        $this->applyCommonFilters($query, $request);

        $items = $query->paginate(25)->withQueryString();

        return view('reports.changes', [
            'items' => $items,
            'customers' => Customer::orderBy('name')->get(),
            'filters' => $request->all(),
        ]);
    }

    public function preventive(Request $request)
    {
        $query = PreventiveExecution::with(['task.customer','task.branch','task.asset','engineer','preventiveSchedule'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $items = $query->paginate(25)->withQueryString();

        return view('reports.preventive', [
            'items' => $items,
            'customers' => Customer::orderBy('name')->get(),
            'filters' => $request->all(),
        ]);
    }

    public function assets(Request $request)
    {
        $query = Asset::with(['customer','branch','category'])
            ->orderBy('name');

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $items = $query->paginate(25)->withQueryString();

        return view('reports.assets', [
            'items' => $items,
            'customers' => Customer::orderBy('name')->get(),
            'filters' => $request->all(),
        ]);
    }

    public function customers()
    {
        return view('reports.customers', [
            'items' => Customer::withCount(['branches','assets','incidents'])
                ->orderBy('name')
                ->paginate(25),
        ]);
    }

    public function export(Request $request, string $type): StreamedResponse
    {
        $filename = "ssi-{$type}-report-".now()->format('Ymd-His').".csv";

        return response()->streamDownload(function () use ($type, $request) {
            $out = fopen('php://output', 'w');

            match ($type) {
                'incidents' => $this->exportIncidents($out, $request),
                'changes' => $this->exportChanges($out, $request),
                'preventive' => $this->exportPreventive($out, $request),
                'assets' => $this->exportAssets($out, $request),
                'customers' => $this->exportCustomers($out),
                default => abort(404),
            };

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function applyCommonFilters($query, Request $request): void
    {
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
    }

    private function exportIncidents($out, Request $request): void
    {
        fputcsv($out, ['Ticket No','Title','Customer','Branch','Category','Severity','Status','Reported At','Created At']);

        $query = Incident::with(['customer','branch','category']);
        $this->applyCommonFilters($query, $request);

        $query->latest()->chunk(200, function ($items) use ($out) {
            foreach ($items as $i) {
                fputcsv($out, [
                    $i->incident_no ?? $i->ticket_no ?? $i->id,
                    $i->title,
                    $i->customer?->name,
                    $i->branch?->name,
                    $i->category?->name,
                    $i->severity,
                    $i->status,
                    $i->reported_at,
                    $i->created_at,
                ]);
            }
        });
    }

    private function exportChanges($out, Request $request): void
    {
        fputcsv($out, ['Change No','Title','Customer','Branch','Category','Severity','Status','Created At']);

        $query = ChangeRequest::with(['customer','branch','category']);
        $this->applyCommonFilters($query, $request);

        $query->latest()->chunk(200, function ($items) use ($out) {
            foreach ($items as $i) {
                fputcsv($out, [
                    $i->change_no ?? $i->id,
                    $i->title,
                    $i->customer?->name,
                    $i->branch?->name,
                    $i->category?->name,
                    $i->severity,
                    $i->status,
                    $i->created_at,
                ]);
            }
        });
    }

    private function exportPreventive($out, Request $request): void
    {
        fputcsv($out, ['PM No','Schedule','Engineer','Task','Customer','Branch','Status','Started At','Completed At']);

        PreventiveExecution::with(['preventiveSchedule','engineer','task.customer','task.branch'])
            ->latest()
            ->chunk(200, function ($items) use ($out) {
                foreach ($items as $i) {
                    fputcsv($out, [
                        $i->pm_no ?? $i->id,
                        $i->preventiveSchedule?->name,
                        $i->engineer?->name,
                        $i->task?->title,
                        $i->task?->customer?->name,
                        $i->task?->branch?->name,
                        $i->status,
                        $i->started_at,
                        $i->completed_at,
                    ]);
                }
            });
    }

    private function exportAssets($out, Request $request): void
    {
        fputcsv($out, ['Asset Code','Name','Customer','Branch','Category','Brand','Model','Serial','Status']);

        $query = Asset::with(['customer','branch','category']);

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $query->orderBy('name')->chunk(200, function ($items) use ($out) {
            foreach ($items as $i) {
                fputcsv($out, [
                    $i->asset_code,
                    $i->name,
                    $i->customer?->name,
                    $i->branch?->name,
                    $i->category?->name,
                    $i->brand,
                    $i->model,
                    $i->serial_number,
                    $i->status,
                ]);
            }
        });
    }

    private function exportCustomers($out): void
    {
        fputcsv($out, ['Code','Name','Industry','Contact Person','Email','Phone','Status']);

        Customer::orderBy('name')->chunk(200, function ($items) use ($out) {
            foreach ($items as $i) {
                fputcsv($out, [
                    $i->code,
                    $i->name,
                    $i->industry,
                    $i->contact_person,
                    $i->contact_email,
                    $i->contact_phone,
                    $i->status,
                ]);
            }
        });
    }
}
