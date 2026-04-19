<?php

namespace App\Application\Form\UseCases;

use App\Domain\Form\Repositories\FormRepositoryInterface;
use App\Domain\Exceptions\FormNotFoundException;

final class DeleteFormUseCase
{
    public function __construct(private FormRepositoryInterface $repository)
    {
    }

    public function execute(int $id): void
    {
        $form = $this->repository->find($id);
        if (!$form) {
            throw new FormNotFoundException("Form with id {$id} not found");
        }

        $this->repository->delete($id);
    }
}