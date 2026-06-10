<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'company_name',
        'app_name',
        'logo_path',
    ];

    public static function current(): self
    {
        return self::firstOrCreate([
            'id' => 1,
        ], [
            'company_name' => 'PT Sinergi Solusi Informatika',
            'app_name' => 'Operations Control System',
        ]);
    }
}
