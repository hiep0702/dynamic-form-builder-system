<?php

namespace App\Http\Requests;

use App\Application\Form\Commands\UpdateFormCommand;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,active,archived'],
            'fields' => ['required', 'array', 'min:1'],
            'fields.*.type' => ['required', 'in:text,number,date,select,checkbox,textarea,file'],
            'fields.*.required' => ['required', 'boolean'],
            'fields.*.label' => ['required', 'string'],
            'fields.*.defaultValue' => ['nullable'],
            'fields.*.validationRules' => ['nullable', 'array'],
            'fields.*.properties' => ['nullable', 'array'],
        ];
    }

    public function toCommand(int $id): UpdateFormCommand
    {
        $data = $this->validated();

        return new UpdateFormCommand(
            $id,
            $data['title'],
            $data['description'] ?? null,
            $data['status'],
            $data['fields']
        );
    }
}
