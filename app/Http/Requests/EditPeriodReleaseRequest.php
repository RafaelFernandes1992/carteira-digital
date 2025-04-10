<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPeriodReleaseRequest extends FormRequest
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
            'id' => 'required|string|exists:period_releases,id'
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), [
            'id' => $this->route('lancamentoId'),
        ]);
    }
}
