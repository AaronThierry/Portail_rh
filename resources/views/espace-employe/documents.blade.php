@extends('layouts.espace-employe')

@section('title', 'Mes Documents')
@section('page-title', $currentCategory ? $currentCategory->nom : 'Mes Documents')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    @if($currentCategory)
        <a href="{{ route('espace-employe.documents') }}">Mes Documents</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>{{ $currentCategory->nom }}</span>
    @else
        <span>Mes Documents</span>
    @endif
@endsection

@section('styles')
<style>
/* ════════════════════════════════════════════════════
   DOCUMENTS — Charte Portail RH+
   Indigo × Teal × Neutres · Syne · DM Sans · DM Mono
   ════════════════════════════════════════════════════ */

.doc-page { display: flex; flex-direction: column; gap: 1.5rem; animation: fadeUp .4s ease both; }

/* ── Hero ─────────────────────────────────────────── */
.doc-hero {
    background: linear-gradient(135deg, var(--ind-900) 0%, var(--ind-700) 60%, #1a3a5c 100%);
    border-radius: var(--r-xl);
    padding: 2rem 2.5rem;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.doc-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 55% 80% at 90% 50%, rgba(10,175,162,.18) 0%, transparent 70%);
    pointer-events: none;
}

.doc-hero::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--teal-400), var(--teal-300));
}

.doc-hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.doc-hero-left { display: flex; align-items: center; gap: 1.25rem; }

.doc-hero-ico {
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

.doc-hero-ico svg { width: 26px; height: 26px; }

.doc-hero-title {
    font-family: var(--font-d);
    font-size: 1.625rem;
    font-weight: 700;
    letter-spacing: -.01em;
    margin: 0 0 .3rem;
    color: #fff;
}

.doc-hero-sub { font-size: .9rem; color: rgba(255,255,255,.62); margin: 0; }

.doc-hero-stats { display: flex; gap: 2rem; }

.doc-stat { text-align: center; }

.doc-stat-val {
    font-family: var(--font-d);
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
    color: #fff;
}

.doc-stat-lbl {
    font-size: .75rem;
    color: rgba(255,255,255,.5);
    margin-top: .3rem;
    text-transform: uppercase;
    letter-spacing: .05em;
}

/* ── Nav Bar ──────────────────────────────────────── */
.doc-navbar {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-lg);
    padding: .875rem 1.25rem;
    display: flex;
    align-items: center;
    gap: .875rem;
    box-shadow: var(--shadow-sm);
    flex-wrap: wrap;
}

.doc-back {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .5rem .875rem;
    background: var(--n-50);
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    color: var(--text-2);
    font-size: .8125rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s ease;
    white-space: nowrap;
}

.doc-back:hover { border-color: var(--ind-400); color: var(--ind-500); background: var(--ind-50); }
.doc-back svg { width: 16px; height: 16px; }

.doc-path {
    display: flex;
    align-items: center;
    gap: .375rem;
    flex: 1;
    overflow-x: auto;
    scrollbar-width: none;
}
.doc-path::-webkit-scrollbar { display: none; }

.doc-path-item {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .4rem .75rem;
    border-radius: var(--r-f);
    font-size: .8125rem;
    font-weight: 600;
    color: var(--text-2);
    text-decoration: none;
    white-space: nowrap;
    transition: all .2s ease;
    background: var(--n-50);
}

.doc-path-item:hover { background: var(--ind-50); color: var(--ind-500); }

.doc-path-item.active {
    background: var(--ind-900);
    color: #fff;
}

.doc-path-item svg { width: 14px; height: 14px; }

.doc-path-sep { color: var(--text-3); display: flex; align-items: center; }
.doc-path-sep svg { width: 14px; height: 14px; }

.doc-search {
    position: relative;
    width: 260px;
    flex-shrink: 0;
}

.doc-search-ico {
    position: absolute;
    left: .75rem;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    color: var(--text-3);
    pointer-events: none;
}

.doc-search input {
    width: 100%;
    padding: .55rem 1rem .55rem 2.25rem;
    background: var(--n-50);
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    font-size: .875rem;
    font-family: var(--font);
    color: var(--text);
    transition: all .2s ease;
}

.doc-search input::placeholder { color: var(--text-3); }

.doc-search input:focus {
    outline: none;
    border-color: var(--ind-400);
    background: var(--surface);
    box-shadow: 0 0 0 3px rgba(55,72,200,.10);
}

/* ── Section wrapper ──────────────────────────────── */
.doc-section {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.doc-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.125rem 1.5rem;
    border-bottom: 1.5px solid var(--border-2);
    background: var(--n-50);
}

.doc-section-title {
    display: flex;
    align-items: center;
    gap: .75rem;
    font-family: var(--font-d);
    font-size: .9375rem;
    font-weight: 700;
    color: var(--text);
}

.doc-section-icon {
    width: 34px;
    height: 34px;
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    border-radius: var(--r);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

.doc-section-icon svg { width: 16px; height: 16px; }

.doc-count {
    font-size: .75rem;
    font-weight: 600;
    color: var(--text-3);
    background: var(--n-100);
    padding: .25rem .625rem;
    border-radius: var(--r-f);
    font-family: var(--font-m);
}

/* ── Folders Grid ─────────────────────────────────── */
.doc-folders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 1rem;
    padding: 1.5rem;
}

.doc-folder {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem 1rem 1.125rem;
    background: var(--n-50);
    border: 1.5px solid var(--border-2);
    border-radius: var(--r-xl);
    border-top: 3px solid var(--folder-color, var(--ind-400));
    text-decoration: none;
    transition: transform .25s cubic-bezier(.4,0,.2,1), box-shadow .25s ease, border-color .25s ease;
    position: relative;
    cursor: pointer;
}

.doc-folder:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    border-color: var(--folder-color, var(--ind-400));
    border-top-color: var(--folder-color, var(--ind-400));
}

.doc-folder-ico {
    width: 64px;
    height: 64px;
    border-radius: var(--r-lg);
    background: color-mix(in srgb, var(--folder-color, var(--ind-400)) 14%, transparent);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: .875rem;
    color: var(--folder-color, var(--ind-400));
    transition: transform .25s ease;
}

.doc-folder:hover .doc-folder-ico { transform: scale(1.08) rotate(-4deg); }
.doc-folder-ico svg { width: 30px; height: 30px; }

.doc-folder-name {
    font-family: var(--font-d);
    font-size: .9375rem;
    font-weight: 700;
    color: var(--text);
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    margin-bottom: .35rem;
}

.doc-folder-meta {
    display: flex;
    align-items: center;
    gap: .3rem;
    font-size: .75rem;
    color: var(--text-3);
}

.doc-folder-meta svg { width: 13px; height: 13px; }

.doc-folder-new {
    position: absolute;
    top: .625rem;
    right: .625rem;
    background: rgba(10,175,162,.15);
    color: var(--teal-500);
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .04em;
    padding: .2rem .45rem;
    border-radius: var(--r-f);
}

/* ── Files View toggle ────────────────────────────── */
.doc-view-toggle {
    display: flex;
    gap: .25rem;
    background: var(--n-100);
    padding: .2rem;
    border-radius: var(--r);
}

.doc-view-btn {
    padding: .4rem .5rem;
    border: none;
    background: transparent;
    border-radius: calc(var(--r) - 2px);
    color: var(--text-3);
    cursor: pointer;
    transition: all .2s ease;
    display: flex;
    align-items: center;
}

.doc-view-btn:hover { color: var(--ind-500); }

.doc-view-btn.active {
    background: var(--surface);
    color: var(--ind-600);
    box-shadow: var(--shadow-sm);
}

.doc-view-btn svg { width: 16px; height: 16px; }

/* ── Category badge ───────────────────────────────── */
.doc-cat-badge {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .4rem .875rem;
    border-radius: var(--r-f);
    font-size: .8125rem;
    font-weight: 700;
    color: #fff;
}

.doc-cat-badge svg { width: 14px; height: 14px; }

/* ── File Cards (Grid) ────────────────────────────── */
.doc-files-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
    gap: 1rem;
    padding: 1.5rem;
}

.doc-file-card {
    background: var(--n-50);
    border: 1.5px solid var(--border-2);
    border-radius: var(--r-xl);
    padding: 1.25rem;
    transition: transform .25s cubic-bezier(.4,0,.2,1), box-shadow .25s ease, border-color .25s ease;
    position: relative;
}

.doc-file-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    border-color: var(--border);
}

.doc-file-top {
    display: flex;
    align-items: flex-start;
    gap: .875rem;
    margin-bottom: .875rem;
}

.doc-file-ico {
    width: 48px;
    height: 48px;
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #fff;
}

.doc-file-ico svg { width: 22px; height: 22px; }
.doc-file-ico.pdf  { background: linear-gradient(135deg, #EF4444, #DC2626); }
.doc-file-ico.doc  { background: linear-gradient(135deg, var(--ind-400), var(--ind-600)); }
.doc-file-ico.img  { background: linear-gradient(135deg, var(--teal-400), var(--teal-300)); }
.doc-file-ico.xls  { background: linear-gradient(135deg, #22C55E, #16A34A); }
.doc-file-ico.def  { background: linear-gradient(135deg, var(--n-400), var(--n-500)); }

.doc-file-info { flex: 1; min-width: 0; }

.doc-file-name {
    font-weight: 700;
    font-size: .9375rem;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: .25rem;
}

.doc-file-ext {
    display: inline-block;
    font-family: var(--font-m);
    font-size: .65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--text-3);
    background: var(--n-100);
    padding: .1rem .4rem;
    border-radius: var(--r-sm);
}

.doc-file-meta {
    display: flex;
    flex-wrap: wrap;
    gap: .625rem;
    margin-bottom: .875rem;
}

.doc-file-meta-item {
    display: inline-flex;
    align-items: center;
    gap: .25rem;
    font-family: var(--font-m);
    font-size: .72rem;
    color: var(--text-3);
}

.doc-file-meta-item svg { width: 12px; height: 12px; }

.doc-file-actions { display: flex; gap: .5rem; }

.doc-fbtn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .35rem;
    padding: .575rem;
    border-radius: var(--r);
    font-size: .75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s ease;
    text-decoration: none;
    border: none;
}

.doc-fbtn svg { width: 14px; height: 14px; }

.doc-fbtn.primary {
    background: linear-gradient(135deg, var(--ind-500), var(--ind-600));
    color: #fff;
    box-shadow: 0 2px 8px rgba(55,72,200,.25);
}

.doc-fbtn.primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(55,72,200,.35); color: #fff; }

.doc-fbtn.secondary {
    background: var(--surface);
    border: 1.5px solid var(--border);
    color: var(--text-2);
}

.doc-fbtn.secondary:hover { border-color: var(--teal-400); color: var(--teal-500); }

/* ── File rows (List view) ────────────────────────── */
.doc-files-list { display: flex; flex-direction: column; }

.doc-file-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: .875rem 1.5rem;
    border-bottom: 1px solid var(--border-2);
    transition: background .15s ease;
}

.doc-file-row:last-child { border-bottom: none; }
.doc-file-row:hover { background: var(--n-50); }

.doc-file-row .doc-file-ico { width: 40px; height: 40px; border-radius: var(--r); }

.doc-file-row-name {
    flex: 1;
    font-weight: 600;
    font-size: .9rem;
    color: var(--text);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.doc-file-row-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-family: var(--font-m);
    font-size: .72rem;
    color: var(--text-3);
    white-space: nowrap;
}

.doc-file-row-actions { display: flex; gap: .5rem; }

.doc-row-btn {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .4rem .75rem;
    border-radius: var(--r);
    font-size: .75rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s ease;
    white-space: nowrap;
}

.doc-row-btn svg { width: 13px; height: 13px; }
.doc-row-btn.primary { background: rgba(55,72,200,.10); color: var(--ind-500); }
.doc-row-btn.primary:hover { background: rgba(55,72,200,.18); }
.doc-row-btn.secondary { background: var(--n-100); color: var(--text-2); }
.doc-row-btn.secondary:hover { background: rgba(10,175,162,.10); color: var(--teal-500); }

/* ── Empty State ──────────────────────────────────── */
.doc-empty {
    text-align: center;
    padding: 4.5rem 2rem;
}

.doc-empty-ico {
    width: 96px;
    height: 96px;
    margin: 0 auto 1.5rem;
    background: rgba(55,72,200,.07);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ind-400);
}

.doc-empty-ico svg { width: 44px; height: 44px; opacity: .65; }

.doc-empty h3 {
    font-family: var(--font-d);
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 .625rem;
}

.doc-empty p {
    color: var(--text-2);
    max-width: 380px;
    margin: 0 auto;
    line-height: 1.65;
}

/* ── Responsive ───────────────────────────────────── */
@media (max-width: 1024px) {
    .doc-hero-inner  { flex-direction: column; text-align: center; }
    .doc-hero-left   { flex-direction: column; align-items: center; }
    .doc-hero-stats  { justify-content: center; }
    .doc-navbar      { flex-wrap: wrap; }
    .doc-search      { width: 100%; order: 3; }
}

@media (max-width: 768px) {
    .doc-folders-grid { grid-template-columns: repeat(2, 1fr); gap: .75rem; padding: 1rem; }
    .doc-files-grid   { grid-template-columns: 1fr; padding: 1rem; }
    .doc-file-row-meta { display: none; }
}

@media (max-width: 480px) {
    .doc-folders-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endsection

@section('content')
<div class="doc-page">

    {{-- ── Hero ── --}}
    <div class="doc-hero">
        <div class="doc-hero-inner">
            <div class="doc-hero-left">
                <div class="doc-hero-ico">
                    @if($currentCategory)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                            <rect x="2" y="3" width="20" height="18" rx="2"/>
                            <path d="M8 3v18M2 9h6M2 15h6"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <h1 class="doc-hero-title">
                        {{ $currentCategory ? $currentCategory->nom : 'Mon Dossier Personnel' }}
                    </h1>
                    <p class="doc-hero-sub">
                        @if($currentCategory)
                            {{ $currentCategory->description ?? 'Documents de la catégorie ' . $currentCategory->nom }}
                        @else
                            Vos documents sont organisés par catégories pour un accès rapide et sécurisé
                        @endif
                    </p>
                </div>
            </div>
            <div class="doc-hero-stats">
                <div class="doc-stat">
                    <div class="doc-stat-val">{{ $stats['total'] }}</div>
                    <div class="doc-stat-lbl">Documents</div>
                </div>
                <div class="doc-stat">
                    <div class="doc-stat-val">{{ $stats['categories'] }}</div>
                    <div class="doc-stat-lbl">Dossiers</div>
                </div>
                <div class="doc-stat">
                    <div class="doc-stat-val">{{ $stats['recent'] }}</div>
                    <div class="doc-stat-lbl">Récents</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Nav Bar ── --}}
    <div class="doc-navbar">
        @if($currentCategory)
            <a href="{{ route('espace-employe.documents') }}" class="doc-back">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Retour
            </a>
        @endif

        <div class="doc-path">
            <a href="{{ route('espace-employe.documents') }}" class="doc-path-item {{ !$currentCategory ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                </svg>
                Mon Dossier
            </a>
            @if($currentCategory)
                <span class="doc-path-sep">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </span>
                <span class="doc-path-item active">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                    {{ $currentCategory->nom }}
                </span>
            @endif
        </div>

        <div class="doc-search">
            <svg class="doc-search-ico" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Rechercher…">
        </div>
    </div>

    @if(!$currentCategory)
    {{-- ═══════════════════════
         FOLDERS VIEW
    ═══════════════════════ --}}
    @if($categoriesWithDocs->count() > 0 || $uncategorizedDocs->count() > 0)
        <div class="doc-section">
            <div class="doc-section-head">
                <div class="doc-section-title">
                    <div class="doc-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    Mes Dossiers
                </div>
                <span class="doc-count">{{ $categoriesWithDocs->count() + ($uncategorizedDocs->count() > 0 ? 1 : 0) }}</span>
            </div>

            <div class="doc-folders-grid">
                @foreach($categoriesWithDocs as $category)
                    @php
                        $cnt = $documentsByCategory->get($category->id, collect([]))->count();
                        $fc  = $category->couleur ?? '#3748C8';
                        $isNew = $documentsByCategory->get($category->id, collect([]))->where('created_at', '>=', now()->subDays(7))->count() > 0;
                    @endphp
                    <a href="{{ route('espace-employe.documents', ['categorie' => $category->id]) }}"
                       class="doc-folder"
                       style="--folder-color: {{ $fc }};"
                       data-name="{{ strtolower($category->nom) }}">
                        @if($isNew)
                            <span class="doc-folder-new">Nouveau</span>
                        @endif
                        <div class="doc-folder-ico">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 6h-8l-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z"/>
                            </svg>
                        </div>
                        <div class="doc-folder-name">{{ $category->nom }}</div>
                        <div class="doc-folder-meta">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                            {{ $cnt }} document{{ $cnt > 1 ? 's' : '' }}
                        </div>
                    </a>
                @endforeach

                @if($uncategorizedDocs->count() > 0)
                    @php $uc = $uncategorizedDocs->count(); @endphp
                    <a href="{{ route('espace-employe.documents', ['categorie' => '0']) }}"
                       class="doc-folder"
                       style="--folder-color: var(--n-400);"
                       data-name="autres documents">
                        <div class="doc-folder-ico">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 6h-8l-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z"/>
                            </svg>
                        </div>
                        <div class="doc-folder-name">Autres Documents</div>
                        <div class="doc-folder-meta">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                            {{ $uc }} document{{ $uc > 1 ? 's' : '' }}
                        </div>
                    </a>
                @endif
            </div>
        </div>

    @else
        <div class="doc-section">
            <div class="doc-empty">
                <div class="doc-empty-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <h3>Aucun document disponible</h3>
                <p>Votre dossier personnel est vide pour le moment. Les documents seront affichés ici une fois ajoutés par l'administration.</p>
            </div>
        </div>
    @endif

    @else
    {{-- ═══════════════════════
         FILES VIEW
    ═══════════════════════ --}}
    @php
        $filesToShow   = $selectedCategory == '0' ? $uncategorizedDocs : $documents;
        $categoryColor = $currentCategory ? ($currentCategory->couleur ?? '#3748C8') : 'var(--n-400)';
    @endphp

    <div class="doc-section">
        <div class="doc-section-head">
            <div class="doc-section-title">
                <span class="doc-cat-badge" style="background: {{ $categoryColor }};">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                    {{ $currentCategory ? $currentCategory->nom : 'Autres Documents' }}
                </span>
                <span class="doc-count">{{ $filesToShow->count() }}</span>
            </div>
            <div class="doc-view-toggle">
                <button class="doc-view-btn active" data-view="grid" title="Grille">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                </button>
                <button class="doc-view-btn" data-view="list" title="Liste">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
                        <line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/>
                        <line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
                    </svg>
                </button>
            </div>
        </div>

        @if($filesToShow->count() > 0)
        <div class="doc-files-grid" id="filesContainer">
            @foreach($filesToShow as $document)
                @php
                    $ext = strtolower($document->extension ?? pathinfo($document->chemin ?? '', PATHINFO_EXTENSION));
                    $ico = 'def';
                    if ($ext === 'pdf')                              $ico = 'pdf';
                    elseif (in_array($ext, ['doc','docx']))         $ico = 'doc';
                    elseif (in_array($ext, ['jpg','jpeg','png','gif','webp'])) $ico = 'img';
                    elseif (in_array($ext, ['xls','xlsx','csv']))   $ico = 'xls';
                @endphp
                {{-- GRID CARD --}}
                <div class="doc-file-card" data-name="{{ strtolower($document->titre ?? $document->nom_original ?? '') }}">
                    <div class="doc-file-top">
                        <div class="doc-file-ico {{ $ico }}">
                            @if($ico === 'pdf')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                            @elseif($ico === 'img')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                            @elseif($ico === 'xls')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <rect x="8" y="12" width="8" height="6" rx="1"/>
                                </svg>
                            @elseif($ico === 'doc')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                            @endif
                        </div>
                        <div class="doc-file-info">
                            <div class="doc-file-name">{{ $document->titre ?? $document->nom_original ?? 'Document' }}</div>
                            <span class="doc-file-ext">.{{ $ext ?: 'fichier' }}</span>
                        </div>
                    </div>

                    <div class="doc-file-meta">
                        <span class="doc-file-meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            {{ $document->created_at->format('d/m/Y') }}
                        </span>
                        @if($document->taille)
                            <span class="doc-file-meta-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                                {{ number_format($document->taille / 1024, 0) }} Ko
                            </span>
                        @endif
                    </div>

                    <div class="doc-file-actions">
                        <a href="{{ route('espace-employe.documents.preview', $document->id) }}" class="doc-fbtn primary" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            Voir
                        </a>
                        <a href="{{ route('espace-employe.documents.download', $document->id) }}" class="doc-fbtn secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            Télécharger
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @else
        <div class="doc-empty">
            <div class="doc-empty-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <h3>Dossier vide</h3>
            <p>Ce dossier ne contient aucun document pour le moment.</p>
        </div>
        @endif
    </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Search ──
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.doc-folder, .doc-file-card, .doc-file-row').forEach(el => {
                el.style.display = (!q || (el.dataset.name || '').includes(q)) ? '' : 'none';
            });
        });
    }

    // ── View toggle ──
    const viewBtns = document.querySelectorAll('.doc-view-btn');
    const container = document.getElementById('filesContainer');

    viewBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            viewBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            if (!container) return;

            if (this.dataset.view === 'list') {
                container.classList.remove('doc-files-grid');
                container.classList.add('doc-files-list');
                // Convert cards → rows
                container.querySelectorAll('.doc-file-card').forEach(card => {
                    card.classList.remove('doc-file-card');
                    card.classList.add('doc-file-row');
                });
            } else {
                container.classList.remove('doc-files-list');
                container.classList.add('doc-files-grid');
                container.querySelectorAll('.doc-file-row').forEach(row => {
                    row.classList.remove('doc-file-row');
                    row.classList.add('doc-file-card');
                });
            }
        });
    });
});
</script>
@endsection
