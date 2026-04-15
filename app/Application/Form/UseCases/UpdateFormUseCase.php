<?php

namespace App\Application\Form\UseCases;

use App\Domain\Form\Entities\Field;
use App\Domain\Form\Entities\Form;
use App\Domain\Exceptions\FormNotFoundException;
use App\Domain\Form\Repositories\FormRepositoryInterface;

final class UpdateFormUseCase
{
    public function __construct(private FormRepositoryInterface $repository)
    {
    }

    public function execute(int $id, string $title, string $status, array $fields): Form
    {
        $form = $this->repository->find($id);

        if ($form === null) {
            throw new FormNotFoundException('Form not found.');
        }

        $fieldObjects = array_map(fn(array $fieldData) => new Field(
            null,
            $fieldData['type'],
            (bool) $fieldData['required'],
        ), $fields);

        $form = new Form($id, $title, $status, $fieldObjects);

        return $this->repository->save($form);
    }
}
