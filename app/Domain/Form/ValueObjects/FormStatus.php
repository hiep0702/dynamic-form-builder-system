<?php

namespace App\Domain\Form\ValueObjects;

use App\Domain\Exceptions\DomainValidationException;

final class FormStatus
{
    public const DRAFT = 'draft';
    public const ACTIVE = 'active';
    public const ARCHIVED = 'archived';

    private function __construct(private string $value)
    {
    }

    public static function fromString(string $value): self
    {
        $allowed = [self::DRAFT, self::ACTIVE, self::ARCHIVED];

        if (!in_array($value, $allowed, true)) {
            throw new DomainValidationException(['status' => 'Invalid form status.']);
        }

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function isDraft(): bool
    {
        return $this->value === self::DRAFT;
    }

    public function isActive(): bool
    {
        return $this->value === self::ACTIVE;
    }

    public function isArchived(): bool
    {
        return $this->value === self::ARCHIVED;
    }
}
