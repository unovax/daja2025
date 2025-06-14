<?php

namespace App\Http\Requests\Catalogs\Measure;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
            'name' => 'required|string|max:100',
            'value' => 'required|numeric|regex:/^\d{1,4}(\.\d{1,2})?$/',
            'unit_id' => 'required|exists:units,id',
            'client_id' => 'required|exists:clients,id',
        ];
    }
}
