<?php

namespace App\Application\Form\UseCases;

use App\Domain\Form\Entities\Field;
use App\Domain\Form\Entities\Form;
use App\Domain\Form\Repositories\FormRepositoryInterface;
use App\Domain\Exceptions\FormNotFoundException;

final class UpdateFieldUseCase
{
    public function __construct(private FormRepositoryInterface $repository)
    {
    }

    public function execute(int $formId, int $fieldId, array $fieldData): Form
    {
        $form = $this->repository->find($formId);
        if (!$form) {
            throw new FormNotFoundException("Form with id {$formId} not found");
        }

        $field = Field::fromArray(array_merge($fieldData, ['id' => $fieldId]));
        $updatedForm = $form->updateField($fieldId, $field);

        return $this->repository->save($updatedForm);
    }
}