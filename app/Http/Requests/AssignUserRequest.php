<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // L'email sera pris automatiquement depuis le personnel
            'password' => ['nullable', 'string', 'min:8', 'max:255'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'status' => ['nullable', 'in:active,inactive'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'role.required' => 'Le rôle est requis',
            'role.exists' => 'Le rôle sélectionné n\'existe pas',
            'status.in' => 'Le statut doit être actif ou inactif',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'password' => 'mot de passe',
            'role' => 'rôle',
            'status' => 'statut',
        ];
    }
}
