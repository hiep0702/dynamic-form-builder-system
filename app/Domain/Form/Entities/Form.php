<?php

namespace App\Domain\Form\Entities;

final class Form
{
    public function __construct(
        private ?int $id,
        private string $title,
        private string $status,
        private array $fields = []
    ) {
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function fields(): array
    {
        return $this->fields;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'fields' => array_map(fn(Field $field) => $field->toArray(), $this->fields),
        ];
    }

    public static function fromArray(array $data): self
    {
        $fields = array_map(fn(array $field) => Field::fromArray($field), $data['fields'] ?? []);

        return new self(
            $data['id'] ?? null,
            $data['title'],
            $data['status'],
            $fields,
        );
    }
}
