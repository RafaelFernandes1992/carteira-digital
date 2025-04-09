<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeriodRequest extends FormRequest
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
            'id' => 'required|integer|exists:periods,id',
            'mes' => 'required|string|between:1,12',
            'ano' => 'required|integer|between:2000,2100',
            'saldo_inicial' => 'required|numeric',
            'descricao' => 'required|string',
            'observacao' => 'nullable|string',
        ];
    }
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'id' => $this->route('competenciaId'),
        ]);
    }
}
