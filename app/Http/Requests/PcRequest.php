<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PcRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'school_id' => 'required | max:10',
            'grade' => 'required | max:10',
            'class' => 'required | max:10',
            'name' => 'required | max:10',
        ];
    }
}
