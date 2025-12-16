@extends('layouts.app')

@section('title', 'Modifier Département')

@section('content')
<div class="departement-edit-page">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('admin.departements.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Modifier Département</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ $departement->nom }}</p>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
    <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4 mb-6 rounded-r-lg">
        <p class="font-semibold mb-2">Erreurs de validation :</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <form action="{{ route('admin.departements.update', $departement->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Information Card -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations de base -->
                <div class="card">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Informations de base</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="nom" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Nom du département <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $departement->nom) }}" required
                                   class="input" placeholder="Exemple: Ressources Humaines">
                        </div>

                        <div>
                            <label for="code" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Code
                            </label>
                            <input type="text" name="code" id="code" value="{{ old('code', $departement->code) }}"
                                   class="input" placeholder="Exemple: RH">
                        </div>

                        @if(auth()->user()->role === 'super_admin')
                        <div>
                            <label for="entreprise_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Entreprise <span class="text-red-500">*</span>
                            </label>
                            <select name="entreprise_id" id="entreprise_id" {{ $departement->is_global ? 'disabled' : 'required' }} class="input">
                                <option value="">Sélectionnez une entreprise</option>
                                @foreach($entreprises as $entreprise)
                                <option value="{{ $entreprise->id }}" {{ old('entreprise_id', $departement->entreprise_id) == $entreprise->id ? 'selected' : '' }}>
                                    {{ $entreprise->nom }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="4"
                                      class="input" placeholder="Description du département...">{{ old('description', $departement->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Options -->
                <div class="card">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Options</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $departement->is_active) ? 'checked' : '' }} class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Département actif</span>
                            </label>
                        </div>

                        @if(auth()->user()->role === 'super_admin')
                        <div>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_global" value="1" {{ old('is_global', $departement->is_global) ? 'checked' : '' }} class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Département global</span>
                            </label>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Un département global est disponible pour toutes les entreprises
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="space-y-3">
                        <button type="submit" class="btn btn-primary w-full">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Mettre à jour
                        </button>
                        <a href="{{ route('admin.departements.index') }}" class="btn btn-secondary w-full">
                            Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Disable entreprise_id when is_global is checked
@if(auth()->user()->role === 'super_admin')
document.querySelector('input[name="is_global"]').addEventListener('change', function() {
    const entrepriseSelect = document.getElementById('entreprise_id');
    if (this.checked) {
        entrepriseSelect.disabled = true;
        entrepriseSelect.value = '';
    } else {
        entrepriseSelect.disabled = false;
    }
});
@endif
</script>
@endsection
