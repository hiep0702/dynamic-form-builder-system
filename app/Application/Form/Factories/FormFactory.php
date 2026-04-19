<?php

namespace App\Application\Form\Factories;

use App\Application\Form\Commands\CreateFormCommand;
use App\Application\Form\Commands\UpdateFormCommand;
use App\Domain\Form\Entities\Field;
use App\Domain\Form\Entities\Form;
use App\Domain\Form\ValueObjects\FormStatus;

final class FormFactory
{
    public function create(CreateFormCommand $command): Form
    {
        $fields = array_map(fn(array $fieldData) => Field::fromArray($fieldData), $command->fields);

        return new Form(
            null,
            $command->title,
            $command->description ?? '',
            FormStatus::fromString($command->status),
            1,
            $fields,
        );
    }

    public function update(UpdateFormCommand $command, Form $form): Form
    {
        $fields = array_map(fn(array $fieldData) => Field::fromArray($fieldData), $command->fields);

        return $form
            ->withTitle($command->title)
            ->withDescription($command->description ?? '')
            ->withStatus(FormStatus::fromString($command->status))
            ->withFields($fields)
            ->incrementVersion();
    }
}
