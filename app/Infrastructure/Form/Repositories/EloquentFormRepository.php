<?php

namespace App\Infrastructure\Form\Repositories;

use App\Domain\Form\Entities\Field;
use App\Domain\Form\Entities\Form;
use App\Domain\Form\Repositories\FormRepositoryInterface;
use App\Domain\Form\ValueObjects\FormStatus;
use App\Infrastructure\Form\Models\FieldModel;
use App\Infrastructure\Form\Models\FormModel;

final class EloquentFormRepository implements FormRepositoryInterface
{
    public function save(Form $form): Form
    {
        $model = $form->id() ? FormModel::find($form->id()) : new FormModel();

        $model->title = $form->title();
        $model->description = $form->description();
        $model->status = $form->status();
        $model->save();

        $model->fields()->delete();

        foreach ($form->fields() as $field) {
            $model->fields()->create([
                'type' => $field->type(),
                'required' => $field->required(),
                'label' => $field->label(),
                'default_value' => $field->defaultValue(),
                'validation_rules' => $field->validationRules(),
                'properties' => $field->properties(),
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

    public function delete(int $id): void
    {
        FormModel::findOrFail($id)->delete();
    }

    private function mapToEntity(FormModel $model): Form
    {
        $fields = $model->fields->map(fn(FieldModel $field) => Field::fromArray([
            'id' => $field->id,
            'type' => $field->type,
            'required' => $field->required,
            'label' => $field->label,
            'defaultValue' => $field->default_value,
            'validationRules' => $field->validation_rules ?? [],
            'properties' => $field->properties ?? [],
        ]))->all();

        return new Form(
            $model->id,
            $model->title,
            $model->description,
            FormStatus::fromString($model->status),
            $fields,
        );
    }
}
