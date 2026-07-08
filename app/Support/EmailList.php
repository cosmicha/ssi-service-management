<?php

namespace App\Support;

class EmailList
{
    public static function parse(?string $value): array
    {
        if (!$value) {
            return [];
        }

        return collect(preg_split('/[\s,;]+/', $value))
            ->map(fn ($email) => trim($email))
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values()
            ->all();
    }
}
