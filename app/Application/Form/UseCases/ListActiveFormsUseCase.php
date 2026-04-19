<?php

namespace App\Application\Form\UseCases;

use App\Domain\Form\Repositories\FormRepositoryInterface;

final class ListActiveFormsUseCase
{
    public function __construct(private FormRepositoryInterface $repository)
    {
    }

    public function execute(): array
    {
        return $this->repository->findActive();
    }
}