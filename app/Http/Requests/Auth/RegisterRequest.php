<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'firstname' => ['required', 'string', 'max:254', 'min:3'],
            'lastname' => ['required', 'string', 'max:254', 'min:3'],
            'email' => ['required', 'string', 'email'],
            'phone' => ['digits:10'],
            'password' => 
                [
                    'required',
                    'string',
                    'min:8',
                    'max:254',
                    'confirmed',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                ]
        ];
    }

    public function messages()
    {
        return [
            'firstname.required' => 'Le prénom est obligatoire',
            'firstname.sring' => 'Format invalide',
            'firstname.max' => 'Le prénom doit faire 254 caractères maximum',
            'firstname.min' => 'Le prénom doit faire 3 caractères minimum',

            'lastname.required' => 'Le nom de famille est obligatoire',
            'lastname.sring' => 'Format invalide',
            'lastname.max' => 'Le nom de famille doit faire 254 caractères maximum',
            'lastname.min' => 'Le nom de famille doit faire 3 caractères minimum',

            'email.required' => 'L\'email est obligatoire',
            'email.string' => 'Format invalide',
            'email.email' => 'L\'email est invalide',

            'phone.digits' => 'Téléphone invalide (format: 0102030405)',

            'password.required' => 'Le mot de passe est obligatoire',
            'password.string' => 'Format invalide',
            'password.min' => 'Le mot de passe doit faire 8 caractères minimum',
            'password.max' => 'Le mot de passe doit faire 254 caractères maximum',
            'password.confirmed' => 'Les mots de passes ne correspondent pas',
            'password.regex' => 'Le mot de passe doit contenir au moins: 1 lettre minuscule, 1 lettre majuscule et 1 chiffre'
        ];
    }
}
