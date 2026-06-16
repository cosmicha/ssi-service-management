<?php

namespace App\Services;

use App\Models\CustomerSla;
use App\Models\Incident;
use Carbon\Carbon;

class SlaService
{
    public function applyToIncident(Incident $incident): Incident
    {
        $severity = $incident->severity ?? 'medium';

        $sla = CustomerSla::where('customer_id', $incident->customer_id)
            ->where('severity', $severity)
            ->where('is_active', true)
            ->first();

        if (!$sla) {
            $incident->update([
                'sla_status' => 'no_sla',
                'response_sla_status' => 'no_sla',
                'resolution_sla_status' => 'no_sla',
                'response_due_at' => null,
                'resolution_due_at' => null,
            ]);

            return $incident->refresh();
        }

        $createdAt = $incident->reported_at ?? $incident->created_at ?? now();

        $incident->update([
            'response_due_at' => $sla->response_minutes
                ? Carbon::parse($createdAt)->copy()->addMinutes($sla->response_minutes)
                : null,

            'resolution_due_at' => $sla->resolution_minutes
                ? Carbon::parse($createdAt)->copy()->addMinutes($sla->resolution_minutes)
                : null,

            'sla_status' => 'on_track',
            'response_sla_status' => 'on_track',
            'resolution_sla_status' => 'on_track',
        ]);

        return $this->refreshStatus($incident->refresh());
    }

    public function refreshStatus(Incident $incident): Incident
    {
        if (($incident->sla_status ?? null) === 'no_sla') {
            return $incident;
        }

        $now = now();

        $responseStatus = $this->calculateSingleStatus(
            dueAt: $incident->response_due_at,
            completedAt: $incident->responded_at,
            now: $now
        );

        $resolutionStatus = $this->calculateSingleStatus(
            dueAt: $incident->resolution_due_at,
            completedAt: $incident->resolved_at,
            now: $now
        );

        $overall = 'on_track';

        if ($responseStatus === 'breached' || $resolutionStatus === 'breached') {
            $overall = 'breached';
        } elseif ($responseStatus === 'near_breach' || $resolutionStatus === 'near_breach') {
            $overall = 'near_breach';
        } elseif (
            in_array($responseStatus, ['met', 'no_sla']) &&
            in_array($resolutionStatus, ['met', 'no_sla'])
        ) {
            $overall = 'met';
        }

        $incident->update([
            'response_sla_status' => $responseStatus,
            'resolution_sla_status' => $resolutionStatus,
            'sla_status' => $overall,
            'sla_breached_at' => $overall === 'breached'
                ? ($incident->sla_breached_at ?? now())
                : $incident->sla_breached_at,
        ]);

        return $incident->refresh();
    }

    private function calculateSingleStatus($dueAt, $completedAt, Carbon $now): string
    {
        if (!$dueAt) {
            return 'no_sla';
        }

        $due = Carbon::parse($dueAt);

        if ($completedAt) {
            return Carbon::parse($completedAt)->lte($due) ? 'met' : 'breached';
        }

        if ($now->gt($due)) {
            return 'breached';
        }

        $totalMinutesLeft = $now->diffInMinutes($due, false);

        if ($totalMinutesLeft <= 60) {
            return 'near_breach';
        }

        return 'on_track';
    }

    public function markResponded(Incident $incident): Incident
    {
        if (!$incident->responded_at) {
            $incident->update([
                'responded_at' => now(),
            ]);
        }

        return $this->refreshStatus($incident->refresh());
    }

    public function markResolved(Incident $incident): Incident
    {
        if (!$incident->resolved_at) {
            $incident->update([
                'resolved_at' => now(),
            ]);
        }

        return $this->refreshStatus($incident->refresh());
    }
}
