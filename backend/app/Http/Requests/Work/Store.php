<?php

namespace App\Http\Requests\Work;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
            'notes' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'work_details' => 'required|array|min:1',
            'work_details.*.name' => 'required|string|max:100',
            'work_details.*.description' => 'required|string|max:255',
            'work_details.*.price' => 'required|numeric',
            'work_details.*.start_date' => 'required|date',
            'work_details.*.end_date' => 'required|date|after_or_equal:work_details.*.start_date',
            'work_details.*.photo' => 'required|string',
            'work_details.*.is_new' => 'required|boolean',
        ];
    }
}
