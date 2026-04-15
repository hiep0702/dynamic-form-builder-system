<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Submission;

interface SubmissionRepositoryInterface
{
    public function save(Submission $submission): Submission;
}
