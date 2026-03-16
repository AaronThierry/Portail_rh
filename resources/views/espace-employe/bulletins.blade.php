@extends('layouts.espace-employe')

@section('title', 'Mes Bulletins de Paie')
@section('page-title', 'Mes Bulletins de Paie')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    @if(isset($bulletinSelectionne))
        <a href="{{ route('espace-employe.bulletins') }}">Bulletins de paie</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>{{ $bulletinSelectionne->periode_formatee }}</span>
    @else
        <span>Bulletins de paie</span>
    @endif
@endsection

@section('styles')
<style>
/* ════════════════════════════════════════════════════
   BULLETINS DE PAIE — Charte Portail RH+
   Indigo × Teal × Neutres · Syne · DM Sans · DM Mono
   ════════════════════════════════════════════════════ */

.bp-page { animation: fadeUp .4s ease both; }

/* ── Hero Banner ──────────────────────────────────── */
.bp-hero {
    background: linear-gradient(135deg, var(--ind-900) 0%, var(--ind-700) 60%, #1a3a5c 100%);
    border-radius: var(--r-xl);
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.bp-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 60% 80% at 90% 50%, rgba(10,175,162,.18) 0%, transparent 70%);
    pointer-events: none;
}

.bp-hero::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--teal-400), var(--teal-300));
}

.bp-hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.bp-hero-left {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.bp-hero-icon {
    width: 56px;
    height: 56px;
    background: rgba(10,175,162,.20);
    border: 1px solid rgba(10,175,162,.35);
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: var(--teal-300);
}

.bp-hero-icon svg { width: 26px; height: 26px; }

.bp-hero-title {
    font-family: var(--font-d);
    font-size: 1.625rem;
    font-weight: 700;
    letter-spacing: -.01em;
    margin: 0 0 .3rem;
    color: #fff;
}

.bp-hero-sub {
    font-size: .9rem;
    color: rgba(255,255,255,.65);
    margin: 0;
}

.bp-hero-stats {
    display: flex;
    gap: 2rem;
}

.bp-hero-stat {
    text-align: center;
}

.bp-hero-stat-value {
    font-family: var(--font-d);
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
    color: #fff;
}

.bp-hero-stat-label {
    font-size: .8rem;
    color: rgba(255,255,255,.55);
    margin-top: .3rem;
    text-transform: uppercase;
    letter-spacing: .05em;
}

/* ── Year Navigation ──────────────────────────────── */
.bp-years {
    display: flex;
    gap: .5rem;
    margin-bottom: 1.75rem;
    flex-wrap: wrap;
    align-items: center;
}

.bp-year-label {
    font-size: .75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--text-3);
    margin-right: .5rem;
}

.bp-year-btn {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .5rem 1.125rem;
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-f);
    font-family: var(--font-d);
    font-size: .875rem;
    font-weight: 600;
    color: var(--text-2);
    cursor: pointer;
    transition: all .2s ease;
    text-decoration: none;
    box-shadow: var(--shadow-sm);
}

.bp-year-btn:hover {
    border-color: var(--ind-400);
    color: var(--ind-500);
    transform: translateY(-1px);
    box-shadow: var(--shadow);
}

.bp-year-btn.active {
    background: var(--ind-900);
    border-color: var(--ind-900);
    color: #fff;
    box-shadow: 0 4px 14px rgba(10,16,64,.25);
}

.bp-year-btn .badge {
    background: rgba(255,255,255,.18);
    padding: .1rem .45rem;
    border-radius: var(--r-f);
    font-size: .75rem;
    font-family: var(--font-m);
}

.bp-year-btn:not(.active) .badge {
    background: var(--n-100);
    color: var(--text-2);
}

/* ── Months Grid ──────────────────────────────────── */
.bp-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(256px, 1fr));
    gap: 1.125rem;
}

/* ── Month Card ───────────────────────────────────── */
.bp-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    overflow: hidden;
    transition: transform .25s cubic-bezier(.4,0,.2,1), box-shadow .25s ease, border-color .25s ease;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    position: relative;
}

.bp-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--teal-400);
    transition: background .25s ease;
}

.bp-card.empty::before {
    background: var(--n-200);
}

.bp-card:hover:not(.empty) {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    border-color: var(--teal-400);
}

.bp-card.empty {
    opacity: .55;
    cursor: default;
}

.bp-card-body {
    padding: 1.375rem 1.375rem 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.bp-card-icon {
    width: 52px;
    height: 52px;
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: transform .25s ease;
}

.bp-card:hover:not(.empty) .bp-card-icon {
    transform: scale(1.08) rotate(-4deg);
}

.bp-card-icon.available {
    background: linear-gradient(135deg, var(--teal-400), var(--teal-300));
    color: #fff;
    box-shadow: 0 4px 12px rgba(10,175,162,.30);
}

.bp-card-icon.pending {
    background: var(--n-100);
    color: var(--text-3);
}

.bp-card-icon svg { width: 24px; height: 24px; }

.bp-card-info { flex: 1; min-width: 0; }

.bp-card-month {
    font-family: var(--font-d);
    font-size: 1.0625rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 .375rem;
}

.bp-card.empty .bp-card-month { color: var(--text-2); }

.bp-badge {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .25rem .6rem;
    border-radius: var(--r-f);
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .02em;
}

.bp-badge.available {
    background: rgba(10,175,162,.10);
    color: var(--teal-500);
}

.bp-badge.pending {
    background: var(--n-100);
    color: var(--text-3);
}

.bp-badge svg { width: 11px; height: 11px; }

.bp-card-footer {
    padding: .75rem 1.375rem;
    background: var(--n-50);
    border-top: 1px solid var(--border-2);
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: .8rem;
    color: var(--text-3);
}

.bp-card-footer .link {
    display: flex;
    align-items: center;
    gap: .3rem;
    color: var(--teal-500);
    font-weight: 600;
    font-size: .8rem;
    transition: gap .2s ease;
}

.bp-card:hover:not(.empty) .bp-card-footer .link { gap: .55rem; }

.bp-card-footer .link svg { width: 13px; height: 13px; }

/* ── Detail View ──────────────────────────────────── */
.bp-detail {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
}

.bp-detail-head {
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    padding: 1.75rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    position: relative;
}

.bp-detail-head::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--teal-400), transparent);
}

.bp-detail-title {
    display: flex;
    align-items: center;
    gap: 1.125rem;
}

.bp-detail-thumb {
    width: 52px;
    height: 52px;
    background: rgba(10,175,162,.20);
    border: 1px solid rgba(10,175,162,.30);
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--teal-300);
}

.bp-detail-thumb svg { width: 24px; height: 24px; }

.bp-detail-title h2 {
    font-family: var(--font-d);
    font-size: 1.25rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 .2rem;
}

.bp-detail-title p {
    font-size: .85rem;
    color: rgba(255,255,255,.55);
    margin: 0;
}

.bp-detail-actions { display: flex; gap: .75rem; }

/* ── Buttons ──────────────────────────────────────── */
.bp-btn {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .65rem 1.25rem;
    border-radius: var(--r);
    font-weight: 600;
    font-size: .875rem;
    cursor: pointer;
    transition: all .2s ease;
    text-decoration: none;
    border: none;
    white-space: nowrap;
}

.bp-btn svg { width: 16px; height: 16px; }

.bp-btn-primary {
    background: linear-gradient(135deg, var(--teal-400), var(--teal-300));
    color: #fff;
    box-shadow: 0 4px 14px rgba(10,175,162,.35);
}

.bp-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(10,175,162,.45);
    color: #fff;
}

.bp-btn-ghost {
    background: rgba(255,255,255,.10);
    border: 1px solid rgba(255,255,255,.20);
    color: rgba(255,255,255,.85);
}

.bp-btn-ghost:hover {
    background: rgba(255,255,255,.18);
    color: #fff;
}

/* ── Detail Body ──────────────────────────────────── */
.bp-detail-body { padding: 2rem; }

.bp-preview-wrap {
    background: var(--n-100);
    border: 1.5px solid var(--border);
    border-radius: var(--r-lg);
    height: 560px;
    overflow: hidden;
    margin-bottom: 2rem;
}

.bp-preview-wrap iframe { width: 100%; height: 100%; border: none; }

/* ── Info Cards ───────────────────────────────────── */
.bp-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.bp-meta-card {
    background: var(--n-50);
    border: 1.5px solid var(--border-2);
    border-radius: var(--r-lg);
    padding: 1.125rem 1.25rem;
    display: flex;
    align-items: center;
    gap: .875rem;
    transition: box-shadow .2s ease, transform .2s ease;
}

.bp-meta-card:hover {
    box-shadow: var(--shadow);
    transform: translateY(-2px);
}

.bp-meta-ico {
    width: 42px;
    height: 42px;
    border-radius: var(--r);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.bp-meta-ico.ind  { background: rgba(55,72,200,.10); color: var(--ind-500); }
.bp-meta-ico.teal { background: rgba(10,175,162,.10); color: var(--teal-400); }
.bp-meta-ico.amb  { background: var(--amber-100);     color: var(--amber-400); }

.bp-meta-ico svg { width: 20px; height: 20px; }

.bp-meta-label {
    font-size: .68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--text-3);
    margin: 0 0 .25rem;
}

.bp-meta-val {
    font-family: var(--font-m);
    font-size: 1rem;
    font-weight: 500;
    color: var(--text);
    margin: 0;
}

/* ── Empty State ──────────────────────────────────── */
.bp-empty {
    text-align: center;
    padding: 5rem 2rem;
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
}

.bp-empty-ico {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.75rem;
    background: rgba(55,72,200,.07);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ind-400);
}

.bp-empty-ico svg { width: 46px; height: 46px; opacity: .7; }

.bp-empty h3 {
    font-family: var(--font-d);
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 .75rem;
}

.bp-empty p {
    color: var(--text-2);
    max-width: 420px;
    margin: 0 auto;
    line-height: 1.65;
}

/* ── Responsive ───────────────────────────────────── */
@media (max-width: 768px) {
    .bp-hero-inner  { flex-direction: column; text-align: center; }
    .bp-hero-left   { flex-direction: column; align-items: center; }
    .bp-hero-stats  { justify-content: center; }
    .bp-grid        { grid-template-columns: 1fr; }
    .bp-detail-head { flex-direction: column; text-align: center; }
    .bp-detail-title{ flex-direction: column; align-items: center; }
    .bp-detail-actions { flex-direction: column; }
    .bp-preview-wrap { height: 420px; }
    .bp-meta-grid   { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')
<div class="bp-page">
    @if(!isset($bulletinSelectionne))
    {{-- ═══════════════════════════════════
         VUE LISTE
    ═══════════════════════════════════ --}}

    {{-- Hero --}}
    <div class="bp-hero">
        <div class="bp-hero-inner">
            <div class="bp-hero-left">
                <div class="bp-hero-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                </div>
                <div>
                    <h1 class="bp-hero-title">Mes Bulletins de Paie</h1>
                    <p class="bp-hero-sub">Consultez et téléchargez vos fiches de paie en toute sécurité</p>
                </div>
            </div>
            <div class="bp-hero-stats">
                <div class="bp-hero-stat">
                    <div class="bp-hero-stat-value">{{ $totalBulletins ?? 0 }}</div>
                    <div class="bp-hero-stat-label">Bulletins</div>
                </div>
                <div class="bp-hero-stat">
                    <div class="bp-hero-stat-value">{{ count($anneesDisponibles ?? []) ?: '—' }}</div>
                    <div class="bp-hero-stat-label">Années</div>
                </div>
            </div>
        </div>
    </div>

    @if(count($anneesDisponibles ?? []) > 0)
        {{-- Year nav --}}
        <div class="bp-years">
            <span class="bp-year-label">Année</span>
            @foreach($anneesDisponibles as $annee)
                @php $countAnnee = isset($bulletinsParAnnee[$annee]) ? $bulletinsParAnnee[$annee]->count() : 0; @endphp
                <a href="{{ route('espace-employe.bulletins', ['annee' => $annee]) }}"
                   class="bp-year-btn {{ $anneeSelectionnee == $annee ? 'active' : '' }}">
                    {{ $annee }}
                    <span class="badge">{{ $countAnnee }}</span>
                </a>
            @endforeach
        </div>

        {{-- Month grid --}}
        <div class="bp-grid">
            @foreach($moisData as $mois => $data)
                @if($data['bulletin'])
                    <a href="{{ route('espace-employe.bulletins', ['annee' => $anneeSelectionnee, 'mois' => $mois]) }}"
                       class="bp-card">
                        <div class="bp-card-body">
                            <div class="bp-card-icon available">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                            </div>
                            <div class="bp-card-info">
                                <p class="bp-card-month">{{ $data['nom'] }}</p>
                                <span class="bp-badge available">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    Disponible
                                </span>
                            </div>
                        </div>
                        <div class="bp-card-footer">
                            <span>{{ $data['bulletin']->fichier_taille_formatee }}</span>
                            <span class="link">
                                Consulter
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </span>
                        </div>
                    </a>
                @else
                    <div class="bp-card empty">
                        <div class="bp-card-body">
                            <div class="bp-card-icon pending">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                                </svg>
                            </div>
                            <div class="bp-card-info">
                                <p class="bp-card-month">{{ $data['nom'] }}</p>
                                <span class="bp-badge pending">En attente</span>
                            </div>
                        </div>
                        <div class="bp-card-footer">
                            <span>—</span>
                            <span>Non disponible</span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

    @else
        {{-- Empty state --}}
        <div class="bp-empty">
            <div class="bp-empty-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <h3>Aucun bulletin disponible</h3>
            <p>Vos bulletins de paie apparaîtront ici une fois qu'ils seront mis à disposition par votre service RH. Revenez bientôt !</p>
        </div>
    @endif

    @else
    {{-- ═══════════════════════════════════
         VUE DÉTAIL
    ═══════════════════════════════════ --}}
    <div class="bp-detail">
        <div class="bp-detail-head">
            <div class="bp-detail-title">
                <div class="bp-detail-thumb">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <div>
                    <h2>Bulletin de {{ $bulletinSelectionne->periode_formatee }}</h2>
                    <p>Mis à disposition le {{ $bulletinSelectionne->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
            <div class="bp-detail-actions">
                <a href="{{ route('espace-employe.bulletins.preview', $bulletinSelectionne) }}" target="_blank" class="bp-btn bp-btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                    Plein écran
                </a>
                <a href="{{ route('espace-employe.bulletins.download', $bulletinSelectionne) }}" class="bp-btn bp-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Télécharger
                </a>
            </div>
        </div>

        <div class="bp-detail-body">
            {{-- PDF Preview --}}
            <div class="bp-preview-wrap">
                <iframe src="{{ route('espace-employe.bulletins.preview', $bulletinSelectionne) }}#toolbar=0&navpanes=0&scrollbar=1"></iframe>
            </div>

            {{-- Metadata --}}
            <div class="bp-meta-grid">
                <div class="bp-meta-card">
                    <div class="bp-meta-ico ind">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <div>
                        <p class="bp-meta-label">Période</p>
                        <p class="bp-meta-val">{{ $bulletinSelectionne->periode_formatee }}</p>
                    </div>
                </div>

                @if($bulletinSelectionne->salaire_net)
                <div class="bp-meta-card">
                    <div class="bp-meta-ico teal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="bp-meta-label">Net à payer</p>
                        <p class="bp-meta-val">{{ number_format($bulletinSelectionne->salaire_net, 0, ',', ' ') }} F</p>
                    </div>
                </div>
                @endif

                <div class="bp-meta-card">
                    <div class="bp-meta-ico amb">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                    </div>
                    <div>
                        <p class="bp-meta-label">Taille</p>
                        <p class="bp-meta-val">{{ $bulletinSelectionne->fichier_taille_formatee }}</p>
                    </div>
                </div>

                <div class="bp-meta-card">
                    <div class="bp-meta-ico ind">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <div>
                        <p class="bp-meta-label">Référence</p>
                        <p class="bp-meta-val">{{ $bulletinSelectionne->reference ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
