<?php

namespace App\Application\Submission\UseCases;

use App\Domain\Submission\Entities\Submission;
use App\Domain\Submission\Repositories\SubmissionRepositoryInterface;
use App\Domain\Exceptions\FormNotFoundException;

final class GetSubmissionDetailUseCase
{
    public function __construct(private SubmissionRepositoryInterface $repository)
    {
    }

    public function execute(int $id): Submission
    {
        $submission = $this->repository->find($id);

        if (!$submission) {
            throw new FormNotFoundException("Submission with id {$id} not found");
        }

        return $submission;
    }
}