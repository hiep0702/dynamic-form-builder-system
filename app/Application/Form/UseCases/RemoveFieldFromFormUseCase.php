<?php

namespace App\Application\Form\UseCases;

use App\Domain\Form\Entities\Form;
use App\Domain\Form\Repositories\FormRepositoryInterface;
use App\Domain\Exceptions\FormNotFoundException;

final class RemoveFieldFromFormUseCase
{
    public function __construct(private FormRepositoryInterface $repository)
    {
    }

    public function execute(int $formId, int $fieldId): Form
    {
        $form = $this->repository->find($formId);
        if (!$form) {
            throw new FormNotFoundException("Form with id {$formId} not found");
        }

        $fields = array_filter($form->fields(), fn($field) => $field->id() !== $fieldId);

        $updatedForm = new Form(
            $form->id(),
            $form->title(),
            $form->status(),
            array_values($fields)
        );

        return $this->repository->save($updatedForm);
    }
}