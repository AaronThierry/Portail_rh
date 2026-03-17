{{-- ══════════════════════════════════════════════════════════
     Footer — Indigo × Teal Charter
     Touche unique : scanning beam animé sur la bordure top
     ══════════════════════════════════════════════════════════ --}}

<footer class="ft-root" id="appFooter">

    {{-- Bordure top dégradée + scanning beam --}}
    <div class="ft-topbar">
        <div class="ft-beam"></div>
    </div>

    <div class="ft-inner">

        {{-- ── Gauche : branding ─────────────────────────── --}}
        <div class="ft-brand">
            <div class="ft-logo" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
            <div class="ft-brand-text">
                <span class="ft-name">Portail RH+</span>
                <span class="ft-copy">&copy; {{ date('Y') }} — Tous droits réservés</span>
            </div>
        </div>

        {{-- ── Centre : navigation ───────────────────────── --}}
        <nav class="ft-nav" aria-label="Liens du pied de page">
            <a href="/mentions-legales" class="ft-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                <span>Mentions légales</span>
            </a>

            <span class="ft-sep" aria-hidden="true"></span>

            <a href="/confidentialite" class="ft-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <span>Confidentialité</span>
            </a>

            <span class="ft-sep" aria-hidden="true"></span>

            <a href="/support" class="ft-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                <span>Support</span>
            </a>
        </nav>

        {{-- ── Droite : status + version ─────────────────── --}}
        <div class="ft-meta">

            {{-- Statut système --}}
            <div class="ft-status" title="Statut du système">
                <span class="ft-dot"></span>
                <svg class="ft-pulse-icon" viewBox="0 0 36 10" fill="none"
                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="0,5 6,5 9,1 12,9 15,2 18,8 21,5 36,5"/>
                </svg>
                <span class="ft-status-txt">Opérationnel</span>
            </div>

            {{-- Version badge --}}
            <div class="ft-version">
                <span class="ft-ver-lbl">v</span>
                <span class="ft-ver-num">1.0.0</span>
            </div>

        </div>
    </div>
</footer>

<style>
/* ════════════════════════════════════════════════════════════
   FOOTER — Indigo × Teal Charter
   Fonts : Syne (brand) · DM Sans (body) · DM Mono (data)
   ════════════════════════════════════════════════════════════ */

:root {
    --ft-ind:    #6366f1;
    --ft-ind-dk: #4338ca;
    --ft-teal:   #14b8a6;
    --ft-teal-dk:#0d9488;
    --ft-bg:     rgba(255,255,255,0.93);
    --ft-border: rgba(99,102,241,.12);
    --ft-muted:  #94a3b8;
    --ft-text:   #64748b;
    --ft-green:  #10b981;
    --ft-h:      56px;
}

/* ── Shell ─────────────────────────────────────────────── */
.ft-root {
    height: var(--ft-h);
    background: var(--ft-bg);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    flex-shrink: 0;
    position: relative;
    z-index: 10;
}

/* ── Bordure top : dégradé indigo → teal ───────────────── */
.ft-topbar {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg,
        transparent 0%,
        var(--ft-ind) 20%,
        var(--ft-teal) 50%,
        var(--ft-ind) 80%,
        transparent 100%);
    overflow: hidden;
}

/* ── Scanning beam (touche unique) ─────────────────────── */
.ft-beam {
    position: absolute;
    top: 0; left: -30%;
    width: 30%;
    height: 100%;
    background: linear-gradient(90deg,
        transparent 0%,
        rgba(255,255,255,.9) 50%,
        transparent 100%);
    animation: ft-scan 3.6s cubic-bezier(.4,0,.6,1) infinite;
}

@keyframes ft-scan {
    0%   { left: -30%; opacity: 0; }
    10%  { opacity: 1; }
    90%  { opacity: 1; }
    100% { left: 130%; opacity: 0; }
}

/* ── Conteneur flex ────────────────────────────────────── */
.ft-inner {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 1.75rem;
    gap: 1.5rem;
    max-width: 1920px;
    margin: 0 auto;
}

/* ═══════════════════════════════
   GAUCHE — Branding
   ═══════════════════════════════ */
.ft-brand {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-shrink: 0;
}

.ft-logo {
    width: 30px; height: 30px;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, var(--ft-ind) 0%, var(--ft-ind-dk) 100%);
    border-radius: 8px;
    color: #fff;
    transition: transform .35s cubic-bezier(.34,1.56,.64,1),
                box-shadow .35s ease;
    cursor: default;
}
.ft-logo svg { width: 15px; height: 15px; }
.ft-logo:hover {
    transform: scale(1.12) rotate(6deg);
    box-shadow: 0 4px 16px rgba(99,102,241,.4);
}

.ft-brand-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}

.ft-name {
    font-family: 'Syne', sans-serif;
    font-size: .8125rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--ft-ind) 0%, var(--ft-teal) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -.01em;
}

.ft-copy {
    font-family: 'DM Sans', sans-serif;
    font-size: .6875rem;
    color: var(--ft-muted);
    letter-spacing: .01em;
}

/* ═══════════════════════════════
   CENTRE — Navigation
   ═══════════════════════════════ */
.ft-nav {
    display: flex;
    align-items: center;
    gap: .25rem;
}

.ft-link {
    display: flex;
    align-items: center;
    gap: .4375rem;
    padding: .375rem .75rem;
    font-family: 'DM Sans', sans-serif;
    font-size: .8rem;
    font-weight: 500;
    color: var(--ft-text);
    text-decoration: none;
    border-radius: 7px;
    position: relative;
    transition: color .22s ease, background .22s ease;
    overflow: hidden;
}

/* Sweep lumineux */
.ft-link::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg,
        transparent 0%,
        rgba(99,102,241,.06) 50%,
        transparent 100%);
    transform: translateX(-100%);
    transition: transform .4s ease;
    border-radius: inherit;
}
.ft-link:hover::before { transform: translateX(100%); }

.ft-link:hover {
    color: var(--ft-ind);
    background: rgba(99,102,241,.06);
}

.ft-link svg {
    width: 13px; height: 13px;
    flex-shrink: 0;
    opacity: .65;
    transition: opacity .2s, transform .25s cubic-bezier(.34,1.56,.64,1);
}
.ft-link:hover svg {
    opacity: 1;
    transform: scale(1.2);
    stroke: var(--ft-ind);
}

/* Underline teal au hover */
.ft-link::after {
    content: '';
    position: absolute;
    bottom: 3px; left: 50%;
    width: 0; height: 1.5px;
    background: linear-gradient(90deg, var(--ft-ind), var(--ft-teal));
    border-radius: 1px;
    transform: translateX(-50%);
    transition: width .28s cubic-bezier(.25,1,.5,1);
}
.ft-link:hover::after { width: calc(100% - 1.25rem); }

.ft-sep {
    width: 1px; height: 14px;
    background: var(--ft-border);
    margin: 0 .125rem;
    flex-shrink: 0;
}

/* ═══════════════════════════════
   DROITE — Status + Version
   ═══════════════════════════════ */
.ft-meta {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-shrink: 0;
}

/* ── Status pill ──────────────────────────────────────── */
.ft-status {
    display: flex;
    align-items: center;
    gap: .5rem;
    padding: .3125rem .6875rem;
    background: rgba(16,185,129,.07);
    border: 1px solid rgba(16,185,129,.18);
    border-radius: 20px;
    cursor: default;
    transition: background .25s, border-color .25s;
}
.ft-status:hover {
    background: rgba(16,185,129,.12);
    border-color: rgba(16,185,129,.3);
}

/* Dot pulsant */
.ft-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--ft-green);
    box-shadow: 0 0 0 0 rgba(16,185,129,.5);
    animation: ft-dot-pulse 2.2s ease-in-out infinite;
    flex-shrink: 0;
}
@keyframes ft-dot-pulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,.5); }
    50%      { box-shadow: 0 0 0 5px rgba(16,185,129,0); }
}

/* Mini ECG polyline */
.ft-pulse-icon {
    width: 28px; height: 9px;
    color: var(--ft-green);
    opacity: .7;
    stroke-dasharray: 80;
    stroke-dashoffset: 80;
    animation: ft-ecg 2.2s ease-in-out infinite;
}
@keyframes ft-ecg {
    0%    { stroke-dashoffset: 80; opacity: 0; }
    15%   { opacity: .7; }
    60%   { stroke-dashoffset: 0;  opacity: .7; }
    90%,100% { stroke-dashoffset: 0; opacity: 0; }
}

.ft-status-txt {
    font-family: 'DM Mono', monospace;
    font-size: .6875rem;
    font-weight: 500;
    color: var(--ft-green);
    letter-spacing: .02em;
}

/* ── Version badge ────────────────────────────────────── */
.ft-version {
    display: flex;
    align-items: baseline;
    gap: .125rem;
    padding: .3125rem .6875rem;
    background: rgba(99,102,241,.06);
    border: 1px solid rgba(99,102,241,.15);
    border-radius: 7px;
    cursor: default;
    transition: all .3s cubic-bezier(.25,1,.5,1);
}
.ft-version:hover {
    background: linear-gradient(135deg, var(--ft-ind) 0%, var(--ft-ind-dk) 100%);
    border-color: var(--ft-ind);
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(99,102,241,.28);
}
.ft-version:hover .ft-ver-lbl,
.ft-version:hover .ft-ver-num { color: #fff; }

.ft-ver-lbl {
    font-family: 'DM Mono', monospace;
    font-size: .625rem;
    font-weight: 400;
    color: var(--ft-muted);
    transition: color .3s;
}
.ft-ver-num {
    font-family: 'DM Mono', monospace;
    font-size: .75rem;
    font-weight: 600;
    color: var(--ft-ind);
    transition: color .3s;
}

/* ═══════════════════════════════
   RESPONSIVE
   ═══════════════════════════════ */
@media (max-width: 1024px) {
    .ft-root { height: auto; }
    .ft-inner {
        flex-direction: column;
        padding: .875rem 1.25rem;
        gap: .625rem;
    }
    .ft-brand, .ft-nav, .ft-meta { width: 100%; justify-content: center; }
    .ft-nav { flex-wrap: wrap; }
    .ft-sep { display: none; }
    .ft-status { display: none; }
}

@media (max-width: 480px) {
    .ft-link span { display: none; }
    .ft-link { padding: .5rem .625rem; }
    .ft-link svg { width: 16px; height: 16px; opacity: 1; }
    .ft-link::after { display: none; }
    .ft-copy { display: none; }
}
</style>
