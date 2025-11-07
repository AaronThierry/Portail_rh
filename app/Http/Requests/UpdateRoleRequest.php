<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Form Request pour la mise à jour d'un rôle
 *
 * Gère la validation des données lors de la modification d'un rôle existant.
 * Les règles sont adaptées pour permettre la modification tout en gardant
 * l'intégrité des données.
 *
 * @package App\Http\Requests
 * @author Portail RH
 */
class UpdateRoleRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $role = $this->route('role');

        // Vérifie que l'utilisateur a la permission de modifier ce rôle
        return $this->user()->can('update', $role);
    }

    /**
     * Prépare les données pour la validation
     *
     * Nettoie et formate les données avant la validation
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim($this->name ?? ''),
            'description' => trim($this->description ?? ''),
        ]);
    }

    /**
     * Règles de validation qui s'appliquent à la requête
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $role = $this->route('role');

        return [
            // Nom du rôle - doit être unique sauf pour le rôle actuel
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                Rule::unique('roles', 'name')->ignore($role->id),
                'regex:/^[a-zA-ZÀ-ÿ\s\-_]+$/',
            ],

            // Description du rôle (optionnelle)
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],

            // Permissions (si on veut les mettre à jour avec le rôle)
            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'integer',
                'exists:permissions,id',
            ],
        ];
    }

    /**
     * Messages de validation personnalisés
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du rôle est obligatoire.',
            'name.min' => 'Le nom du rôle doit contenir au moins :min caractères.',
            'name.max' => 'Le nom du rôle ne peut pas dépasser :max caractères.',
            'name.unique' => 'Ce nom de rôle est déjà utilisé par un autre rôle.',
            'name.regex' => 'Le nom du rôle ne peut contenir que des lettres, espaces, tirets et underscores.',

            'description.max' => 'La description ne peut pas dépasser :max caractères.',

            'permissions.array' => 'Les permissions doivent être fournies sous forme de liste.',
            'permissions.*.integer' => 'Chaque permission doit être un identifiant valide.',
            'permissions.*.exists' => 'Une ou plusieurs permissions sélectionnées n\'existent pas.',
        ];
    }

    /**
     * Noms d'attributs personnalisés pour les messages d'erreur
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nom du rôle',
            'description' => 'description',
            'permissions' => 'permissions',
        ];
    }

    /**
     * Gère un échec de validation
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $role = $this->route('role');

        \Log::warning('Validation échouée pour la mise à jour de rôle', [
            'user_id' => $this->user()?->id,
            'role_id' => $role?->id,
            'role_name' => $role?->name,
            'errors' => $validator->errors()->toArray(),
            'input' => $this->except(['password', '_token']),
        ]);

        parent::failedValidation($validator);
    }
}
