<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCongeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'type_conge_id' => ['required', 'exists:type_conges,id'],
            'date_debut' => ['required', 'date', 'after_or_equal:today'],
            'date_fin' => ['required', 'date', 'after_or_equal:date_debut'],
            'motif' => ['nullable', 'string', 'max:1000'],
            'piece_jointe' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'demi_journee_debut' => ['nullable', 'boolean'],
            'demi_journee_fin' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'type_conge_id.required' => 'Le type de congé est obligatoire.',
            'type_conge_id.exists' => 'Le type de congé sélectionné est invalide.',
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.after_or_equal' => 'La date de début ne peut pas être dans le passé.',
            'date_fin.required' => 'La date de fin est obligatoire.',
            'date_fin.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.',
            'piece_jointe.max' => 'Le fichier ne doit pas dépasser 5 Mo.',
            'piece_jointe.mimes' => 'Le fichier doit être au format PDF, JPG ou PNG.',
        ];
    }
}
