@extends('layouts.espace-employe')

@section('title', 'Mes Congés')
@section('page-title', 'Mes Congés')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Mes Congés</span>
@endsection

@section('styles')
<style>
/* ════════════════════════════════════════════════════
   CONGÉS — Charte Portail RH+
   Indigo × Teal × Neutres · Syne · DM Sans · DM Mono
   ════════════════════════════════════════════════════ */

.cg-page { display: flex; flex-direction: column; gap: 1.75rem; animation: fadeUp .4s ease both; }

/* ── Flash ────────────────────────────────────────── */
.cg-flash {
    padding: .875rem 1.25rem;
    border-radius: var(--r-lg);
    font-size: .9rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: .625rem;
}
.cg-flash svg { width: 18px; height: 18px; flex-shrink: 0; }
.cg-flash.success { background: rgba(10,175,162,.10); color: var(--teal-600); border: 1px solid rgba(10,175,162,.25); }
.cg-flash.error   { background: var(--rose-100); color: var(--rose-800); border: 1px solid #fecaca; }

/* ── Solde KPI cards ──────────────────────────────── */
.cg-solde-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}

.cg-solde-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    transition: box-shadow .2s ease, transform .2s ease;
}

.cg-solde-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

.cg-solde-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
}

.cg-solde-card.total::before    { background: linear-gradient(90deg, var(--ind-400), var(--ind-300)); }
.cg-solde-card.pris::before     { background: linear-gradient(90deg, var(--amber-400), #FBBF24); }
.cg-solde-card.restants::before { background: linear-gradient(90deg, var(--teal-400), var(--teal-300)); }

.cg-solde-head {
    display: flex;
    align-items: center;
    gap: .875rem;
    margin-bottom: 1.25rem;
}

.cg-solde-ico {
    width: 44px;
    height: 44px;
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.cg-solde-ico svg { width: 22px; height: 22px; }
.cg-solde-ico.total    { background: rgba(55,72,200,.10);  color: var(--ind-500); }
.cg-solde-ico.pris     { background: var(--amber-100);     color: var(--amber-400); }
.cg-solde-ico.restants { background: rgba(10,175,162,.12); color: var(--teal-500); }

.cg-solde-label {
    font-size: .8125rem;
    font-weight: 600;
    color: var(--text-3);
    text-transform: uppercase;
    letter-spacing: .05em;
}

.cg-solde-val {
    font-family: var(--font-d);
    font-size: 2.375rem;
    font-weight: 700;
    color: var(--text);
    line-height: 1;
}

.cg-solde-unit {
    font-family: var(--font-m);
    font-size: .875rem;
    color: var(--text-3);
    margin-left: .375rem;
}

/* Optional: mini progress bar on "restants" */
.cg-solde-bar {
    margin-top: 1rem;
    height: 4px;
    background: var(--n-100);
    border-radius: var(--r-f);
    overflow: hidden;
}

.cg-solde-bar-fill {
    height: 100%;
    border-radius: var(--r-f);
    transition: width .8s ease;
}

.cg-solde-card.total    .cg-solde-bar-fill { background: linear-gradient(90deg, var(--ind-400), var(--ind-300)); }
.cg-solde-card.pris     .cg-solde-bar-fill { background: linear-gradient(90deg, var(--amber-400), #FBBF24); }
.cg-solde-card.restants .cg-solde-bar-fill { background: linear-gradient(90deg, var(--teal-400), var(--teal-300)); }

/* ── CTA Hero ─────────────────────────────────────── */
.cg-cta {
    background: linear-gradient(135deg, var(--ind-900) 0%, var(--ind-700) 60%, #1a3a5c 100%);
    border-radius: var(--r-xl);
    padding: 1.875rem 2.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    color: #fff;
    position: relative;
    overflow: hidden;
    flex-wrap: wrap;
}

.cg-cta::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 50% 90% at 90% 50%, rgba(10,175,162,.18) 0%, transparent 70%);
    pointer-events: none;
}

.cg-cta::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--teal-400), var(--teal-300));
}

.cg-cta-left {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 1.125rem;
}

.cg-cta-ico {
    width: 50px;
    height: 50px;
    background: rgba(10,175,162,.20);
    border: 1px solid rgba(10,175,162,.30);
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--teal-300);
    flex-shrink: 0;
}

.cg-cta-ico svg { width: 24px; height: 24px; }

.cg-cta-title {
    font-family: var(--font-d);
    font-size: 1.25rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 .25rem;
}

.cg-cta-sub { font-size: .875rem; color: rgba(255,255,255,.60); margin: 0; }

.cg-cta-btn {
    position: relative;
    z-index: 1;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .75rem 1.5rem;
    background: linear-gradient(135deg, var(--teal-400), var(--teal-300));
    border: none;
    border-radius: var(--r);
    font-family: var(--font);
    font-size: .9375rem;
    font-weight: 700;
    color: #fff;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(10,175,162,.35);
    transition: all .25s ease;
    white-space: nowrap;
}

.cg-cta-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(10,175,162,.45); }
.cg-cta-btn svg { width: 18px; height: 18px; }

/* ── History section ──────────────────────────────── */
.cg-history {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.cg-history-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.125rem 1.5rem;
    border-bottom: 1.5px solid var(--border-2);
    background: var(--n-50);
    flex-wrap: wrap;
    gap: .75rem;
}

.cg-history-title {
    display: flex;
    align-items: center;
    gap: .75rem;
    font-family: var(--font-d);
    font-size: .9375rem;
    font-weight: 700;
    color: var(--text);
}

.cg-section-ico {
    width: 34px;
    height: 34px;
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    border-radius: var(--r);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

.cg-section-ico svg { width: 16px; height: 16px; }

.cg-year-select {
    padding: .45rem .875rem;
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    font-size: .875rem;
    font-family: var(--font-m);
    color: var(--text);
    cursor: pointer;
    transition: border-color .2s;
}

.cg-year-select:focus { outline: none; border-color: var(--ind-400); }

/* ── Table ────────────────────────────────────────── */
.cg-table {
    width: 100%;
    border-collapse: collapse;
}

.cg-table thead th {
    padding: .75rem 1.5rem;
    text-align: left;
    font-size: .7rem;
    font-weight: 700;
    color: var(--text-3);
    text-transform: uppercase;
    letter-spacing: .07em;
    background: var(--n-50);
    border-bottom: 1.5px solid var(--border-2);
    white-space: nowrap;
}

.cg-table tbody td {
    padding: 1rem 1.5rem;
    font-size: .9rem;
    color: var(--text);
    border-bottom: 1px solid var(--border-2);
    vertical-align: middle;
}

.cg-table tbody tr:last-child td { border-bottom: none; }
.cg-table tbody tr:hover td { background: var(--n-50); }

.cg-type-cell {
    display: flex;
    align-items: center;
    gap: .75rem;
}

.cg-type-ico {
    width: 36px;
    height: 36px;
    border-radius: var(--r);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #fff;
}

.cg-type-ico svg { width: 17px; height: 17px; }

.cg-period {
    font-family: var(--font-m);
    font-size: .8125rem;
    color: var(--text-2);
    white-space: nowrap;
}

.cg-dur {
    font-family: var(--font-m);
    font-size: .875rem;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
}

/* ── Status badges ────────────────────────────────── */
.cg-badge {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .3rem .7rem;
    border-radius: var(--r-f);
    font-size: .72rem;
    font-weight: 600;
    white-space: nowrap;
}

.cg-badge svg { width: 11px; height: 11px; }
.cg-badge.approved  { background: rgba(10,175,162,.10); color: var(--teal-500); }
.cg-badge.pending   { background: var(--amber-100);     color: var(--amber-400); }
.cg-badge.rejected  { background: var(--rose-100);      color: var(--rose-400); }
.cg-badge.cancelled { background: var(--n-100);          color: var(--text-3); }

/* ── Row action buttons ───────────────────────────── */
.cg-row-actions { display: flex; gap: .375rem; align-items: center; }

.cg-row-btn {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .35rem .7rem;
    border-radius: var(--r);
    font-size: .72rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s ease;
    text-decoration: none;
    border: 1.5px solid transparent;
    white-space: nowrap;
}

.cg-row-btn svg { width: 12px; height: 12px; }
.cg-row-btn.cancel  { border-color: var(--border); color: var(--text-3); background: transparent; }
.cg-row-btn.cancel:hover  { border-color: var(--rose-400); color: var(--rose-400); }
.cg-row-btn.extend  { border-color: rgba(55,72,200,.25); color: var(--ind-500); background: rgba(55,72,200,.06); }
.cg-row-btn.extend:hover  { background: rgba(55,72,200,.12); }
.cg-row-btn.download{ border-color: rgba(10,175,162,.25); color: var(--teal-500); background: rgba(10,175,162,.06); }
.cg-row-btn.download:hover{ background: rgba(10,175,162,.12); }
.cg-row-btn.reason  { border-color: var(--border); color: var(--text-3); background: transparent; }
.cg-row-btn.reason:hover  { border-color: var(--amber-400); color: var(--amber-400); }

/* ── Empty state ──────────────────────────────────── */
.cg-empty {
    text-align: center;
    padding: 4rem 2rem;
}

.cg-empty-ico {
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

.cg-empty-ico svg { width: 42px; height: 42px; opacity: .65; }

.cg-empty h3 {
    font-family: var(--font-d);
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 .5rem;
}

.cg-empty p { font-size: .9rem; color: var(--text-2); margin: 0; }

/* ── Modals ───────────────────────────────────────── */
.cg-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(10,16,64,.45);
    backdrop-filter: blur(4px);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.cg-modal-overlay.active { display: flex; }

.cg-modal {
    background: var(--surface);
    border-radius: var(--r-xl);
    width: 100%;
    max-width: 540px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-xl);
}

.cg-modal-head {
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    padding: 1.375rem 1.5rem;
    display: flex;
    align-items: center;
    gap: .875rem;
    position: relative;
}

.cg-modal-head::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--teal-400), transparent);
}

.cg-modal-head-ico {
    width: 40px;
    height: 40px;
    background: rgba(10,175,162,.20);
    border: 1px solid rgba(10,175,162,.30);
    border-radius: var(--r);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--teal-300);
    flex-shrink: 0;
}

.cg-modal-head-ico svg { width: 20px; height: 20px; }

.cg-modal-head h3 {
    font-family: var(--font-d);
    font-size: 1.0625rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
    flex: 1;
}

.cg-modal-x {
    width: 30px;
    height: 30px;
    background: rgba(255,255,255,.10);
    border: none;
    border-radius: var(--r);
    color: rgba(255,255,255,.65);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s;
    flex-shrink: 0;
}

.cg-modal-x:hover { background: rgba(255,255,255,.20); color: #fff; }
.cg-modal-x svg { width: 15px; height: 15px; }

.cg-modal-body { padding: 1.5rem; }
.cg-modal-foot {
    padding: 1rem 1.5rem 1.5rem;
    display: flex;
    justify-content: flex-end;
    gap: .625rem;
}

/* ── Form elements ────────────────────────────────── */
.cg-form-group { margin-bottom: 1.125rem; }

.cg-form-label {
    display: block;
    font-size: .8rem;
    font-weight: 600;
    color: var(--text-2);
    margin-bottom: .375rem;
    text-transform: uppercase;
    letter-spacing: .05em;
}

.cg-form-input,
.cg-form-select,
.cg-form-textarea {
    width: 100%;
    padding: .65rem .875rem;
    background: var(--n-50);
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    font-size: .875rem;
    font-family: var(--font);
    color: var(--text);
    transition: all .2s ease;
    box-sizing: border-box;
}

.cg-form-textarea { resize: vertical; min-height: 80px; }

.cg-form-input:focus,
.cg-form-select:focus,
.cg-form-textarea:focus {
    outline: none;
    border-color: var(--ind-400);
    background: var(--surface);
    box-shadow: 0 0 0 3px rgba(55,72,200,.10);
}

.cg-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

.cg-form-hint { font-size: .75rem; color: var(--text-3); margin-top: .3rem; }
.cg-form-err  { font-size: .75rem; color: var(--rose-400); margin-top: .3rem; }

.cg-info-box {
    padding: .75rem 1rem;
    background: rgba(55,72,200,.07);
    border: 1px solid rgba(55,72,200,.15);
    border-radius: var(--r);
    margin-bottom: 1.25rem;
    font-size: .85rem;
    color: var(--ind-500);
}

/* ── Modal buttons ────────────────────────────────── */
.cg-btn-ghost {
    padding: .65rem 1.125rem;
    background: var(--n-100);
    border: none;
    border-radius: var(--r);
    font-size: .875rem;
    font-weight: 600;
    color: var(--text-2);
    cursor: pointer;
    transition: all .2s;
}

.cg-btn-ghost:hover { background: var(--n-200); color: var(--text); }

.cg-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .65rem 1.25rem;
    background: linear-gradient(135deg, var(--teal-400), var(--teal-300));
    border: none;
    border-radius: var(--r);
    font-size: .875rem;
    font-weight: 700;
    color: #fff;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(10,175,162,.30);
    transition: all .2s;
}

.cg-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(10,175,162,.40); }
.cg-btn-primary svg { width: 16px; height: 16px; }

/* ── Responsive ───────────────────────────────────── */
@media (max-width: 1024px) {
    .cg-solde-grid { grid-template-columns: 1fr; }
    .cg-cta { flex-direction: column; text-align: center; }
    .cg-cta-left { flex-direction: column; align-items: center; text-align: center; }
}

@media (max-width: 768px) {
    .cg-history { overflow-x: auto; }
    .cg-table   { min-width: 620px; }
    .cg-form-row { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')
<div class="cg-page">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="cg-flash success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="cg-flash error">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="cg-flash error">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>@foreach($errors->all() as $err){{ $err }}<br>@endforeach</div>
        </div>
    @endif

    {{-- ── Solde KPI ── --}}
    @php
        $total    = $soldeConges['annuels'] ?? 0;
        $pris     = $soldeConges['pris'] ?? 0;
        $restants = $soldeConges['restants'] ?? 0;
        $pctPris  = $total > 0 ? round($pris / $total * 100) : 0;
        $pctRest  = $total > 0 ? round($restants / $total * 100) : 0;
    @endphp
    <div class="cg-solde-grid">
        <div class="cg-solde-card total">
            <div class="cg-solde-head">
                <div class="cg-solde-ico total">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <span class="cg-solde-label">Congés annuels</span>
            </div>
            <div>
                <span class="cg-solde-val">{{ $total }}</span>
                <span class="cg-solde-unit">jours</span>
            </div>
            <div class="cg-solde-bar">
                <div class="cg-solde-bar-fill" style="width: 100%;"></div>
            </div>
        </div>

        <div class="cg-solde-card pris">
            <div class="cg-solde-head">
                <div class="cg-solde-ico pris">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <span class="cg-solde-label">Congés pris</span>
            </div>
            <div>
                <span class="cg-solde-val">{{ $pris }}</span>
                <span class="cg-solde-unit">jours</span>
            </div>
            <div class="cg-solde-bar">
                <div class="cg-solde-bar-fill" style="width: {{ $pctPris }}%;"></div>
            </div>
        </div>

        <div class="cg-solde-card restants">
            <div class="cg-solde-head">
                <div class="cg-solde-ico restants">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <span class="cg-solde-label">Congés restants</span>
            </div>
            <div>
                <span class="cg-solde-val">{{ $restants }}</span>
                <span class="cg-solde-unit">jours</span>
            </div>
            <div class="cg-solde-bar">
                <div class="cg-solde-bar-fill" style="width: {{ $pctRest }}%;"></div>
            </div>
        </div>
    </div>

    {{-- ── CTA ── --}}
    <div class="cg-cta">
        <div class="cg-cta-left">
            <div class="cg-cta-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                    <line x1="12" y1="14" x2="12" y2="18"/>
                    <line x1="10" y1="16" x2="14" y2="16"/>
                </svg>
            </div>
            <div>
                <h3 class="cg-cta-title">Besoin de prendre des congés ?</h3>
                <p class="cg-cta-sub">Soumettez votre demande en quelques clics et suivez son avancement en temps réel.</p>
            </div>
        </div>
        <button class="cg-cta-btn" onclick="document.getElementById('congeModal').classList.add('active')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Nouvelle demande
        </button>
    </div>

    {{-- ── History ── --}}
    <div class="cg-history">
        <div class="cg-history-head">
            <div class="cg-history-title">
                <div class="cg-section-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/>
                        <line x1="8" y1="2" x2="8" y2="18"/>
                        <line x1="16" y1="6" x2="16" y2="22"/>
                    </svg>
                </div>
                Historique des congés
            </div>
            <select class="cg-year-select" onchange="window.location.href='{{ route('espace-employe.conges') }}?annee='+this.value">
                @foreach($anneesDisponibles as $a)
                    <option value="{{ $a }}" {{ $a == $annee ? 'selected' : '' }}>{{ $a }}</option>
                @endforeach
            </select>
        </div>

        @if($conges->count() > 0)
        <div style="overflow-x: auto;">
            <table class="cg-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Période</th>
                        <th>Durée</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($conges as $conge)
                    <tr>
                        <td>
                            <div class="cg-type-cell">
                                <div class="cg-type-ico" style="background: {{ $conge->typeConge->couleur ?? 'var(--ind-500)' }};">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                    </svg>
                                </div>
                                <span>{{ $conge->typeConge->nom ?? 'Congé' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="cg-period">
                                {{ $conge->date_debut->format('d/m/Y') }} → {{ $conge->date_fin->format('d/m/Y') }}
                            </span>
                        </td>
                        <td>
                            <span class="cg-dur">{{ $conge->nombre_jours }}&thinsp;{{ $conge->nombre_jours > 1 ? 'jours' : 'jour' }}</span>
                        </td>
                        <td>
                            @switch($conge->statut)
                                @case('en_attente')
                                    <span class="cg-badge pending">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        En attente
                                    </span>
                                    @break
                                @case('approuve')
                                    <span class="cg-badge approved">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                        Approuvé
                                    </span>
                                    @break
                                @case('refuse')
                                    <span class="cg-badge rejected">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                        </svg>
                                        Refusé
                                    </span>
                                    @break
                                @case('annule')
                                    <span class="cg-badge cancelled">Annulé</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            <div class="cg-row-actions">
                                @if($conge->statut === 'en_attente')
                                    <form action="{{ route('espace-employe.conges.annuler', $conge) }}" method="POST"
                                          onsubmit="return confirm('Annuler cette demande de congé ?')">
                                        @csrf
                                        <button type="submit" class="cg-row-btn cancel">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                            </svg>
                                            Annuler
                                        </button>
                                    </form>
                                @endif
                                @if($conge->statut === 'approuve')
                                    <button class="cg-row-btn extend"
                                            onclick="openProlongerModal({{ $conge->id }}, '{{ $conge->date_fin->format('Y-m-d') }}', '{{ $conge->date_fin->format('d/m/Y') }}', '{{ addslashes($conge->typeConge->nom ?? 'Congé') }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="5 12 19 12"/><polyline points="13 6 19 12 13 18"/>
                                        </svg>
                                        Prolonger
                                    </button>
                                    @if($conge->document_officiel)
                                        <a href="{{ route('espace-employe.conges.document', $conge) }}" class="cg-row-btn download">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                                <polyline points="7 10 12 15 17 10"/>
                                                <line x1="12" y1="15" x2="12" y2="3"/>
                                            </svg>
                                            Note
                                        </a>
                                    @endif
                                @endif
                                @if($conge->statut === 'refuse' && $conge->motif_refus)
                                    <button class="cg-row-btn reason"
                                            onclick="alert('Motif du refus :\n{{ addslashes($conge->motif_refus) }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/>
                                            <line x1="12" y1="8" x2="12" y2="12"/>
                                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                                        </svg>
                                        Motif
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="cg-empty">
            <div class="cg-empty-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <h3>Aucun congé enregistré</h3>
            <p>Vous n'avez pas encore de congés pour l'année {{ $annee }}.</p>
        </div>
        @endif
    </div>

</div>

{{-- ══════════════════════════
     MODAL — Nouvelle demande
═══════════════════════════ --}}
<div class="cg-modal-overlay" id="congeModal">
    <div class="cg-modal">
        <div class="cg-modal-head">
            <div class="cg-modal-head-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                    <line x1="12" y1="14" x2="12" y2="18"/>
                    <line x1="10" y1="16" x2="14" y2="16"/>
                </svg>
            </div>
            <h3>Nouvelle demande de congé</h3>
            <button class="cg-modal-x" onclick="document.getElementById('congeModal').classList.remove('active')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('espace-employe.conges.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="cg-modal-body">
                <div class="cg-form-group">
                    <label class="cg-form-label">Type de congé *</label>
                    <select name="type_conge_id" class="cg-form-select" required>
                        <option value="">Sélectionnez un type</option>
                        @foreach($typesConge as $type)
                            <option value="{{ $type->id }}" {{ old('type_conge_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->nom }} ({{ $type->jours_par_an }} j/an)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="cg-form-row">
                    <div class="cg-form-group">
                        <label class="cg-form-label">Date de début *</label>
                        <input type="date" name="date_debut" class="cg-form-input"
                               value="{{ old('date_debut') }}" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="cg-form-group">
                        <label class="cg-form-label">Date de fin *</label>
                        <input type="date" name="date_fin" class="cg-form-input"
                               value="{{ old('date_fin') }}" required min="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="cg-form-group">
                    <label class="cg-form-label">Motif <span style="opacity:.45;">(optionnel)</span></label>
                    <textarea name="motif" class="cg-form-textarea"
                              placeholder="Raison de votre demande…">{{ old('motif') }}</textarea>
                </div>

                <div class="cg-form-group">
                    <label class="cg-form-label">Pièce jointe <span style="opacity:.45;">(optionnel)</span></label>
                    <input type="file" name="piece_jointe" class="cg-form-input" accept=".pdf,.jpg,.jpeg,.png">
                    <p class="cg-form-hint">PDF, JPG ou PNG · Max 5 Mo</p>
                </div>
            </div>
            <div class="cg-modal-foot">
                <button type="button" class="cg-btn-ghost"
                        onclick="document.getElementById('congeModal').classList.remove('active')">Annuler</button>
                <button type="submit" class="cg-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    Soumettre
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════
     MODAL — Prolongation
═══════════════════════════ --}}
<div class="cg-modal-overlay" id="prolongerModal">
    <div class="cg-modal">
        <div class="cg-modal-head">
            <div class="cg-modal-head-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="5 12 19 12"/><polyline points="13 6 19 12 13 18"/>
                </svg>
            </div>
            <h3>Prolonger un congé</h3>
            <button class="cg-modal-x" onclick="document.getElementById('prolongerModal').classList.remove('active')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form id="prolongerForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="cg-modal-body">
                <div class="cg-info-box">
                    <strong id="prolongerTypeLabel">Congé</strong> &mdash; Fin actuelle : <strong id="prolongerDateFinLabel">—</strong>
                </div>

                <div class="cg-form-group">
                    <label class="cg-form-label">Nouvelle date de fin *</label>
                    <input type="date" name="nouvelle_date_fin" id="prolongerDateFin" class="cg-form-input" required>
                    <p class="cg-form-hint">La nouvelle date doit être postérieure à la date de fin actuelle.</p>
                </div>

                <div class="cg-form-group">
                    <label class="cg-form-label">Motif <span style="opacity:.45;">(optionnel)</span></label>
                    <textarea name="motif" class="cg-form-textarea"
                              placeholder="Raison de la prolongation…"></textarea>
                </div>

                <div class="cg-form-group">
                    <label class="cg-form-label">Pièce jointe <span style="opacity:.45;">(optionnel)</span></label>
                    <input type="file" name="piece_jointe" class="cg-form-input" accept=".pdf,.jpg,.jpeg,.png">
                    <p class="cg-form-hint">PDF, JPG ou PNG · Max 5 Mo</p>
                </div>
            </div>
            <div class="cg-modal-foot">
                <button type="button" class="cg-btn-ghost"
                        onclick="document.getElementById('prolongerModal').classList.remove('active')">Annuler</button>
                <button type="submit" class="cg-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    Demander
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Close on backdrop click
document.querySelectorAll('.cg-modal-overlay').forEach(function (o) {
    o.addEventListener('click', function (e) { if (e.target === this) this.classList.remove('active'); });
});

// Close on Escape
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.cg-modal-overlay.active').forEach(function (o) {
            o.classList.remove('active');
        });
    }
});

// Open prolonger modal
function openProlongerModal(congeId, dateFinYmd, dateFinFormatted, typeName) {
    document.getElementById('prolongerForm').action = '/mon-espace/conges/' + congeId + '/prolonger';
    document.getElementById('prolongerTypeLabel').textContent = typeName;
    document.getElementById('prolongerDateFinLabel').textContent = dateFinFormatted;
    var next = new Date(dateFinYmd);
    next.setDate(next.getDate() + 1);
    var di = document.getElementById('prolongerDateFin');
    di.min   = next.toISOString().split('T')[0];
    di.value = '';
    document.getElementById('prolongerModal').classList.add('active');
}

// Re-open on validation errors
@if($errors->any())
    @if(old('nouvelle_date_fin'))
        document.getElementById('prolongerModal').classList.add('active');
    @else
        document.getElementById('congeModal').classList.add('active');
    @endif
@endif
</script>
@endsection
