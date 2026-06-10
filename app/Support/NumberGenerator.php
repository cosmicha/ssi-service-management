<?php

namespace App\Support;

class NumberGenerator
{
    public static function generate(string $prefix): string
    {
        $year = now()->format('y');

        do {

            $random = strtoupper(substr(
                str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'),
                0,
                4
            ));

            $number = "{$prefix}-{$random}-{$year}";

        } while (
            \App\Models\Task::where('task_no', $number)->exists()
        );

        return $number;
    }
}
