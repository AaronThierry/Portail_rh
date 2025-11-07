<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Form Request pour la création d'un rôle
 *
 * Gère la validation des données lors de la création d'un nouveau rôle.
 * Inclut des règles de validation strictes pour garantir l'intégrité des données.
 *
 * @package App\Http\Requests
 * @author Portail RH
 */
class StoreRoleRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Vérifie que l'utilisateur authentifié a la permission de créer des rôles
        return $this->user()->can('create', \Spatie\Permission\Models\Role::class);
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
        return [
            // Nom du rôle
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                Rule::unique('roles', 'name'),
                // Autorise uniquement lettres, espaces, tirets et underscores
                'regex:/^[a-zA-ZÀ-ÿ\s\-_]+$/',
            ],

            // Description du rôle (optionnelle)
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],

            // Permissions à attribuer au rôle (optionnelles)
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
            'name.unique' => 'Ce nom de rôle existe déjà dans le système.',
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
        // Log l'échec de validation pour le monitoring
        \Log::warning('Validation échouée pour la création de rôle', [
            'user_id' => $this->user()?->id,
            'errors' => $validator->errors()->toArray(),
            'input' => $this->except(['password', '_token']),
        ]);

        parent::failedValidation($validator);
    }
}
