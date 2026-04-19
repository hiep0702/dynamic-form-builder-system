<?php

namespace App\Domain\Field\Handlers;

use App\Domain\Form\Entities\Field;
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

        if (!is_int($value) && !is_float($value) && !(is_string($value) && is_numeric($value))) {
            return false;
        }

        $numValue = (float) $value;
        $min = $field->properties()['min'] ?? null;
        $max = $field->properties()['max'] ?? null;
        $step = $field->properties()['step'] ?? null;

        if ($min !== null && $numValue < $min) {
            return false;
        }
        if ($max !== null && $numValue > $max) {
            return false;
        }
        if ($step !== null && fmod($numValue - ($min ?? 0), $step) != 0) {
            return false;
        }

        return true;
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
