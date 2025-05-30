<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCreditCardRequest extends FormRequest
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
            'id' => 'required|integer|exists:credit_cards,id',
            'numero_cartao' => 'required|string|digits:4',
            'apelido' => 'required|string|min:3|max:15',
            'valor_limite' => 'required|numeric',
            'dia_vencimento_fatura' => 'required|integer',
            'dia_fechamento_fatura' => 'required|integer',
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), [
            'id' => $this->route('creditCardId'),
        ]);
    }
}
