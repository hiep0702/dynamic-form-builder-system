<?php

namespace App\Application\Form\UseCases;

use App\Domain\Form\Entities\Field;
use App\Domain\Form\Entities\Form;
use App\Domain\Form\Repositories\FormRepositoryInterface;
use App\Domain\Exceptions\FormNotFoundException;

final class AddFieldToFormUseCase
{
    public function __construct(private FormRepositoryInterface $repository)
    {
    }

    public function execute(int $formId, array $fieldData): Form
    {
        $form = $this->repository->find($formId);
        if (!$form) {
            throw new FormNotFoundException("Form with id {$formId} not found");
        }

        $field = Field::fromArray($fieldData);
        $fields = $form->fields();
        $fields[] = $field;

        $updatedForm = new Form(
            $form->id(),
            $form->title(),
            $form->status(),
            $fields
        );

        return $this->repository->save($updatedForm);
    }
}