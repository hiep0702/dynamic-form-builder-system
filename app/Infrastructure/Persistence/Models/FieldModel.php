<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class FieldModel extends Model
{
    protected $table = 'fields';

    protected $fillable = ['form_id', 'type', 'required'];

    protected $casts = [
        'required' => 'boolean',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(FormModel::class, 'form_id');
    }
}
