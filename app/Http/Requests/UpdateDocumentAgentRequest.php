<?php

namespace App\Http\Requests;

use App\Models\DocumentAgent;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentAgentRequest extends FormRequest
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
        $maxSize = DocumentAgent::TAILLE_MAX_MO * 1024;
        $extensions = implode(',', DocumentAgent::EXTENSIONS_AUTORISEES);

        return [
            'document' => "nullable|file|mimes:{$extensions}|max:{$maxSize}",
            'titre' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'categorie_id' => 'nullable|exists:categories_documents,id',
            'date_document' => 'nullable|date',
            'date_expiration' => 'nullable|date',
            'reference' => 'nullable|string|max:100',
            'confidentiel' => 'boolean',
            'visible_employe' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'document.file' => 'Le fichier uploadé n\'est pas valide',
            'document.mimes' => 'Format de fichier non autorisé. Formats acceptés : PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, GIF, WEBP',
            'document.max' => 'Le fichier ne doit pas dépasser ' . DocumentAgent::TAILLE_MAX_MO . ' Mo',
            'titre.max' => 'Le titre ne doit pas dépasser 255 caractères',
            'description.max' => 'La description ne doit pas dépasser 1000 caractères',
            'categorie_id.exists' => 'La catégorie sélectionnée n\'existe pas',
            'date_document.date' => 'La date du document n\'est pas valide',
            'date_expiration.date' => 'La date d\'expiration n\'est pas valide',
            'reference.max' => 'La référence ne doit pas dépasser 100 caractères',
        ];
    }
}
