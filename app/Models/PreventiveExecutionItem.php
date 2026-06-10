<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreventiveExecutionItem extends Model
{
    protected $fillable = [
        'preventive_execution_id',
        'checklist_template_item_id',
        'result',
        'value_text',
        'remarks',
        'photo_path',
    ];

    public function execution(): BelongsTo
    {
        return $this->belongsTo(
            PreventiveExecution::class
        );
    }

    public function checklistItem(): BelongsTo
    {
        return $this->belongsTo(
            ChecklistTemplateItem::class,
            'checklist_template_item_id'
        );
    }
}
