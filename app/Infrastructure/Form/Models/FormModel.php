<?php

namespace App\Infrastructure\Form\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class FormModel extends Model
{
    protected $table = 'forms';

    protected $fillable = ['title', 'status'];

    public function fields(): HasMany
    {
        return $this->hasMany(FieldModel::class, 'form_id');
    }
}
