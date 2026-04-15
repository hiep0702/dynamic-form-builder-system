<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Form;

interface FormRepositoryInterface
{
    public function save(Form $form): Form;

    public function find(int $id): ?Form;

    public function all(): array;
}
