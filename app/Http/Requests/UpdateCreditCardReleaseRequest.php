<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCreditCardReleaseRequest extends FormRequest
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
            'id' => 'required|integer|exists:credit_card_releases,id',
            'data_compra' => 'required|date',
            'descricao' => 'required|string|max:255',
            'quantidade_parcelas' => 'required|integer|min:1|max:18',
            'valor' => 'required|numeric|min:0.01',
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), [
            'id' => $this->route('creditCardReleaseId'),
        ]);
    }
}
