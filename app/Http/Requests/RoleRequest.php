<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($this->route('role')),
                function ($attribute, $value, $fail) {
                    $interdits = ['administrateur', 'administrateur principal'];
                    if (in_array(mb_strtolower($value), $interdits)) {
                        $fail('Ce nom de rôle est réservé.');
                    }
                },
            ],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du rôle est obligatoire.',
            'name.unique' => 'Ce rôle existe déjà.',
            'permissions.*.exists' => 'Une permission sélectionnée n\'existe pas.',
        ];
    }
}
