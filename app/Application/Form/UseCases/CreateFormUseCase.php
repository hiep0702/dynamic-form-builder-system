<?php

namespace App\Application\Form\UseCases;

use App\Domain\Form\Entities\Field;
use App\Domain\Form\Entities\Form;
use App\Domain\Form\Repositories\FormRepositoryInterface;

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
