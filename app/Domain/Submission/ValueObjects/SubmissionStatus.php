<?php

namespace App\Domain\Submission\ValueObjects;

enum SubmissionStatus: string
{
    case QUEUED = 'queued';
    case PROCESSED = 'processed';
    case FAILED = 'failed';
}