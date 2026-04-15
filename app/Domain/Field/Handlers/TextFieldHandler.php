<?php

namespace App\Domain\Field\Handlers;

use App\Domain\Entities\Field;
use App\Domain\Field\FieldHandlerInterface;

final class TextFieldHandler implements FieldHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === Field::TYPE_TEXT;
    }

    public function validate(mixed $value, Field $field): bool
    {
        if ($value === null) {
            return ! $field->required();
        }

        return is_string($value);
    }

    public function transform(mixed $value): mixed
    {
        return $value === null ? null : trim((string) $value);
    }
}
