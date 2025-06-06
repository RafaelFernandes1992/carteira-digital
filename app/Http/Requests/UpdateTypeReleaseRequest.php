<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTypeReleaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:type_releases,id',
            'descricao' => 'required|string|min:3|max:100',
            'rotineira' => 'nullable|boolean',
            'dedutivel' => 'nullable|boolean',
            'isenta' => 'nullable|boolean',
            'tipo' => 'required|in:receita,despesa,investimento',
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), [
            'id' => $this->route('typeReleaseId'),
        ]);
    }
}
