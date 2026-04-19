<?php

namespace App\Domain\Form\Entities;

use App\Domain\Form\ValueObjects\FieldType;

final class Field
{
    public const TYPE_TEXT = 'text';
    public const TYPE_NUMBER = 'number';
    public const TYPE_DATE = 'date';
    public const TYPE_SELECT = 'select';
    public const TYPE_CHECKBOX = 'checkbox';
    public const TYPE_TEXTAREA = 'textarea';
    public const TYPE_FILE = 'file';

    public function __construct(
        private ?int $id,
        private FieldType $type,
        private bool $required,
        private string $label,
        private mixed $defaultValue,
        private array $validationRules,
        private array $properties = []
    ) {
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type->value();
    }

    public function typeValue(): FieldType
    {
        return $this->type;
    }

    public function required(): bool
    {
        return $this->required;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function defaultValue(): mixed
    {
        return $this->defaultValue;
    }

    public function validationRules(): array
    {
        return $this->validationRules;
    }

    public function properties(): array
    {
        return $this->properties;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'required' => $this->required,
            'label' => $this->label,
            'defaultValue' => $this->defaultValue,
            'validationRules' => $this->validationRules,
            'properties' => $this->properties,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            FieldType::fromString($data['type']),
            (bool) ($data['required'] ?? false),
            $data['label'] ?? '',
            $data['defaultValue'] ?? null,
            $data['validationRules'] ?? [],
            $data['properties'] ?? []
        );
    }

    public static function allowedTypes(): array
    {
        return [self::TYPE_TEXT, self::TYPE_NUMBER, self::TYPE_DATE, self::TYPE_SELECT, self::TYPE_CHECKBOX, self::TYPE_TEXTAREA, self::TYPE_FILE];
    }
}
