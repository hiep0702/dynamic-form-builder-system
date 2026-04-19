<?php

namespace App\Domain\Form\Entities;

use App\Domain\Form\ValueObjects\FormStatus;

final class Form
{
    public function __construct(
        private ?int $id,
        private string $title,
        private string $description,
        private FormStatus $status,
        private int $version,
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

    public function description(): string
    {
        return $this->description;
    }

    public function status(): string
    {
        return $this->status->value();
    }

    public function statusValue(): FormStatus
    {
        return $this->status;
    }

    public function fields(): array
    {
        return $this->fields;
    }

    public function version(): int
    {
        return $this->version;
    }

    public function withTitle(string $title): self
    {
        return new self($this->id, $title, $this->description, $this->status, $this->version, $this->fields);
    }

    public function withDescription(string $description): self
    {
        return new self($this->id, $this->title, $description, $this->status, $this->version, $this->fields);
    }

    public function withStatus(FormStatus $status): self
    {
        return new self($this->id, $this->title, $this->description, $status, $this->version, $this->fields);
    }

    public function withFields(array $fields): self
    {
        return new self($this->id, $this->title, $this->description, $this->status, $this->version, $fields);
    }

    public function withVersion(int $version): self
    {
        return new self($this->id, $this->title, $this->description, $this->status, $version, $this->fields);
    }

    public function incrementVersion(): self
    {
        return $this->withVersion($this->version + 1);
    }

    public function addField(Field $field): self
    {
        $fields = $this->fields;
        $fields[] = $field;

        return new self($this->id, $this->title, $this->description, $this->status, $this->version + 1, $fields);
    }

    public function updateField(int $fieldId, Field $field): self
    {
        $fields = array_map(
            fn(Field $existing) => $existing->id() === $fieldId ? $field : $existing,
            $this->fields
        );

        return new self($this->id, $this->title, $this->description, $this->status, $this->version + 1, $fields);
    }

    public function removeField(int $fieldId): self
    {
        $fields = array_filter($this->fields, fn(Field $existing) => $existing->id() !== $fieldId);

        return new self($this->id, $this->title, $this->description, $this->status, $this->version + 1, array_values($fields));
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value(),
            'version' => $this->version,
            'fields' => array_map(fn(Field $field) => $field->toArray(), $this->fields),
        ];
    }

    public static function fromArray(array $data): self
    {
        $fields = array_map(fn(array $field) => Field::fromArray($field), $data['fields'] ?? []);

        return new self(
            $data['id'] ?? null,
            $data['title'],
            $data['description'] ?? '',
            FormStatus::fromString($data['status']),
            $data['version'] ?? 1,
            $fields,
        );
    }

    public function schemaSnapshot(): array
    {
        return [
            'form_id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value(),
            'version' => $this->version,
            'fields' => array_map(fn(Field $field) => $field->toArray(), $this->fields),
        ];
    }
}
