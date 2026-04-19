<?php

namespace App\Application\Form\UseCases;

use App\Domain\Form\Entities\Form;
use App\Domain\Form\Repositories\FormRepositoryInterface;
use App\Domain\Exceptions\FormNotFoundException;

final class GetActiveFormDetailUseCase
{
    public function __construct(private FormRepositoryInterface $repository)
    {
    }

    public function execute(int $id): Form
    {
        $form = $this->repository->find($id);

        if (!$form || $form->status() !== 'active') {
            throw new FormNotFoundException("Active form with id {$id} not found");
        }

        return $form;
    }
}