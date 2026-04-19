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

        $fields = $form->fields();
        $updatedFields = array_map(function (Field $field) use ($fieldId, $fieldData) {
            if ($field->id() === $fieldId) {
                return Field::fromArray(array_merge($field->toArray(), $fieldData, ['id' => $fieldId]));
            }
            return $field;
        }, $fields);

        $updatedForm = new Form(
            $form->id(),
            $form->title(),
            $form->status(),
            $updatedFields
        );

        return $this->repository->save($updatedForm);
    }
}