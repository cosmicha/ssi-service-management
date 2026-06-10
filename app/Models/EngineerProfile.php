<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EngineerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'employee_no',
        'phone',
        'skill_level',
        'home_base',
        'is_active',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
