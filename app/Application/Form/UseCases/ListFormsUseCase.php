<?php

namespace App\Application\Form\UseCases;

use App\Domain\Form\Repositories\FormRepositoryInterface;

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
