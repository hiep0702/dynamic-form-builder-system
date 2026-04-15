<?php

namespace App\Domain\Submission\Repositories;

use App\Domain\Submission\Entities\Submission;

interface SubmissionRepositoryInterface
{
    public function save(Submission $submission): Submission;
}
