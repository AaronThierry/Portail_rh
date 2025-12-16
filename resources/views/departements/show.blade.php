@extends('layouts.app')

@section('title', $departement->nom)

@section('content')
<div class="departement-show-page">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.departements.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $departement->nom }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        @if($departement->is_global)
                            Département global
                        @elseif($departement->entreprise)
                            {{ $departement->entreprise->nom }}
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.departements.edit', $departement->id) }}" class="btn btn-primary">
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
                        <p class="text-base text-gray-900 dark:text-white">{{ $departement->nom }}</p>
                    </div>

                    @if($departement->code)
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Code</p>
                        <span class="px-3 py-1 text-sm font-mono bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded">
                            {{ $departement->code }}
                        </span>
                    </div>
                    @endif

                    @if($departement->entreprise)
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Entreprise</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $departement->entreprise->nom }}</p>
                    </div>
                    @endif

                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Type</p>
                        @if($departement->is_global)
                        <span class="badge badge-info">Global</span>
                        @else
                        <span class="badge badge-secondary">Entreprise</span>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Statut</p>
                        @if($departement->is_active)
                        <span class="badge badge-success">Actif</span>
                        @else
                        <span class="badge badge-danger">Inactif</span>
                        @endif
                    </div>

                    @if($departement->description)
                    <div class="md:col-span-2">
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Description</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $departement->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Services du département -->
            <div class="card">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Services</h2>
                    <a href="{{ route('admin.services.create', ['departement_id' => $departement->id]) }}" class="btn btn-primary btn-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Nouveau Service
                    </a>
                </div>

                @if($departement->services->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">
                                    Service
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">
                                    Code
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">
                                    Employés
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">
                                    Statut
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($departement->services as $service)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $service->nom }}</div>
                                    @if($service->description)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($service->description, 40) }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($service->code)
                                    <span class="px-2 py-1 text-xs font-mono bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded">
                                        {{ $service->code }}
                                    </span>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $service->users->count() }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($service->is_active)
                                    <span class="badge badge-success">Actif</span>
                                    @else
                                    <span class="badge badge-danger">Inactif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.services.show', $service->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="Voir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.services.edit', $service->id) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300" title="Modifier">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="py-12 text-center text-gray-500 dark:text-gray-400">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-lg font-medium mb-2">Aucun service enregistré</p>
                    <p class="text-sm mb-4">Commencez par créer votre premier service</p>
                    <a href="{{ route('admin.services.create', ['departement_id' => $departement->id]) }}" class="btn btn-primary inline-flex">
                        Créer un service
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Stats -->
            <div class="card">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Statistiques</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Employés</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $departement->users->count() }}</p>
                        </div>
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Services</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $departement->services->count() }}</p>
                        </div>
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
