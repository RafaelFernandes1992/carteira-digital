<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeriodReleaseRequest extends FormRequest
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
            'id' => 'required|integer|exists:period_releases,id',
            'valor_total' => 'required|numeric',
            'observacao' => 'nullable|string',
            'data_debito_credito' => 'required|date|date_format:Y-m-d',
            'situacao' => 'required|in:creditado,debitado,nao_debitado',
            'type_release_id' => 'required|integer|exists:type_releases,id',
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), [
            'id' => $this->route('lancamentoId'),
        ]);
    }
}
