@extends('layouts.app')

@section('title', 'Assigner des Permissions')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header avec retour --}}
        <div class="mb-6">
            <a href="{{ route('parametres.permissions') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour aux permissions
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Assigner des Permissions</h1>
            <p class="text-gray-600 mt-2">Rôle : <span class="font-semibold text-blue-600">{{ $role->name }}</span></p>
        </div>

        <form action="{{ route('parametres.assign-permissions.store', $role) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Colonne principale - Permissions --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg">
                        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
                            <h2 class="text-xl font-bold text-gray-900">Sélection des Permissions</h2>
                            <p class="text-sm text-gray-600 mt-1">Cochez les permissions que ce rôle doit avoir</p>
                        </div>

                        <div class="p-6 space-y-6">
                            @foreach($groupedPermissions as $category => $perms)
                                <div class="border-2 border-gray-100 rounded-xl overflow-hidden hover:border-blue-200 transition">
                                    {{-- En-tête de catégorie --}}
                                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 flex items-center justify-between">
                                        <h3 class="text-base font-bold text-gray-800 uppercase tracking-wide flex items-center">
                                            <span class="w-2 h-2 bg-blue-600 rounded-full mr-3"></span>
                                            {{ ucfirst($category) }}
                                            <span class="ml-3 text-xs font-normal text-gray-500">({{ count($perms) }} permissions)</span>
                                        </h3>
                                        <button type="button"
                                                onclick="toggleCategory('{{ $category }}')"
                                                class="text-sm text-blue-600 hover:text-blue-800 font-medium transition">
                                            Tout sélectionner
                                        </button>
                                    </div>

                                    {{-- Grille des permissions --}}
                                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @foreach($perms as $permission)
                                            <label class="relative flex items-start p-4 rounded-lg border-2 border-gray-200 hover:border-blue-400 hover:bg-blue-50 cursor-pointer transition group">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox"
                                                           name="permissions[]"
                                                           value="{{ $permission->id }}"
                                                           data-category="{{ $category }}"
                                                           {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 transition">
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <span class="text-sm font-medium text-gray-900 group-hover:text-blue-900 transition">
                                                        {{ $permission->name }}
                                                    </span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Sidebar - Résumé et actions --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg sticky top-6">
                        {{-- Résumé --}}
                        <div class="p-6 border-b border-gray-200 bg-gradient-to-br from-blue-50 to-purple-50">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Résumé</h3>

                            <div class="space-y-4">
                                <div class="bg-white rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-600">Permissions sélectionnées</span>
                                        <span id="selected-count" class="text-2xl font-bold text-blue-600">{{ count($rolePermissions) }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Total disponible</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $permissions->count() }}</span>
                                    </div>
                                </div>

                                {{-- Barre de progression --}}
                                <div>
                                    <div class="flex justify-between text-xs text-gray-600 mb-2">
                                        <span>Progression</span>
                                        <span id="progress-percentage">{{ $permissions->count() > 0 ? round((count($rolePermissions) / $permissions->count()) * 100) : 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                        <div id="progress-bar"
                                             class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all duration-300 shadow-inner"
                                             style="width: {{ $permissions->count() > 0 ? (count($rolePermissions) / $permissions->count()) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Actions rapides --}}
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Actions Rapides</h3>
                            <div class="space-y-2">
                                <button type="button"
                                        onclick="selectAll()"
                                        class="w-full px-4 py-2.5 text-sm font-medium text-blue-700 bg-blue-50 border-2 border-blue-200 rounded-lg hover:bg-blue-100 transition flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Tout sélectionner
                                </button>
                                <button type="button"
                                        onclick="deselectAll()"
                                        class="w-full px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 border-2 border-gray-200 rounded-lg hover:bg-gray-200 transition flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Tout désélectionner
                                </button>
                            </div>
                        </div>

                        {{-- Boutons de soumission --}}
                        <div class="p-6">
                            <button type="submit"
                                    class="w-full px-4 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg hover:from-blue-700 hover:to-purple-700 transition duration-200 shadow-lg hover:shadow-xl mb-3">
                                Enregistrer les Permissions
                            </button>
                            <a href="{{ route('parametres.permissions') }}"
                               class="block w-full px-4 py-3 text-sm font-medium text-center text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                                Annuler
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function selectAll() {
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = true;
        });
        updateCounter();
    }

    function deselectAll() {
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        updateCounter();
    }

    function toggleCategory(category) {
        const checkboxes = document.querySelectorAll(`input[data-category="${category}"]`);
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);

        checkboxes.forEach(checkbox => {
            checkbox.checked = !allChecked;
        });

        updateCounter();
    }

    function updateCounter() {
        const total = document.querySelectorAll('input[type="checkbox"]').length;
        const checked = document.querySelectorAll('input[type="checkbox"]:checked').length;
        const percentage = total > 0 ? Math.round((checked / total) * 100) : 0;

        document.getElementById('selected-count').textContent = checked;
        document.getElementById('progress-percentage').textContent = percentage + '%';
        document.getElementById('progress-bar').style.width = percentage + '%';
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateCounter);
        });
    });
</script>
@endsection
