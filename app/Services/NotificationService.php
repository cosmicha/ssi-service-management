<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public static function send(
        string $subject,
        string $message,
        ?string $to = null,
        ?string $buttonUrl = null,
        string $buttonText = 'Open Service Portal'
    ): void
    {
        $recipient =
            $to
            ?? env('SSI_NOTIFICATION_EMAIL');

        $button = '';

        if ($buttonUrl) {
            $button = '
                <div style="margin-top:22px;">
                    <a href="' . e($buttonUrl) . '"
                       style="
                        background:#ff8a00;
                        color:#111827;
                        text-decoration:none;
                        padding:13px 20px;
                        border-radius:10px;
                        display:inline-block;
                        font-weight:800;
                       ">
                        ' . e($buttonText) . '
                    </a>
                </div>';
        }

        $html = '
        <div style="
            font-family:Arial,sans-serif;
            background:#f8fafc;
            padding:32px;
        ">
            <div style="
                max-width:720px;
                margin:auto;
                background:#ffffff;
                border-radius:20px;
                overflow:hidden;
                box-shadow:0 8px 26px rgba(15,23,42,.10);
                border:1px solid #e2e8f0;
            ">

                <div style="
                    background:#020617;
                    color:#ffffff;
                    padding:26px 30px;
                ">
                    <div style="
                        font-size:13px;
                        letter-spacing:1.5px;
                        text-transform:uppercase;
                        color:#ff8a00;
                        font-weight:800;
                    ">
                        Service Notification
                    </div>

                    <div style="
                        font-size:24px;
                        font-weight:900;
                        margin-top:6px;
                    ">
                        SSI Service Management
                    </div>
                </div>

                <div style="padding:28px 30px;">

                    <div style="
                        font-size:18px;
                        font-weight:900;
                        color:#0f172a;
                        margin-bottom:16px;
                    ">
                        ' . e($subject) . '
                    </div>

                    <div style="
                        background:#f8fafc;
                        border:1px solid #e2e8f0;
                        border-radius:16px;
                        padding:20px;
                        line-height:1.75;
                        font-size:14px;
                        color:#0f172a;
                    ">
                        ' . nl2br(e($message)) . '
                    </div>

                    ' . $button . '

                </div>

                <div style="
                    padding:18px 30px;
                    background:#f1f5f9;
                    font-size:12px;
                    color:#64748b;
                ">
                    PT Sinergi Solusi Informatika<br>
                    This is an automated notification. Please do not reply directly to this email.
                </div>

            </div>
        </div>';

        Mail::html(
            $html,
            function ($mail) use (
                $recipient,
                $subject
            ) {
                $mail->to($recipient)
                     ->subject($subject);
            }
        );
    }

    public static function sendTaskAssigned($task): void
    {
        if (
            !$task->assignee ||
            !$task->assignee->email
        ) {
            return;
        }

        $message =
            "Task Assigned\n\n" .
            "Task No: " . ($task->task_no ?? '-') . "\n" .
            "Title: " . ($task->title ?? '-') . "\n" .
            "Customer: " . ($task->customer?->name ?? '-') . "\n" .
            "Asset: " . ($task->asset?->name ?? '-') . "\n" .
            "Priority: " . ($task->priority ?? '-') . "\n" .
            "Status: " . ($task->status ?? '-') . "\n";

        self::send(
            '[SSI] Task Assigned - ' . ($task->task_no ?? ''),
            $message,
            $task->assignee->email,
            url('/tasks/' . $task->id),
            'Open Task'
        );
    }
}
