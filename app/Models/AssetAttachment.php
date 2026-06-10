<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetAttachment extends Model
{
    protected $fillable = [
        'asset_id',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'attachment_type',
        'uploaded_by',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
