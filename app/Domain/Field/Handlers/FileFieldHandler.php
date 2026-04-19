<?php

namespace App\Domain\Field\Handlers;

use App\Domain\Form\Entities\Field;
use App\Domain\Field\FieldHandlerInterface;

final class FileFieldHandler implements FieldHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === Field::TYPE_FILE;
    }

    public function validate(mixed $value, Field $field): bool
    {
        if ($value === null) {
            return ! $field->required();
        }

        // Assume $value is an uploaded file array or path
        // Basic validation for file type and size
        $allowedTypes = $field->properties()['allowedTypes'] ?? [];
        $maxSizeMB = $field->properties()['maxSizeMB'] ?? null;

        if (is_array($value) && isset($value['type'], $value['size'])) {
            $fileType = $value['type'];
            $fileSizeMB = $value['size'] / (1024 * 1024);

            if (!empty($allowedTypes) && !in_array($fileType, $allowedTypes)) {
                return false;
            }

            if ($maxSizeMB !== null && $fileSizeMB > $maxSizeMB) {
                return false;
            }

            return true;
        }

        return false;
    }

    public function transform(mixed $value): mixed
    {
        return $value; // Could return file path or processed data
    }
}