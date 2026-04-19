<?php

namespace App\Domain\Submission\Entities;

use App\Domain\Submission\ValueObjects\SubmissionStatus;

final class Submission
{
    public function __construct(
        private ?int $id,
        private int $formId,
        private array $payload,
        private int $schemaVersion,
        private array $schemaSnapshot,
        private SubmissionStatus $status,
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

    public function schemaVersion(): int
    {
        return $this->schemaVersion;
    }

    public function schemaSnapshot(): array
    {
        return $this->schemaSnapshot;
    }

    public function status(): SubmissionStatus
    {
        return $this->status;
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
            'schema_version' => $this->schemaVersion,
            'schema_snapshot' => $this->schemaSnapshot,
            'status' => $this->status->value,
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
        ];
    }
}
