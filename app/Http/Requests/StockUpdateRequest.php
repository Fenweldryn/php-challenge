<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'symbol' => ['required', 'string'],
            'open' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'high' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'low' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'close' => ['required', 'numeric', 'between:-999999.99,999999.99'],
        ];
    }
}
