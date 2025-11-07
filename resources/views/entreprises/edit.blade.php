@extends('layouts.app')

@section('title', 'Modifier Entreprise')

@section('content')
<div class="entreprise-edit-page">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('entreprises.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Modifier Entreprise</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ $entreprise->nom }}</p>
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
    <form action="{{ route('entreprises.update', $entreprise->id) }}" method="POST" enctype="multipart/form-data">
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
                                Nom de l'entreprise <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $entreprise->nom) }}" required
                                   class="input" placeholder="Nom complet de l'entreprise">
                        </div>

                        <div>
                            <label for="sigle" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Sigle / Acronyme
                            </label>
                            <input type="text" name="sigle" id="sigle" value="{{ old('sigle', $entreprise->sigle) }}"
                                   class="input" placeholder="Ex: SARL, SA...">
                        </div>

                        <div>
                            <label for="secteur_activite" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Secteur d'activité
                            </label>
                            <input type="text" name="secteur_activite" id="secteur_activite" value="{{ old('secteur_activite', $entreprise->secteur_activite) }}"
                                   class="input" placeholder="Ex: Technologie, Commerce...">
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      class="input">{{ old('description', $entreprise->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="card">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Contact</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                E-mail <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $entreprise->email) }}" required
                                   class="input" placeholder="contact@entreprise.com">
                        </div>

                        <div>
                            <label for="telephone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Téléphone
                            </label>
                            <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $entreprise->telephone) }}"
                                   class="input" placeholder="+237 6XX XXX XXX">
                        </div>

                        <div class="md:col-span-2">
                            <label for="site_web" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Site web
                            </label>
                            <input type="url" name="site_web" id="site_web" value="{{ old('site_web', $entreprise->site_web) }}"
                                   class="input" placeholder="https://www.entreprise.com">
                        </div>
                    </div>
                </div>

                <!-- Localisation -->
                <div class="card">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Localisation</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="adresse" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Adresse
                            </label>
                            <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $entreprise->adresse) }}"
                                   class="input" placeholder="Adresse complète">
                        </div>

                        <div>
                            <label for="ville" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Ville
                            </label>
                            <input type="text" name="ville" id="ville" value="{{ old('ville', $entreprise->ville) }}"
                                   class="input" placeholder="Douala, Yaoundé...">
                        </div>

                        <div>
                            <label for="code_postal" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Code postal
                            </label>
                            <input type="text" name="code_postal" id="code_postal" value="{{ old('code_postal', $entreprise->code_postal) }}"
                                   class="input" placeholder="BP 1234">
                        </div>

                        <div class="md:col-span-2">
                            <label for="pays" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Pays <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pays" id="pays" value="{{ old('pays', $entreprise->pays) }}" required
                                   class="input" placeholder="Cameroun">
                        </div>
                    </div>
                </div>

                <!-- Informations légales -->
                <div class="card">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Informations légales</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="numero_registre" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Numéro de registre
                            </label>
                            <input type="text" name="numero_registre" id="numero_registre" value="{{ old('numero_registre', $entreprise->numero_registre) }}"
                                   class="input" placeholder="RC-XXX-XXXX">
                        </div>

                        <div>
                            <label for="numero_fiscal" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Numéro fiscal
                            </label>
                            <input type="text" name="numero_fiscal" id="numero_fiscal" value="{{ old('numero_fiscal', $entreprise->numero_fiscal) }}"
                                   class="input" placeholder="NIF-XXXXXXXXX">
                        </div>

                        <div>
                            <label for="nombre_employes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Nombre d'employés
                            </label>
                            <input type="number" name="nombre_employes" id="nombre_employes" value="{{ old('nombre_employes', $entreprise->nombre_employes) }}" min="1"
                                   class="input" placeholder="Ex: 50">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Statut
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $entreprise->is_active) ? 'checked' : '' }} class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Entreprise active</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Logo -->
                <div class="card">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Logo</h2>

                    <div class="space-y-4">
                        @if($entreprise->logo)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Logo actuel :</p>
                            <img src="{{ asset($entreprise->logo) }}" alt="Logo actuel" class="w-full h-48 object-contain rounded-lg bg-gray-50 dark:bg-gray-800 p-4">
                        </div>
                        @endif

                        <div id="logo-preview" class="hidden">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Nouveau logo :</p>
                            <img src="" alt="Preview" class="w-full h-48 object-contain rounded-lg bg-gray-50 dark:bg-gray-800 p-4">
                        </div>

                        <label for="logo" class="block">
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-primary-500 dark:hover:border-primary-400 transition-colors cursor-pointer">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Cliquez pour changer le logo<br>
                                    <span class="text-xs">PNG, JPG, GIF jusqu'à 2MB</span>
                                </p>
                            </div>
                            <input type="file" name="logo" id="logo" accept="image/*" class="hidden">
                        </label>
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
                        <a href="{{ route('entreprises.index') }}" class="btn btn-secondary w-full">
                            Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Preview logo
document.getElementById('logo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('logo-preview');
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
