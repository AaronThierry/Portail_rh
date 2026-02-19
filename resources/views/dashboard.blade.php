@extends('layouts.app')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Vue d\'ensemble de votre activite')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <rect x="3" y="3" width="7" height="7" rx="1"></rect>
    <rect x="14" y="3" width="7" height="7" rx="1"></rect>
    <rect x="3" y="14" width="7" height="7" rx="1"></rect>
    <rect x="14" y="14" width="7" height="7" rx="1"></rect>
</svg>
@endsection

@section('styles')
<style>
.dashboard-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px;
  margin-bottom: 28px;
}

.stat-card {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  padding: 22px;
  transition: var(--transition);
  position: relative;
  overflow: hidden;
}

.stat-card::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 4px;
  height: 100%;
}

.stat-card.card-primary::after { background: var(--primary); }
.stat-card.card-success::after { background: var(--success); }
.stat-card.card-warning::after { background: #f59e0b; }
.stat-card.card-info::after { background: var(--info); }
.stat-card.card-danger::after { background: var(--danger); }

.stat-card:hover {
  box-shadow: var(--shadow-lg);
  transform: translateY(-2px);
}

.stat-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 14px;
}

.stat-card-title {
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.stat-icon {
  width: 44px;
  height: 44px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
}

.stat-icon.bg-primary { background: linear-gradient(135deg, var(--primary), var(--primary-hover)); }
.stat-icon.bg-success { background: linear-gradient(135deg, var(--success), #059669); }
.stat-icon.bg-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.stat-icon.bg-info { background: linear-gradient(135deg, var(--info), #0891b2); }
.stat-icon.bg-danger { background: linear-gradient(135deg, var(--danger), #dc2626); }

.stat-value {
  font-size: 1.75rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 6px;
  line-height: 1;
}

.stat-sub {
  font-size: 0.8rem;
  color: var(--text-muted);
  display: flex;
  align-items: center;
  gap: 4px;
}

.stat-sub .badge-inline {
  display: inline-flex;
  align-items: center;
  gap: 3px;
  padding: 2px 8px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
}

.badge-green { background: rgba(16,185,129,0.1); color: #059669; }
.badge-red { background: rgba(239,68,68,0.1); color: #dc2626; }
.badge-orange { background: rgba(245,158,11,0.1); color: #d97706; }
.badge-blue { background: rgba(59,130,246,0.1); color: #2563eb; }

/* ── Chart card ───────────────────────────────────────── */
.chart-card {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  padding: 0;
  overflow: hidden;
  position: relative;
}

.chart-top-bar {
  height: 3px;
  background: linear-gradient(90deg, #3b82f6 0%, #818cf8 40%, #f59e0b 100%);
}

.chart-card-inner {
  padding: 20px 24px 24px;
}

.chart-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 20px;
}

.chart-title-block { flex: 1; }

.chart-title {
  font-size: 0.95rem;
  font-weight: 700;
  color: var(--text-primary);
  letter-spacing: -0.015em;
}

.chart-subtitle {
  font-size: 0.73rem;
  color: var(--text-muted);
  margin-top: 2px;
  letter-spacing: 0.01em;
}

.chart-legend {
  display: flex;
  gap: 8px;
  align-items: center;
  flex-shrink: 0;
}

.legend-pill {
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 3px 9px;
  border-radius: 20px;
  font-size: 0.7rem;
  font-weight: 600;
  letter-spacing: 0.02em;
}

.legend-pill-blue {
  background: rgba(59,130,246,0.08);
  color: #3b82f6;
  border: 1px solid rgba(59,130,246,0.2);
}

.legend-pill-amber {
  background: rgba(245,158,11,0.08);
  color: #d97706;
  border: 1px solid rgba(245,158,11,0.2);
}

.legend-dot {
  width: 7px;
  height: 7px;
  border-radius: 2px;
  flex-shrink: 0;
}

/* ── Activity feed ────────────────────────────────────── */
.recent-activities {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.activities-header {
  padding: 18px 20px 14px;
  border-bottom: 1px solid var(--card-border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-shrink: 0;
}

.activities-count {
  font-size: 0.7rem;
  font-weight: 700;
  color: var(--text-muted);
  background: var(--bg-tertiary);
  border: 1px solid var(--card-border);
  padding: 2px 9px;
  border-radius: 12px;
  letter-spacing: 0.03em;
}

.activity-list {
  display: flex;
  flex-direction: column;
  padding: 8px 0;
  position: relative;
  flex: 1;
  overflow-y: auto;
  overflow-x: hidden;
  /* Custom scrollbar */
  scrollbar-width: thin;
  scrollbar-color: var(--card-border) transparent;
}

.activity-list::-webkit-scrollbar {
  width: 4px;
}

.activity-list::-webkit-scrollbar-track {
  background: transparent;
}

.activity-list::-webkit-scrollbar-thumb {
  background: var(--card-border);
  border-radius: 2px;
}

.activity-list::-webkit-scrollbar-thumb:hover {
  background: var(--text-muted);
}

/* Timeline vertical connector */
.activity-list::before {
  content: '';
  position: absolute;
  left: 37px;
  top: 24px;
  bottom: 24px;
  width: 1px;
  background: linear-gradient(to bottom, var(--card-border) 60%, transparent 100%);
  pointer-events: none;
}

.activity-item {
  display: flex;
  gap: 12px;
  padding: 9px 20px;
  position: relative;
  transition: var(--transition);
  cursor: default;
  animation: activityFadeIn 0.35s ease both;
}

@keyframes activityFadeIn {
  from { opacity: 0; transform: translateX(-6px); }
  to   { opacity: 1; transform: translateX(0); }
}

.activity-item:nth-child(1) { animation-delay: 0.04s; }
.activity-item:nth-child(2) { animation-delay: 0.09s; }
.activity-item:nth-child(3) { animation-delay: 0.14s; }
.activity-item:nth-child(4) { animation-delay: 0.19s; }
.activity-item:nth-child(5) { animation-delay: 0.24s; }
.activity-item:nth-child(6) { animation-delay: 0.29s; }
.activity-item:nth-child(7) { animation-delay: 0.34s; }
.activity-item:nth-child(8) { animation-delay: 0.39s; }

.activity-item::before {
  content: '';
  position: absolute;
  left: 0;
  top: 6px;
  bottom: 6px;
  width: 2px;
  border-radius: 0 2px 2px 0;
  background: var(--primary);
  opacity: 0;
  transform: scaleY(0.4);
  transition: opacity 0.2s ease, transform 0.2s ease;
}

.activity-item:hover { background: var(--bg-tertiary); }
.activity-item:hover::before { opacity: 1; transform: scaleY(1); }

.activity-icon {
  width: 34px;
  height: 34px;
  border-radius: 9px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  color: white;
  position: relative;
  z-index: 1;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.activity-item:hover .activity-icon { transform: scale(1.06); }

.activity-icon.icon-success {
  background: #10b981;
  box-shadow: 0 0 0 3px rgba(16,185,129,0.12);
}
.activity-icon.icon-danger {
  background: #ef4444;
  box-shadow: 0 0 0 3px rgba(239,68,68,0.12);
}
.activity-icon.icon-warning {
  background: #f59e0b;
  box-shadow: 0 0 0 3px rgba(245,158,11,0.12);
}
.activity-icon.icon-info {
  background: #06b6d4;
  box-shadow: 0 0 0 3px rgba(6,182,212,0.12);
}
.activity-icon.icon-primary {
  background: var(--primary);
  box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}

.activity-content { flex: 1; min-width: 0; padding-top: 1px; }

.activity-title {
  font-size: 0.82rem;
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 1px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  letter-spacing: -0.01em;
}

.activity-description {
  font-size: 0.765rem;
  color: var(--text-muted);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  line-height: 1.45;
}

.activity-time {
  display: inline-block;
  margin-top: 3px;
  font-size: 0.67rem;
  font-weight: 500;
  color: var(--text-light, #9ca3af);
  letter-spacing: 0.025em;
}

.empty-activities {
  text-align: center;
  padding: 36px 20px;
  color: var(--text-muted);
}

.quick-actions {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  padding: 24px;
  margin-bottom: 24px;
}

.actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
  gap: 14px;
}

.action-btn {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  padding: 18px 12px;
  background: var(--bg-tertiary);
  border: 2px solid var(--card-border);
  border-radius: 12px;
  color: var(--text-primary);
  text-decoration: none;
  font-size: 0.8rem;
  font-weight: 600;
  text-align: center;
  transition: var(--transition);
  cursor: pointer;
}

.action-btn:hover {
  background: var(--primary);
  border-color: var(--primary);
  color: white;
  transform: translateY(-3px);
  box-shadow: var(--shadow-lg);
}

.action-btn svg { flex-shrink: 0; }

.summary-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
}

.summary-item {
  background: var(--bg-tertiary);
  border-radius: 10px;
  padding: 16px;
  text-align: center;
}

.summary-item .label {
  font-size: 0.75rem;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 6px;
}

.summary-item .value {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--text-primary);
}

.empty-activities {
  text-align: center;
  padding: 30px 20px;
  color: var(--text-muted);
}

@media (max-width: 768px) {
  .dashboard-grid { grid-template-columns: 1fr 1fr; }
  .main-charts { grid-template-columns: 1fr !important; }
  .actions-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 480px) {
  .dashboard-grid { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')
<div class="dashboard-content">
    {{-- Header --}}
    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary); margin-bottom: 6px;">
            Bonjour, {{ auth()->user()->prenom ?? auth()->user()->name ?? 'Admin' }}
        </h1>
        <p style="color: var(--text-muted); font-size: 0.95rem;">
            Voici un apercu de votre portail RH &mdash; {{ now()->translatedFormat('l j F Y') }}
        </p>
    </div>

    {{-- Cartes statistiques --}}
    <div class="dashboard-grid">
        {{-- Total Employes --}}
        <div class="stat-card card-primary">
            <div class="stat-card-header">
                <span class="stat-card-title">Employes actifs</span>
                <div class="stat-icon bg-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $totalEmployes }}</div>
            <div class="stat-sub">
                <span class="badge-inline badge-blue">{{ $employesAvecCompte }} avec compte</span>
            </div>
        </div>

        {{-- Conges en attente --}}
        <div class="stat-card card-warning">
            <div class="stat-card-header">
                <span class="stat-card-title">Conges en attente</span>
                <div class="stat-icon bg-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $statsConges['en_attente'] }}</div>
            <div class="stat-sub">
                <span class="badge-inline badge-green">{{ $statsConges['approuve'] }} approuves</span>
                <span class="badge-inline badge-red">{{ $statsConges['refuse'] }} refuses</span>
            </div>
        </div>

        {{-- Absences en attente --}}
        <div class="stat-card card-info">
            <div class="stat-card-header">
                <span class="stat-card-title">Absences en attente</span>
                <div class="stat-icon bg-info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $statsAbsences['en_attente'] }}</div>
            <div class="stat-sub">
                <span class="badge-inline badge-green">{{ $statsAbsences['justifiees'] }} justifiees</span>
                <span class="badge-inline badge-red">{{ $statsAbsences['injustifiees'] }} injustifiees</span>
            </div>
        </div>

        {{-- Bulletins de paie --}}
        <div class="stat-card card-primary">
            <div class="stat-card-header">
                <span class="stat-card-title">Bulletins {{ $annee }}</span>
                <div class="stat-icon bg-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $statsBulletins['total_bulletins'] }}</div>
            <div class="stat-sub">
                <span class="badge-inline badge-blue">{{ $statsBulletins['total_employes'] }} employes</span>
            </div>
        </div>

        {{-- Documents expirant --}}
        <div class="stat-card card-danger">
            <div class="stat-card-header">
                <span class="stat-card-title">Docs expirant (-30j)</span>
                <div class="stat-icon bg-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $docsExpirentBientot }}</div>
            <div class="stat-sub">
                @if($docsExpirentBientot > 0)
                    <span class="badge-inline badge-orange">A renouveler</span>
                @else
                    <span class="badge-inline badge-green">Tout est en ordre</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Actions rapides --}}
    <div class="quick-actions">
        <h2 class="chart-title" style="margin-bottom: 16px;">Actions rapides</h2>
        <div class="actions-grid">
            @if(auth()->user()->hasRole('Super Admin'))
            <a href="{{ route('admin.entreprises.index') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Entreprises
            </a>
            @endif
            <a href="{{ route('admin.personnels.create') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
                Ajouter employe
            </a>
            <a href="{{ route('admin.conges.index') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                Gestion conges
            </a>
            <a href="{{ route('admin.absences.index') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                Gestion absences
            </a>
            <a href="{{ route('admin.dossiers-agents.index') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"></path>
                </svg>
                Dossiers Agents
            </a>
            <a href="{{ route('admin.bulletins-paie.index') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
                Bulletins de Paie
            </a>
        </div>
    </div>

    {{-- Graphiques + Activites --}}
    <div class="main-charts" style="display: grid; grid-template-columns: 3fr 2fr; gap: 24px; margin-bottom: 24px; align-items: stretch;">

        {{-- Graphique conges/absences par mois --}}
        <div class="chart-card">
            <div class="chart-top-bar"></div>
            <div class="chart-card-inner">
                <div class="chart-header">
                    <div class="chart-title-block">
                        <h2 class="chart-title">Congés & Absences</h2>
                        <div class="chart-subtitle">Évolution mensuelle &mdash; {{ $annee }}</div>
                    </div>
                    <div class="chart-legend">
                        <div class="legend-pill legend-pill-blue">
                            <div class="legend-dot" style="background: #3b82f6;"></div>
                            Congés
                        </div>
                        <div class="legend-pill legend-pill-amber">
                            <div class="legend-dot" style="background: #f59e0b;"></div>
                            Absences
                        </div>
                    </div>
                </div>
                <div style="position: relative; height: 280px;">
                    <canvas id="chartCongesAbsences"></canvas>
                </div>
            </div>
        </div>

        {{-- Activites recentes --}}
        <div class="recent-activities">
            <div class="activities-header">
                <h2 class="chart-title">Activités récentes</h2>
                @if($activitesRecentes->count() > 0)
                    <span class="activities-count">{{ $activitesRecentes->count() }}</span>
                @endif
            </div>
            <div class="activity-list">
                @forelse($activitesRecentes as $activite)
                    <div class="activity-item">
                        <div class="activity-icon icon-{{ $activite['icon'] }}">
                            @if($activite['type'] === 'conge')
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    @if($activite['icon'] === 'success')
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    @else
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    @endif
                                </svg>
                            @elseif($activite['type'] === 'demande_conge')
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            @elseif($activite['type'] === 'absence')
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                            @elseif($activite['type'] === 'bulletin')
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            @elseif($activite['type'] === 'personnel')
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                </svg>
                            @endif
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $activite['titre'] }}</div>
                            <div class="activity-description">{{ $activite['description'] }}</div>
                            <span class="activity-time">{{ $activite['date']->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-activities">
                        <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 10px; opacity: 0.35;">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="3" y1="9" x2="21" y2="9"></line>
                        </svg>
                        <p style="font-size: 0.85rem;">Aucune activité récente</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Resume annuel --}}
    <div class="chart-card">
        <div class="chart-top-bar"></div>
        <div class="chart-card-inner">
        <div class="chart-header" style="margin-bottom: 16px;">
            <div class="chart-title-block">
                <h2 class="chart-title">Résumé annuel</h2>
                <div class="chart-subtitle">Données consolidées — {{ $annee }}</div>
            </div>
        </div>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="label">Total conges</div>
                <div class="value">{{ $statsConges['total'] }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Total absences</div>
                <div class="value">{{ $statsAbsences['total'] }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Retards</div>
                <div class="value">{{ $statsAbsences['retards'] }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Bulletins emis</div>
                <div class="value">{{ $statsBulletins['total_bulletins'] }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Masse salariale nette</div>
                <div class="value">{{ number_format($statsBulletins['masse_salariale_nette'] ?? 0, 0, ',', ' ') }} F</div>
            </div>
            <div class="summary-item">
                <div class="label">Entreprises</div>
                <div class="value">{{ $totalEntreprises }}</div>
            </div>
        </div>
        </div>{{-- /chart-card-inner --}}
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('chartCongesAbsences');
    if (!canvas) return;

    const moisLabels  = @json($moisLabels);
    const congesData  = @json($congesParMois);
    const absencesData = @json($absencesParMois);

    const style     = getComputedStyle(document.documentElement);
    const textColor = style.getPropertyValue('--text-muted').trim()   || '#6b7280';
    const gridColor = style.getPropertyValue('--card-border').trim()  || '#e5e7eb';

    const canvasCtx = canvas.getContext('2d');

    // Gradient fills — fade from solid top to transparent bottom
    const congeGrad = canvasCtx.createLinearGradient(0, 0, 0, 280);
    congeGrad.addColorStop(0,   'rgba(59, 130, 246, 0.82)');
    congeGrad.addColorStop(1,   'rgba(59, 130, 246, 0.18)');

    const absenceGrad = canvasCtx.createLinearGradient(0, 0, 0, 280);
    absenceGrad.addColorStop(0, 'rgba(245, 158, 11, 0.82)');
    absenceGrad.addColorStop(1, 'rgba(245, 158, 11, 0.18)');

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: moisLabels,
            datasets: [
                {
                    label: 'Congés approuvés',
                    data: congesData,
                    backgroundColor: congeGrad,
                    borderColor: 'rgba(59, 130, 246, 0.9)',
                    borderWidth: 1,
                    borderRadius: 5,
                    borderSkipped: false,
                },
                {
                    label: 'Absences',
                    data: absencesData,
                    backgroundColor: absenceGrad,
                    borderColor: 'rgba(245, 158, 11, 0.9)',
                    borderWidth: 1,
                    borderRadius: 5,
                    borderSkipped: false,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: { display: false },   // custom pills used instead
                tooltip: {
                    backgroundColor: 'rgba(12, 22, 40, 0.95)',
                    titleColor: '#e2e8f0',
                    bodyColor: '#94a3b8',
                    borderColor: 'rgba(148,163,184,0.15)',
                    borderWidth: 1,
                    padding: 14,
                    cornerRadius: 10,
                    titleFont: { size: 12, weight: '700' },
                    bodyFont: { size: 12 },
                    boxWidth: 9,
                    boxHeight: 9,
                    boxPadding: 4,
                    usePointStyle: true,
                    pointStyle: 'rectRounded',
                    callbacks: {
                        title: function(items) {
                            return items[0]?.label || '';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        color: textColor,
                        font: { size: 11, weight: '500' },
                        maxRotation: 0,
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: gridColor,
                        drawBorder: false,
                    },
                    border: { display: false, dash: [4, 4] },
                    ticks: {
                        color: textColor,
                        font: { size: 11 },
                        stepSize: 1,
                        precision: 0,
                        padding: 8,
                    }
                }
            },
            animation: {
                duration: 600,
                easing: 'easeOutQuart',
            }
        }
    });
});
</script>
@endsection
