<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidentUpdate extends Model
{
    protected $fillable = [
        'incident_id',
        'user_id',
        'update_type',
        'message',
        'old_status',
        'new_status',
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(IncidentUpdateAttachment::class);
    }
}
