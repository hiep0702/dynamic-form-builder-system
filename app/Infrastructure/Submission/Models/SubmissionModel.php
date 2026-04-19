<?php

namespace App\Infrastructure\Submission\Models;

use Illuminate\Database\Eloquent\Model;

final class SubmissionModel extends Model
{
    protected $table = 'submissions';

    protected $fillable = ['form_id', 'payload', 'schema_version', 'schema_snapshot', 'status'];

    protected $casts = [
        'payload' => 'array',
        'schema_snapshot' => 'array',
        'status' => \App\Domain\Submission\ValueObjects\SubmissionStatus::class,
    ];
}
