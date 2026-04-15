<?php

namespace App\Http\Requests;

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
            'title' => ['string', 'max:255'],
            'status' => ['in:draft,active'],
            'fields' => ['required', 'array', 'min:1'],
            'fields.*.type' => ['required', 'in:text,number,date,boolean'],
            'fields.*.required' => ['required', 'boolean'],
        ];
    }
}
