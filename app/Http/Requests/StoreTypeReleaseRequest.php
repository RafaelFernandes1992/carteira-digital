<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreTypeReleaseRequest extends FormRequest
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
            'descricao' => 'required|string|min:3|max:100',
            'rotineira' => 'nullable|boolean',
            'dedutivel' => 'nullable|boolean',
            'isenta' => 'nullable|boolean',
            'tipo' => 'required|in:receita,despesa,investimento',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        session()->flash('error', 'Os dados fornecidos são inválidos.');
        session()->flash('validation_errors', $validator->errors());
        return redirect()->back()->withInput();
    }

}
