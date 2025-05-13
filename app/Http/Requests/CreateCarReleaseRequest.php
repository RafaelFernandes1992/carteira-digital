<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCarReleaseRequest extends FormRequest
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
            'competenciaId' => 'required|integer|exists:periods,id',
            'search' => 'nullable|string|max:50',
        ];
    }
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'competenciaId' => $this->route('competenciaId'),
        ]);
    }
}
