<?php

namespace App\Infrastructure\Form\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class FieldModel extends Model
{
    protected $table = 'fields';

    protected $fillable = ['form_id', 'type', 'required', 'label', 'default_value', 'validation_rules', 'properties'];

    protected $casts = [
        'required' => 'boolean',
        'default_value' => 'json',
        'validation_rules' => 'json',
        'properties' => 'json',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(FormModel::class, 'form_id');
    }
}
