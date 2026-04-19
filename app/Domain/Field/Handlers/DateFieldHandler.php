<?php

namespace App\Domain\Field\Handlers;

use App\Domain\Form\Entities\Field;
use App\Domain\Field\FieldHandlerInterface;

final class DateFieldHandler implements FieldHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === Field::TYPE_DATE;
    }

    public function validate(mixed $value, Field $field): bool
    {
        if ($value === null) {
            return ! $field->required();
        }

        if (!is_string($value)) {
            return false;
        }

        $dateTime = \DateTime::createFromFormat($field->properties()['format'] ?? 'Y-m-d', $value);
        if (!$dateTime) {
            return false;
        }

        $minDate = $field->properties()['minDate'] ?? null;
        $maxDate = $field->properties()['maxDate'] ?? null;

        if ($minDate && $dateTime < new \DateTime($minDate)) {
            return false;
        }
        if ($maxDate && $dateTime > new \DateTime($maxDate)) {
            return false;
        }

        return true;
    }

    public function transform(mixed $value): mixed
    {
        return $value === null ? null : new \DateTime($value);
    }
}
