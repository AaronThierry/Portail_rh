@extends('layouts.app')

@section('title', 'Paramètres — Portail RH+')
@section('page-title', 'Paramètres')
@section('page-subtitle', 'Configuration du système')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <circle cx="12" cy="12" r="3"></circle>
    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0 .33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.6a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
</svg>
@endsection

@section('styles')
<style>
/* ── Variables locales ───────────────────────────────── */
:root {
  --settings-accent: #3b82f6;
  --settings-amber: #f59e0b;
  --settings-emerald: #10b981;
  --settings-violet: #818cf8;
}

/* ── Layout ──────────────────────────────────────────── */
.settings-page {
  padding: 8px 0 32px;
  display: flex;
  flex-direction: column;
  gap: 24px;
}

/* ── Flash ───────────────────────────────────────────── */
.flash-bar {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 13px 18px;
  border-radius: var(--border-radius);
  font-size: 0.88rem;
  font-weight: 500;
  animation: flashIn 0.3s ease;
}
@keyframes flashIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }
.flash-bar.success { background: rgba(16,185,129,0.08); border: 1px solid rgba(16,185,129,0.2); color: #059669; }
.flash-bar.error   { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #dc2626; }

/* ── Stat cards row ──────────────────────────────────── */
.stats-row {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
}

.stat-card {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: box-shadow 0.2s ease, transform 0.2s ease;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.07); }

.stat-top-bar { height: 3px; flex-shrink: 0; }
.stat-top-bar.blue   { background: linear-gradient(90deg, #2563eb, #818cf8); }
.stat-top-bar.green  { background: linear-gradient(90deg, #059669, #10b981); }
.stat-top-bar.amber  { background: linear-gradient(90deg, #d97706, #fbbf24); }

.stat-inner {
  padding: 18px 20px 20px;
  display: flex;
  align-items: center;
  gap: 14px;
}

.stat-icon {
  width: 42px;
  height: 42px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.stat-icon.blue  { background: rgba(59,130,246,0.1); color: #3b82f6; }
.stat-icon.green { background: rgba(16,185,129,0.1); color: #10b981; }
.stat-icon.amber { background: rgba(245,158,11,0.1); color: #d97706; }

.stat-label {
  font-size: 0.73rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  color: var(--text-muted);
  margin-bottom: 3px;
}
.stat-value {
  font-size: 1.7rem;
  font-weight: 800;
  color: var(--text-primary);
  letter-spacing: -0.03em;
  line-height: 1;
}

/* ── Section title ───────────────────────────────────── */
.section-title {
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--text-muted);
  margin-bottom: 12px;
  padding-left: 2px;
}

/* ── Settings grid ───────────────────────────────────── */
.settings-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
}

.settings-card {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: box-shadow 0.2s ease;
}
.settings-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.06); }

.card-top-bar { height: 3px; flex-shrink: 0; }

.card-body { padding: 20px 22px 22px; flex: 1; display: flex; flex-direction: column; }

.card-header {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 18px;
}

.card-icon {
  width: 36px;
  height: 36px;
  border-radius: 9px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  color: white;
}
.card-icon.blue   { background: #3b82f6; }
.card-icon.violet { background: #818cf8; }
.card-icon.emerald{ background: #10b981; }
.card-icon.slate  { background: #64748b; }
.card-icon.amber  { background: #f59e0b; }

.card-title {
  font-size: 0.9rem;
  font-weight: 700;
  color: var(--text-primary);
  letter-spacing: -0.01em;
}
.card-subtitle {
  font-size: 0.73rem;
  color: var(--text-muted);
  margin-top: 1px;
}

/* ── Config rows ─────────────────────────────────────── */
.config-rows { flex: 1; display: flex; flex-direction: column; gap: 0; }

.config-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 0;
  border-bottom: 1px solid var(--card-border);
}
.config-row:last-child { border-bottom: none; }

.config-label {
  font-size: 0.78rem;
  color: var(--text-muted);
  font-weight: 500;
}
.config-value {
  font-size: 0.82rem;
  font-weight: 600;
  color: var(--text-primary);
  text-align: right;
  max-width: 55%;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/* ── Card footer link ────────────────────────────────── */
.card-footer {
  margin-top: 18px;
  padding-top: 14px;
  border-top: 1px solid var(--card-border);
  display: flex;
  justify-content: flex-end;
}

.card-link {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 0.78rem;
  font-weight: 600;
  color: var(--primary, #3b82f6);
  text-decoration: none;
  padding: 6px 12px;
  border-radius: 6px;
  transition: background 0.15s ease, color 0.15s ease;
}
.card-link:hover {
  background: rgba(59,130,246,0.08);
  color: var(--primary, #3b82f6);
}

/* ── Badge pills ─────────────────────────────────────── */
.badge-pill {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 3px 10px;
  border-radius: 20px;
  font-size: 0.72rem;
  font-weight: 700;
  letter-spacing: 0.02em;
}
.badge-pill.blue   { background: rgba(59,130,246,0.1); color: #2563eb; }
.badge-pill.green  { background: rgba(16,185,129,0.1); color: #059669; }
.badge-pill.amber  { background: rgba(245,158,11,0.1); color: #d97706; }
.badge-pill.red    { background: rgba(239,68,68,0.1);  color: #dc2626; }
.badge-pill.slate  { background: rgba(100,116,139,0.1); color: #475569; }

/* ── Roles/perms count row ───────────────────────────── */
.count-badges {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  margin-top: 2px;
}

/* ── System info grid ────────────────────────────────── */
.sysinfo-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
}
.sysinfo-item {
  background: var(--bg-tertiary);
  border: 1px solid var(--card-border);
  border-radius: 8px;
  padding: 10px 12px;
}
.sysinfo-item-label {
  font-size: 0.68rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  color: var(--text-muted);
  margin-bottom: 3px;
}
.sysinfo-item-value {
  font-size: 0.82rem;
  font-weight: 700;
  color: var(--text-primary);
}

/* ── Responsive ──────────────────────────────────────── */
@media (max-width: 900px) {
  .settings-grid { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
  .stats-row { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')
<div class="settings-page">

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="flash-bar success">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flash-bar error">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Statistiques --}}
    <div class="stats-row">
        {{-- Utilisateurs --}}
        <div class="stat-card">
            <div class="stat-top-bar blue"></div>
            <div class="stat-inner">
                <div class="stat-icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <div>
                    <div class="stat-label">Total utilisateurs</div>
                    <div class="stat-value">{{ $stats['total_users'] }}</div>
                </div>
            </div>
        </div>

        {{-- Actifs --}}
        <div class="stat-card">
            <div class="stat-top-bar green"></div>
            <div class="stat-inner">
                <div class="stat-icon green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <div>
                    <div class="stat-label">Comptes actifs</div>
                    <div class="stat-value">{{ $stats['active_users'] }}</div>
                </div>
            </div>
        </div>

        {{-- Entreprises --}}
        <div class="stat-card">
            <div class="stat-top-bar amber"></div>
            <div class="stat-inner">
                <div class="stat-icon amber">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </div>
                <div>
                    <div class="stat-label">Entreprises</div>
                    <div class="stat-value">{{ $stats['total_entreprises'] }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grille de configuration --}}
    <div>
        <div class="section-title">Configuration</div>
        <div class="settings-grid">

            {{-- Application --}}
            <div class="settings-card">
                <div class="card-top-bar" style="background: linear-gradient(90deg, #3b82f6, #818cf8);"></div>
                <div class="card-body">
                    <div class="card-header">
                        <div class="card-icon blue">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                        </div>
                        <div>
                            <div class="card-title">Application</div>
                            <div class="card-subtitle">Identité & branding</div>
                        </div>
                    </div>
                    <div class="config-rows">
                        <div class="config-row">
                            <span class="config-label">Nom</span>
                            <span class="config-value">{{ $settings['app_name'] ?? config('app.name') }}</span>
                        </div>
                        <div class="config-row">
                            <span class="config-label">Description</span>
                            <span class="config-value">{{ Str::limit($settings['app_description'] ?? '—', 30) }}</span>
                        </div>
                        @if($entreprise)
                        <div class="config-row">
                            <span class="config-label">Entreprise</span>
                            <span class="config-value">{{ $entreprise->nom }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Paramètres régionaux --}}
            <div class="settings-card">
                <div class="card-top-bar" style="background: linear-gradient(90deg, #10b981, #34d399);"></div>
                <div class="card-body">
                    <div class="card-header">
                        <div class="card-icon emerald">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        </div>
                        <div>
                            <div class="card-title">Paramètres régionaux</div>
                            <div class="card-subtitle">Langue, fuseau & format</div>
                        </div>
                    </div>
                    <div class="config-rows">
                        <div class="config-row">
                            <span class="config-label">Langue</span>
                            <span class="config-value">
                                @php $langMap = ['fr'=>'Français','en'=>'English','ar'=>'العربية']; @endphp
                                {{ $langMap[$settings['language'] ?? 'fr'] ?? $settings['language'] ?? 'Français' }}
                            </span>
                        </div>
                        <div class="config-row">
                            <span class="config-label">Fuseau horaire</span>
                            <span class="config-value">{{ $settings['timezone'] ?? config('app.timezone', 'UTC') }}</span>
                        </div>
                        <div class="config-row">
                            <span class="config-label">Format date</span>
                            <span class="config-value">{{ $settings['date_format'] ?? 'd/m/Y' }}</span>
                        </div>
                        <div class="config-row">
                            <span class="config-label">Devise</span>
                            <span class="config-value">{{ $settings['currency'] ?? 'FCFA' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rôles & Permissions --}}
            @hasrole('Super Admin')
            <div class="settings-card">
                <div class="card-top-bar" style="background: linear-gradient(90deg, #818cf8, #a78bfa);"></div>
                <div class="card-body">
                    <div class="card-header">
                        <div class="card-icon violet">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <div>
                            <div class="card-title">Rôles & Permissions</div>
                            <div class="card-subtitle">Contrôle d'accès</div>
                        </div>
                    </div>
                    <div class="config-rows">
                        @php
                            $rolesCount = \Spatie\Permission\Models\Role::count();
                            $permsCount = \Spatie\Permission\Models\Permission::count();
                        @endphp
                        <div class="config-row">
                            <span class="config-label">Rôles définis</span>
                            <span class="badge-pill blue">{{ $rolesCount }}</span>
                        </div>
                        <div class="config-row">
                            <span class="config-label">Permissions</span>
                            <span class="badge-pill violet" style="background: rgba(129,140,248,0.1); color: #6366f1;">{{ $permsCount }}</span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.roles.index') }}" class="card-link">
                            Gérer les rôles
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endhasrole

            {{-- Sécurité --}}
            <div class="settings-card">
                <div class="card-top-bar" style="background: linear-gradient(90deg, #f59e0b, #fbbf24);"></div>
                <div class="card-body">
                    <div class="card-header">
                        <div class="card-icon amber">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                        <div>
                            <div class="card-title">Sécurité</div>
                            <div class="card-subtitle">Authentification & sessions</div>
                        </div>
                    </div>
                    <div class="config-rows">
                        <div class="config-row">
                            <span class="config-label">Double authentification</span>
                            @if($settings['enable_2fa'] ?? false)
                                <span class="badge-pill green">Activée</span>
                            @else
                                <span class="badge-pill slate">Désactivée</span>
                            @endif
                        </div>
                        <div class="config-row">
                            <span class="config-label">Durée session</span>
                            <span class="config-value">{{ $settings['session_lifetime'] ?? 120 }} min</span>
                        </div>
                        <div class="config-row">
                            <span class="config-label">Tentatives max</span>
                            <span class="config-value">{{ $settings['max_login_attempts'] ?? 5 }}</span>
                        </div>
                        <div class="config-row">
                            <span class="config-label">Expiration mdp</span>
                            <span class="config-value">{{ $settings['password_expiry_days'] ?? 90 }} jours</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notifications --}}
            <div class="settings-card">
                <div class="card-top-bar" style="background: linear-gradient(90deg, #06b6d4, #38bdf8);"></div>
                <div class="card-body">
                    <div class="card-header">
                        <div class="card-icon" style="background: #06b6d4;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        </div>
                        <div>
                            <div class="card-title">Notifications</div>
                            <div class="card-subtitle">Canaux & événements</div>
                        </div>
                    </div>
                    <div class="config-rows">
                        <div class="config-row">
                            <span class="config-label">Email</span>
                            @if($settings['email_notifications'] ?? true)
                                <span class="badge-pill green">Actif</span>
                            @else
                                <span class="badge-pill slate">Inactif</span>
                            @endif
                        </div>
                        <div class="config-row">
                            <span class="config-label">SMS</span>
                            @if($settings['sms_notifications'] ?? false)
                                <span class="badge-pill green">Actif</span>
                            @else
                                <span class="badge-pill slate">Inactif</span>
                            @endif
                        </div>
                        <div class="config-row">
                            <span class="config-label">Création compte</span>
                            @if($settings['notify_user_created'] ?? true)
                                <span class="badge-pill blue">Activée</span>
                            @else
                                <span class="badge-pill slate">Désactivée</span>
                            @endif
                        </div>
                        <div class="config-row">
                            <span class="config-label">Demande congé</span>
                            @if($settings['notify_leave_request'] ?? true)
                                <span class="badge-pill blue">Activée</span>
                            @else
                                <span class="badge-pill slate">Désactivée</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Système (Super Admin uniquement) --}}
            @hasrole('Super Admin')
            <div class="settings-card">
                <div class="card-top-bar" style="background: linear-gradient(90deg, #64748b, #94a3b8);"></div>
                <div class="card-body">
                    <div class="card-header">
                        <div class="card-icon slate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                        </div>
                        <div>
                            <div class="card-title">Système</div>
                            <div class="card-subtitle">Environnement technique</div>
                        </div>
                    </div>
                    <div class="sysinfo-grid">
                        <div class="sysinfo-item">
                            <div class="sysinfo-item-label">PHP</div>
                            <div class="sysinfo-item-value">{{ PHP_MAJOR_VERSION }}.{{ PHP_MINOR_VERSION }}</div>
                        </div>
                        <div class="sysinfo-item">
                            <div class="sysinfo-item-label">Laravel</div>
                            <div class="sysinfo-item-value">{{ app()->version() }}</div>
                        </div>
                        <div class="sysinfo-item">
                            <div class="sysinfo-item-label">Base de données</div>
                            <div class="sysinfo-item-value">{{ ucfirst(config('database.default')) }}</div>
                        </div>
                        <div class="sysinfo-item">
                            <div class="sysinfo-item-label">Cache</div>
                            <div class="sysinfo-item-value">{{ ucfirst(config('cache.default')) }}</div>
                        </div>
                        <div class="sysinfo-item">
                            <div class="sysinfo-item-label">Mail</div>
                            <div class="sysinfo-item-value">{{ ucfirst(config('mail.default')) }}</div>
                        </div>
                        <div class="sysinfo-item">
                            <div class="sysinfo-item-label">Queue</div>
                            <div class="sysinfo-item-value">{{ ucfirst(config('queue.default')) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endhasrole

        </div>
    </div>

</div>
@endsection
