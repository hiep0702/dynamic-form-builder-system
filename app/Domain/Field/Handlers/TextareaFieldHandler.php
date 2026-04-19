<?php

namespace App\Domain\Field\Handlers;

use App\Domain\Form\Entities\Field;
use App\Domain\Field\FieldHandlerInterface;

final class TextareaFieldHandler implements FieldHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === Field::TYPE_TEXTAREA;
    }

    public function validate(mixed $value, Field $field): bool
    {
        if ($value === null) {
            return ! $field->required();
        }

        if (!is_string($value)) {
            return false;
        }

        $maxLength = $field->properties()['maxLength'] ?? null;
        if ($maxLength !== null && strlen($value) > $maxLength) {
            return false;
        }

        return true;
    }

    public function transform(mixed $value): mixed
    {
        return $value;
    }
}