<?php

namespace Farouter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FarouterRequest extends FormRequest
{
    public $foo = 'bar';

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
            //
        ];
    }
}
