<?php

namespace App\Application\Form\UseCases;

use App\Domain\Exceptions\FormNotFoundException;
use App\Domain\Form\Repositories\FormRepositoryInterface;

final class GetFormDetailUseCase
{
    public function __construct(private FormRepositoryInterface $repository)
    {
    }

    public function execute(int $id)
    {
        $form = $this->repository->find($id);

        if ($form === null) {
            throw new FormNotFoundException('Form not found.');
        }

        return $form;
    }
}
