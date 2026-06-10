<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidentUpdateAttachment extends Model
{
    protected $fillable = [
        'incident_update_id',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    public function incidentUpdate()
    {
        return $this->belongsTo(IncidentUpdate::class, 'incident_update_id');
    }
}
