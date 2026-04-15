<?php

namespace App\Domain\Submission\Entities;

final class Submission
{
    public function __construct(
        private ?int $id,
        private int $formId,
        private array $payload,
        private ?\DateTimeImmutable $createdAt = null
    ) {
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function formId(): int
    {
        return $this->formId;
    }

    public function payload(): array
    {
        return $this->payload;
    }

    public function createdAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'form_id' => $this->formId,
            'payload' => $this->payload,
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
        ];
    }
}
