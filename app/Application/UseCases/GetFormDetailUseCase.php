<?php

namespace App\Application\UseCases;

use App\Domain\Exceptions\FormNotFoundException;
use App\Domain\Repositories\FormRepositoryInterface;

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
