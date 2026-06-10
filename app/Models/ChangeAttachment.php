<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChangeAttachment extends Model
{
    protected $fillable = [
        'change_request_id',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'attachment_type',
        'uploaded_by',
    ];

    public function changeRequest(): BelongsTo
    {
        return $this->belongsTo(ChangeRequest::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
