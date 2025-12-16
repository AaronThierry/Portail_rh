@extends('layouts.app')

@section('title', $service->nom)

@section('content')
<div class="service-show-page">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.services.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $service->nom }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        @if($service->departement)
                            {{ $service->departement->nom }}
                            @if($service->is_global)
                                (Service global)
                            @elseif($service->entreprise)
                                - {{ $service->entreprise->nom }}
                            @endif
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-primary">
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
                        <p class="text-base text-gray-900 dark:text-white">{{ $service->nom }}</p>
                    </div>

                    @if($service->code)
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Code</p>
                        <span class="px-3 py-1 text-sm font-mono bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded">
                            {{ $service->code }}
                        </span>
                    </div>
                    @endif

                    @if($service->departement)
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Département</p>
                        <a href="{{ route('admin.departements.show', $service->departement->id) }}" class="text-base text-blue-600 dark:text-blue-400 hover:underline">
                            {{ $service->departement->nom }}
                        </a>
                    </div>
                    @endif

                    @if($service->entreprise)
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Entreprise</p>
                        <a href="{{ route('admin.entreprises.show', $service->entreprise->id) }}" class="text-base text-blue-600 dark:text-blue-400 hover:underline">
                            {{ $service->entreprise->nom }}
                        </a>
                    </div>
                    @endif

                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Type</p>
                        @if($service->is_global)
                        <span class="badge badge-info">Global</span>
                        @else
                        <span class="badge badge-secondary">Entreprise</span>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Statut</p>
                        @if($service->is_active)
                        <span class="badge badge-success">Actif</span>
                        @else
                        <span class="badge badge-danger">Inactif</span>
                        @endif
                    </div>

                    @if($service->description)
                    <div class="md:col-span-2">
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Description</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $service->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Employés du service -->
            <div class="card">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Employés</h2>
                </div>

                @if($service->users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">
                                    Employé
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">
                                    E-mail
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">
                                    Rôle
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">
                                    Statut
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($service->users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 flex-shrink-0 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-xs">
                                            {{ strtoupper(substr($user->nom, 0, 1) . substr($user->prenom, 0, 1)) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ $user->nom }} {{ $user->prenom }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-900 dark:text-gray-200">{{ $user->email }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($user->role === 'admin')
                                    <span class="badge badge-primary">Admin</span>
                                    @elseif($user->role === 'super_admin')
                                    <span class="badge badge-danger">Super Admin</span>
                                    @else
                                    <span class="badge badge-secondary">Employé</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($user->statut === 'actif')
                                    <span class="badge badge-success">Actif</span>
                                    @elseif($user->statut === 'suspendu')
                                    <span class="badge badge-warning">Suspendu</span>
                                    @else
                                    <span class="badge badge-danger">Inactif</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="py-12 text-center text-gray-500 dark:text-gray-400">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p class="text-lg font-medium mb-2">Aucun employé affecté</p>
                    <p class="text-sm">Ce service n'a pas encore d'employés</p>
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
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $service->users->count() }}</p>
                        </div>
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
