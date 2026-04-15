<?php

namespace App\Domain\Field\Handlers;

use App\Domain\Entities\Field;
use App\Domain\Field\FieldHandlerInterface;

final class NumberFieldHandler implements FieldHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === Field::TYPE_NUMBER;
    }

    public function validate(mixed $value, Field $field): bool
    {
        if ($value === null) {
            return ! $field->required();
        }

        return is_int($value) || is_float($value) || (is_string($value) && is_numeric($value));
    }

    public function transform(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        if (is_numeric($value)) {
            return strpos((string) $value, '.') !== false ? (float) $value : (int) $value;
        }

        return null;
    }
}
