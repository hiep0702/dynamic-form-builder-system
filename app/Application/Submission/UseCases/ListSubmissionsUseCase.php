<?php

namespace App\Application\Submission\UseCases;

use App\Domain\Submission\Repositories\SubmissionRepositoryInterface;

final class ListSubmissionsUseCase
{
    public function __construct(private SubmissionRepositoryInterface $repository)
    {
    }

    public function execute(): array
    {
        return $this->repository->all();
    }
}