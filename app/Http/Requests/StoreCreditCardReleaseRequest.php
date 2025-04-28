<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreditCardReleaseRequest extends FormRequest
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
            'credit_card_id' => 'required|integer|exists:credit_cards,id',
            'period_id' => 'required|integer|exists:periods,id',
            'data_compra' => 'required|date',
            'data_pagamento_fatura' => 'nullable|date',
            'descricao' => 'required|string|max:255',
            'quantidade_parcelas' => 'required|integer|min:1|max:18',
            'valor' => 'required|numeric|min:0.01',
            'valor_pago_fatura' => 'nullable|numeric|min:1',
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), [
            'period_id' => $this->route('competenciaId'),
        ]);
    }
}
