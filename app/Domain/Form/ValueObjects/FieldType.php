<?php

namespace App\Domain\Form\ValueObjects;

use App\Domain\Exceptions\DomainValidationException;

final class FieldType
{
    public const TEXT = 'text';
    public const NUMBER = 'number';
    public const DATE = 'date';
    public const SELECT = 'select';
    public const CHECKBOX = 'checkbox';
    public const TEXTAREA = 'textarea';
    public const FILE = 'file';

    private function __construct(private string $value)
    {
    }

    public static function fromString(string $value): self
    {
        $allowed = [
            self::TEXT,
            self::NUMBER,
            self::DATE,
            self::SELECT,
            self::CHECKBOX,
            self::TEXTAREA,
            self::FILE,
        ];

        if (!in_array($value, $allowed, true)) {
            throw new DomainValidationException(['type' => 'Invalid field type.']);
        }

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
