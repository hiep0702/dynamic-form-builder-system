<?php

namespace App\Domain\Field;

use App\Domain\Form\Entities\Field;

interface FieldHandlerInterface
{
    public function supports(string $type): bool;

    public function validate(mixed $value, Field $field): bool;

    public function transform(mixed $value): mixed;
}
