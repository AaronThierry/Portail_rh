@extends('layouts.app')

@section('title', $entreprise->nom)

@section('content')
<div class="entreprise-show-page">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('entreprises.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $entreprise->nom }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $entreprise->sigle }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('entreprises.edit', $entreprise->id) }}" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations générales -->
            <div class="card">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Informations générales</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Nom</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $entreprise->nom }}</p>
                    </div>

                    @if($entreprise->sigle)
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Sigle</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $entreprise->sigle }}</p>
                    </div>
                    @endif

                    @if($entreprise->secteur_activite)
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Secteur d'activité</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $entreprise->secteur_activite }}</p>
                    </div>
                    @endif

                    @if($entreprise->nombre_employes)
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Nombre d'employés</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $entreprise->nombre_employes }}</p>
                    </div>
                    @endif

                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Statut</p>
                        @if($entreprise->is_active)
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-danger">Inactive</span>
                        @endif
                    </div>

                    @if($entreprise->description)
                    <div class="md:col-span-2">
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Description</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $entreprise->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Contact -->
            <div class="card">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Contact</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">E-mail</p>
                        <a href="mailto:{{ $entreprise->email }}" class="text-base text-blue-600 dark:text-blue-400 hover:underline">{{ $entreprise->email }}</a>
                    </div>

                    @if($entreprise->telephone)
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Téléphone</p>
                        <a href="tel:{{ $entreprise->telephone }}" class="text-base text-blue-600 dark:text-blue-400 hover:underline">{{ $entreprise->telephone }}</a>
                    </div>
                    @endif

                    @if($entreprise->site_web)
                    <div class="md:col-span-2">
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Site web</p>
                        <a href="{{ $entreprise->site_web }}" target="_blank" class="text-base text-blue-600 dark:text-blue-400 hover:underline">{{ $entreprise->site_web }}</a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Localisation -->
            <div class="card">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Localisation</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($entreprise->adresse)
                    <div class="md:col-span-2">
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Adresse</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $entreprise->adresse }}</p>
                    </div>
                    @endif

                    @if($entreprise->ville)
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Ville</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $entreprise->ville }}</p>
                    </div>
                    @endif

                    @if($entreprise->code_postal)
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Code postal</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $entreprise->code_postal }}</p>
                    </div>
                    @endif

                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Pays</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $entreprise->pays }}</p>
                    </div>
                </div>
            </div>

            <!-- Informations légales -->
            @if($entreprise->numero_registre || $entreprise->numero_fiscal)
            <div class="card">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Informations légales</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($entreprise->numero_registre)
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Numéro de registre</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $entreprise->numero_registre }}</p>
                    </div>
                    @endif

                    @if($entreprise->numero_fiscal)
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Numéro fiscal</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $entreprise->numero_fiscal }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Logo -->
            <div class="card">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Logo</h2>
                @if($entreprise->logo)
                <img src="{{ asset($entreprise->logo) }}" alt="{{ $entreprise->nom }}" class="w-full h-48 object-contain rounded-lg bg-gray-50 dark:bg-gray-800 p-4">
                @else
                <div class="w-full h-48 rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-6xl">
                    {{ strtoupper(substr($entreprise->nom, 0, 2)) }}
                </div>
                @endif
            </div>

            <!-- Stats -->
            <div class="card">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Statistiques</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Utilisateurs</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $entreprise->utilisateurs->count() }}</p>
                        </div>
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Départements</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $entreprise->departements->count() }}</p>
                        </div>
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Services</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $entreprise->services->count() }}</p>
                        </div>
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
