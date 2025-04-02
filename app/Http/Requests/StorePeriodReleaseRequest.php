<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePeriodReleaseRequest extends FormRequest
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
//        todo: receber o tipo do meu lancamento
        return [
            'valor_total' => 'required|numeric',
            'observacao' => 'required|string',
            'data_debito_credito' => 'required|date|date_format:Y-m-d',
            'situacao' => 'required|in:creditado,debitado,nao_debitado',
            'period_id' => 'required|integer|exists:periods,id',
            'type_release_id' => 'required|integer|exists:type_releases,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Os dados fornecidos são inválidos.',
            'error' => $validator->errors(),
        ], 422));
    }
}
