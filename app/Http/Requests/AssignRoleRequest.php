<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request pour l'attribution de rôles aux utilisateurs
 *
 * Valide les données lors de l'attribution ou du retrait de rôles à un utilisateur.
 * Garantit que seuls des rôles valides peuvent être attribués.
 *
 * @package App\Http\Requests
 * @author Portail RH
 */
class AssignRoleRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $targetUser = $this->route('user');

        // Vérifie via la policy UserPolicy que l'utilisateur peut attribuer des rôles
        return $this->user()->can('assignRole', $targetUser);
    }

    /**
     * Règles de validation qui s'appliquent à la requête
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Rôles à attribuer
            'roles' => [
                'required',
                'array',
                'min:1', // Au moins un rôle doit être attribué
            ],

            'roles.*' => [
                'integer',
                'exists:roles,id',
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
            'roles.required' => 'Vous devez sélectionner au moins un rôle.',
            'roles.array' => 'Les rôles doivent être fournis sous forme de liste.',
            'roles.min' => 'Vous devez sélectionner au moins un rôle.',
            'roles.*.integer' => 'Chaque rôle doit être un identifiant valide.',
            'roles.*.exists' => 'Un ou plusieurs rôles sélectionnés n\'existent pas.',
        ];
    }

    /**
     * Méthode personnalisée pour valider les restrictions de rôles
     *
     * Empêche l'attribution de rôles auxquels l'utilisateur n'a pas accès
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $authUser = $this->user();
            $targetUser = $this->route('user');
            $roleIds = $this->input('roles', []);

            // Super Admin peut attribuer n'importe quel rôle
            if ($authUser->hasRole('Super Admin')) {
                return;
            }

            // Récupère les rôles sélectionnés
            $roles = \Spatie\Permission\Models\Role::whereIn('id', $roleIds)->get();

            // Vérifie qu'aucun rôle "Super Admin" n'est attribué par un non-Super Admin
            foreach ($roles as $role) {
                if ($role->name === 'Super Admin') {
                    $validator->errors()->add(
                        'roles',
                        'Seul un Super Admin peut attribuer le rôle "Super Admin".'
                    );
                    break;
                }

                // Un Admin ne peut pas attribuer le rôle Admin à quelqu'un d'autre entreprise
                if ($role->name === 'Admin' && $authUser->entreprise_id !== $targetUser->entreprise_id) {
                    $validator->errors()->add(
                        'roles',
                        'Vous ne pouvez attribuer le rôle Admin qu\'aux utilisateurs de votre entreprise.'
                    );
                    break;
                }
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
            'roles' => 'rôles',
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
        $targetUser = $this->route('user');

        \Log::warning('Validation échouée pour l\'attribution de rôle', [
            'auth_user_id' => $this->user()?->id,
            'target_user_id' => $targetUser?->id,
            'errors' => $validator->errors()->toArray(),
            'input' => $this->all(),
        ]);

        parent::failedValidation($validator);
    }
}
