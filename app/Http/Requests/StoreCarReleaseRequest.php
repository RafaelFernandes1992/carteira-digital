<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarReleaseRequest extends FormRequest
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
            'car_id' => 'required|integer|exists:cars,id',
            'period_id' => 'required|integer|exists:periods,id',
            'data_despesa' => 'required|date',
            'valor' => 'required|numeric|min:0.01',
            'descricao' => 'required|string|max:255',
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), [
            'period_id' => $this->route('competenciaId'),
        ]);
    }
}
