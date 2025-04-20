<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StorePeriodRequest extends FormRequest
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
            'mes' => 'required|string|between:1,12',
            'ano' => 'required|integer|between:2000,2100',
            'saldo_inicial' => 'required|numeric',
            'descricao' => 'required|string',
            'observacao' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        session()->flash('error', 'Os dados fornecidos são inválidos.');
        session()->flash('validation_errors', $validator->errors());
        return redirect()->back()->withInput();
    }

}
