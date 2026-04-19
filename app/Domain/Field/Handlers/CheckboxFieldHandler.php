<?php

namespace App\Domain\Field\Handlers;

use App\Domain\Form\Entities\Field;
use App\Domain\Field\FieldHandlerInterface;

final class CheckboxFieldHandler implements FieldHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === Field::TYPE_CHECKBOX;
    }

    public function validate(mixed $value, Field $field): bool
    {
        if ($value === null) {
            return ! $field->required();
        }

        // For checkbox, value can be array of selected options or boolean for single
        if (is_array($value)) {
            $options = $field->properties()['options'] ?? [];
            $minSelect = $field->properties()['minSelect'] ?? 0;
            $maxSelect = $field->properties()['maxSelect'] ?? count($options);
            $count = count($value);
            return $count >= $minSelect && $count <= $maxSelect && array_diff($value, $options) === [];
        }

        return is_bool($value);
    }

    public function transform(mixed $value): mixed
    {
        if (is_array($value)) {
            return $value;
        }
        return $value === null ? null : (bool) $value;
    }
}
