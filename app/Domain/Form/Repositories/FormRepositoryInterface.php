<?php

namespace App\Domain\Form\Repositories;

use App\Domain\Form\Entities\Form;

interface FormRepositoryInterface
{
    public function save(Form $form): Form;

    public function find(int $id): ?Form;

    public function all(): array;
}
