<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\FormRepositoryInterface;

final class ListFormsUseCase
{
    public function __construct(private FormRepositoryInterface $repository)
    {
    }

    public function execute(): array
    {
        return $this->repository->all();
    }
}
