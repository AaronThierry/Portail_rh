@extends('layouts.espace-employe')

@section('title', 'Attestations')
@section('page-title', 'Attestations')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Attestations</span>
@endsection

@section('styles')
<style>
/* ════════════════════════════════════════════════════
   ATTESTATIONS — Charte Portail RH+
   Indigo × Teal × Neutres · Syne · DM Sans · DM Mono
   ════════════════════════════════════════════════════ */

.att-page { display: flex; flex-direction: column; gap: 1.75rem; animation: fadeUp .4s ease both; }

/* ── Hero request panel ───────────────────────────── */
.att-hero {
    background: linear-gradient(135deg, var(--ind-900) 0%, var(--ind-700) 60%, #1a3a5c 100%);
    border-radius: var(--r-xl);
    padding: 2.25rem 2.5rem;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.att-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 55% 80% at 90% 40%, rgba(10,175,162,.20) 0%, transparent 70%);
    pointer-events: none;
}

.att-hero::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--teal-400), var(--teal-300));
}

.att-hero-head {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 1.125rem;
    margin-bottom: 1.75rem;
}

.att-hero-ico {
    width: 52px;
    height: 52px;
    background: rgba(10,175,162,.20);
    border: 1px solid rgba(10,175,162,.35);
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: var(--teal-300);
}

.att-hero-ico svg { width: 24px; height: 24px; }

.att-hero-title {
    font-family: var(--font-d);
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: -.01em;
    margin: 0 0 .25rem;
    color: #fff;
}

.att-hero-sub { font-size: .875rem; color: rgba(255,255,255,.60); margin: 0; max-width: 480px; line-height: 1.55; }

/* ── Attestation type cards ───────────────────────── */
.att-types {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 1rem;
}

.att-type {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .875rem;
    padding: 1.625rem 1.25rem;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.14);
    border-radius: var(--r-xl);
    cursor: pointer;
    transition: background .25s ease, transform .25s cubic-bezier(.4,0,.2,1), box-shadow .25s ease;
    text-align: center;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.att-type::before {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: var(--att-color, var(--teal-400));
    opacity: 0;
    transition: opacity .25s ease;
}

.att-type:hover {
    background: rgba(255,255,255,.15);
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,0,0,.25);
}

.att-type:hover::before { opacity: 1; }

.att-type-ico {
    width: 58px;
    height: 58px;
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--att-color, rgba(10,175,162,.25));
    color: #fff;
    flex-shrink: 0;
    transition: transform .25s ease;
}

.att-type:hover .att-type-ico { transform: scale(1.1) rotate(-5deg); }
.att-type-ico svg { width: 26px; height: 26px; }

.att-type-name {
    font-family: var(--font-d);
    font-size: .9375rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.3;
}

.att-type-desc { font-size: .75rem; color: rgba(255,255,255,.55); line-height: 1.4; }

/* ── History section ──────────────────────────────── */
.att-history {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.att-history-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.125rem 1.5rem;
    border-bottom: 1.5px solid var(--border-2);
    background: var(--n-50);
}

.att-history-title {
    display: flex;
    align-items: center;
    gap: .75rem;
    font-family: var(--font-d);
    font-size: .9375rem;
    font-weight: 700;
    color: var(--text);
}

.att-section-ico {
    width: 34px;
    height: 34px;
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    border-radius: var(--r);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

.att-section-ico svg { width: 16px; height: 16px; }

.att-count {
    font-size: .75rem;
    font-weight: 600;
    color: var(--text-3);
    background: var(--n-100);
    padding: .25rem .625rem;
    border-radius: var(--r-f);
    font-family: var(--font-m);
}

/* ── History rows ─────────────────────────────────── */
.att-list { padding: .5rem; }

.att-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: .875rem 1rem;
    border-radius: var(--r-lg);
    transition: background .15s ease;
}

.att-item:hover { background: var(--n-50); }

.att-item-ico {
    width: 46px;
    height: 46px;
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #fff;
}

.att-item-ico svg { width: 20px; height: 20px; }
.att-item-ico.travail  { background: linear-gradient(135deg, var(--ind-500), var(--ind-600)); }
.att-item-ico.salaire  { background: linear-gradient(135deg, var(--teal-400), var(--teal-300)); }
.att-item-ico.presence { background: linear-gradient(135deg, #7C3AED, #6D28D9); }
.att-item-ico.autre    { background: linear-gradient(135deg, var(--amber-400), #D97706); }

.att-item-info { flex: 1; min-width: 0; }

.att-item-name {
    font-weight: 600;
    font-size: .9375rem;
    color: var(--text);
    margin: 0 0 .2rem;
}

.att-item-date {
    font-family: var(--font-m);
    font-size: .75rem;
    color: var(--text-3);
}

.att-status {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .3rem .7rem;
    border-radius: var(--r-f);
    font-size: .72rem;
    font-weight: 600;
    white-space: nowrap;
}

.att-status svg { width: 11px; height: 11px; }
.att-status.ready      { background: rgba(10,175,162,.10); color: var(--teal-500); }
.att-status.processing { background: var(--amber-100);     color: var(--amber-400); }
.att-status.pending    { background: var(--n-100);          color: var(--text-3); }

.att-item-actions { display: flex; gap: .375rem; }

.att-act-btn {
    width: 38px;
    height: 38px;
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    background: transparent;
    color: var(--text-3);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .2s ease;
    text-decoration: none;
}

.att-act-btn:hover { background: var(--ind-900); border-color: var(--ind-900); color: #fff; }
.att-act-btn svg { width: 16px; height: 16px; }

/* ── Empty state ──────────────────────────────────── */
.att-empty {
    text-align: center;
    padding: 3.5rem 2rem;
}

.att-empty-ico {
    width: 88px;
    height: 88px;
    margin: 0 auto 1.375rem;
    background: rgba(55,72,200,.07);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ind-400);
}

.att-empty-ico svg { width: 40px; height: 40px; opacity: .65; }

.att-empty h3 {
    font-family: var(--font-d);
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 .5rem;
}

.att-empty p { font-size: .9rem; color: var(--text-2); margin: 0; }

/* ── Modal ────────────────────────────────────────── */
.att-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(10,16,64,.45);
    backdrop-filter: blur(4px);
    z-index: 900;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    opacity: 0;
    pointer-events: none;
    transition: opacity .25s ease;
}

.att-modal-backdrop.open { opacity: 1; pointer-events: all; }

.att-modal {
    background: var(--surface);
    border-radius: var(--r-xl);
    width: 100%;
    max-width: 480px;
    box-shadow: var(--shadow-xl);
    transform: translateY(16px);
    transition: transform .25s cubic-bezier(.4,0,.2,1);
    overflow: hidden;
}

.att-modal-backdrop.open .att-modal { transform: none; }

.att-modal-head {
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
}

.att-modal-head::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--teal-400), transparent);
}

.att-modal-thumb {
    width: 44px;
    height: 44px;
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    flex-shrink: 0;
}

.att-modal-thumb svg { width: 22px; height: 22px; }

.att-modal-head h3 {
    font-family: var(--font-d);
    font-size: 1.125rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 .15rem;
}

.att-modal-head p { font-size: .8rem; color: rgba(255,255,255,.55); margin: 0; }

.att-modal-close {
    margin-left: auto;
    width: 32px;
    height: 32px;
    background: rgba(255,255,255,.10);
    border: none;
    border-radius: var(--r);
    color: rgba(255,255,255,.7);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background .2s;
}

.att-modal-close:hover { background: rgba(255,255,255,.20); color: #fff; }
.att-modal-close svg { width: 16px; height: 16px; }

.att-modal-body { padding: 1.5rem; }

.att-form-group { margin-bottom: 1.125rem; }

.att-form-label {
    display: block;
    font-size: .8rem;
    font-weight: 600;
    color: var(--text-2);
    margin-bottom: .375rem;
    text-transform: uppercase;
    letter-spacing: .05em;
}

.att-form-input,
.att-form-textarea {
    width: 100%;
    padding: .65rem .875rem;
    background: var(--n-50);
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    font-size: .875rem;
    font-family: var(--font);
    color: var(--text);
    transition: all .2s ease;
}

.att-form-textarea { min-height: 90px; resize: vertical; }

.att-form-input:focus,
.att-form-textarea:focus {
    outline: none;
    border-color: var(--ind-400);
    background: var(--surface);
    box-shadow: 0 0 0 3px rgba(55,72,200,.10);
}

.att-form-input::placeholder,
.att-form-textarea::placeholder { color: var(--text-3); }

.att-modal-foot {
    padding: 1rem 1.5rem 1.5rem;
    display: flex;
    gap: .75rem;
    justify-content: flex-end;
}

.att-modal-btn {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .65rem 1.25rem;
    border-radius: var(--r);
    font-size: .875rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all .2s ease;
}

.att-modal-btn svg { width: 16px; height: 16px; }

.att-modal-btn.primary {
    background: linear-gradient(135deg, var(--teal-400), var(--teal-300));
    color: #fff;
    box-shadow: 0 4px 14px rgba(10,175,162,.30);
}

.att-modal-btn.primary:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(10,175,162,.40); }

.att-modal-btn.ghost {
    background: var(--n-100);
    color: var(--text-2);
}

.att-modal-btn.ghost:hover { background: var(--n-200); color: var(--text); }

/* ── Responsive ───────────────────────────────────── */
@media (max-width: 768px) {
    .att-hero { padding: 1.5rem; }
    .att-types { grid-template-columns: repeat(2, 1fr); }
    .att-item  { flex-wrap: wrap; }
    .att-item-actions { margin-left: auto; }
}

@media (max-width: 480px) {
    .att-types { grid-template-columns: 1fr 1fr; gap: .75rem; }
}
</style>
@endsection

@section('content')
<div class="att-page">

    {{-- ── Hero / Request panel ── --}}
    <div class="att-hero">
        <div class="att-hero-head">
            <div class="att-hero-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <div>
                <h2 class="att-hero-title">Demander une attestation</h2>
                <p class="att-hero-sub">Sélectionnez le type d'attestation dont vous avez besoin. Le document sera généré et mis à disposition sous 24 à 48 heures.</p>
            </div>
        </div>

        <div class="att-types">
            {{-- Travail --}}
            <button class="att-type" style="--att-color: rgba(55,72,200,.55);"
                    onclick="openModal('travail', 'Attestation de travail', 'Prouve votre emploi actuel')">
                <div class="att-type-ico" style="background: rgba(55,72,200,.45);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <span class="att-type-name">Attestation de travail</span>
                <span class="att-type-desc">Prouve votre emploi actuel</span>
            </button>

            {{-- Salaire --}}
            <button class="att-type" style="--att-color: rgba(10,175,162,.55);"
                    onclick="openModal('salaire', 'Attestation de salaire', 'Justificatif de revenus')">
                <div class="att-type-ico" style="background: rgba(10,175,162,.40);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                <span class="att-type-name">Attestation de salaire</span>
                <span class="att-type-desc">Justificatif de revenus</span>
            </button>

            {{-- Présence --}}
            <button class="att-type" style="--att-color: rgba(124,58,237,.55);"
                    onclick="openModal('presence', 'Attestation de présence', 'Pour une date précise')">
                <div class="att-type-ico" style="background: rgba(124,58,237,.40);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                        <path d="M9 16l2 2 4-4"/>
                    </svg>
                </div>
                <span class="att-type-name">Attestation de présence</span>
                <span class="att-type-desc">Pour une date précise</span>
            </button>

            {{-- Autre --}}
            <button class="att-type" style="--att-color: rgba(245,158,11,.55);"
                    onclick="openModal('autre', 'Autre attestation', 'Demande spécifique')">
                <div class="att-type-ico" style="background: rgba(245,158,11,.35);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="12" y1="18" x2="12" y2="12"/>
                        <line x1="9" y1="15" x2="15" y2="15"/>
                    </svg>
                </div>
                <span class="att-type-name">Autre attestation</span>
                <span class="att-type-desc">Demande spécifique</span>
            </button>
        </div>
    </div>

    {{-- ── History ── --}}
    <div class="att-history">
        <div class="att-history-head">
            <div class="att-history-title">
                <div class="att-section-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                Mes attestations
            </div>
            {{-- Count badge if there are items --}}
            {{-- <span class="att-count">3</span> --}}
        </div>

        <div class="att-list">
            {{-- Replace the block below with @foreach($attestations as $att) when data exists --}}
            {{--
            Example row:
            <div class="att-item">
                <div class="att-item-ico travail">
                    <svg ...>...</svg>
                </div>
                <div class="att-item-info">
                    <p class="att-item-name">Attestation de travail</p>
                    <span class="att-item-date">12/03/2026 à 14:32</span>
                </div>
                <span class="att-status ready">
                    <svg ...><polyline points="20 6 9 17 4 12"/></svg>
                    Prête
                </span>
                <div class="att-item-actions">
                    <a href="#" class="att-act-btn" title="Télécharger">
                        <svg ...>download icon</svg>
                    </a>
                </div>
            </div>
            --}}

            <div class="att-empty">
                <div class="att-empty-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <h3>Aucune attestation</h3>
                <p>Vous n'avez pas encore fait de demande d'attestation.</p>
            </div>
        </div>
    </div>
</div>

{{-- ── Request Modal ── --}}
<div class="att-modal-backdrop" id="attModal" onclick="closeModal(event)">
    <div class="att-modal" id="attModalBox">
        <div class="att-modal-head">
            <div class="att-modal-thumb" id="modalThumb">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <div>
                <h3 id="modalTitle">Demande d'attestation</h3>
                <p id="modalDesc">Remplissez les informations ci-dessous</p>
            </div>
            <button class="att-modal-close" onclick="closeModalDirect()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="#" id="attForm">
            @csrf
            <input type="hidden" name="type" id="attType">
            <div class="att-modal-body">
                <div class="att-form-group" id="dateGroup" style="display:none;">
                    <label class="att-form-label" for="datePresence">Date de présence</label>
                    <input type="date" class="att-form-input" id="datePresence" name="date_presence">
                </div>
                <div class="att-form-group">
                    <label class="att-form-label" for="motif">Motif / Usage prévu <span style="opacity:.5;">(optionnel)</span></label>
                    <textarea class="att-form-textarea" id="motif" name="motif"
                        placeholder="Ex : demande de visa, prêt bancaire, démarche administrative…"></textarea>
                </div>
            </div>
            <div class="att-modal-foot">
                <button type="button" class="att-modal-btn ghost" onclick="closeModalDirect()">Annuler</button>
                <button type="submit" class="att-modal-btn primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    Envoyer la demande
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
const thumbColors = {
    travail:  'linear-gradient(135deg, var(--ind-500), var(--ind-600))',
    salaire:  'linear-gradient(135deg, var(--teal-400), var(--teal-300))',
    presence: 'linear-gradient(135deg, #7C3AED, #6D28D9)',
    autre:    'linear-gradient(135deg, var(--amber-400), #D97706)',
};

const thumbIcons = {
    travail: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>`,
    salaire: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>`,
    presence:`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16l2 2 4-4"/></svg>`,
    autre:   `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>`,
};

function openModal(type, title, desc) {
    document.getElementById('attType').value    = type;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDesc').textContent  = desc;
    const thumb = document.getElementById('modalThumb');
    thumb.style.background = thumbColors[type] || thumbColors.autre;
    thumb.innerHTML = thumbIcons[type] || thumbIcons.autre;
    document.getElementById('dateGroup').style.display = type === 'presence' ? '' : 'none';
    document.getElementById('attModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModalDirect() {
    document.getElementById('attModal').classList.remove('open');
    document.body.style.overflow = '';
}

function closeModal(e) {
    if (e.target === document.getElementById('attModal')) closeModalDirect();
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModalDirect(); });
</script>
@endsection
