<?php

namespace App\Application\Form\Commands;

final class CreateFormCommand
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $status,
        public readonly array $fields
    ) {
    }
}
