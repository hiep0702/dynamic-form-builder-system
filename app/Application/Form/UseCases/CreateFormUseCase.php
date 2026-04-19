<?php

namespace App\Application\Form\UseCases;

use App\Application\Form\Commands\CreateFormCommand;
use App\Application\Form\Factories\FormFactory;
use App\Domain\Form\Entities\Form;
use App\Domain\Form\Repositories\FormRepositoryInterface;

final class CreateFormUseCase
{
    public function __construct(
        private FormRepositoryInterface $repository,
        private FormFactory $factory
    ) {
    }

    public function execute(CreateFormCommand $command): Form
    {
        $form = $this->factory->create($command);

        return $this->repository->save($form);
    }
}
