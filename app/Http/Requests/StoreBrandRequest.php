<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('admin', auth()->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255|unique:brands,name',
            'image' => 'required|image',
            'active' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Champ nom requis',
            'name.min' => 'Nom minimum 3 lettres',
            'name.max' => 'Nom maximum 255 lettres',
            'name.unique' => 'Une marque de ce nom existe déjà',

            'image.required' => 'Champ image requis',
            'image.image' => 'Le fichier doit être une image',

            'active.boolean' => 'Champ actif invalide'
        ];
    }
}
