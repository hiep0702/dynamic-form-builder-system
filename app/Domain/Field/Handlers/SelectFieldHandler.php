<?php

namespace App\Domain\Field\Handlers;

use App\Domain\Form\Entities\Field;
use App\Domain\Field\FieldHandlerInterface;

final class SelectFieldHandler implements FieldHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === Field::TYPE_SELECT;
    }

    public function validate(mixed $value, Field $field): bool
    {
        if ($value === null) {
            return ! $field->required();
        }

        $options = $field->properties()['options'] ?? [];
        return in_array($value, $options, true);
    }

    public function transform(mixed $value): mixed
    {
        return $value;
    }
}