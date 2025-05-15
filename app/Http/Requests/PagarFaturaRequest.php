<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagarFaturaRequest extends FormRequest
{
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
            'competencia_id' => 'required|exists:periods,id',
            'credit_card_id' => 'required|exists:credit_cards,id',
            'valor_pago_fatura' => 'required|numeric',
            'data_pagamento_fatura' => 'required|date',
        ];
    }

}
