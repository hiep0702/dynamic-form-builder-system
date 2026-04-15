<?php

namespace App\Domain\Field\Handlers;

use App\Domain\Form\Entities\Field;
use App\Domain\Field\FieldHandlerInterface;

final class BooleanFieldHandler implements FieldHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === Field::TYPE_BOOLEAN;
    }

    public function validate(mixed $value, Field $field): bool
    {
        if ($value === null) {
            return ! $field->required();
        }

        return is_bool($value);
    }

    public function transform(mixed $value): mixed
    {
        return $value === null ? null : (bool) $value;
    }
}
