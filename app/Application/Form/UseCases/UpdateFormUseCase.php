<?php

namespace App\Application\Form\UseCases;

use App\Application\Form\Commands\UpdateFormCommand;
use App\Application\Form\Factories\FormFactory;
use App\Domain\Exceptions\FormNotFoundException;
use App\Domain\Form\Entities\Form;
use App\Domain\Form\Repositories\FormRepositoryInterface;

final class UpdateFormUseCase
{
    public function __construct(
        private FormRepositoryInterface $repository,
        private FormFactory $factory
    ) {
    }

    public function execute(UpdateFormCommand $command): Form
    {
        $form = $this->repository->find($command->id);

        if ($form === null) {
            throw new FormNotFoundException('Form not found.');
        }

        $updatedForm = $this->factory->update($command, $form);

        return $this->repository->save($updatedForm);
    }
}
