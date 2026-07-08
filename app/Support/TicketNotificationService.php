<?php

namespace App\Support;

use App\Mail\TicketEventMail;
use App\Models\ProblemLog;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TicketNotificationService
{
    public static function recipients(ProblemLog $problemLog): array
    {
        $emails = [];

        if ($problemLog->company && method_exists($problemLog->company, 'notificationEmailList')) {
            $emails = array_merge($emails, $problemLog->company->notificationEmailList());
        }

        if (method_exists($problemLog, 'customer') && $problemLog->customer && method_exists($problemLog->customer, 'notificationEmailList')) {
            $emails = array_merge($emails, $problemLog->customer->notificationEmailList());
        }

        if ($problemLog->assignedEngineer && $problemLog->assignedEngineer->email) {
            $emails[] = $problemLog->assignedEngineer->email;
        }

        $adminEmails = User::where('role', 'admin')
            ->whereNotNull('email')
            ->pluck('email')
            ->all();

        $emails = array_merge($emails, $adminEmails);

        if ($problemLog->createdByUser && $problemLog->createdByUser->email) {
            $emails[] = $problemLog->createdByUser->email;
        }

        return collect($emails)
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    public static function send(ProblemLog $problemLog, string $title, string $message): void
    {
        $problemLog->loadMissing(['company', 'assignedEngineer', 'createdByUser']);

        $recipients = self::recipients($problemLog);

        if (empty($recipients)) {
            return;
        }

        try {
            Mail::to($recipients)->send(new TicketEventMail($problemLog, $title, $message));
        } catch (\Throwable $e) {
            Log::error('Ticket email notification failed', [
                'ticket_id' => $problemLog->id,
                'title' => $title,
                'recipients' => $recipients,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
