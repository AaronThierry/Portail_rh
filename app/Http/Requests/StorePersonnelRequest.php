<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonnelRequest extends FormRequest
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
            // Relations
            'entreprise_id' => ['required', 'exists:entreprises,id'],
            'departement_id' => ['nullable', 'exists:departements,id'],
            'service_id' => ['nullable', 'exists:services,id'],

            // Informations personnelles
            'matricule' => ['nullable', 'string', 'max:50', 'unique:personnels,matricule'],
            'nom' => ['required', 'string', 'max:100'],
            'prenoms' => ['required', 'string', 'max:150'],
            'sexe' => ['nullable', 'in:M,F'],
            'civilite' => ['nullable', 'in:M.,Mme,Mlle,Dr,Pr'],

            // Coordonnées
            'adresse' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255', 'unique:personnels,email'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'telephone_code_pays' => ['nullable', 'string', 'max:10'],
            'telephone_whatsapp' => ['nullable', 'boolean'],

            // Documents
            'numero_identification' => ['nullable', 'string', 'max:100', 'unique:personnels,numero_identification'],

            // Poste et contrat
            'poste' => ['nullable', 'string', 'max:150'],
            'date_naissance' => ['nullable', 'date', 'before:today'],
            'type_contrat' => ['required', 'in:CDI,CDD'],
            'date_embauche' => ['nullable', 'date'],
            'date_fin_contrat' => ['nullable', 'date', 'after:date_embauche', 'required_if:type_contrat,CDD'],

            // Photo
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],

            // Statut
            'is_active' => ['nullable', 'boolean'],
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
            'entreprise_id.required' => 'L\'entreprise est requise',
            'entreprise_id.exists' => 'L\'entreprise sélectionnée n\'existe pas',
            'nom.required' => 'Le nom est requis',
            'prenoms.required' => 'Le(s) prénom(s) est/sont requis',
            'email.email' => 'L\'adresse email doit être valide',
            'email.unique' => 'Cet email est déjà utilisé',
            'type_contrat.required' => 'Le type de contrat est requis',
            'date_fin_contrat.required_if' => 'La date de fin de contrat est requise pour un CDD',
            'date_fin_contrat.after' => 'La date de fin doit être après la date d\'embauche',
            'date_naissance.before' => 'La date de naissance doit être dans le passé',
            'photo.image' => 'Le fichier doit être une image',
            'photo.max' => 'La photo ne doit pas dépasser 2 Mo',
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
            'entreprise_id' => 'entreprise',
            'departement_id' => 'département',
            'service_id' => 'service',
            'nom' => 'nom',
            'prenoms' => 'prénoms',
            'sexe' => 'sexe',
            'civilite' => 'civilité',
            'email' => 'email',
            'telephone' => 'téléphone',
            'numero_identification' => 'numéro d\'identification',
            'poste' => 'poste',
            'date_naissance' => 'date de naissance',
            'type_contrat' => 'type de contrat',
            'date_embauche' => 'date d\'embauche',
            'date_fin_contrat' => 'date de fin de contrat',
        ];
    }
}
