<?php

namespace App\Application\Form\Commands;

final class UpdateFormCommand
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $status,
        public readonly array $fields
    ) {
    }
}
