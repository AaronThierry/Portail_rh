@extends('layouts.app')

@section('title', 'Alertes Documents — Dossiers Agents')
@section('page-title', 'Alertes Documents')
@section('page-subtitle', 'Documents expirés ou arrivant à échéance')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
</svg>
@endsection

@section('styles')
<style>
/* ============================================================
   ALERTES DOCUMENTS — Indigo × Teal Charter (dossier-agent)
   ============================================================ */
:root {
    --da-ind:       #6366f1;
    --da-ind-dk:    #4338ca;
    --da-ind-pale:  rgba(99,102,241,.12);
    --da-teal:      #14b8a6;
    --da-teal-dk:   #0d9488;
    --da-teal-pale: rgba(20,184,166,.12);
    --da-amber:     #f59e0b;
    --da-amber-pale:rgba(245,158,11,.12);
    --da-red:       #ef4444;
    --da-red-pale:  rgba(239,68,68,.12);
    --da-surf:      #ffffff;
    --da-bg:        #f8fafc;
    --da-text:      #1e293b;
    --da-text-2:    #64748b;
    --da-text-3:    #94a3b8;
    --da-border:    #e2e8f0;
    --da-r:         12px;
    --da-r-lg:      16px;
    --da-r-xl:      20px;
    --da-sh-sm:     0 1px 3px rgba(0,0,0,.05);
    --da-sh-md:     0 4px 12px rgba(0,0,0,.07);
}
.dark {
    --da-surf:   #1e293b;
    --da-bg:     #0f172a;
    --da-text:   #f1f5f9;
    --da-text-2: #94a3b8;
    --da-text-3: #64748b;
    --da-border: #334155;
    --da-sh-sm:  0 1px 3px rgba(0,0,0,.3);
    --da-sh-md:  0 4px 12px rgba(0,0,0,.4);
}

@keyframes da-up { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }

/* ── Page ── */
.da-page {
    font-family: 'DM Sans', sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem 3rem;
    animation: da-up .4s cubic-bezier(.16,1,.3,1);
}

/* ── Hero ── */
.da-hero { border-radius: var(--da-r-xl); overflow: hidden; margin-bottom: 1.75rem; }
.da-hero-bg {
    background: linear-gradient(135deg, #312e81 0%, #4338ca 45%, #0d9488 100%);
    padding: 2rem 2rem 1.75rem;
    position: relative;
}
.da-hero-bg::before {
    content:''; position:absolute; top:-60px; right:-60px;
    width:280px; height:280px;
    background:radial-gradient(circle,rgba(20,184,166,.35) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
.da-hero-bg::after {
    content:''; position:absolute; bottom:-40px; left:-40px;
    width:200px; height:200px;
    background:radial-gradient(circle,rgba(99,102,241,.3) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
.da-hero-inner {
    position:relative; display:flex; align-items:flex-end;
    justify-content:space-between; gap:1.5rem; flex-wrap:wrap;
}
.da-hero-left h1 {
    font-family:'Syne',sans-serif; font-size:1.75rem; font-weight:700;
    color:#fff; margin:0 0 .35rem; letter-spacing:-.4px; line-height:1.2;
}
.da-hero-left p { font-size:.875rem; color:rgba(255,255,255,.7); margin:0; }
.da-hero-accent {
    height:3px;
    background:linear-gradient(90deg,transparent,rgba(99,102,241,.6),rgba(20,184,166,.8),transparent);
}

/* ── Breadcrumb ── */
.da-breadcrumb {
    display:flex; align-items:center; gap:.5rem;
    font-size:.8125rem; color:rgba(255,255,255,.6);
    margin-bottom:.875rem;
}
.da-breadcrumb a { color:rgba(255,255,255,.7); text-decoration:none; }
.da-breadcrumb a:hover { color:#fff; }
.da-breadcrumb svg { width:14px; height:14px; flex-shrink:0; }

/* ── KPI chips ── */
.da-hero-kpis {
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.12);
    border-radius:var(--da-r-lg);
    padding:.875rem 1.5rem;
    display:flex; gap:2rem;
    backdrop-filter:blur(8px);
}
.da-hero-kpi { text-align:center; position:relative; }
.da-hero-kpi + .da-hero-kpi::before {
    content:''; position:absolute; left:-1rem; top:10%; bottom:10%;
    width:1px; background:rgba(255,255,255,.15);
}
.da-hero-kpi-val { font-family:'Syne',sans-serif; font-size:1.5rem; font-weight:700; color:#fff; line-height:1; }
.da-hero-kpi-lbl { font-size:.6875rem; color:rgba(255,255,255,.6); text-transform:uppercase; letter-spacing:.5px; font-weight:600; margin-top:.3rem; }
.da-hero-kpi-val.red    { color:#fca5a5; }
.da-hero-kpi-val.amber  { color:#fde68a; }

/* ── Boutons ── */
.da-btn {
    display:inline-flex; align-items:center; gap:.5rem;
    padding:.625rem 1.25rem; border-radius:var(--da-r);
    font-family:'DM Sans',sans-serif; font-size:.8125rem; font-weight:600;
    cursor:pointer; transition:all .2s cubic-bezier(.4,0,.2,1);
    border:1.5px solid transparent; text-decoration:none; white-space:nowrap; line-height:1.4;
}
.da-btn svg { width:16px; height:16px; flex-shrink:0; }
.da-btn-outline {
    background:rgba(255,255,255,.12); color:#fff; border-color:rgba(255,255,255,.25);
}
.da-btn-outline:hover { background:rgba(255,255,255,.2); color:#fff; }

/* ── Filter tabs ── */
.da-tabs {
    display:flex; gap:.5rem; margin-bottom:1.5rem;
    animation: da-up .4s cubic-bezier(.16,1,.3,1) .1s both;
}
.da-tab {
    display:inline-flex; align-items:center; gap:.5rem;
    padding:.5rem 1rem; border-radius:var(--da-r);
    font-size:.8125rem; font-weight:600; cursor:pointer;
    text-decoration:none; transition:all .2s ease;
    border:1.5px solid var(--da-border);
    background:var(--da-surf); color:var(--da-text-2);
}
.da-tab:hover { border-color:var(--da-ind); color:var(--da-ind); }
.da-tab.active-danger {
    background:var(--da-red-pale); color:var(--da-red);
    border-color:rgba(239,68,68,.3);
}
.da-tab.active-warning {
    background:var(--da-amber-pale); color:var(--da-amber);
    border-color:rgba(245,158,11,.3);
}
.da-tab.active-all {
    background:var(--da-ind-pale); color:var(--da-ind);
    border-color:rgba(99,102,241,.3);
}
.da-tab-count {
    display:inline-flex; align-items:center; justify-content:center;
    width:20px; height:20px; border-radius:50%;
    font-size:.6875rem; font-weight:700;
}
.da-tab.active-danger .da-tab-count { background:var(--da-red); color:#fff; }
.da-tab.active-warning .da-tab-count { background:var(--da-amber); color:#fff; }
.da-tab.active-all .da-tab-count { background:var(--da-ind); color:#fff; }

/* ── Section ── */
.da-section {
    margin-bottom: 2rem;
    animation: da-up .4s cubic-bezier(.16,1,.3,1) .15s both;
}
.da-section-header {
    display:flex; align-items:center; gap:.75rem;
    margin-bottom:1rem;
}
.da-section-badge {
    display:inline-flex; align-items:center; gap:.5rem;
    padding:.375rem .875rem; border-radius:var(--da-r);
    font-size:.8125rem; font-weight:700;
}
.da-section-badge.danger  { background:var(--da-red-pale);   color:var(--da-red); }
.da-section-badge.warning { background:var(--da-amber-pale); color:var(--da-amber); }
.da-section-badge svg { width:14px; height:14px; }

/* ── Table ── */
.da-card {
    background:var(--da-surf); border:1px solid var(--da-border);
    border-radius:var(--da-r-lg); overflow:hidden;
    box-shadow:var(--da-sh-sm);
}
.da-table { width:100%; border-collapse:collapse; }
.da-table thead th {
    padding:.75rem 1rem; font-size:.75rem; font-weight:600;
    text-transform:uppercase; letter-spacing:.5px; color:var(--da-text-3);
    border-bottom:1px solid var(--da-border); text-align:left;
    background:var(--da-bg);
}
.da-table tbody td {
    padding:.875rem 1rem; font-size:.875rem; color:var(--da-text);
    border-bottom:1px solid var(--da-border);
    vertical-align:middle;
}
.da-table tbody tr:last-child td { border-bottom:none; }
.da-table tbody tr:hover { background:var(--da-bg); }

/* ── Employe cell ── */
.da-emp-cell { display:flex; align-items:center; gap:.75rem; }
.da-emp-avatar {
    width:36px; height:36px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    font-family:'Syne',sans-serif; font-size:.75rem; font-weight:700;
    color:#fff; flex-shrink:0;
    background:linear-gradient(135deg,#6366f1,#4338ca);
}
.da-emp-name { font-weight:600; }
.da-emp-matricule { font-size:.75rem; color:var(--da-text-3); }

/* ── Catégorie badge ── */
.da-cat-badge {
    display:inline-flex; align-items:center; gap:.375rem;
    padding:.25rem .625rem; border-radius:8px;
    font-size:.75rem; font-weight:600;
    background:var(--da-ind-pale); color:var(--da-ind);
}

/* ── Date expiration ── */
.da-date-cell { display:flex; align-items:center; gap:.5rem; }
.da-date-chip {
    padding:.25rem .625rem; border-radius:8px;
    font-size:.75rem; font-weight:700; font-family:'DM Mono',monospace;
}
.da-date-chip.expired  { background:var(--da-red-pale);   color:var(--da-red); }
.da-date-chip.soon     { background:var(--da-amber-pale); color:var(--da-amber); }
.da-days-badge {
    font-size:.7rem; font-weight:600; padding:.15rem .5rem;
    border-radius:6px; white-space:nowrap;
}
.da-days-badge.expired { background:rgba(239,68,68,.08); color:var(--da-red); }
.da-days-badge.soon    { background:rgba(245,158,11,.08); color:var(--da-amber); }

/* ── Actions ── */
.da-action-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:32px; height:32px; border-radius:8px;
    border:1.5px solid var(--da-border); background:var(--da-surf);
    color:var(--da-text-2); text-decoration:none; transition:all .2s ease;
}
.da-action-btn:hover { border-color:var(--da-ind); color:var(--da-ind); background:var(--da-ind-pale); }
.da-action-btn svg { width:15px; height:15px; }

/* ── Empty state ── */
.da-empty {
    text-align:center; padding:3rem 2rem;
    color:var(--da-text-2);
}
.da-empty-icon {
    width:56px; height:56px; border-radius:16px;
    background:var(--da-ind-pale); color:var(--da-ind);
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 1rem;
}
.da-empty-icon svg { width:28px; height:28px; }
.da-empty h3 { font-size:1rem; font-weight:600; color:var(--da-text); margin:0 0 .375rem; }
.da-empty p  { font-size:.875rem; margin:0; }
</style>
@endsection

@section('content')
<div class="da-page">

    {{-- ── HERO ── --}}
    <div class="da-hero">
        <div class="da-hero-bg">
            <div class="da-breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                <a href="{{ route('admin.dossiers-agents.index') }}">Dossiers Agents</a>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                <span style="color:#fff">Alertes</span>
            </div>

            <div class="da-hero-inner">
                <div class="da-hero-left">
                    <h1>Alertes Documents</h1>
                    <p>Surveillez les documents expirés et ceux arrivant à échéance</p>
                </div>

                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:.75rem;">
                    <div class="da-hero-kpis">
                        <div class="da-hero-kpi">
                            <div class="da-hero-kpi-val red">{{ $documentsExpires->count() }}</div>
                            <div class="da-hero-kpi-lbl">Expirés</div>
                        </div>
                        <div class="da-hero-kpi">
                            <div class="da-hero-kpi-val amber">{{ $documentsExpirentBientot->count() }}</div>
                            <div class="da-hero-kpi-lbl">Expirent bientôt</div>
                        </div>
                        <div class="da-hero-kpi">
                            <div class="da-hero-kpi-val">{{ $documentsExpires->count() + $documentsExpirentBientot->count() }}</div>
                            <div class="da-hero-kpi-lbl">Total alertes</div>
                        </div>
                    </div>

                    <a href="{{ route('admin.dossiers-agents.index') }}" class="da-btn da-btn-outline">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                        Retour aux dossiers
                    </a>
                </div>
            </div>
        </div>
        <div class="da-hero-accent"></div>
    </div>

    {{-- ── TABS FILTRE ── --}}
    @php
        $filterType = request('type', 'all');
        $totalExpires = $documentsExpires->count();
        $totalBientot = $documentsExpirentBientot->count();
    @endphp

    <div class="da-tabs">
        <a href="{{ route('admin.dossier-agent.alertes') }}"
           class="da-tab {{ $filterType === 'all' ? 'active-all' : '' }}">
            Toutes les alertes
            <span class="da-tab-count">{{ $totalExpires + $totalBientot }}</span>
        </a>
        <a href="{{ route('admin.dossier-agent.alertes', ['type' => 'expires']) }}"
           class="da-tab {{ $filterType === 'expires' ? 'active-danger' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Expirés
            @if($totalExpires > 0)
                <span class="da-tab-count">{{ $totalExpires }}</span>
            @endif
        </a>
        <a href="{{ route('admin.dossier-agent.alertes', ['type' => 'bientot']) }}"
           class="da-tab {{ $filterType === 'bientot' ? 'active-warning' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            Expirent bientôt
            @if($totalBientot > 0)
                <span class="da-tab-count">{{ $totalBientot }}</span>
            @endif
        </a>
    </div>

    {{-- ── SECTION EXPIRÉS ── --}}
    @if($filterType !== 'bientot')
    <div class="da-section">
        <div class="da-section-header">
            <div class="da-section-badge danger">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Documents expirés — {{ $totalExpires }}
            </div>
        </div>

        <div class="da-card">
            @if($documentsExpires->isEmpty())
                <div class="da-empty">
                    <div class="da-empty-icon" style="background:rgba(239,68,68,.1);color:#ef4444">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <h3>Aucun document expiré</h3>
                    <p>Tous les documents sont valides ou sans date d'expiration.</p>
                </div>
            @else
                <table class="da-table">
                    <thead>
                        <tr>
                            <th>Employé</th>
                            <th>Document</th>
                            <th>Catégorie</th>
                            <th>Date expiration</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documentsExpires as $doc)
                        @php
                            $daysAgo = now()->diffInDays($doc->date_expiration, false);
                            $initiales = collect(explode(' ', $doc->personnel->nom_complet ?? $doc->personnel->nom))
                                ->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->implode('');
                        @endphp
                        <tr>
                            <td>
                                <div class="da-emp-cell">
                                    <div class="da-emp-avatar">{{ $initiales }}</div>
                                    <div>
                                        <div class="da-emp-name">{{ $doc->personnel->nom_complet ?? ($doc->personnel->nom . ' ' . $doc->personnel->prenoms) }}</div>
                                        <div class="da-emp-matricule">{{ $doc->personnel->matricule }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight:600">{{ $doc->titre ?: $doc->nom_original }}</div>
                                @if($doc->reference)
                                    <div style="font-size:.75rem;color:var(--da-text-3)">Réf : {{ $doc->reference }}</div>
                                @endif
                            </td>
                            <td>
                                @if($doc->categorie)
                                    <span class="da-cat-badge">{{ $doc->categorie->nom }}</span>
                                @else
                                    <span style="color:var(--da-text-3);font-size:.8125rem">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="da-date-cell">
                                    <span class="da-date-chip expired">{{ $doc->date_expiration->format('d/m/Y') }}</span>
                                    <span class="da-days-badge expired">il y a {{ abs((int)$daysAgo) }}j</span>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex;gap:.375rem">
                                    <a href="{{ route('admin.dossier-agent.show', $doc->personnel) }}"
                                       class="da-action-btn" title="Voir le dossier">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ Storage::url($doc->chemin) }}" target="_blank"
                                       class="da-action-btn" title="Télécharger">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @endif

    {{-- ── SECTION EXPIRENT BIENTÔT ── --}}
    @if($filterType !== 'expires')
    <div class="da-section">
        <div class="da-section-header">
            <div class="da-section-badge warning">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Expirent dans les 30 jours — {{ $totalBientot }}
            </div>
        </div>

        <div class="da-card">
            @if($documentsExpirentBientot->isEmpty())
                <div class="da-empty">
                    <div class="da-empty-icon" style="background:rgba(245,158,11,.1);color:#f59e0b">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <h3>Aucun document à renouveler</h3>
                    <p>Aucun document n'expire dans les 30 prochains jours.</p>
                </div>
            @else
                <table class="da-table">
                    <thead>
                        <tr>
                            <th>Employé</th>
                            <th>Document</th>
                            <th>Catégorie</th>
                            <th>Date expiration</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documentsExpirentBientot as $doc)
                        @php
                            $daysLeft = now()->diffInDays($doc->date_expiration, false);
                            $initiales = collect(explode(' ', $doc->personnel->nom_complet ?? $doc->personnel->nom))
                                ->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->implode('');
                        @endphp
                        <tr>
                            <td>
                                <div class="da-emp-cell">
                                    <div class="da-emp-avatar" style="background:linear-gradient(135deg,#f59e0b,#d97706)">{{ $initiales }}</div>
                                    <div>
                                        <div class="da-emp-name">{{ $doc->personnel->nom_complet ?? ($doc->personnel->nom . ' ' . $doc->personnel->prenoms) }}</div>
                                        <div class="da-emp-matricule">{{ $doc->personnel->matricule }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight:600">{{ $doc->titre ?: $doc->nom_original }}</div>
                                @if($doc->reference)
                                    <div style="font-size:.75rem;color:var(--da-text-3)">Réf : {{ $doc->reference }}</div>
                                @endif
                            </td>
                            <td>
                                @if($doc->categorie)
                                    <span class="da-cat-badge">{{ $doc->categorie->nom }}</span>
                                @else
                                    <span style="color:var(--da-text-3);font-size:.8125rem">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="da-date-cell">
                                    <span class="da-date-chip soon">{{ $doc->date_expiration->format('d/m/Y') }}</span>
                                    <span class="da-days-badge soon">{{ (int)$daysLeft }}j restants</span>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex;gap:.375rem">
                                    <a href="{{ route('admin.dossier-agent.show', $doc->personnel) }}"
                                       class="da-action-btn" title="Voir le dossier">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ Storage::url($doc->chemin) }}" target="_blank"
                                       class="da-action-btn" title="Télécharger">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @endif

    {{-- ── EMPTY GLOBAL ── --}}
    @if($documentsExpires->isEmpty() && $documentsExpirentBientot->isEmpty())
    <div class="da-card" style="padding:3rem 2rem;text-align:center">
        <div class="da-empty-icon" style="margin:0 auto 1rem">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <h3 style="font-size:1.125rem;font-weight:600;color:var(--da-text);margin:0 0 .5rem">Aucune alerte</h3>
        <p style="color:var(--da-text-2);margin:0 0 1.25rem">Tous les documents sont valides. Aucun document n'expire dans les 30 prochains jours.</p>
        <a href="{{ route('admin.dossiers-agents.index') }}" class="da-btn" style="background:var(--da-ind-pale);color:var(--da-ind);border-color:rgba(99,102,241,.2)">
            Retour aux dossiers
        </a>
    </div>
    @endif

</div>
@endsection
