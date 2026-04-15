<?php

namespace App\Application\Submission\UseCases;

use App\Domain\Submission\Entities\Submission;
use App\Domain\Form\Entities\Field;
use App\Domain\Exceptions\DomainValidationException;
use App\Domain\Exceptions\FormNotFoundException;
use App\Domain\Field\FieldHandlerRegistry;
use App\Domain\Form\Repositories\FormRepositoryInterface;
use App\Domain\Submission\Repositories\SubmissionRepositoryInterface;

final class SubmitFormUseCase
{
    public function __construct(
        private FormRepositoryInterface $formRepository,
        private SubmissionRepositoryInterface $submissionRepository,
        private FieldHandlerRegistry $fieldRegistry
    ) {
    }

    public function execute(int $formId, array $payload): Submission
    {
        $form = $this->formRepository->find($formId);

        if ($form === null) {
            throw new FormNotFoundException('Form not found.');
        }

        if ($form->status() !== 'active') {
            throw new DomainValidationException(['form' => ['Form is not active.']]);
        }

        $errors = [];
        $values = [];

        foreach ($form->fields() as $index => $field) {
            /** @var Field $field */
            $fieldKey = $field->id() ?? $index;
            $fieldValue = array_key_exists($fieldKey, $payload) ? $payload[$fieldKey] : null;

            if ($fieldValue === null && $field->required()) {
                $errors["field_{$fieldKey}"] = ['This field is required.'];
                continue;
            }

            $handler = $this->fieldRegistry->handlerFor($field->type());

            if (! $handler->validate($fieldValue, $field)) {
                $errors["field_{$fieldKey}"] = ["Value is not valid for field type {$field->type()}."];
                continue;
            }

            $values["field_{$fieldKey}"] = $handler->transform($fieldValue);
        }

        if (! empty($errors)) {
            throw new DomainValidationException($errors);
        }

        $submission = new Submission(null, $formId, $values, null);

        return $this->submissionRepository->save($submission);
    }
}
