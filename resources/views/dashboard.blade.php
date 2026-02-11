@extends('layouts.app')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Vue d\'ensemble de votre activité')
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
/* Dashboard specific styles */
.dashboard-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 24px;
  margin-bottom: 32px;
}

.stat-card {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  padding: 24px;
  transition: var(--transition);
}

.stat-card:hover {
  box-shadow: var(--shadow-lg);
  transform: translateY(-2px);
}

.stat-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
}

.stat-card-title {
  font-size: 0.875rem;
  font-weight: 600;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, var(--primary), var(--primary-hover));
  color: white;
}

.stat-icon.success {
  background: linear-gradient(135deg, var(--success), #059669);
}

.stat-icon.warning {
  background: linear-gradient(135deg, var(--warning), #d97706);
}

.stat-icon.info {
  background: linear-gradient(135deg, var(--info), #0891b2);
}

.stat-value {
  font-size: 2rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 8px;
  line-height: 1;
}

.stat-change {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 0.875rem;
  font-weight: 600;
}

.stat-change.positive {
  color: var(--success);
}

.stat-change.negative {
  color: var(--danger);
}

.chart-card {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  padding: 24px;
  margin-bottom: 24px;
}

.chart-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
  padding-bottom: 16px;
  border-bottom: 1px solid var(--card-border);
}

.chart-title {
  font-size: 1.125rem;
  font-weight: 700;
  color: var(--text-primary);
}

.chart-filters {
  display: flex;
  gap: 8px;
}

.filter-btn {
  padding: 8px 16px;
  background: var(--bg-tertiary);
  border: 2px solid var(--card-border);
  border-radius: 8px;
  color: var(--text-secondary);
  font-size: 0.875rem;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}

.filter-btn:hover {
  background: var(--bg-secondary);
  border-color: var(--primary);
  color: var(--text-primary);
}

.filter-btn.active {
  background: var(--primary);
  border-color: var(--primary);
  color: white;
  box-shadow: var(--shadow-md);
}

.recent-activities {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  padding: 24px;
}

.activity-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.activity-item {
  display: flex;
  gap: 16px;
  padding: 16px;
  background: var(--bg-tertiary);
  border-radius: 10px;
  transition: var(--transition);
}

.activity-item:hover {
  background: var(--bg-secondary);
  box-shadow: var(--shadow-sm);
}

.activity-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  background: var(--primary);
  color: white;
}

.activity-content {
  flex: 1;
  min-width: 0;
}

.activity-title {
  font-size: 0.9375rem;
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 4px;
}

.activity-description {
  font-size: 0.875rem;
  color: var(--text-muted);
  margin-bottom: 4px;
}

.activity-time {
  font-size: 0.75rem;
  color: var(--text-light);
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
  grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
  gap: 16px;
}

.action-btn {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  padding: 20px;
  background: var(--bg-tertiary);
  border: 2px solid var(--card-border);
  border-radius: 12px;
  color: var(--text-primary);
  text-decoration: none;
  font-size: 0.875rem;
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

.action-btn svg {
  transition: var(--transition);
}

.action-btn svg {
  flex-shrink: 0;
}

@media (max-width: 768px) {
  .dashboard-grid {
    grid-template-columns: 1fr;
  }

  .chart-filters {
    flex-wrap: wrap;
  }

  .actions-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <!-- Page Header -->
    <div style="margin-bottom: 32px;">
        <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--text-primary); margin-bottom: 8px;">
            Bonjour, {{ auth()->user()->prenom ?? 'Admin' }} 👋
        </h1>
        <p style="color: var(--text-muted); font-size: 1rem;">
            Voici un aperçu de votre portail RH aujourd'hui
        </p>
    </div>

    <!-- Statistics Cards -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-card-title">Total Employés</span>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $totalEmployees ?? 248 }}</div>
            <div class="stat-change positive">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                    <polyline points="17 6 23 6 23 12"></polyline>
                </svg>
                +12% ce mois
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-card-title">Présents Aujourd'hui</span>
                <div class="stat-icon success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $presentToday ?? 231 }}</div>
            <div class="stat-change positive">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                    <polyline points="17 6 23 6 23 12"></polyline>
                </svg>
                93.1% taux de présence
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-card-title">Congés en attente</span>
                <div class="stat-icon warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $pendingLeaves ?? 15 }}</div>
            <div class="stat-change negative">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                    <polyline points="17 18 23 18 23 12"></polyline>
                </svg>
                +3 depuis hier
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-card-title">Nouvelles Candidatures</span>
                <div class="stat-icon info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <polyline points="17 11 19 13 23 9"></polyline>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $newCandidates ?? 42 }}</div>
            <div class="stat-change positive">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                    <polyline points="17 6 23 6 23 12"></polyline>
                </svg>
                +8 cette semaine
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2 class="chart-title" style="margin-bottom: 20px;">Actions rapides</h2>
        <div class="actions-grid">
            @if(auth()->user()->hasRole('Super Admin'))
            <a href="{{ route('admin.entreprises.index') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Gérer entreprises
            </a>
            @endif
            <a href="{{ route('admin.dossiers-agents.index') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"></path>
                </svg>
                Dossiers Agents
            </a>
            <a href="{{ route('admin.bulletins-paie.index') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
                Bulletins de Paie
            </a>
            <a href="{{ route('admin.personnels.create') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
                Ajouter un employé
            </a>
            <a href="#" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                Gestion congés
            </a>
            <a href="#" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                Rapports
            </a>
        </div>
    </div>

    <!-- Charts Section -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 24px;">
        <div class="chart-card">
            <div class="chart-header">
                <h2 class="chart-title">Présence mensuelle</h2>
                <div class="chart-filters">
                    <button class="filter-btn active">7 jours</button>
                    <button class="filter-btn">30 jours</button>
                    <button class="filter-btn">12 mois</button>
                </div>
            </div>
            <div style="height: 300px; display: flex; align-items: center; justify-content: center; background: var(--bg-tertiary); border-radius: 10px;">
                <p style="color: var(--text-muted);">Graphique de présence (à intégrer avec Chart.js ou similar)</p>
            </div>
        </div>

        <div class="recent-activities">
            <h2 class="chart-title" style="margin-bottom: 20px;">Activités récentes</h2>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon" style="background: var(--success);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Congé approuvé</div>
                        <div class="activity-description">Marie Dubois - 5 jours validés</div>
                        <div class="activity-time">Il y a 10 minutes</div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon" style="background: var(--primary);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="20" y1="8" x2="20" y2="14"></line>
                            <line x1="23" y1="11" x2="17" y2="11"></line>
                        </svg>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Nouvel employé</div>
                        <div class="activity-description">Thomas Martin a été ajouté</div>
                        <div class="activity-time">Il y a 1 heure</div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon" style="background: var(--info);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Document signé</div>
                        <div class="activity-description">Contrat CDI - Sophie Laurent</div>
                        <div class="activity-time">Il y a 2 heures</div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon" style="background: var(--warning);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Entretien programmé</div>
                        <div class="activity-description">Alexandre Petit - Demain 14h</div>
                        <div class="activity-time">Il y a 3 heures</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Dashboard specific JavaScript
console.log('Dashboard page loaded');

// Example: Initialize chart filters
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Remove active class from all buttons
        this.parentElement.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        // Add active class to clicked button
        this.classList.add('active');

        // TODO: Load chart data based on selected filter
        console.log('Filter changed to:', this.textContent);
    });
});
</script>
@endsection
