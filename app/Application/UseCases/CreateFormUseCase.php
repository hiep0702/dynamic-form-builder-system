<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Field;
use App\Domain\Entities\Form;
use App\Domain\Repositories\FormRepositoryInterface;

final class CreateFormUseCase
{
    public function __construct(private FormRepositoryInterface $repository)
    {
    }

    public function execute(string $title, string $status, array $fields): Form
    {
        $fieldObjects = array_map(fn(array $fieldData) => new Field(
            null,
            $fieldData['type'],
            (bool) $fieldData['required'],
        ), $fields);

        $form = new Form(null, $title, $status, $fieldObjects);

        return $this->repository->save($form);
    }
}
