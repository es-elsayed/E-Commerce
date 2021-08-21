<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'abbr' => 'required|string|max:10',
            'direction' => 'required|in:rtl,ltr',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'This field is required',
            'string' => 'This field must be string',
            'name.max' => 'Maximum character must be less than 100',
            'abbr.max' => 'Maximum character must be less than 10',
            'in' => 'Invalid input data',
        ];
    }
}
