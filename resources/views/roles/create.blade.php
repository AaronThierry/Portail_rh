@extends('layouts.app')

@section('title', 'Créer un Rôle')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.roles.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Créer un Nouveau Rôle</h1>
                <p class="text-sm text-gray-600 mt-1">Étape 1/2 : Définir le nom du rôle</p>
            </div>
        </div>
    </div>

    {{-- Formulaire --}}
    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf

                {{-- Nom du rôle --}}
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du Rôle <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="Ex: Responsable RH, Chef de Projet..."
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">
                        Choisissez un nom descriptif et unique pour ce rôle
                    </p>
                </div>

                {{-- Description (optionnel) --}}
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description (optionnel)
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        placeholder="Décrivez les responsabilités et le périmètre de ce rôle...">{{ old('description') }}</textarea>
                    <p class="mt-2 text-xs text-gray-500">
                        Cette description n'est pas enregistrée, elle est pour votre référence
                    </p>
                </div>

                {{-- Info box --}}
                <div class="mb-6 bg-primary-50 border-l-4 border-primary-500 p-4 rounded">
                    <div class="flex">
                        <svg class="w-5 h-5 text-primary-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-blue-700">
                            <p class="font-medium mb-1">Prochaine étape</p>
                            <p>Après avoir créé le rôle, vous pourrez lui assigner des permissions spécifiques.</p>
                        </div>
                    </div>
                </div>

                {{-- Boutons --}}
                <div class="flex items-center justify-between pt-4 border-t">
                    <a href="{{ route('admin.roles.index') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-primary-500 rounded-lg hover:bg-primary-600 transition">
                        Créer le Rôle
                    </button>
                </div>
            </form>
        </div>

        {{-- Guide rapide --}}
        <div class="mt-6 bg-gray-50 rounded-lg p-6">
            <h3 class="text-sm font-semibold text-gray-800 mb-3">💡 Conseils pour nommer vos rôles</h3>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Utilisez des noms clairs et descriptifs (ex: "Responsable RH", "Chef d'équipe")
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Évitez les abréviations difficiles à comprendre
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Pensez à la hiérarchie et au niveau de responsabilité
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Restez cohérent avec vos rôles existants
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
