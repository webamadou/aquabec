<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateCurrencyRequest extends FormRequest
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
            "name"    => "required|unique:currencies,name,".$this->currency->id,
            "icons"   => "required|max:60|unique:currencies,icons,".$this->currency->id,
            "description" => "nullable"
        ];
    }
}
