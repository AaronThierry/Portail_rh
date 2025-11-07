@extends('layouts.app')

@section('title', 'Paramètres de Notifications')

@section('content')
<div class="settings-layout">
    @include('parametres.partials.sidebar')

    <div class="settings-sidebar-overlay" id="settingsSidebarOverlay"></div>

    <main class="settings-content">
        <div class="settings-header">
            <h1 class="settings-title">Paramètres de Notifications</h1>
            <p class="settings-description">Configuration des notifications et alertes</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('parametres.notifications.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="settings-section">
                <div class="settings-section-header">
                    <div class="settings-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="settings-section-title">Canaux de Notification</h3>
                        <p class="settings-section-description">Activer ou désactiver les canaux</p>
                    </div>
                </div>

                <div style="display: grid; gap: 16px;">
                    <label class="flex items-center gap-3 cursor-pointer p-4 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <input type="checkbox" name="email_notifications" value="1"
                               {{ old('email_notifications', $settings['email_notifications'] ?? true) ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                        <div>
                            <span class="font-semibold text-gray-900 dark:text-white">Notifications par Email</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Recevoir les notifications par email</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer p-4 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <input type="checkbox" name="sms_notifications" value="1"
                               {{ old('sms_notifications', $settings['sms_notifications'] ?? false) ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                        <div>
                            <span class="font-semibold text-gray-900 dark:text-white">Notifications par SMS</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Recevoir les notifications par SMS</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer p-4 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <input type="checkbox" name="push_notifications" value="1"
                               {{ old('push_notifications', $settings['push_notifications'] ?? false) ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                        <div>
                            <span class="font-semibold text-gray-900 dark:text-white">Notifications Push</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Recevoir les notifications push dans le navigateur</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="settings-section">
                <div class="settings-section-header">
                    <div class="settings-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                    </div>
                    <div>
                        <h3 class="settings-section-title">Types de Notifications</h3>
                        <p class="settings-section-description">Choisir quels événements notifier</p>
                    </div>
                </div>

                <div style="display: grid; gap: 16px;">
                    <label class="flex items-center gap-3 cursor-pointer p-4 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <input type="checkbox" name="notify_user_created" value="1"
                               {{ old('notify_user_created', $settings['notify_user_created'] ?? true) ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                        <div>
                            <span class="font-semibold text-gray-900 dark:text-white">Création d'utilisateur</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Notifier lors de la création d'un nouvel utilisateur</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer p-4 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <input type="checkbox" name="notify_leave_request" value="1"
                               {{ old('notify_leave_request', $settings['notify_leave_request'] ?? true) ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                        <div>
                            <span class="font-semibold text-gray-900 dark:text-white">Demandes de congé</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Notifier lors d'une nouvelle demande de congé</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer p-4 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <input type="checkbox" name="notify_document_shared" value="1"
                               {{ old('notify_document_shared', $settings['notify_document_shared'] ?? true) ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                        <div>
                            <span class="font-semibold text-gray-900 dark:text-white">Partage de documents</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Notifier lors du partage d'un document</p>
                        </div>
                    </label>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ route('parametres.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </main>

    <button class="settings-mobile-toggle" id="settingsMobileToggle">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M12 1v6m0 6v6m0-6h6m-6 0H6"></path>
        </svg>
    </button>
</div>

<link rel="stylesheet" href="{{ asset('assets/css/settings.css') }}">
@endsection
