<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
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
            'apelido' => 'required|string|min:3|max:30',
            'renavam' => 'required|string|digits:11',
            'placa' => 'required|string|min:7|max:7',
            'marca' => 'required|string|min:2|max:30',
            'modelo' => 'required|string|min:2|max:30',
            'data_aquisicao' => 'required|date|date_format:Y-m-d',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        session()->flash('error', 'Os dados fornecidos são inválidos.');
        session()->flash('validation_errors', $validator->errors());
        return redirect()->back()->withInput();
    }
}
