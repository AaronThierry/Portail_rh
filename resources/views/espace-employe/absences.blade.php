@extends('layouts.espace-employe')

@section('title', 'Mes Absences')
@section('page-title', 'Mes Absences')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Mes Absences</span>
@endsection

@section('styles')
<style>
/* ════════════════════════════════════════════════════
   ABSENCES — Charte Portail RH+
   Indigo × Teal × Neutres · Syne · DM Sans · DM Mono
   ════════════════════════════════════════════════════ */

.ab-page { display: flex; flex-direction: column; gap: 1.75rem; animation: fadeUp .4s ease both; }

/* ── Flash ────────────────────────────────────────── */
.ab-flash {
    padding: .875rem 1.25rem;
    border-radius: var(--r-lg);
    font-size: .9rem;
    font-weight: 500;
    display: flex;
    align-items: flex-start;
    gap: .625rem;
}
.ab-flash svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: .1rem; }
.ab-flash.success { background: rgba(10,175,162,.10); color: var(--teal-600); border: 1px solid rgba(10,175,162,.25); }
.ab-flash.error   { background: var(--rose-100); color: var(--rose-800); border: 1px solid #fecaca; }

/* ── Info banner ──────────────────────────────────── */
.ab-info {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-left: 4px solid var(--ind-400);
    border-radius: var(--r-lg);
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: .875rem;
    font-size: .875rem;
    color: var(--text-2);
}
.ab-info svg { width: 20px; height: 20px; color: var(--ind-400); flex-shrink: 0; }

/* ── KPI Stats grid ───────────────────────────────── */
.ab-stats {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 1.125rem;
}

.ab-kpi {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    padding: 1.375rem 1.25rem;
    position: relative;
    overflow: hidden;
    transition: transform .2s ease, box-shadow .2s ease;
}

.ab-kpi:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

.ab-kpi::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
}

.ab-kpi.total::before      { background: linear-gradient(90deg, var(--ind-400), var(--ind-300)); }
.ab-kpi.justified::before  { background: linear-gradient(90deg, var(--teal-400), var(--teal-300)); }
.ab-kpi.unjust::before     { background: linear-gradient(90deg, var(--rose-400), #FB923C); }
.ab-kpi.late::before       { background: linear-gradient(90deg, var(--amber-400), #FBBF24); }
.ab-kpi.pending::before    { background: linear-gradient(90deg, #8B5CF6, #A78BFA); }

.ab-kpi-head {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin-bottom: 1rem;
}

.ab-kpi-ico {
    width: 42px;
    height: 42px;
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ab-kpi-ico svg { width: 20px; height: 20px; }
.ab-kpi-ico.total    { background: rgba(55,72,200,.10);  color: var(--ind-500); }
.ab-kpi-ico.justified{ background: rgba(10,175,162,.12); color: var(--teal-500); }
.ab-kpi-ico.unjust   { background: var(--rose-100);      color: var(--rose-400); }
.ab-kpi-ico.late     { background: var(--amber-100);     color: var(--amber-400); }
.ab-kpi-ico.pending  { background: rgba(139,92,246,.10); color: #8B5CF6; }

.ab-kpi-label {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--text-3);
}

.ab-kpi-val {
    font-family: var(--font-d);
    font-size: 2.125rem;
    font-weight: 700;
    color: var(--text);
    line-height: 1;
}

/* ── History section ──────────────────────────────── */
.ab-history {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.ab-history-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.125rem 1.5rem;
    border-bottom: 1.5px solid var(--border-2);
    background: var(--n-50);
    flex-wrap: wrap;
    gap: .75rem;
}

.ab-section-title {
    display: flex;
    align-items: center;
    gap: .75rem;
    font-family: var(--font-d);
    font-size: .9375rem;
    font-weight: 700;
    color: var(--text);
}

.ab-section-ico {
    width: 34px;
    height: 34px;
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    border-radius: var(--r);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

.ab-section-ico svg { width: 16px; height: 16px; }

.ab-head-right { display: flex; align-items: center; gap: .625rem; flex-wrap: wrap; }

.ab-year-select {
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

.ab-year-select:focus { outline: none; border-color: var(--ind-400); }

.ab-btn-declare {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .55rem 1.125rem;
    background: linear-gradient(135deg, var(--teal-400), var(--teal-300));
    border: none;
    border-radius: var(--r);
    font-family: var(--font);
    font-size: .8125rem;
    font-weight: 700;
    color: #fff;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(10,175,162,.28);
    transition: all .2s ease;
    white-space: nowrap;
}

.ab-btn-declare:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(10,175,162,.38); }
.ab-btn-declare svg { width: 16px; height: 16px; }

/* ── Table ────────────────────────────────────────── */
.ab-table { width: 100%; border-collapse: collapse; }

.ab-table thead th {
    padding: .7rem 1.25rem;
    text-align: left;
    font-size: .68rem;
    font-weight: 700;
    color: var(--text-3);
    text-transform: uppercase;
    letter-spacing: .07em;
    background: var(--n-50);
    border-bottom: 1.5px solid var(--border-2);
    white-space: nowrap;
}

.ab-table tbody td {
    padding: .875rem 1.25rem;
    font-size: .875rem;
    color: var(--text);
    border-bottom: 1px solid var(--border-2);
    vertical-align: middle;
}

.ab-table tbody tr:last-child td { border-bottom: none; }
.ab-table tbody tr:hover td { background: var(--n-50); }

.ab-type-cell {
    display: flex;
    align-items: center;
    gap: .625rem;
}

.ab-type-ico {
    width: 34px;
    height: 34px;
    border-radius: var(--r);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #fff;
}

.ab-type-ico svg { width: 16px; height: 16px; }

.ab-date {
    font-family: var(--font-m);
    font-size: .8125rem;
    white-space: nowrap;
    color: var(--text-2);
}

.ab-dur {
    font-family: var(--font-m);
    font-size: .8125rem;
    color: var(--text-2);
    white-space: nowrap;
}

.ab-motif-cell {
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-size: .8125rem;
    color: var(--text-3);
}

/* ── Badges ───────────────────────────────────────── */
.ab-badge {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .28rem .65rem;
    border-radius: var(--r-f);
    font-size: .7rem;
    font-weight: 600;
    white-space: nowrap;
}
.ab-badge svg { width: 10px; height: 10px; }
.ab-badge.justified  { background: rgba(10,175,162,.10); color: var(--teal-500); }
.ab-badge.unjust     { background: var(--rose-100);      color: var(--rose-400); }
.ab-badge.en-attente { background: var(--amber-100);     color: var(--amber-400); }
.ab-badge.approuvee  { background: rgba(10,175,162,.10); color: var(--teal-500); }
.ab-badge.refusee    { background: var(--rose-100);      color: var(--rose-400); }

.ab-motif-refus {
    display: block;
    font-size: .72rem;
    color: var(--rose-400);
    margin-top: .2rem;
}

/* ── Row actions ──────────────────────────────────── */
.ab-row-actions { display: flex; gap: .375rem; align-items: center; }

.ab-row-btn {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .33rem .65rem;
    border-radius: var(--r);
    font-size: .7rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    border: 1.5px solid transparent;
    white-space: nowrap;
    background: transparent;
    text-decoration: none;
}

.ab-row-btn svg { width: 11px; height: 11px; }
.ab-row-btn.justify { border-color: rgba(10,175,162,.3);  color: var(--teal-500); background: rgba(10,175,162,.06); }
.ab-row-btn.justify:hover { background: rgba(10,175,162,.14); }
.ab-row-btn.cancel  { border-color: var(--border); color: var(--text-3); }
.ab-row-btn.cancel:hover  { border-color: var(--rose-400); color: var(--rose-400); }

/* ── Empty ────────────────────────────────────────── */
.ab-empty { text-align: center; padding: 4rem 2rem; }

.ab-empty-ico {
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

.ab-empty-ico svg { width: 42px; height: 42px; opacity: .65; }

.ab-empty h3 {
    font-family: var(--font-d);
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 .5rem;
}

.ab-empty p { font-size: .9rem; color: var(--text-2); margin: 0; }

/* ── Modals ───────────────────────────────────────── */
.ab-modal-overlay {
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

.ab-modal-overlay.active { display: flex; }

.ab-modal {
    background: var(--surface);
    border-radius: var(--r-xl);
    width: 100%;
    max-width: 540px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-xl);
}

.ab-modal-head {
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    padding: 1.375rem 1.5rem;
    display: flex;
    align-items: center;
    gap: .875rem;
    position: relative;
}

.ab-modal-head::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--teal-400), transparent);
}

.ab-modal-head-ico {
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

.ab-modal-head-ico svg { width: 20px; height: 20px; }

.ab-modal-head h3 {
    font-family: var(--font-d);
    font-size: 1.0625rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
    flex: 1;
}

.ab-modal-x {
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

.ab-modal-x:hover { background: rgba(255,255,255,.20); color: #fff; }
.ab-modal-x svg { width: 15px; height: 15px; }

.ab-modal-body { padding: 1.5rem; }
.ab-modal-foot {
    padding: 1rem 1.5rem 1.5rem;
    display: flex;
    justify-content: flex-end;
    gap: .625rem;
}

/* ── Form ─────────────────────────────────────────── */
.ab-form-group { margin-bottom: 1.125rem; }

.ab-form-label {
    display: block;
    font-size: .78rem;
    font-weight: 700;
    color: var(--text-2);
    margin-bottom: .375rem;
    text-transform: uppercase;
    letter-spacing: .05em;
}

.ab-form-input,
.ab-form-select,
.ab-form-textarea {
    width: 100%;
    padding: .65rem .875rem;
    background: var(--n-50);
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    font-size: .875rem;
    font-family: var(--font);
    color: var(--text);
    transition: all .2s;
    box-sizing: border-box;
}

.ab-form-textarea { resize: vertical; min-height: 80px; }

.ab-form-input:focus,
.ab-form-select:focus,
.ab-form-textarea:focus {
    outline: none;
    border-color: var(--ind-400);
    background: var(--surface);
    box-shadow: 0 0 0 3px rgba(55,72,200,.10);
}

.ab-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.ab-form-hint { font-size: .72rem; color: var(--text-3); margin-top: .3rem; }
.ab-form-err  { font-size: .72rem; color: var(--rose-400); margin-top: .3rem; }

.ab-btn-ghost {
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
.ab-btn-ghost:hover { background: var(--n-200); color: var(--text); }

.ab-btn-primary {
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
.ab-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(10,175,162,.40); }
.ab-btn-primary svg { width: 16px; height: 16px; }

/* ── Responsive ───────────────────────────────────── */
@media (max-width: 1200px) { .ab-stats { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px) {
    .ab-stats { grid-template-columns: repeat(2, 1fr); }
    .ab-history { overflow-x: auto; }
    .ab-table   { min-width: 680px; }
    .ab-form-row { grid-template-columns: 1fr; }
    .ab-history-head { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 480px) { .ab-stats { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="ab-page">

    {{-- Flash --}}
    @if(session('success'))
        <div class="ab-flash success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="ab-flash error">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="ab-flash error">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>@foreach($errors->all() as $e){{ $e }}<br>@endforeach</div>
        </div>
    @endif

    {{-- Info banner --}}
    <div class="ab-info">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
        </svg>
        <span>Consultez et gérez vos absences. Vous pouvez déclarer une absence et soumettre des justificatifs directement depuis cette page.</span>
    </div>

    {{-- ── KPI Stats ── --}}
    <div class="ab-stats">
        <div class="ab-kpi total">
            <div class="ab-kpi-head">
                <div class="ab-kpi-ico total">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                </div>
                <span class="ab-kpi-label">Total</span>
            </div>
            <div class="ab-kpi-val">{{ $statsAbsences['total'] }}</div>
        </div>

        <div class="ab-kpi justified">
            <div class="ab-kpi-head">
                <div class="ab-kpi-ico justified">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <span class="ab-kpi-label">Justifiées</span>
            </div>
            <div class="ab-kpi-val">{{ $statsAbsences['justifiees'] }}</div>
        </div>

        <div class="ab-kpi unjust">
            <div class="ab-kpi-head">
                <div class="ab-kpi-ico unjust">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                </div>
                <span class="ab-kpi-label">Non justifiées</span>
            </div>
            <div class="ab-kpi-val">{{ $statsAbsences['injustifiees'] }}</div>
        </div>

        <div class="ab-kpi late">
            <div class="ab-kpi-head">
                <div class="ab-kpi-ico late">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <span class="ab-kpi-label">Retards</span>
            </div>
            <div class="ab-kpi-val">{{ $statsAbsences['retards'] }}</div>
        </div>

        <div class="ab-kpi pending">
            <div class="ab-kpi-head">
                <div class="ab-kpi-ico pending">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <span class="ab-kpi-label">En attente</span>
            </div>
            <div class="ab-kpi-val">{{ $statsAbsences['en_attente'] }}</div>
        </div>
    </div>

    {{-- ── History ── --}}
    <div class="ab-history">
        <div class="ab-history-head">
            <div class="ab-section-title">
                <div class="ab-section-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                Historique des absences
            </div>
            <div class="ab-head-right">
                <select class="ab-year-select" onchange="window.location.href='{{ route('espace-employe.absences') }}?annee='+this.value">
                    @foreach($anneesDisponibles as $a)
                        <option value="{{ $a }}" {{ $a == $annee ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
                <button type="button" class="ab-btn-declare"
                        onclick="document.getElementById('declareAbsenceModal').classList.add('active')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Déclarer une absence
                </button>
            </div>
        </div>

        @if($absences->count() > 0)
        <div style="overflow-x: auto;">
            <table class="ab-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Durée</th>
                        <th>Justifiée</th>
                        <th>Statut</th>
                        <th>Motif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absences as $absence)
                    <tr>
                        <td>
                            <div class="ab-type-cell">
                                <div class="ab-type-ico" style="background: {{ $absence->typeAbsence->couleur ?? 'var(--ind-500)' }};">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                                    </svg>
                                </div>
                                <span>{{ $absence->typeAbsence->nom ?? 'Absence' }}</span>
                            </div>
                        </td>
                        <td><span class="ab-date">{{ $absence->date_absence->format('d/m/Y') }}</span></td>
                        <td><span class="ab-dur">{{ $absence->duree_label }}</span></td>
                        <td>
                            @if($absence->justifiee)
                                <span class="ab-badge justified">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    Justifiée
                                </span>
                            @else
                                <span class="ab-badge unjust">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    Non justifiée
                                </span>
                            @endif
                        </td>
                        <td>
                            @switch($absence->statut)
                                @case('en_attente')
                                    <span class="ab-badge en-attente">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        En attente
                                    </span>
                                    @break
                                @case('approuvee')
                                    <span class="ab-badge approuvee">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                        Approuvée
                                    </span>
                                    @break
                                @case('refusee')
                                    <div>
                                        <span class="ab-badge refusee">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                            Refusée
                                        </span>
                                        @if($absence->motif_refus)
                                            <span class="ab-motif-refus">{{ $absence->motif_refus }}</span>
                                        @endif
                                    </div>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            <span class="ab-motif-cell" title="{{ $absence->motif }}">{{ $absence->motif ?? '—' }}</span>
                        </td>
                        <td>
                            <div class="ab-row-actions">
                                @if(!$absence->justifiee && $absence->statut === 'approuvee' && $absence->source === 'admin')
                                    <button type="button" class="ab-row-btn justify"
                                            onclick="openJustifyModal({{ $absence->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        Justifier
                                    </button>
                                @endif
                                @if($absence->statut === 'en_attente' && $absence->source === 'employe')
                                    <form action="{{ route('espace-employe.absences.annuler', $absence) }}" method="POST"
                                          onsubmit="return confirm('Annuler cette déclaration d\'absence ?')">
                                        @csrf
                                        <button type="submit" class="ab-row-btn cancel">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                            Annuler
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="ab-empty">
            <div class="ab-empty-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <h3>Aucune absence enregistrée</h3>
            <p>Vous n'avez aucune absence pour l'année {{ $annee }}.</p>
        </div>
        @endif
    </div>

</div>

{{-- ══════════════════════════
     MODAL — Déclarer une absence
═══════════════════════════ --}}
<div class="ab-modal-overlay" id="declareAbsenceModal">
    <div class="ab-modal">
        <div class="ab-modal-head">
            <div class="ab-modal-head-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <h3>Déclarer une absence</h3>
            <button class="ab-modal-x" onclick="document.getElementById('declareAbsenceModal').classList.remove('active')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('espace-employe.absences.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="ab-modal-body">
                <div class="ab-form-group">
                    <label class="ab-form-label">Type d'absence *</label>
                    <select name="type_absence_id" class="ab-form-select" required>
                        <option value="">Sélectionnez un type</option>
                        @foreach($typesAbsence as $type)
                            <option value="{{ $type->id }}" {{ old('type_absence_id') == $type->id ? 'selected' : '' }}>{{ $type->nom }}</option>
                        @endforeach
                    </select>
                    @error('type_absence_id')<p class="ab-form-err">{{ $message }}</p>@enderror
                </div>

                <div class="ab-form-row">
                    <div class="ab-form-group">
                        <label class="ab-form-label">Date de l'absence *</label>
                        <input type="date" name="date_absence" class="ab-form-input" value="{{ old('date_absence') }}" required>
                        @error('date_absence')<p class="ab-form-err">{{ $message }}</p>@enderror
                    </div>
                    <div class="ab-form-group">
                        <label class="ab-form-label">Durée *</label>
                        <select name="duree_type" id="dureeTypeSelect" class="ab-form-select" required onchange="toggleMinutesRetard()">
                            <option value="">Sélectionnez</option>
                            <option value="journee"         {{ old('duree_type') == 'journee'         ? 'selected' : '' }}>Journée entière</option>
                            <option value="demi_journee"    {{ old('duree_type') == 'demi_journee'    ? 'selected' : '' }}>Demi-journée</option>
                            <option value="retard"          {{ old('duree_type') == 'retard'          ? 'selected' : '' }}>Retard</option>
                            <option value="depart_anticipe" {{ old('duree_type') == 'depart_anticipe' ? 'selected' : '' }}>Départ anticipé</option>
                        </select>
                        @error('duree_type')<p class="ab-form-err">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="ab-form-group" id="minutesRetardGroup" style="display:none;">
                    <label class="ab-form-label">Durée du retard (minutes)</label>
                    <input type="number" name="minutes_retard" id="minutesRetardInput" class="ab-form-input"
                           value="{{ old('minutes_retard') }}" min="1" max="480" placeholder="Ex : 30">
                    @error('minutes_retard')<p class="ab-form-err">{{ $message }}</p>@enderror
                </div>

                <div class="ab-form-group">
                    <label class="ab-form-label">Motif *</label>
                    <textarea name="motif" class="ab-form-textarea"
                              placeholder="Indiquez la raison de votre absence…" required>{{ old('motif') }}</textarea>
                    @error('motif')<p class="ab-form-err">{{ $message }}</p>@enderror
                </div>

                <div class="ab-form-group">
                    <label class="ab-form-label">Justificatif <span style="opacity:.45;">(optionnel)</span></label>
                    <input type="file" name="justificatif" class="ab-form-input" accept=".pdf,.jpg,.jpeg,.png">
                    <p class="ab-form-hint">PDF, JPG ou PNG · Max 5 Mo</p>
                    @error('justificatif')<p class="ab-form-err">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="ab-modal-foot">
                <button type="button" class="ab-btn-ghost"
                        onclick="document.getElementById('declareAbsenceModal').classList.remove('active')">Annuler</button>
                <button type="submit" class="ab-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    Soumettre
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════
     MODAL — Justifier une absence
═══════════════════════════ --}}
<div class="ab-modal-overlay" id="justifyModal">
    <div class="ab-modal">
        <div class="ab-modal-head">
            <div class="ab-modal-head-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
            </div>
            <h3>Soumettre un justificatif</h3>
            <button class="ab-modal-x" onclick="document.getElementById('justifyModal').classList.remove('active')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form id="justifyForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="ab-modal-body">
                <div class="ab-form-group">
                    <label class="ab-form-label">Justificatif *</label>
                    <input type="file" name="justificatif" class="ab-form-input" accept=".pdf,.jpg,.jpeg,.png" required>
                    <p class="ab-form-hint">PDF, JPG ou PNG · Max 5 Mo</p>
                </div>
                <div class="ab-form-group">
                    <label class="ab-form-label">Commentaire <span style="opacity:.45;">(optionnel)</span></label>
                    <textarea name="motif" class="ab-form-textarea"
                              placeholder="Commentaire concernant le justificatif…"></textarea>
                </div>
            </div>
            <div class="ab-modal-foot">
                <button type="button" class="ab-btn-ghost"
                        onclick="document.getElementById('justifyModal').classList.remove('active')">Annuler</button>
                <button type="submit" class="ab-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    Soumettre
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Close on backdrop click + Escape
document.querySelectorAll('.ab-modal-overlay').forEach(function (o) {
    o.addEventListener('click', function (e) { if (e.target === this) this.classList.remove('active'); });
});
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape')
        document.querySelectorAll('.ab-modal-overlay.active').forEach(function (o) { o.classList.remove('active'); });
});

// Toggle minutes field
function toggleMinutesRetard() {
    var sel   = document.getElementById('dureeTypeSelect');
    var grp   = document.getElementById('minutesRetardGroup');
    var input = document.getElementById('minutesRetardInput');
    if (sel.value === 'retard') {
        grp.style.display = '';
    } else {
        grp.style.display = 'none';
        input.value = '';
    }
}

// Open justify modal
function openJustifyModal(absenceId) {
    document.getElementById('justifyForm').action = '{{ url("mon-espace/absences") }}/' + absenceId + '/justifier';
    document.getElementById('justifyModal').classList.add('active');
}

// Init
toggleMinutesRetard();

// Re-open on validation errors
@if($errors->any())
    document.getElementById('declareAbsenceModal').classList.add('active');
@endif
</script>
@endsection
