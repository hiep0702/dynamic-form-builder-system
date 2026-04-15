<?php

namespace App\Domain\Exceptions;

use RuntimeException;

final class DomainValidationException extends RuntimeException
{
    private array $errors;

    public function __construct(array $errors)
    {
        parent::__construct('Validation failed.');
        $this->errors = $errors;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
