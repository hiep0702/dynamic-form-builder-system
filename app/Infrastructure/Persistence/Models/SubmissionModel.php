<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

final class SubmissionModel extends Model
{
    protected $table = 'submissions';

    protected $fillable = ['form_id', 'payload'];

    protected $casts = [
        'payload' => 'array',
    ];
}
