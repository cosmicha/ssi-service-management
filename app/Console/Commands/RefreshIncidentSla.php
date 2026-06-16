<?php

namespace App\Console\Commands;

use App\Models\Incident;
use App\Services\SlaService;
use Illuminate\Console\Command;

class RefreshIncidentSla extends Command
{
    protected $signature = 'sla:refresh-incidents {--apply-missing : Apply SLA matrix to incidents without due dates}';

    protected $description = 'Refresh SLA status for all incidents';

    public function handle(SlaService $slaService): int
    {
        $count = 0;

        Incident::query()
            ->orderBy('id')
            ->chunkById(100, function ($incidents) use ($slaService, &$count) {
                foreach ($incidents as $incident) {
                    if (
                        $this->option('apply-missing') &&
                        (!$incident->response_due_at || !$incident->resolution_due_at)
                    ) {
                        $slaService->applyToIncident($incident);
                    } else {
                        $slaService->refreshStatus($incident);
                    }

                    $count++;
                }
            });

        $this->info("SLA refreshed for {$count} incidents.");

        return self::SUCCESS;
    }
}
