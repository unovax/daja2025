<?php

namespace App\Http\Requests\Tax;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        $id = $this->route('tax');
        return [
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('taxes', 'code')
                    ->ignore($id)
                    ->where(function ($query) {
                        return $query->where('tenant_id', Auth::user()->tenant_id)->whereNull('deleted_at');
                    }),
            ],
            'name' => 'required|string|max:100',
            'percentage' => 'required|numeric',
        ];
    }
}
