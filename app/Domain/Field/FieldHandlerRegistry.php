<?php

namespace App\Domain\Field;

use InvalidArgumentException;

final class FieldHandlerRegistry
{
    /** @var FieldHandlerInterface[] */
    private array $handlers;

    public function __construct(iterable $handlers)
    {
        $this->handlers = [];

        foreach ($handlers as $handler) {
            $this->handlers[] = $handler;
        }
    }

    public function handlerFor(string $type): FieldHandlerInterface
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($type)) {
                return $handler;
            }
        }

        throw new InvalidArgumentException("No handler for field type: {$type}");
    }
}
