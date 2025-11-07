@extends('layouts.app')

@section('title', 'Détails Utilisateur')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header avec retour -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('utilisateurs.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="font-medium">Retour à la liste</span>
            </a>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Profil Utilisateur</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Carte Profil Principal -->
        <div class="lg:col-span-1">
            <div class="card bg-gradient-to-br from-purple-600 via-indigo-600 to-blue-600 text-white overflow-hidden">
                <div class="p-6 text-center">
                    <!-- Avatar -->
                    <div class="mb-4 inline-block relative">
                        <img src="{{ $user->avatar ? asset($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nom . ' ' . $user->prenom) . '&size=200&background=ffffff&color=667eea' }}"
                             alt="Avatar"
                             class="w-32 h-32 rounded-full border-4 border-white shadow-xl mx-auto">
                        <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-400 border-4 border-white rounded-full"></div>
                    </div>

                    <!-- Nom -->
                    <h2 class="text-2xl font-bold mb-1">{{ $user->nom }} {{ $user->prenom }}</h2>
                    <p class="text-purple-100 mb-4">{{ $user->email }}</p>

                    <!-- Badges -->
                    <div class="flex justify-center gap-2 mb-6">
                        @php
                            $roleBadgeClass = match($user->role ?? 'employee') {
                                'super_admin' => 'bg-red-500',
                                'admin' => 'bg-yellow-500',
                                'manager' => 'bg-blue-500',
                                'hr' => 'bg-orange-500',
                                default => 'bg-green-500'
                            };
                            $roleLabel = match($user->role ?? 'employee') {
                                'super_admin' => 'Super Admin',
                                'admin' => 'Administrateur',
                                'manager' => 'Manager',
                                'hr' => 'Ressources Humaines',
                                default => 'Employé'
                            };
                        @endphp
                        <span class="px-4 py-1.5 {{ $roleBadgeClass }} text-white text-xs font-bold rounded-full shadow-lg">
                            {{ $roleLabel }}
                        </span>
                        @if($user->statut === 'actif')
                        <span class="px-4 py-1.5 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg">
                            Actif
                        </span>
                        @else
                        <span class="px-4 py-1.5 bg-red-500 text-white text-xs font-bold rounded-full shadow-lg">
                            Inactif
                        </span>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 justify-center">
                        <a href="{{ route('utilisateurs.edit', $user->id) }}" class="btn bg-white text-purple-600 hover:bg-purple-50 flex-1">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Modifier
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistiques Rapides -->
            <div class="card mt-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Statistiques</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Projets actifs</span>
                        <span class="text-2xl font-bold text-purple-600">0</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Tâches complétées</span>
                        <span class="text-2xl font-bold text-green-600">0</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Jours de congé</span>
                        <span class="text-2xl font-bold text-blue-600">0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations Détaillées -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations Personnelles -->
            <div class="card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Informations Personnelles</h3>
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Nom</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->nom ?? 'Non renseigné' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Prénom</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->prenom ?? 'Non renseigné' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Email</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->email }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Téléphone</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->telephone ?? 'Non renseigné' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Date de naissance</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->date_naissance ? \Carbon\Carbon::parse($user->date_naissance)->format('d/m/Y') : 'Non renseigné' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Lieu de naissance</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->lieu_naissance ?? 'Non renseigné' }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Adresse</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->adresse ?? 'Non renseignée' }}</p>
                    </div>
                </div>
            </div>

            <!-- Informations Professionnelles -->
            <div class="card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Informations Professionnelles</h3>
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Matricule</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->matricule ?? 'Non renseigné' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Poste</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->poste ?? 'Non renseigné' }}</p>
                    </div>

                    @if($user->entreprise)
                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Entreprise</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->entreprise->nom }}</p>
                    </div>
                    @endif

                    @if($user->departement)
                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Département</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->departement->nom }}</p>
                    </div>
                    @endif

                    @if($user->service)
                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Service</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->service->nom }}</p>
                    </div>
                    @endif

                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Date d'embauche</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->date_embauche ? \Carbon\Carbon::parse($user->date_embauche)->format('d/m/Y') : 'Non renseigné' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Type de contrat</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->type_contrat ?? 'Non renseigné' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500 dark:text-gray-400">Salaire de base</label>
                        <p class="text-base font-medium text-gray-900 dark:text-white mt-1">{{ $user->salaire_base ? number_format($user->salaire_base, 0, ',', ' ') . ' FCFA' : 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Historique</h3>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Compte créé</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->created_at ? $user->created_at->format('d/m/Y à H:i') : 'N/A' }}</p>
                        </div>
                    </div>

                    @if($user->updated_at && $user->updated_at != $user->created_at)
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Dernière modification</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
