@extends('layouts.app')

@section('title', 'Import en lot — Bulletins de paie')

@section('styles')
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@700;800&display=swap');
<style>
/* ═══════════════════════════════════════════════════════════════
   BULLETIN IMPORT — Indigo × Teal Premium Design System
   ═══════════════════════════════════════════════════════════════ */

.bi-page { padding: 0; background: #f8fafc; min-height: 100vh; }

/* ── HERO ── */
.bi-hero {
    background: linear-gradient(135deg, #312e81 0%, #4338ca 45%, #0d9488 100%);
    padding: 2.5rem 2rem 3.5rem;
    position: relative;
    overflow: hidden;
}
.bi-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}
.bi-hero-inner { max-width: 1100px; margin: 0 auto; position: relative; z-index: 1; }
.bi-hero-top { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
.bi-breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: .82rem; color: rgba(255,255,255,.65); }
.bi-breadcrumb a { color: rgba(255,255,255,.8); text-decoration: none; transition: color .2s; }
.bi-breadcrumb a:hover { color: #fff; }
.bi-breadcrumb svg { width: 12px; height: 12px; }

.bi-hero-title { font-family: 'Syne', sans-serif; font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800; color: #fff; margin: 0 0 .5rem; line-height: 1.1; }
.bi-hero-sub { color: rgba(255,255,255,.75); font-size: .95rem; margin: 0; }

.bi-hero-kpis { display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1.75rem; }
.bi-kpi {
    background: rgba(255,255,255,.1);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 14px;
    padding: .9rem 1.4rem;
    min-width: 140px;
    flex: 1;
}
.bi-kpi-val { font-family: 'Syne', sans-serif; font-size: 1.6rem; font-weight: 800; color: #fff; line-height: 1; }
.bi-kpi-lbl { font-size: .78rem; color: rgba(255,255,255,.7); margin-top: .25rem; }

/* ── BODY ── */
.bi-body { max-width: 1100px; margin: -1.5rem auto 0; padding: 0 2rem 3rem; position: relative; z-index: 2; }

/* ── RESULT BANNER ── */
.bi-result {
    border-radius: 16px; padding: 1.5rem 1.75rem;
    margin-bottom: 1.75rem; position: relative;
    animation: bi-fadeUp .4s ease;
}
@keyframes bi-fadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }

.bi-result-success { background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #6ee7b7; }
.bi-result-partial  { background: linear-gradient(135deg, #fffbeb, #fef3c7); border: 1px solid #fcd34d; }
.bi-result-error    { background: linear-gradient(135deg, #fef2f2, #fee2e2); border: 1px solid #fca5a5; }

.bi-result-head { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
.bi-result-icon { width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.bi-result-success .bi-result-icon { background: #d1fae5; color: #059669; }
.bi-result-partial  .bi-result-icon { background: #fef3c7; color: #d97706; }
.bi-result-error    .bi-result-icon { background: #fee2e2; color: #dc2626; }
.bi-result-icon svg { width: 22px; height: 22px; }
.bi-result-title { font-size: 1.05rem; font-weight: 700; }
.bi-result-success .bi-result-title { color: #065f46; }
.bi-result-partial  .bi-result-title { color: #78350f; }
.bi-result-error    .bi-result-title { color: #7f1d1d; }

.bi-result-stats { display: flex; gap: 1.5rem; flex-wrap: wrap; margin-bottom: .5rem; }
.bi-result-stat {
    display: flex; align-items: center; gap: .5rem;
    padding: .5rem .9rem; border-radius: 8px;
    font-size: .875rem; font-weight: 600;
}
.bi-stat-ok   { background: rgba(5,150,105,.1); color: #065f46; }
.bi-stat-dup  { background: rgba(217,119,6,.1);  color: #78350f; }
.bi-stat-err  { background: rgba(220,38,38,.1);  color: #7f1d1d; }
.bi-stat-tot  { background: rgba(99,102,241,.1); color: #3730a3; }

.bi-result-errors { margin-top: .75rem; }
.bi-result-errors summary { cursor: pointer; font-size: .85rem; font-weight: 600; color: #7f1d1d; padding: .35rem 0; }
.bi-err-list { margin: .5rem 0 0; padding-left: 1.25rem; }
.bi-err-list li { font-size: .82rem; color: #991b1b; margin-bottom: .3rem; line-height: 1.5; }
.bi-err-file { font-family: monospace; font-weight: 700; }

/* ── CARDS ── */
.bi-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    animation: bi-fadeUp .45s ease;
}
.bi-card-title {
    font-size: 1rem; font-weight: 700; color: #1e293b;
    margin: 0 0 1.5rem; display: flex; align-items: center; gap: .6rem;
}
.bi-card-title svg { width: 20px; height: 20px; color: #6366f1; flex-shrink: 0; }

/* ── NAMING CONVENTION ── */
.bi-convention {
    background: linear-gradient(135deg, #eef2ff, #f0fdfa);
    border: 1px solid #c7d2fe;
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
}
.bi-convention-title { font-size: .82rem; font-weight: 700; color: #3730a3; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .75rem; }
.bi-convention-pattern {
    font-family: 'Courier New', monospace;
    font-size: .88rem;
    background: rgba(99,102,241,.08);
    color: #4338ca;
    padding: .5rem .85rem;
    border-radius: 7px;
    border: 1px solid rgba(99,102,241,.2);
    margin-bottom: .75rem;
    word-break: break-all;
}
.bi-convention-examples { display: flex; flex-direction: column; gap: .25rem; }
.bi-convention-example {
    font-family: 'Courier New', monospace; font-size: .78rem;
    color: #475569; padding: .15rem .4rem;
    border-left: 2px solid #c7d2fe;
}
.bi-convention-tip { margin-top: .75rem; font-size: .8rem; color: #64748b; }
.bi-convention-tip code { background: rgba(99,102,241,.08); color: #4338ca; padding: .1rem .4rem; border-radius: 4px; font-family: monospace; }

/* ── FORM GRID ── */
.bi-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem; }
@media (max-width: 640px) { .bi-form-grid { grid-template-columns: 1fr; } }

.bi-field { display: flex; flex-direction: column; gap: .4rem; }
.bi-label { font-size: .82rem; font-weight: 600; color: #374151; }
.bi-label-req { color: #ef4444; }
.bi-select {
    padding: .65rem .9rem;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    background: #fff; color: #1e293b;
    font-size: .9rem; outline: none;
    transition: border-color .2s, box-shadow .2s;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .75rem center;
    padding-right: 2.5rem;
}
.bi-select:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.12); }

.bi-error-msg { font-size: .78rem; color: #ef4444; }

/* ── DROP ZONE ── */
.bi-drop-wrap { grid-column: 1 / -1; }
.bi-drop-zone {
    border: 2.5px dashed #c7d2fe;
    border-radius: 16px;
    padding: 3rem 2rem;
    text-align: center;
    cursor: pointer;
    position: relative;
    transition: all .25s cubic-bezier(.4,0,.2,1);
    background: #fafbff;
    overflow: hidden;
}
.bi-drop-zone::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 50% 120%, rgba(99,102,241,.06), transparent 70%);
}
.bi-drop-zone:hover, .bi-drop-zone.drag-over {
    border-color: #6366f1;
    background: #eef2ff;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(99,102,241,.12);
}
.bi-drop-zone.has-file {
    border-color: #10b981; border-style: solid;
    background: #f0fdf4;
}
.bi-drop-icon {
    width: 64px; height: 64px; margin: 0 auto .75rem;
    background: linear-gradient(135deg, #eef2ff, #e0e7ff);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    transition: all .25s;
}
.bi-drop-zone:hover .bi-drop-icon,
.bi-drop-zone.drag-over .bi-drop-icon { background: linear-gradient(135deg, #6366f1, #4338ca); }
.bi-drop-zone.has-file .bi-drop-icon { background: linear-gradient(135deg, #d1fae5, #6ee7b7); }
.bi-drop-icon svg { width: 28px; height: 28px; color: #6366f1; }
.bi-drop-zone:hover .bi-drop-icon svg,
.bi-drop-zone.drag-over .bi-drop-icon svg { color: #fff; }
.bi-drop-zone.has-file .bi-drop-icon svg { color: #059669; }
.bi-drop-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin-bottom: .35rem; }
.bi-drop-title strong { color: #6366f1; }
.bi-drop-sub { font-size: .82rem; color: #94a3b8; }
.bi-drop-file-info {
    display: none;
    align-items: center; justify-content: center; gap: .75rem;
    font-size: .875rem; font-weight: 600; color: #059669;
}
.bi-drop-zone.has-file .bi-drop-file-info { display: flex; }
.bi-drop-zone.has-file .bi-drop-default { display: none; }
.bi-file-icon {
    width: 36px; height: 36px; background: #d1fae5;
    border-radius: 8px; display: flex; align-items: center; justify-content: center;
}
.bi-file-icon svg { width: 18px; height: 18px; color: #059669; }
.bi-drop-input {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}

/* ── CHECKBOX ── */
.bi-toggle-row {
    display: flex; align-items: center; gap: .75rem;
    padding: .85rem 1.1rem;
    background: #f8fafc; border: 1px solid #e2e8f0;
    border-radius: 10px; cursor: pointer;
    transition: border-color .2s, background .2s;
}
.bi-toggle-row:hover { border-color: #c7d2fe; background: #eef2ff; }
.bi-toggle-row input[type="checkbox"] { width: 18px; height: 18px; accent-color: #6366f1; cursor: pointer; }
.bi-toggle-label { flex: 1; font-size: .875rem; font-weight: 500; color: #374151; }
.bi-toggle-badge {
    font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em;
    padding: .2rem .5rem; border-radius: 6px;
    background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46;
}

/* ── ACTIONS ── */
.bi-actions { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
.bi-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .75rem 1.75rem; border-radius: 12px;
    font-size: .9rem; font-weight: 600; cursor: pointer;
    border: none; text-decoration: none;
    transition: all .2s cubic-bezier(.4,0,.2,1);
    white-space: nowrap;
}
.bi-btn-primary {
    background: linear-gradient(135deg, #4338ca, #6366f1);
    color: #fff; box-shadow: 0 4px 14px rgba(99,102,241,.3);
}
.bi-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,.4); }
.bi-btn-primary:disabled { opacity: .65; cursor: not-allowed; transform: none; }
.bi-btn-ghost {
    background: transparent; color: #64748b;
    border: 1.5px solid #e2e8f0;
}
.bi-btn-ghost:hover { background: #f8fafc; color: #374151; }
.bi-btn svg { width: 18px; height: 18px; }
.bi-progress-msg {
    display: none; align-items: center; gap: .6rem;
    font-size: .85rem; color: #6366f1; font-weight: 500;
}
.bi-progress-msg.visible { display: flex; }

/* ── HISTORY ── */
.bi-hist-table { width: 100%; border-collapse: collapse; }
.bi-hist-table th {
    text-align: left; padding: .6rem 1rem;
    font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
    color: #94a3b8; border-bottom: 1px solid #f1f5f9;
}
.bi-hist-table td { padding: .9rem 1rem; border-bottom: 1px solid #f8fafc; font-size: .875rem; color: #374151; }
.bi-hist-table tr:last-child td { border-bottom: none; }
.bi-hist-table tr:hover td { background: #fafbff; }

.bi-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .25rem .65rem; border-radius: 20px; font-size: .75rem; font-weight: 700;
}
.bi-badge-success { background: #d1fae5; color: #065f46; }
.bi-badge-warning { background: #fef3c7; color: #78350f; }
.bi-badge-danger  { background: #fee2e2; color: #7f1d1d; }
.bi-badge-info    { background: #e0e7ff; color: #3730a3; }

.bi-num-ok  { color: #059669; font-weight: 700; }
.bi-num-dup { color: #d97706; font-weight: 600; }
.bi-num-err { color: #dc2626; font-weight: 600; }

/* Spinner */
@keyframes bi-spin { to { transform: rotate(360deg); } }
.bi-spinner { animation: bi-spin 1s linear infinite; }

/* Empty state */
.bi-empty { text-align: center; padding: 2.5rem 1rem; color: #94a3b8; }
.bi-empty svg { width: 40px; height: 40px; margin-bottom: .75rem; }
.bi-empty p { font-size: .875rem; margin: 0; }
</style>
@endsection

@section('content')
<div class="bi-page">

{{-- ══ HERO ══ --}}
<div class="bi-hero">
    <div class="bi-hero-inner">
        <div class="bi-hero-top">
            <nav class="bi-breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <a href="{{ route('admin.bulletins-paie.index') }}">Bulletins de paie</a>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span>Import en lot</span>
            </nav>
        </div>

        <h1 class="bi-hero-title">Import en lot de bulletins</h1>
        <p class="bi-hero-sub">Chargez un ZIP contenant tous les PDFs — le système les associe automatiquement aux employés</p>

        <div class="bi-hero-kpis">
            <div class="bi-kpi">
                <div class="bi-kpi-val">{{ $historique->sum('succes') }}</div>
                <div class="bi-kpi-lbl">Bulletins importés au total</div>
            </div>
            <div class="bi-kpi">
                <div class="bi-kpi-val">{{ $historique->count() }}</div>
                <div class="bi-kpi-lbl">Imports effectués</div>
            </div>
            <div class="bi-kpi">
                <div class="bi-kpi-val">{{ $historique->where('statut', 'termine')->count() }}</div>
                <div class="bi-kpi-lbl">Imports réussis</div>
            </div>
        </div>
    </div>
</div>

{{-- ══ BODY ══ --}}
<div class="bi-body">

    {{-- ── Résultat import ── --}}
    @if(session('import_result'))
        @php
            $res    = session('import_result');
            $statut = session('import_statut', 'termine');
            $cls    = match($statut) { 'echec' => 'bi-result-error', 'partiel' => 'bi-result-partial', default => 'bi-result-success' };
            $label  = match($statut) { 'echec' => 'Import échoué', 'partiel' => 'Import partiel', default => 'Import terminé avec succès' };
        @endphp
        <div class="bi-result {{ $cls }}">
            <div class="bi-result-head">
                <div class="bi-result-icon">
                    @if($statut === 'echec')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    @elseif($statut === 'partiel')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    @else
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    @endif
                </div>
                <div class="bi-result-title">{{ $label }}</div>
            </div>

            <div class="bi-result-stats">
                <div class="bi-result-stat bi-stat-tot">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <strong>{{ $res['total'] }}</strong> fichiers traités
                </div>
                <div class="bi-result-stat bi-stat-ok">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <strong>{{ $res['succes'] }}</strong> bulletins créés
                </div>
                <div class="bi-result-stat bi-stat-dup">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <strong>{{ $res['doublons'] }}</strong> doublons ignorés
                </div>
                @if(count($res['erreurs']) > 0)
                <div class="bi-result-stat bi-stat-err">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    <strong>{{ count($res['erreurs']) }}</strong> erreurs
                </div>
                @endif
            </div>

            @if(!empty($res['erreurs']))
            <div class="bi-result-errors">
                <details>
                    <summary>Voir les {{ count($res['erreurs']) }} erreur(s)</summary>
                    <ul class="bi-err-list">
                        @foreach($res['erreurs'] as $err)
                            <li><span class="bi-err-file">{{ $err['fichier'] }}</span> — {{ $err['raison'] }}</li>
                        @endforeach
                    </ul>
                </details>
            </div>
            @endif
        </div>
    @endif

    @if(session('error'))
        <div class="bi-result bi-result-error" style="margin-bottom:1.75rem;">
            <div class="bi-result-head">
                <div class="bi-result-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></div>
                <div class="bi-result-title">{{ session('error') }}</div>
            </div>
        </div>
    @endif

    {{-- ── FORMULAIRE D'IMPORT ── --}}
    <div class="bi-card">
        <h2 class="bi-card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="16 16 12 12 8 16"/>
                <line x1="12" y1="12" x2="12" y2="21"/>
                <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
            </svg>
            Chargement de l'archive ZIP
        </h2>

        {{-- Convention de nommage --}}
        <div class="bi-convention">
            <div class="bi-convention-title">Convention de nommage des PDFs</div>
            <div class="bi-convention-pattern">Bulletin_{Matricule}_{NomPrenom}_{YYYY-MM-DD}_au_{YYYY-MM-DD}.pdf</div>
            <div class="bi-convention-examples">
                <div class="bi-convention-example">Bulletin_EMP001_Jean_Dupont_2024-01-01_au_2024-01-31.pdf</div>
                <div class="bi-convention-example">Bulletin_MAT123_Marie_Martin_2024-02-01_au_2024-02-29.pdf</div>
                <div class="bi-convention-example">Bulletin_SANS_MATRICULE_Pierre_Bernard_2024-03-01_au_2024-03-31.pdf</div>
            </div>
            <div class="bi-convention-tip">
                Optionnel : ajoutez un fichier <code>salaires.csv</code> dans le ZIP
                (colonnes : <code>matricule, salaire_brut, salaire_net</code>) pour importer les montants automatiquement.
            </div>
        </div>

        <form action="{{ route('admin.bulletins-paie.import.store') }}" method="POST" enctype="multipart/form-data" id="importForm">
            @csrf

            <div class="bi-form-grid">

                {{-- Entreprise --}}
                <div class="bi-field">
                    <label class="bi-label" for="entreprise_id">Entreprise <span class="bi-label-req">*</span></label>
                    <select name="entreprise_id" id="entreprise_id" class="bi-select" required>
                        <option value="">— Sélectionner une entreprise —</option>
                        @foreach($entreprises as $ent)
                            <option value="{{ $ent->id }}" {{ old('entreprise_id') == $ent->id ? 'selected' : '' }}>
                                {{ $ent->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('entreprise_id')
                        <span class="bi-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Spacer --}}
                <div></div>

                {{-- Drop zone —— pleine largeur --}}
                <div class="bi-drop-wrap">
                    <label class="bi-label">Archive ZIP <span class="bi-label-req">*</span></label>
                    <div class="bi-drop-zone" id="dropZone">
                        <input type="file" name="fichier_zip" id="fichierZip" accept=".zip" required class="bi-drop-input">

                        <div class="bi-drop-default">
                            <div class="bi-drop-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <polyline points="16 16 12 12 8 16"/>
                                    <line x1="12" y1="12" x2="12" y2="21"/>
                                    <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                                </svg>
                            </div>
                            <div class="bi-drop-title">Glissez votre ZIP ici ou <strong>cliquez pour choisir</strong></div>
                            <div class="bi-drop-sub">Format : .zip · Taille max : 100 Mo · Contient les PDFs des bulletins</div>
                        </div>

                        <div class="bi-drop-file-info">
                            <div class="bi-file-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                            </div>
                            <div>
                                <div id="fileName" style="font-weight:700;">—</div>
                                <div id="fileSize" style="font-size:.78rem;color:#059669;font-weight:500;"></div>
                            </div>
                            <button type="button" id="changeFile" style="background:none;border:none;color:#059669;font-size:.8rem;cursor:pointer;text-decoration:underline;">Changer</button>
                        </div>
                    </div>
                    @error('fichier_zip')
                        <span class="bi-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Notification --}}
                <div style="grid-column:1/-1;">
                    <label class="bi-toggle-row">
                        <input type="checkbox" name="notifier" value="1" {{ old('notifier') ? 'checked' : '' }}>
                        <span class="bi-toggle-label">
                            <strong>Notifier les employés</strong> après import (WhatsApp + notification in-app)
                        </span>
                        <span class="bi-toggle-badge">WhatsApp</span>
                    </label>
                </div>

            </div>

            {{-- Actions --}}
            <div class="bi-actions">
                <button type="submit" class="bi-btn bi-btn-primary" id="submitBtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="16 16 12 12 8 16"/>
                        <line x1="12" y1="12" x2="12" y2="21"/>
                        <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                    </svg>
                    Lancer l'import
                </button>
                <a href="{{ route('admin.bulletins-paie.index') }}" class="bi-btn bi-btn-ghost">
                    Annuler
                </a>
                <div class="bi-progress-msg" id="progressMsg">
                    <svg class="bi-spinner" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                    Traitement en cours, veuillez patienter…
                </div>
            </div>

        </form>
    </div>

    {{-- ── HISTORIQUE ── --}}
    <div class="bi-card">
        <h2 class="bi-card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="12 8 12 12 14 14"/>
                <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5"/>
            </svg>
            Historique des imports
        </h2>

        @if($historique->isEmpty())
            <div class="bi-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                <p>Aucun import effectué pour le moment.</p>
            </div>
        @else
            <table class="bi-hist-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Entreprise</th>
                        <th>Effectué par</th>
                        <th>Total</th>
                        <th>Créés</th>
                        <th>Doublons</th>
                        <th>Erreurs</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historique as $log)
                    <tr>
                        <td style="white-space:nowrap;">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td><strong>{{ $log->entreprise?->nom ?? '—' }}</strong></td>
                        <td>{{ $log->uploadedBy?->name ?? '—' }}</td>
                        <td style="font-weight:600;">{{ $log->total }}</td>
                        <td class="bi-num-ok">{{ $log->succes }}</td>
                        <td class="bi-num-dup">{{ $log->doublons }}</td>
                        <td class="bi-num-err">{{ $log->erreurs_count }}</td>
                        <td>
                            @php
                                $bc = match($log->statut) {
                                    'termine'  => 'success',
                                    'partiel'  => 'warning',
                                    'echec'    => 'danger',
                                    default    => 'info',
                                };
                            @endphp
                            <span class="bi-badge bi-badge-{{ $bc }}">
                                @if($log->statut === 'termine') ✓ @elseif($log->statut === 'echec') ✗ @elseif($log->statut === 'partiel') ⚠ @else … @endif
                                {{ $log->statut_label }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
</div>
@endsection

@section('scripts')
<script>
const dropZone   = document.getElementById('dropZone');
const fileInput  = document.getElementById('fichierZip');
const fileName   = document.getElementById('fileName');
const fileSize   = document.getElementById('fileSize');
const changeBtn  = document.getElementById('changeFile');
const form       = document.getElementById('importForm');
const submitBtn  = document.getElementById('submitBtn');
const progressMsg = document.getElementById('progressMsg');

// ── Drag & Drop ──
dropZone.addEventListener('dragover', e => {
    e.preventDefault();
    dropZone.classList.add('drag-over');
});
dropZone.addEventListener('dragleave', e => {
    if (!dropZone.contains(e.relatedTarget)) dropZone.classList.remove('drag-over');
});
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    if (file && file.name.toLowerCase().endsWith('.zip')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        fileInput.files = dt.files;
        showFileInfo(file);
    }
});

// ── Clic sur la drop zone ──
fileInput.addEventListener('click', e => e.stopPropagation());
dropZone.addEventListener('click', e => {
    if (e.target !== changeBtn) fileInput.click();
});
changeBtn.addEventListener('click', e => {
    e.stopPropagation();
    dropZone.classList.remove('has-file');
    fileInput.value = '';
    fileInput.click();
});

// ── Sélection via input ──
fileInput.addEventListener('change', () => {
    if (fileInput.files[0]) showFileInfo(fileInput.files[0]);
});

function showFileInfo(file) {
    const mb = (file.size / 1024 / 1024).toFixed(2);
    fileName.textContent = file.name;
    fileSize.textContent = mb + ' Mo';
    dropZone.classList.add('has-file');
}

// ── Soumission ──
form.addEventListener('submit', e => {
    if (!fileInput.files.length) {
        e.preventDefault();
        dropZone.style.borderColor = '#ef4444';
        dropZone.style.background  = '#fef2f2';
        setTimeout(() => {
            dropZone.style.borderColor = '';
            dropZone.style.background  = '';
        }, 1800);
        return;
    }

    submitBtn.disabled = true;
    progressMsg.classList.add('visible');
    submitBtn.innerHTML = `
        <svg class="bi-spinner" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
        </svg>
        Traitement…
    `;
});
</script>
@endsection
