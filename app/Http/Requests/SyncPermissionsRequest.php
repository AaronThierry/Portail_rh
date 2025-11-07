<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request pour la synchronisation des permissions d'un rôle
 *
 * Valide les données lors de la mise à jour des permissions associées à un rôle.
 * Permet de gérer efficacement les permissions multiples.
 *
 * @package App\Http\Requests
 * @author Portail RH
 */
class SyncPermissionsRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $role = $this->route('role');

        // Vérifie via la RolePolicy que l'utilisateur peut gérer les permissions
        return $this->user()->can('managePermissions', $role);
    }

    /**
     * Règles de validation qui s'appliquent à la requête
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Permissions à synchroniser (peut être vide pour tout retirer)
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
            'permissions.array' => 'Les permissions doivent être fournies sous forme de liste.',
            'permissions.*.integer' => 'Chaque permission doit être un identifiant valide.',
            'permissions.*.exists' => 'Une ou plusieurs permissions sélectionnées n\'existent pas dans le système.',
        ];
    }

    /**
     * Méthode personnalisée pour valider les restrictions de permissions
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $role = $this->route('role');

            // Protection supplémentaire: empêche la modification des permissions du Super Admin
            // sauf par un Super Admin lui-même
            if ($role->name === 'Super Admin' && !$this->user()->hasRole('Super Admin')) {
                $validator->errors()->add(
                    'permissions',
                    'Seul un Super Admin peut modifier les permissions du rôle Super Admin.'
                );
                return;
            }

            // Empêche de retirer TOUTES les permissions d'un rôle système
            $protectedRoles = ['Admin', 'RH', 'Manager', 'Employé'];
            $permissionIds = $this->input('permissions', []);

            if (in_array($role->name, $protectedRoles) && empty($permissionIds)) {
                $validator->errors()->add(
                    'permissions',
                    "Le rôle système '{$role->name}' doit conserver au moins une permission."
                );
            }
        });
    }

    /**
     * Noms d'attributs personnalisés pour les messages d'erreur
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
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

        \Log::warning('Validation échouée pour la synchronisation des permissions', [
            'user_id' => $this->user()?->id,
            'role_id' => $role?->id,
            'role_name' => $role?->name,
            'errors' => $validator->errors()->toArray(),
            'input' => $this->all(),
        ]);

        parent::failedValidation($validator);
    }
}
