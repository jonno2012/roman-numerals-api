<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvertRequest extends FormRequest
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
            'integer' => ['required', 'numeric', 'between:1,1399']
        ];
    }

    public function messages()
    {
        return [
            'between' => ':attribute must be between :min and :max.',
        ];
    }
}
