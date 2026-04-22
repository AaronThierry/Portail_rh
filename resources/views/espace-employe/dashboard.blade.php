@extends('layouts.espace-employe')

@section('title', 'Mon Espace')
@section('page-title', 'Tableau de bord')
@section('breadcrumb')
    <span>Accueil</span>
@endsection

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* ═══════════════════════════════════════════════════════════════════
   PORTAIL RH+  ·  Dashboard Employé
   Charte officielle  —  Indigo × Teal × Neutres
   Syne · DM Sans · DM Mono
   ═══════════════════════════════════════════════════════════════════ */

:root {
    /* Brand */
    --ind-50:  #EEF0FB;
    --ind-100: #D5DAF5;
    --ind-200: #B0BAEC;
    --ind-400: #5566D4;
    --ind-500: #3748C8;
    --ind-600: #2535A8;
    --ind-700: #1A2785;
    --ind-800: #111C62;
    --ind-900: #0A1040;

    --teal-50:  #E6FAF7;
    --teal-100: #B3F0E6;
    --teal-300: #2ECABB;
    --teal-400: #0AAFA2;
    --teal-500: #078F84;
    --teal-700: #03524C;

    --amber-100: #FEF3C7;
    --amber-400: #F59E0B;
    --amber-800: #78350F;
    --rose-100:  #FFE4E6;
    --rose-400:  #FB7185;
    --rose-800:  #9F1239;
    --green-100: #D1FAE5;
    --green-400: #34D399;
    --green-800: #065F46;

    /* Neutrals */
    --n-0:   #FFFFFF;
    --n-50:  #F8F8F9;
    --n-100: #F0F1F3;
    --n-200: #E2E4E8;
    --n-300: #C9CDD5;
    --n-400: #9EA4B0;
    --n-500: #6B7282;
    --n-600: #4B5263;
    --n-700: #343A47;
    --n-800: #1E2330;

    /* Fonts */
    --fd: 'Syne', sans-serif;
    --fb: 'DM Sans', sans-serif;
    --fm: 'DM Mono', monospace;

    /* Shadows */
    --sh-sm: 0 1px 3px rgba(10,16,64,.06), 0 1px 2px rgba(10,16,64,.04);
    --sh:    0 2px 8px rgba(10,16,64,.07), 0 1px 3px rgba(10,16,64,.04);
    --sh-md: 0 4px 16px rgba(10,16,64,.08), 0 2px 6px rgba(10,16,64,.05);
    --sh-lg: 0 12px 32px rgba(10,16,64,.10), 0 4px 10px rgba(10,16,64,.06);

    /* Radius */
    --r-sm:  4px;
    --r:     8px;
    --r-lg:  12px;
    --r-xl:  16px;
    --r-2xl: 24px;
    --r-f:   9999px;
}

/* ── Reset & base ──────────────────────────────────────────── */
.dash, .dash * { box-sizing: border-box; }

.dash {
    font-family: var(--fb);
    color: var(--n-800);
    padding: 0;
}

/* ── Animations ─────────────────────────────────────────────── */
@keyframes rh-up {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes rh-in {
    from { opacity: 0; transform: translateX(-8px); }
    to   { opacity: 1; transform: translateX(0); }
}

/* ════════════════════════════════════════════════════════════
   HERO
════════════════════════════════════════════════════════════ */
.dash-hero {
    position: relative;
    background: linear-gradient(135deg, var(--ind-900) 0%, var(--ind-700) 55%, var(--teal-500) 100%);
    border-radius: var(--r-xl);
    padding: 28px 32px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    overflow: hidden;
    animation: rh-up .45s ease both;
    box-shadow: var(--sh-lg);
}

/* Subtle texture overlay */
.dash-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.025'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}

/* Glow accent */
.dash-hero::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, rgba(46,202,187,.5), transparent 60%);
}

.hero-left { position: relative; z-index: 1; }

.hero-eyebrow {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
}

.hero-pulse {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--teal-300);
    box-shadow: 0 0 0 0 rgba(46,202,187,.5);
    animation: pulse-ring 2.5s ease-out infinite;
}

@keyframes pulse-ring {
    0%   { box-shadow: 0 0 0 0 rgba(46,202,187,.5); }
    70%  { box-shadow: 0 0 0 8px rgba(46,202,187,.0); }
    100% { box-shadow: 0 0 0 0 rgba(46,202,187,.0); }
}

.hero-eyebrow-lbl {
    font-size: .67rem;
    font-weight: 600;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: rgba(255,255,255,.5);
    font-family: var(--fb);
}

.hero-name {
    font-family: var(--fd);
    font-size: 2.2rem;
    font-weight: 800;
    letter-spacing: -.04em;
    color: #fff;
    line-height: 1;
    margin-bottom: 14px;
}

.hero-chips {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .71rem;
    font-weight: 500;
    color: rgba(255,255,255,.65);
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.14);
    padding: 4px 10px;
    border-radius: var(--r-f);
    letter-spacing: .01em;
    white-space: nowrap;
    backdrop-filter: blur(4px);
}
.chip svg { flex-shrink: 0; opacity: .7; }

.chip-teal {
    color: var(--teal-300);
    background: rgba(46,202,187,.12);
    border-color: rgba(46,202,187,.22);
    font-family: var(--fm);
    font-size: .66rem;
    letter-spacing: .04em;
}

/* Right — clock */
.hero-right {
    position: relative;
    z-index: 1;
    flex-shrink: 0;
    text-align: right;
}

.hero-clock-display {
    font-family: var(--fm);
    font-weight: 500;
    line-height: 1;
    margin-bottom: 6px;
    display: flex;
    align-items: baseline;
    justify-content: flex-end;
    gap: 1px;
}
.clock-hm {
    font-size: 2.8rem;
    letter-spacing: -.04em;
    color: #fff;
}
.clock-sep { font-size: 2.8rem; color: rgba(255,255,255,.3); letter-spacing: -.04em; }
.clock-ss {
    font-size: 1.1rem;
    color: rgba(255,255,255,.4);
    align-self: flex-end;
    margin-bottom: 4px;
    margin-left: 1px;
}

.hero-date {
    font-size: .7rem;
    font-weight: 600;
    letter-spacing: .09em;
    text-transform: uppercase;
    color: rgba(255,255,255,.45);
    margin-bottom: 10px;
    font-family: var(--fb);
}

.day-prog-lbl {
    font-size: .6rem;
    font-weight: 600;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: rgba(255,255,255,.4);
    margin-bottom: 5px;
    display: flex;
    justify-content: flex-end;
    gap: 6px;
    font-family: var(--fb);
}
.day-prog-lbl span { color: rgba(255,255,255,.65); font-family: var(--fm); }

.day-bar {
    width: 180px;
    height: 3px;
    background: rgba(255,255,255,.12);
    border-radius: var(--r-f);
    overflow: hidden;
    margin-left: auto;
}
.day-bar-fill {
    height: 100%;
    border-radius: var(--r-f);
    background: linear-gradient(90deg, var(--teal-300), var(--teal-400));
    box-shadow: 0 0 8px rgba(46,202,187,.4);
    transition: width .8s cubic-bezier(.4,0,.2,1);
}

/* ════════════════════════════════════════════════════════════
   KPI CARDS
════════════════════════════════════════════════════════════ */
.dash-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 16px;
}

.scard {
    background: var(--n-0);
    border: 1px solid var(--n-200);
    border-radius: var(--r-xl);
    padding: 22px 22px 18px;
    position: relative;
    overflow: hidden;
    box-shadow: var(--sh-sm);
    transition: box-shadow .2s, transform .2s, border-color .2s;
    animation: rh-up .45s ease both;
    cursor: pointer;
    text-decoration: none;
    display: block;
    color: inherit;
}
.scard:nth-child(1) { animation-delay: .06s; }
.scard:nth-child(2) { animation-delay: .10s; }
.scard:nth-child(3) { animation-delay: .14s; }
.scard:nth-child(4) { animation-delay: .18s; }

.scard:hover {
    box-shadow: var(--sh-md);
    transform: translateY(-2px);
    border-color: var(--n-300);
}

/* Colored top accent bar */
.scard::before {
    content: '';
    position: absolute;
    top: 0; left: 16px; right: 16px;
    height: 4px;
    border-radius: 0 0 var(--r-sm) var(--r-sm);
}

.sc-ind::before   { background: var(--ind-500); }
.sc-teal::before  { background: var(--teal-400); }
.sc-amber::before { background: var(--amber-400); }
.sc-rose::before  { background: var(--rose-400); }

.scard-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 14px;
    margin-top: 8px;
}

.scard-label {
    font-size: .7rem;
    font-weight: 600;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: var(--n-500);
    font-family: var(--fb);
}

.scard-icon {
    width: 30px; height: 30px;
    border-radius: var(--r);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.scard-icon svg { width: 14px; height: 14px; stroke-width: 2; }

.sc-ind  .scard-icon { background: var(--ind-50);   color: var(--ind-600); }
.sc-teal .scard-icon { background: var(--teal-50);  color: var(--teal-500); }
.sc-amber .scard-icon { background: var(--amber-100); color: var(--amber-800); }
.sc-rose  .scard-icon { background: var(--rose-100);  color: var(--rose-800); }

.scard-val {
    font-family: var(--fd);
    font-size: 2.5rem;
    font-weight: 800;
    letter-spacing: -.05em;
    line-height: 1;
    color: var(--ind-800);
    margin-bottom: 10px;
}

.scard-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: .68rem;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: var(--r-f);
}
.scard-badge::before {
    content: '';
    width: 5px; height: 5px;
    border-radius: 50%;
    flex-shrink: 0;
    background: currentColor;
}

.sc-ind  .scard-badge { background: var(--ind-50);    color: var(--ind-600); }
.sc-teal .scard-badge { background: var(--teal-50);   color: var(--teal-600); }
.sc-amber .scard-badge { background: var(--amber-100); color: var(--amber-800); }
.sc-rose  .scard-badge { background: var(--rose-100);  color: var(--rose-800); }

/* ════════════════════════════════════════════════════════════
   MAIN GRID
════════════════════════════════════════════════════════════ */
.dash-main {
    display: grid;
    grid-template-columns: 1fr 308px;
    gap: 12px;
    align-items: start;
}

/* ── Panel (card) ── */
.panel {
    background: var(--n-0);
    border: 1px solid var(--n-200);
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--sh-sm);
    animation: rh-up .45s .22s ease both;
}

.panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px 12px;
    border-bottom: 1px solid var(--n-100);
}

.panel-title {
    font-family: var(--fd);
    font-size: .875rem;
    font-weight: 700;
    color: var(--ind-800);
    letter-spacing: -.015em;
    display: flex;
    align-items: center;
    gap: 8px;
}

.panel-count {
    font-family: var(--fm);
    font-size: .6rem;
    font-weight: 500;
    color: var(--n-500);
    background: var(--n-100);
    border: 1px solid var(--n-200);
    padding: 1px 7px;
    border-radius: var(--r-f);
    letter-spacing: .02em;
}

.panel-link {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: .72rem;
    font-weight: 600;
    color: var(--ind-600);
    text-decoration: none;
    transition: color .15s;
}
.panel-link:hover { color: var(--ind-700); }
.panel-link svg { width: 10px; height: 10px; transition: transform .15s; }
.panel-link:hover svg { transform: translateX(2px); }

/* ── Activity list ── */
.act-list { padding: 4px 0; }

.act-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 20px;
    transition: background .12s;
    cursor: pointer;
    text-decoration: none;
    color: inherit;
}
.act-item:hover { background: var(--n-50); }
.act-item + .act-item { border-top: 1px solid var(--n-100); }

.act-item:nth-child(1) { animation: rh-in .3s .08s ease both; }
.act-item:nth-child(2) { animation: rh-in .3s .12s ease both; }
.act-item:nth-child(3) { animation: rh-in .3s .16s ease both; }
.act-item:nth-child(4) { animation: rh-in .3s .20s ease both; }
.act-item:nth-child(5) { animation: rh-in .3s .24s ease both; }
.act-item:nth-child(6) { animation: rh-in .3s .28s ease both; }
.act-item:nth-child(7) { animation: rh-in .3s .32s ease both; }

.act-ico {
    width: 34px; height: 34px;
    border-radius: var(--r);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.act-ico svg { width: 15px; height: 15px; stroke-width: 1.8; }
.act-ico-file     { background: var(--ind-50);   color: var(--ind-600); }
.act-ico-calendar { background: var(--teal-50);  color: var(--teal-500); }
.act-ico-user     { background: var(--n-100);    color: var(--n-600); }

.act-body { flex: 1; min-width: 0; }

.act-title {
    font-size: .8125rem;
    font-weight: 600;
    color: var(--n-800);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.3;
}

.act-sub {
    font-size: .68rem;
    color: var(--n-500);
    margin-top: 2px;
    font-family: var(--fm);
    display: flex;
    align-items: center;
    gap: 6px;
}

.act-new {
    font-family: var(--fb);
    font-size: .56rem;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    padding: 1px 5px;
    border-radius: var(--r-sm);
    background: var(--teal-50);
    color: var(--teal-600);
    border: 1px solid var(--teal-100);
}

.act-date {
    font-family: var(--fm);
    font-size: .63rem;
    color: var(--n-400);
    flex-shrink: 0;
}

.act-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 52px 20px;
    gap: 10px;
    color: var(--n-400);
}
.act-empty svg { opacity: .3; }
.act-empty p { font-size: .78rem; }

/* ── Right column ── */
.right-col { display: flex; flex-direction: column; gap: 12px; }

/* ── Profile card ── */
.profile-card {
    background: var(--n-0);
    border: 1px solid var(--n-200);
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--sh-sm);
    animation: rh-up .45s .28s ease both;
}

.profile-top {
    padding: 18px 20px 16px;
    display: flex;
    align-items: center;
    gap: 14px;
    border-bottom: 1px solid var(--n-100);
    background: linear-gradient(135deg, var(--ind-50) 0%, var(--n-0) 60%);
}

/* Avatar with ring */
.av-ring {
    position: relative;
    width: 52px; height: 52px;
    flex-shrink: 0;
}
.av-ring::before {
    content: '';
    position: absolute;
    inset: -2px;
    border-radius: 50%;
    background: conic-gradient(
        var(--ind-500) 0deg,
        var(--teal-400) 120deg,
        var(--ind-200) 220deg,
        var(--ind-200) 310deg,
        var(--ind-500) 360deg
    );
    animation: ring-turn 6s linear infinite;
}
@keyframes ring-turn { to { transform: rotate(360deg); } }
.av-ring::after {
    content: '';
    position: absolute;
    inset: 2px;
    border-radius: 50%;
    background: var(--n-0);
    z-index: 1;
}
.av-img {
    position: absolute;
    inset: 3px;
    border-radius: 50%;
    object-fit: cover;
    z-index: 2;
    display: block;
}
.av-dot {
    position: absolute;
    bottom: 1px; right: 1px;
    width: 10px; height: 10px;
    background: var(--green-400);
    border: 2px solid var(--n-0);
    border-radius: 50%;
    z-index: 3;
}

.profile-info { flex: 1; min-width: 0; }

.profile-name {
    font-family: var(--fd);
    font-size: .9375rem;
    font-weight: 700;
    color: var(--ind-800);
    letter-spacing: -.02em;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.2;
}

.profile-post {
    font-size: .72rem;
    font-weight: 500;
    color: var(--n-500);
    margin-top: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.profile-mat {
    display: inline-block;
    margin-top: 5px;
    font-family: var(--fm);
    font-size: .62rem;
    color: var(--ind-600);
    background: var(--ind-50);
    border: 1px solid var(--ind-100);
    padding: 2px 8px;
    border-radius: var(--r-sm);
    letter-spacing: .02em;
}

/* Profile rows */
.prow {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 9px 20px;
    border-bottom: 1px solid var(--n-100);
    transition: background .12s;
}
.prow:last-child { border-bottom: none; }
.prow:hover { background: var(--n-50); }

.prow-ic {
    width: 16px;
    display: flex; align-items: center; justify-content: center;
    color: var(--n-400);
    flex-shrink: 0;
}
.prow-ic svg { width: 12px; height: 12px; stroke-width: 2; }

.prow-txt { flex: 1; min-width: 0; }

.prow-lbl {
    font-size: .58rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--n-400);
    font-family: var(--fb);
}

.prow-val {
    font-size: .78rem;
    font-weight: 600;
    color: var(--n-800);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-top: 1px;
}

.profile-footer {
    padding: 14px 20px;
    border-top: 1px solid var(--n-100);
}

.btn-primary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    padding: 10px 16px;
    background: var(--ind-600);
    color: #fff;
    font-family: var(--fb);
    font-size: .8125rem;
    font-weight: 600;
    border: none;
    border-radius: var(--r);
    text-decoration: none;
    cursor: pointer;
    transition: background .15s, transform .15s, box-shadow .15s;
    letter-spacing: -.005em;
}
.btn-primary svg { width: 14px; height: 14px; flex-shrink: 0; stroke-width: 2; }
.btn-primary:hover {
    background: var(--ind-700);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(37,53,168,.3);
}

/* ── Quick actions ── */
.actions-card {
    background: var(--n-0);
    border: 1px solid var(--n-200);
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--sh-sm);
    animation: rh-up .45s .35s ease both;
}

.actions-grid {
    padding: 12px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 6px;
}

.qa-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 10px;
    background: var(--n-50);
    border: 1.5px solid var(--n-200);
    border-radius: var(--r);
    color: var(--n-600);
    text-decoration: none;
    font-size: .75rem;
    font-weight: 600;
    transition: all .15s;
    white-space: nowrap;
    overflow: hidden;
    letter-spacing: -.005em;
}

.qa-ic {
    width: 24px; height: 24px;
    border-radius: var(--r-sm);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    background: var(--n-0);
    transition: background .15s, color .15s;
}
.qa-ic svg { width: 11px; height: 11px; stroke-width: 2; }

.qa-btn:hover {
    background: var(--ind-50);
    border-color: var(--ind-200);
    color: var(--ind-700);
    transform: translateY(-1px);
    box-shadow: var(--sh);
}
.qa-btn:hover .qa-ic { background: var(--ind-100); color: var(--ind-600); }

/* Primary action */
.qa-btn.qa-primary {
    grid-column: 1 / -1;
    background: linear-gradient(135deg, var(--ind-600), var(--ind-500));
    border-color: transparent;
    color: #fff;
    font-weight: 700;
    font-size: .8125rem;
    padding: 10px 12px;
    box-shadow: 0 2px 8px rgba(37,53,168,.25);
}
.qa-btn.qa-primary .qa-ic { background: rgba(255,255,255,.15); color: #fff; }
.qa-btn.qa-primary:hover {
    background: linear-gradient(135deg, var(--ind-700), var(--ind-600));
    box-shadow: 0 6px 20px rgba(37,53,168,.35);
    color: #fff;
}
.qa-btn.qa-primary:hover .qa-ic { background: rgba(255,255,255,.2); }

/* ── Responsive ── */
@media (max-width: 1080px) {
    .dash-stats { grid-template-columns: repeat(2, 1fr); }
    .dash-main  { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .dash-stats  { grid-template-columns: 1fr 1fr; }
    .dash-hero   { flex-direction: column; align-items: flex-start; gap: 16px; padding: 22px 20px; }
    .hero-right  { text-align: left; width: 100%; }
    .day-bar     { width: 100%; margin-left: 0; }
    .hero-name   { font-size: 1.7rem; }
    .clock-hm    { font-size: 2rem; }
}
</style>
@endsection

@section('content')
@php
    $prenomDisplay = $personnel ? $personnel->prenoms : auth()->user()->name;
@endphp

<div class="dash">

    {{-- ══════════════════════ HERO ══════════════════════ --}}
    <div class="dash-hero">
        <div class="hero-left">
            <div class="hero-eyebrow">
                <div class="hero-pulse"></div>
                <span class="hero-eyebrow-lbl" id="rh-greeting">Bonjour</span>
            </div>
            <h1 class="hero-name">{{ $prenomDisplay }}</h1>
            <div class="hero-chips">
                @if($personnel && $personnel->poste)
                <span class="chip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    {{ $personnel->poste }}
                </span>
                @endif
                @if($personnel && $personnel->departement)
                <span class="chip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    {{ $personnel->departement->nom }}
                </span>
                @endif
                @if($personnel && $personnel->matricule)
                <span class="chip chip-teal">{{ $personnel->matricule }}</span>
                @endif
                @if($personnel && $personnel->date_embauche)
                <span class="chip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Depuis {{ $personnel->date_embauche->format('d/m/Y') }}
                </span>
                @endif
            </div>
        </div>

        <div class="hero-right">
            <div class="hero-clock-display">
                <span class="clock-hm" id="rh-clock-hm">--:--</span>
                <span class="clock-ss" id="rh-clock-ss">--</span>
            </div>
            <div class="hero-date">{{ now()->translatedFormat('l j F Y') }}</div>
            <div class="day-prog-lbl">Journée <span id="rh-day-pct">0%</span></div>
            <div class="day-bar">
                <div class="day-bar-fill" id="rh-day-fill" style="width:0%"></div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════ KPI ══════════════════════ --}}
    <div class="dash-stats">

        <a href="{{ route('espace-employe.documents') }}" class="scard sc-ind">
            <div class="scard-top">
                <span class="scard-label">Documents</span>
                <div class="scard-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
            </div>
            <div class="scard-val" data-count="{{ $stats['documents'] }}">0</div>
            <span class="scard-badge">Dossier actif</span>
        </a>

        <a href="{{ route('espace-employe.conges') }}" class="scard sc-teal">
            <div class="scard-top">
                <span class="scard-label">Congés restants</span>
                <div class="scard-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16l2 2 4-4"/></svg>
                </div>
            </div>
            <div class="scard-val" data-count="{{ $stats['conges_restants'] }}">0</div>
            <span class="scard-badge">Jours disponibles</span>
        </a>

        <a href="{{ route('espace-employe.demandes') }}" class="scard sc-amber">
            <div class="scard-top">
                <span class="scard-label">Demandes</span>
                <div class="scard-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>
            <div class="scard-val" data-count="{{ $stats['demandes_en_cours'] }}">0</div>
            <span class="scard-badge">En cours</span>
        </a>

        <a href="{{ route('espace-employe.profil') }}" class="scard sc-rose">
            <div class="scard-top">
                <span class="scard-label">Ancienneté</span>
                <div class="scard-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
            </div>
            <div class="scard-val" data-count="{{ $stats['anciennete'] }}">0</div>
            <span class="scard-badge">{{ $stats['anciennete'] <= 1 ? 'An de service' : 'Ans de service' }}</span>
        </a>

    </div>

    {{-- ══════════════════════ MAIN GRID ══════════════════════ --}}
    <div class="dash-main">

        {{-- ─ Activité ─ --}}
        <div class="panel">
            <div class="panel-head">
                <span class="panel-title">
                    Activité récente
                    @if(count($activities) > 0)
                    <span class="panel-count">{{ count($activities) }}</span>
                    @endif
                </span>
                <a href="{{ route('espace-employe.documents') }}" class="panel-link">
                    Voir tout
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
            <div class="act-list">
                @forelse($activities as $activity)
                @php
                    $actUrl = match($activity['icon'] ?? 'file') {
                        'calendar' => route('espace-employe.conges'),
                        'user'     => route('espace-employe.profil'),
                        default    => route('espace-employe.documents'),
                    };
                @endphp
                <a href="{{ $actUrl }}" class="act-item">
                    <div class="act-ico act-ico-{{ $activity['icon'] ?? 'file' }}">
                        @if(($activity['icon'] ?? '') === 'calendar')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/></svg>
                        @elseif(($activity['icon'] ?? '') === 'user')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        @endif
                    </div>
                    <div class="act-body">
                        <div class="act-title">{{ $activity['title'] }}</div>
                        <div class="act-sub">
                            {{ $activity['date']->diffForHumans() }}
                            @if($activity['date']->isToday())
                                <span class="act-new">Nouveau</span>
                            @endif
                        </div>
                    </div>
                    <div class="act-date">{{ $activity['date']->format('d/m/Y') }}</div>
                </a>
                @empty
                <div class="act-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <p>Aucune activité récente</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- ─ Right column ─ --}}
        <div class="right-col">

            {{-- Profil --}}
            <div class="profile-card">
                <div class="profile-top">
                    <div class="av-ring">
                        <img
                            src="{{ $personnel && $personnel->photo
                                ? asset('storage/' . $personnel->photo)
                                : 'https://ui-avatars.com/api/?name=' . urlencode($personnel ? $personnel->nom . '+' . $personnel->prenoms : auth()->user()->name) . '&size=200&background=2535A8&color=fff&bold=true' }}"
                            alt="Avatar"
                            class="av-img"
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=200&background=2535A8&color=fff&bold=true'">
                        <span class="av-dot"></span>
                    </div>
                    <div class="profile-info">
                        <div class="profile-name">{{ $personnel ? $personnel->nom_complet : auth()->user()->name }}</div>
                        <div class="profile-post">{{ $personnel ? $personnel->poste : 'Employé' }}</div>
                        @if($personnel && $personnel->matricule)
                        <div class="profile-mat">{{ $personnel->matricule }}</div>
                        @endif
                    </div>
                </div>

                <div class="profile-rows">
                    @if($personnel && $personnel->departement)
                    <div class="prow">
                        <div class="prow-ic"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div>
                        <div class="prow-txt">
                            <div class="prow-lbl">Département</div>
                            <div class="prow-val">{{ $personnel->departement->nom }}</div>
                        </div>
                    </div>
                    @endif
                    @if($personnel && $personnel->service)
                    <div class="prow">
                        <div class="prow-ic"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                        <div class="prow-txt">
                            <div class="prow-lbl">Service</div>
                            <div class="prow-val">{{ $personnel->service->nom }}</div>
                        </div>
                    </div>
                    @endif
                    <div class="prow">
                        <div class="prow-ic"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                        <div class="prow-txt">
                            <div class="prow-lbl">Email</div>
                            <div class="prow-val">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="profile-footer">
                    <a href="{{ route('espace-employe.profil') }}" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Mon profil complet
                    </a>
                </div>
            </div>

            {{-- Actions --}}
            <div class="actions-card">
                <div class="panel-head">
                    <span class="panel-title">Actions rapides</span>
                </div>
                <div class="actions-grid">

                    <a href="{{ route('espace-employe.conges') }}" class="qa-btn qa-primary">
                        <div class="qa-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16h6"/></svg>
                        </div>
                        Demander un congé
                    </a>

                    <a href="{{ route('espace-employe.bulletins') }}" class="qa-btn">
                        <div class="qa-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        Bulletins
                    </a>

                    <a href="{{ route('espace-employe.attestations') }}" class="qa-btn">
                        <div class="qa-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M9 15l2 2 4-4"/></svg>
                        </div>
                        Attestations
                    </a>

                    <a href="{{ route('espace-employe.documents') }}" class="qa-btn">
                        <div class="qa-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        Documents
                    </a>

                    <a href="{{ route('espace-employe.demandes') }}" class="qa-btn">
                        <div class="qa-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </div>
                        Demandes
                    </a>

                    <a href="{{ route('espace-employe.profil') }}" class="qa-btn">
                        <div class="qa-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        Mon profil
                    </a>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
(function () {
    'use strict';

    /* ── Greeting ── */
    var h = new Date().getHours();
    var lbl = document.getElementById('rh-greeting');
    if (lbl) lbl.textContent = h < 12 ? 'Bonjour' : h < 18 ? 'Bon après-midi' : 'Bonsoir';

    /* ── Live clock ── */
    function pad(n) { return String(n).padStart(2, '0'); }

    function tick() {
        var d  = new Date();
        var hm = document.getElementById('rh-clock-hm');
        var ss = document.getElementById('rh-clock-ss');
        if (hm) hm.textContent = pad(d.getHours()) + ':' + pad(d.getMinutes());
        if (ss) ss.textContent = pad(d.getSeconds());
        var pct  = Math.round(((d.getHours() * 3600 + d.getMinutes() * 60 + d.getSeconds()) / 86400) * 100);
        var fill = document.getElementById('rh-day-fill');
        var plbl = document.getElementById('rh-day-pct');
        if (fill) fill.style.width = pct + '%';
        if (plbl) plbl.textContent = pct + '%';
    }
    tick();
    setInterval(tick, 1000);

    /* ── Count-up ── */
    function countUp(el) {
        var target = parseInt(el.dataset.count, 10) || 0;
        if (target === 0) { el.textContent = '0'; return; }
        var start = null;
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / 700, 1);
            var e = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(e * target);
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) { countUp(entry.target); obs.unobserve(entry.target); }
        });
    }, { threshold: .3 });

    document.querySelectorAll('[data-count]').forEach(function (el) { obs.observe(el); });

})();
</script>
@endsection
