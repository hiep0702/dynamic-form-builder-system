<?php

namespace App\Infrastructure\Form\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class FormModel extends Model
{
    protected $table = 'forms';

    protected $fillable = ['title', 'description', 'status', 'schema_version'];

    protected $casts = [
        'schema_version' => 'integer',
    ];

    public function fields(): HasMany
    {
        return $this->hasMany(FieldModel::class, 'form_id');
    }
}
