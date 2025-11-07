@extends('layouts.app')

@section('title', 'Modifier le Rôle')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header avec retour --}}
        <div class="mb-6">
            <a href="{{ route('parametres.roles') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour aux rôles
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Modifier le Rôle</h1>
            <p class="text-gray-600 mt-2">{{ $role->name }}</p>
        </div>

        {{-- Formulaire --}}
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Informations du Rôle</h2>
            </div>

            <form action="{{ route('parametres.roles.update', $role) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                {{-- Nom du rôle --}}
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nom du Rôle <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $role->name) }}"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Warning pour rôles protégés --}}
                @if(in_array($role->name, ['Super Admin', 'Admin']))
                    <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                        <div class="flex">
                            <svg class="w-6 h-6 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-yellow-800">
                                <p class="font-semibold mb-1">⚠️ Rôle Protégé</p>
                                <p>Ce rôle est protégé et ne peut pas être supprimé. Modifiez-le avec précaution.</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Statistiques --}}
                <div class="mb-6 grid grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-5 border-2 border-blue-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-blue-600">Permissions</span>
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-blue-900">{{ $role->permissions()->count() }}</div>
                        <a href="{{ route('parametres.assign-permissions', $role) }}" class="text-xs text-blue-600 hover:text-blue-800 mt-2 inline-flex items-center font-medium">
                            Gérer les permissions
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-5 border-2 border-green-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-green-600">Utilisateurs</span>
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-green-900">{{ $role->users()->count() }}</div>
                        <div class="text-xs text-green-600 mt-2">utilisateur(s) assigné(s)</div>
                    </div>
                </div>

                {{-- Boutons --}}
                <div class="flex items-center justify-between pt-6 border-t-2 border-gray-100">
                    <a href="{{ route('parametres.roles') }}"
                       class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 border-2 border-gray-300 rounded-lg hover:bg-gray-200 transition">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-8 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg hover:from-blue-700 hover:to-purple-700 transition duration-200 shadow-lg hover:shadow-xl">
                        Mettre à Jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
