<?php

namespace App\Http\Requests\Tax;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Create extends FormRequest
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
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('taxes', 'code')->where(function ($query) {
                    return $query->where('tenant_id', Auth::user()->tenant_id)->whereNull('deleted_at');
                }),
            ],
            'name' => 'required|string|max:100',
            'percentage' => 'required|numeric',
        ];
    }
}
