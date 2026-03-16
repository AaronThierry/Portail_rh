@extends('layouts.espace-employe')

@section('title', 'Mes Demandes')
@section('page-title', 'Mes Demandes')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Mes Demandes</span>
@endsection

@section('styles')
<style>
/* ════════════════════════════════════════════════════
   DEMANDES — Charte Portail RH+
   Indigo × Teal × Neutres · Syne · DM Sans · DM Mono
   ════════════════════════════════════════════════════ */

.dm-page { display: flex; flex-direction: column; gap: 1.75rem; animation: fadeUp .4s ease both; }

/* ── KPI row ──────────────────────────────────────── */
.dm-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.125rem;
}

.dm-kpi {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    border-left: 4px solid;
    padding: 1.25rem 1.375rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform .2s ease, box-shadow .2s ease;
}

.dm-kpi:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

.dm-kpi.total    { border-left-color: var(--ind-400); }
.dm-kpi.pending  { border-left-color: var(--amber-400); }
.dm-kpi.approved { border-left-color: var(--teal-400); }
.dm-kpi.rejected { border-left-color: var(--rose-400); }

.dm-kpi-ico {
    width: 44px;
    height: 44px;
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.dm-kpi-ico svg { width: 20px; height: 20px; }
.dm-kpi-ico.total    { background: rgba(55,72,200,.10);  color: var(--ind-500); }
.dm-kpi-ico.pending  { background: var(--amber-100);     color: var(--amber-400); }
.dm-kpi-ico.approved { background: rgba(10,175,162,.12); color: var(--teal-500); }
.dm-kpi-ico.rejected { background: var(--rose-100);      color: var(--rose-400); }

.dm-kpi-val {
    font-family: var(--font-d);
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text);
    line-height: 1;
}

.dm-kpi-lbl {
    font-size: .75rem;
    font-weight: 600;
    color: var(--text-3);
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-top: .2rem;
}

/* ── New request panel ────────────────────────────── */
.dm-new {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.dm-new-head {
    padding: 1.125rem 1.5rem;
    border-bottom: 1.5px solid var(--border-2);
    background: var(--n-50);
    display: flex;
    align-items: center;
    gap: .75rem;
}

.dm-new-head-ico {
    width: 34px;
    height: 34px;
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    border-radius: var(--r);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

.dm-new-head-ico svg { width: 16px; height: 16px; }

.dm-new-title {
    font-family: var(--font-d);
    font-size: .9375rem;
    font-weight: 700;
    color: var(--text);
}

.dm-types-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 1rem;
    padding: 1.5rem;
}

.dm-type-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .75rem;
    padding: 1.5rem 1rem;
    background: var(--n-50);
    border: 1.5px solid var(--border-2);
    border-radius: var(--r-xl);
    cursor: pointer;
    transition: transform .25s cubic-bezier(.4,0,.2,1), box-shadow .25s ease, border-color .25s ease;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.dm-type-btn::before {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: var(--dm-color, var(--ind-400));
    opacity: 0;
    transition: opacity .25s ease;
}

.dm-type-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: var(--dm-color, var(--ind-300));
}

.dm-type-btn:hover::before { opacity: 1; }

.dm-type-ico {
    width: 52px;
    height: 52px;
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    transition: transform .25s ease;
}

.dm-type-btn:hover .dm-type-ico { transform: scale(1.1) rotate(-5deg); }
.dm-type-ico svg { width: 24px; height: 24px; }

.dm-type-lbl {
    font-family: var(--font-d);
    font-size: .875rem;
    font-weight: 700;
    color: var(--text);
    text-align: center;
    line-height: 1.3;
}

.dm-type-sub {
    font-size: .72rem;
    color: var(--text-3);
    text-align: center;
}

/* ── History section ──────────────────────────────── */
.dm-history {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.dm-history-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.125rem 1.5rem;
    border-bottom: 1.5px solid var(--border-2);
    background: var(--n-50);
    flex-wrap: wrap;
    gap: .75rem;
}

.dm-history-title {
    display: flex;
    align-items: center;
    gap: .75rem;
    font-family: var(--font-d);
    font-size: .9375rem;
    font-weight: 700;
    color: var(--text);
}

.dm-section-ico {
    width: 34px;
    height: 34px;
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    border-radius: var(--r);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

.dm-section-ico svg { width: 16px; height: 16px; }

/* ── Filter pills ─────────────────────────────────── */
.dm-filters {
    display: flex;
    gap: .375rem;
    flex-wrap: wrap;
}

.dm-pill {
    padding: .35rem .875rem;
    background: var(--n-100);
    border: 1.5px solid transparent;
    border-radius: var(--r-f);
    font-size: .75rem;
    font-weight: 600;
    color: var(--text-3);
    cursor: pointer;
    transition: all .2s ease;
    white-space: nowrap;
}

.dm-pill:hover { color: var(--ind-500); background: rgba(55,72,200,.08); }

.dm-pill.active {
    background: var(--ind-900);
    color: #fff;
    border-color: var(--ind-900);
}

/* ── Demande list ─────────────────────────────────── */
.dm-list { padding: .75rem; display: flex; flex-direction: column; gap: .5rem; }

.dm-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.125rem 1.25rem;
    background: var(--n-50);
    border: 1.5px solid var(--border-2);
    border-radius: var(--r-lg);
    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
}

.dm-item:hover {
    transform: translateX(3px);
    box-shadow: var(--shadow);
    border-color: var(--border);
}

.dm-item-ico {
    width: 46px;
    height: 46px;
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #fff;
}

.dm-item-ico svg { width: 20px; height: 20px; }

.dm-item-body { flex: 1; min-width: 0; }

.dm-item-type {
    font-weight: 700;
    font-size: .9375rem;
    color: var(--text);
    margin: 0 0 .2rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.dm-item-meta {
    font-family: var(--font-m);
    font-size: .75rem;
    color: var(--text-3);
}

.dm-item-meta .sep { margin: 0 .375rem; opacity: .5; }

/* ── Status badges ────────────────────────────────── */
.dm-badge {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .35rem .75rem;
    border-radius: var(--r-f);
    font-size: .72rem;
    font-weight: 600;
    white-space: nowrap;
    flex-shrink: 0;
}

.dm-badge svg { width: 11px; height: 11px; }
.dm-badge.pending  { background: var(--amber-100);     color: var(--amber-400); }
.dm-badge.approved { background: rgba(10,175,162,.10); color: var(--teal-500); }
.dm-badge.rejected { background: var(--rose-100);      color: var(--rose-400); }
.dm-badge.cancelled{ background: var(--n-100);          color: var(--text-3); }

/* ── Empty ────────────────────────────────────────── */
.dm-empty { text-align: center; padding: 4rem 2rem; }

.dm-empty-ico {
    width: 88px;
    height: 88px;
    margin: 0 auto 1.5rem;
    background: rgba(55,72,200,.07);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ind-400);
}

.dm-empty-ico svg { width: 42px; height: 42px; opacity: .65; }

.dm-empty h3 {
    font-family: var(--font-d);
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 .5rem;
}

.dm-empty p { font-size: .9rem; color: var(--text-2); margin: 0; }

/* ── Responsive ───────────────────────────────────── */
@media (max-width: 1024px) { .dm-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px) {
    .dm-stats      { grid-template-columns: 1fr; }
    .dm-types-grid { grid-template-columns: repeat(2, 1fr); }
    .dm-history-head { flex-direction: column; align-items: flex-start; }
}
</style>
@endsection

@section('content')
<div class="dm-page">

    {{-- ── KPI Stats ── --}}
    @php
        $total    = $demandes->count();
        $pending  = $demandes->where('statut', 'en_attente')->count();
        $approved = $demandes->where('statut', 'approuve')->count();
        $rejected = $demandes->where('statut', 'refuse')->count();
    @endphp
    <div class="dm-stats">
        <div class="dm-kpi total">
            <div class="dm-kpi-ico total">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div>
                <div class="dm-kpi-val">{{ $total }}</div>
                <div class="dm-kpi-lbl">Total</div>
            </div>
        </div>
        <div class="dm-kpi pending">
            <div class="dm-kpi-ico pending">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <div class="dm-kpi-val">{{ $pending }}</div>
                <div class="dm-kpi-lbl">En attente</div>
            </div>
        </div>
        <div class="dm-kpi approved">
            <div class="dm-kpi-ico approved">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div>
                <div class="dm-kpi-val">{{ $approved }}</div>
                <div class="dm-kpi-lbl">Approuvées</div>
            </div>
        </div>
        <div class="dm-kpi rejected">
            <div class="dm-kpi-ico rejected">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <div>
                <div class="dm-kpi-val">{{ $rejected }}</div>
                <div class="dm-kpi-lbl">Refusées</div>
            </div>
        </div>
    </div>

    {{-- ── New Request ── --}}
    <div class="dm-new">
        <div class="dm-new-head">
            <div class="dm-new-head-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
            </div>
            <span class="dm-new-title">Nouvelle demande</span>
        </div>

        <div class="dm-types-grid">
            {{-- Congé --}}
            <a href="{{ route('espace-employe.conges') }}" class="dm-type-btn" style="--dm-color: #7C3AED;">
                <div class="dm-type-ico" style="background: linear-gradient(135deg, #7C3AED, #6D28D9);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <span class="dm-type-lbl">Congé / Absence</span>
                <span class="dm-type-sub">Demande de congé ou signaler une absence</span>
            </a>

            {{-- Attestation --}}
            <a href="{{ route('espace-employe.attestations') }}" class="dm-type-btn" style="--dm-color: var(--ind-400);">
                <div class="dm-type-ico" style="background: linear-gradient(135deg, var(--ind-500), var(--ind-600));">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <span class="dm-type-lbl">Attestation</span>
                <span class="dm-type-sub">Travail, salaire ou présence</span>
            </a>

            {{-- Avance sur salaire --}}
            <button class="dm-type-btn" style="--dm-color: var(--teal-400);"
                    onclick="alert('Fonctionnalité bientôt disponible.')">
                <div class="dm-type-ico" style="background: linear-gradient(135deg, var(--teal-400), var(--teal-300));">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                <span class="dm-type-lbl">Avance sur salaire</span>
                <span class="dm-type-sub">Bientôt disponible</span>
            </button>

            {{-- Autre --}}
            <button class="dm-type-btn" style="--dm-color: var(--amber-400);"
                    onclick="alert('Fonctionnalité bientôt disponible.')">
                <div class="dm-type-ico" style="background: linear-gradient(135deg, var(--amber-400), #D97706);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="12" y1="18" x2="12" y2="12"/>
                        <line x1="9" y1="15" x2="15" y2="15"/>
                    </svg>
                </div>
                <span class="dm-type-lbl">Autre demande</span>
                <span class="dm-type-sub">Demande spécifique</span>
            </button>
        </div>
    </div>

    {{-- ── History ── --}}
    <div class="dm-history">
        <div class="dm-history-head">
            <div class="dm-history-title">
                <div class="dm-section-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                Historique des demandes
            </div>
            <div class="dm-filters">
                <button class="dm-pill active" data-filter="all">Toutes</button>
                <button class="dm-pill" data-filter="en_attente">En attente</button>
                <button class="dm-pill" data-filter="approuve">Approuvées</button>
                <button class="dm-pill" data-filter="refuse">Refusées</button>
            </div>
        </div>

        <div class="dm-list">
            @if($demandes->count() > 0)
                @foreach($demandes as $demande)
                <div class="dm-item" data-statut="{{ $demande->statut }}">
                    <div class="dm-item-ico" style="background: {{ $demande->typeConge->couleur ?? 'var(--ind-500)' }};">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                        </svg>
                    </div>
                    <div class="dm-item-body">
                        <p class="dm-item-type">
                            {{ $demande->typeConge->nom ?? 'Congé' }}
                            &mdash;
                            {{ $demande->nombre_jours }}&thinsp;{{ $demande->nombre_jours > 1 ? 'jours' : 'jour' }}
                        </p>
                        <span class="dm-item-meta">
                            {{ $demande->date_debut->format('d/m/Y') }} → {{ $demande->date_fin->format('d/m/Y') }}
                            <span class="sep">·</span>
                            {{ $demande->created_at->diffForHumans() }}
                        </span>
                    </div>

                    @switch($demande->statut)
                        @case('en_attente')
                            <span class="dm-badge pending">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                En attente
                            </span>
                            @break
                        @case('approuve')
                            <span class="dm-badge approved">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                Approuvé
                            </span>
                            @break
                        @case('refuse')
                            <span class="dm-badge rejected">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                Refusé
                            </span>
                            @break
                        @case('annule')
                            <span class="dm-badge cancelled">Annulé</span>
                            @break
                    @endswitch
                </div>
                @endforeach
            @else
                <div class="dm-empty">
                    <div class="dm-empty-ico">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <h3>Aucune demande</h3>
                    <p>Vous n'avez pas encore effectué de demande.</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.dm-pill').forEach(function (pill) {
    pill.addEventListener('click', function () {
        document.querySelectorAll('.dm-pill').forEach(function (p) { p.classList.remove('active'); });
        this.classList.add('active');
        var filter = this.dataset.filter;
        document.querySelectorAll('.dm-item').forEach(function (item) {
            item.style.display = (filter === 'all' || item.dataset.statut === filter) ? '' : 'none';
        });
    });
});
</script>
@endsection
