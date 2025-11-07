@extends('layouts.app')

@section('title', 'Modifier le Rôle')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('roles.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Modifier le Rôle</h1>
                <p class="text-sm text-gray-600 mt-1">{{ $role->name }}</p>
            </div>
        </div>
    </div>

    {{-- Formulaire --}}
    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nom du rôle --}}
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du Rôle <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $role->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Warning pour rôles protégés --}}
                @if(in_array($role->name, ['Super Admin', 'Admin']))
                    <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-yellow-700">
                                <p class="font-medium">Rôle Protégé</p>
                                <p>Ce rôle est protégé et ne peut pas être supprimé. Modifiez-le avec précaution.</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Info statistiques --}}
                <div class="mb-6 grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-sm text-blue-600 font-medium mb-1">Permissions</div>
                        <div class="text-2xl font-bold text-blue-900">{{ $role->permissions()->count() }}</div>
                        <a href="{{ route('roles.permissions', $role) }}" class="text-xs text-blue-600 hover:text-blue-800 mt-2 inline-block">
                            Gérer les permissions →
                        </a>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-sm text-green-600 font-medium mb-1">Utilisateurs</div>
                        <div class="text-2xl font-bold text-green-900">{{ $role->users()->count() }}</div>
                        <div class="text-xs text-green-600 mt-2">utilisateur(s) assigné(s)</div>
                    </div>
                </div>

                {{-- Boutons --}}
                <div class="flex items-center justify-between pt-4 border-t">
                    <a href="{{ route('roles.index') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                        Mettre à Jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
