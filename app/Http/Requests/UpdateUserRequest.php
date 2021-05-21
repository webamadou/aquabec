<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            "godfather"     => "nullable",
            "prenom"        => "nullable",
            "name"          => "required",
            "email"         => "required|email|unique:users,email,".$this->user->id,
            "username"      => "required|unique:users,username,".$this->user->id,
            "age_group"     => "nullable",
            "gender"        => "nullable",
            "num_civique"   => "nullable|max:10",
            "region_id"     => "nullable",
            "city_id"       => "nullable",
            "postal_code"   => "nullable",
            "street"        => "nullable",
            "num_tel"       => "nullable",
            "mobile_phone"  => "nullable",
            "description"   => "nullable",
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => "Veuillez renseigner le nom s'il vous plait.",
            'email.email'       => "Veuillez rensigner une adresse e-mail correcte.",
            'email.unique'      => "Cette adresse e-mail n'est pas autorisée"
        ];
    }
}
