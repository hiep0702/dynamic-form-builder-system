<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\Field;
use App\Domain\Entities\Form;
use App\Domain\Repositories\FormRepositoryInterface;
use App\Infrastructure\Persistence\Models\FieldModel;
use App\Infrastructure\Persistence\Models\FormModel;

final class EloquentFormRepository implements FormRepositoryInterface
{
    public function save(Form $form): Form
    {
        $model = $form->id() ? FormModel::find($form->id()) : new FormModel();

        $model->title = $form->title();
        $model->status = $form->status();
        $model->save();

        $model->fields()->delete();

        foreach ($form->fields() as $field) {
            $model->fields()->create([
                'type' => $field->type(),
                'required' => $field->required(),
            ]);
        }

        return $this->mapToEntity($model->refresh());
    }

    public function find(int $id): ?Form
    {
        $model = FormModel::with('fields')->find($id);

        return $model ? $this->mapToEntity($model) : null;
    }

    public function all(): array
    {
        return FormModel::with('fields')->get()->map(fn(FormModel $form) => $this->mapToEntity($form))->all();
    }

    private function mapToEntity(FormModel $model): Form
    {
        $fields = $model->fields->map(fn(FieldModel $field) => new Field(
            $field->id,
            $field->type,
            $field->required,
        ))->all();

        return new Form(
            $model->id,
            $model->title,
            $model->status,
            $fields,
        );
    }
}
