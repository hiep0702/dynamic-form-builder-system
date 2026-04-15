<?php

namespace App\Domain\Entities;

final class Field
{
    public const TYPE_TEXT = 'text';
    public const TYPE_NUMBER = 'number';
    public const TYPE_DATE = 'date';
    public const TYPE_BOOLEAN = 'boolean';

    public function __construct(
        private ?int $id,
        private string $type,
        private bool $required
    ) {
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function required(): bool
    {
        return $this->required;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'required' => $this->required,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['type'],
            (bool) ($data['required'] ?? false),
        );
    }

    public static function allowedTypes(): array
    {
        return [self::TYPE_TEXT, self::TYPE_NUMBER, self::TYPE_DATE, self::TYPE_BOOLEAN];
    }
}
