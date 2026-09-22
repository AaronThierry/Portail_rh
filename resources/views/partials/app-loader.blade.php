<div id="appLoader" class="app-loader" aria-hidden="true">

    <!-- Ouverture cinématique : un rideau de couleur se scinde sur le sigle -->
    <div class="al-curtain al-curtain-l"></div>
    <div class="al-curtain al-curtain-r"></div>
    <div class="al-flare"></div>
    <div class="al-hero">
        <span class="al-hero-word">RH+</span>
        <span class="al-hero-shine"></span>
    </div>

    <!-- Deux formes qui convergent vers le badge — écho abstrait aux deux figures du logo -->
    <span class="al-accent al-accent-l"></span>
    <span class="al-accent al-accent-r"></span>

    <!-- Fond révélé une fois le rideau ouvert -->
    <div class="app-loader-orbs">
        <span class="app-loader-orb app-loader-orb-a"></span>
        <span class="app-loader-orb app-loader-orb-b"></span>
        <span class="app-loader-orb app-loader-orb-c"></span>
    </div>

    <!-- État stabilisé : indicateur discret le temps que la page finisse de charger -->
    <div class="app-loader-inner">
        <div class="app-loader-badge">
            <span class="app-loader-glass"></span>
            <span class="app-loader-ring-track"></span>
            <span class="app-loader-ring app-loader-ring-outer"></span>
            <span class="app-loader-ring app-loader-ring-inner"></span>
            <img src="{{ asset('assets/images/logo.png') }}" alt="" class="app-loader-logo">
        </div>
        <div class="app-loader-word">Portail <span>RH+</span></div>
        <div class="app-loader-sub">
            <span>Chargement de votre espace</span>
            <span class="app-loader-dots"><i></i><i></i><i></i></span>
        </div>
    </div>
</div>

<style>
.app-loader {
    position: fixed; inset: 0; z-index: 999999;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #F8FAFC 0%, #EFF6FF 50%, #F8FAFC 100%);
    overflow: hidden;
    transition: opacity .42s ease, transform .42s ease;
}
.app-loader--hide { opacity: 0; transform: scale(1.03); pointer-events: none; }

.app-loader::after {
    content: '';
    position: absolute; inset: 0; z-index: 2; pointer-events: none;
    opacity: .035; mix-blend-mode: overlay;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
}

/* ══ Rideau — le moment de marque ══ */
.al-curtain {
    position: absolute; inset: 0; z-index: 5;
    background: linear-gradient(160deg, #1D4ED8 0%, #1E3A8A 100%);
    animation-duration: .8s; animation-delay: 1.55s; animation-fill-mode: both;
    animation-timing-function: cubic-bezier(.65,0,.35,1);
}
/* Arête diagonale plutôt qu'une coupe franche — les deux moitiés restent jointives */
.al-curtain-l { clip-path: polygon(0 0, 52% 0, 48% 100%, 0 100%);   animation-name: al-curtain-open-l; }
.al-curtain-r { clip-path: polygon(52% 0, 100% 0, 100% 100%, 48% 100%); animation-name: al-curtain-open-r; }

/* Éclat au moment où le rideau se scinde */
.al-flare {
    position: absolute; top: 50%; left: 50%; z-index: 6;
    width: 4px; height: 4px; border-radius: 50%;
    background: radial-gradient(circle, #fff 0%, rgba(255,255,255,.6) 35%, transparent 70%);
    transform: translate(-50%, -50%) scale(1);
    opacity: 0;
    animation: al-flare-burst .65s ease-out 1.55s both;
    pointer-events: none;
}

.al-hero {
    position: absolute; inset: 0; z-index: 7;
    display: flex; align-items: center; justify-content: center;
    pointer-events: none; overflow: hidden;
}
.al-hero-word {
    position: relative;
    font-family: 'Syne', sans-serif; font-weight: 800;
    font-size: clamp(3rem, 20vw, 5.5rem); letter-spacing: -2px; color: #fff;
    clip-path: inset(0 100% 0 0);
    animation:
        al-hero-reveal .75s cubic-bezier(.65,0,.35,1) .4s both,
        al-hero-fade .55s ease-in 1.55s both;
}
.al-hero-shine {
    position: absolute; top: -20%; left: -60%; width: 40%; height: 140%;
    background: linear-gradient(100deg, transparent 0%, rgba(255,255,255,.85) 50%, transparent 100%);
    transform: skewX(-20deg);
    mix-blend-mode: overlay;
    animation: al-shine-sweep .65s ease-in 1s both;
}

/* ══ Deux formes qui convergent vers le badge ══ */
.al-accent {
    position: absolute; top: 50%; z-index: 3;
    width: 46px; height: 92px; margin-top: -46px;
    border-radius: 999px; filter: blur(1px);
    opacity: 0;
}
.al-accent-l {
    left: 50%; background: linear-gradient(160deg, #2563EB, #1D4ED8);
    animation: al-accent-in-l 1.4s cubic-bezier(.65,0,.35,1) 1.6s both;
}
.al-accent-r {
    left: 50%; background: linear-gradient(160deg, #14B8A6, #0D9488);
    animation: al-accent-in-r 1.4s cubic-bezier(.65,0,.35,1) 1.6s both;
}

/* ══ Fond ambiant, révélé derrière le rideau ══ */
.app-loader-orbs { position: absolute; inset: 0; pointer-events: none; }
.app-loader-orb { position: absolute; border-radius: 50%; filter: blur(70px); }
.app-loader-orb-a {
    width: 300px; height: 300px; top: -100px; right: -70px;
    background: #2563EB; opacity: .16;
    animation: al-drift-a 9s ease-in-out infinite;
}
.app-loader-orb-b {
    width: 260px; height: 260px; bottom: -80px; left: -60px;
    background: #14B8A6; opacity: .14;
    animation: al-drift-b 11s ease-in-out infinite;
}
.app-loader-orb-c {
    width: 220px; height: 220px; top: 55%; left: 60%;
    background: #60A5FA; opacity: .12;
    animation: al-drift-c 13s ease-in-out infinite;
}

/* ══ État stabilisé ══ */
.app-loader-inner {
    position: relative; z-index: 1;
    display: flex; flex-direction: column; align-items: center; gap: 1.125rem;
    padding: 0 2rem; text-align: center;
    opacity: 0;
    animation: al-word-in .7s ease-out 2.35s both;
}

.app-loader-badge {
    position: relative; width: 120px; height: 120px;
    display: flex; align-items: center; justify-content: center;
}
.app-loader-glass {
    position: absolute; inset: 0; border-radius: 32px;
    background: rgba(255,255,255,.55);
    backdrop-filter: blur(18px) saturate(160%);
    -webkit-backdrop-filter: blur(18px) saturate(160%);
    border: 1px solid rgba(255,255,255,.7);
    box-shadow: 0 20px 44px rgba(37,99,235,.18), inset 0 1px 0 rgba(255,255,255,.9);
}
.app-loader-ring-track {
    position: absolute; inset: 14px; border-radius: 50%;
    border: 3px solid #e2e8f0; opacity: .4;
}
.app-loader-ring {
    position: absolute; border-radius: 50%;
    opacity: 0;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    animation-fill-mode: both;
}
/* Anneau extérieur : dégradé conique à traîne, comme une comète en orbite */
.app-loader-ring-outer {
    inset: 14px;
    background: conic-gradient(from 0deg, transparent 0deg, transparent 235deg, #2563EB 300deg, #14B8A6 360deg);
    -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 4px), #000 calc(100% - 4px));
            mask: radial-gradient(farthest-side, transparent calc(100% - 4px), #000 calc(100% - 4px));
    filter: drop-shadow(0 0 7px rgba(37,99,235,.5));
    animation-name: al-ring-fade-in, al-ring-spin;
    animation-duration: .7s, 1.9s;
    animation-delay: 2.35s, 2.35s;
}
/* Anneau intérieur : plus petit, tourne en sens inverse, un ton plus doux — donne la profondeur */
.app-loader-ring-inner {
    inset: 32px;
    background: conic-gradient(from 180deg, transparent 0deg, transparent 250deg, #14B8A6 315deg, #2563EB 360deg);
    -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 3px), #000 calc(100% - 3px));
            mask: radial-gradient(farthest-side, transparent calc(100% - 3px), #000 calc(100% - 3px));
    animation-name: al-ring-fade-in-soft, al-ring-spin-rev;
    animation-duration: .7s, 2.6s;
    animation-delay: 2.5s, 2.5s;
}
.app-loader-logo {
    position: relative; z-index: 1;
    width: 58px; height: 58px; object-fit: contain;
    filter: drop-shadow(0 4px 14px rgba(37,99,235,.22));
    animation: al-logo-pulse 2.8s ease-in-out 3.05s infinite;
}

.app-loader-word {
    font-family: 'Syne', sans-serif; font-weight: 800;
    font-size: 1.1875rem; letter-spacing: -.3px; color: #0f172a;
}
.app-loader-word span {
    background: linear-gradient(110deg, #2563EB 20%, #14B8A6 50%, #2563EB 80%);
    background-size: 200% 100%;
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    animation: al-shimmer 3s ease-in-out infinite;
}

.app-loader-sub {
    display: flex; align-items: center; gap: .375rem;
    font-family: 'DM Sans', sans-serif; font-size: .875rem; color: #64748b;
}
.app-loader-dots { display: inline-flex; gap: .2rem; }
.app-loader-dots i {
    width: 4px; height: 4px; border-radius: 50%; background: #2563EB;
    display: block; opacity: .3;
    animation: al-dot-pulse 1.2s ease-in-out infinite;
}
.app-loader-dots i:nth-child(2) { animation-delay: .15s; }
.app-loader-dots i:nth-child(3) { animation-delay: .3s; }

@keyframes al-curtain-open-l { to { transform: translateX(-100%); } }
@keyframes al-curtain-open-r { to { transform: translateX(100%); } }
@keyframes al-hero-reveal { to { clip-path: inset(0 0% 0 0); } }
@keyframes al-hero-fade   { to { opacity: 0; transform: scale(1.15); } }
@keyframes al-shine-sweep { from { transform: translateX(0) skewX(-20deg); } to { transform: translateX(220%) skewX(-20deg); } }
@keyframes al-flare-burst {
    0%   { opacity: 0; transform: translate(-50%,-50%) scale(1); }
    22%  { opacity: 1; }
    100% { opacity: 0; transform: translate(-50%,-50%) scale(90); }
}
@keyframes al-accent-in-l {
    0%   { opacity: 0; transform: translateX(-260px) scale(.6) rotate(-8deg); }
    40%  { opacity: .55; }
    75%  { opacity: .5;  transform: translateX(-18px) scale(1) rotate(-2deg); }
    100% { opacity: 0;   transform: translateX(0) scale(.4) rotate(0deg); }
}
@keyframes al-accent-in-r {
    0%   { opacity: 0; transform: translateX(260px) scale(.6) rotate(8deg); }
    40%  { opacity: .55; }
    75%  { opacity: .5;  transform: translateX(18px) scale(1) rotate(2deg); }
    100% { opacity: 0;   transform: translateX(0) scale(.4) rotate(0deg); }
}

@keyframes al-drift-a {
    0%, 100% { transform: translate(0,0) scale(1); }
    50%      { transform: translate(-24px, 22px) scale(1.06); }
}
@keyframes al-drift-b {
    0%, 100% { transform: translate(0,0) scale(1); }
    50%      { transform: translate(22px, -18px) scale(1.05); }
}
@keyframes al-drift-c {
    0%, 100% { transform: translate(0,0) scale(1); }
    50%      { transform: translate(-18px, -26px) scale(1.08); }
}
@keyframes al-ring-fade-in      { from { opacity: 0; } to { opacity: 1; } }
@keyframes al-ring-fade-in-soft { from { opacity: 0; } to { opacity: .65; } }
@keyframes al-ring-spin     { to { transform: rotate(360deg); } }
@keyframes al-ring-spin-rev { to { transform: rotate(-360deg); } }
@keyframes al-logo-pulse {
    0%, 100% { transform: scale(1); }
    50%      { transform: scale(1.05); }
}
@keyframes al-word-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
@keyframes al-shimmer { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
@keyframes al-dot-pulse {
    0%, 100% { opacity: .3; transform: scale(1); }
    50%      { opacity: 1;  transform: scale(1.3); }
}

@media (prefers-reduced-motion: reduce) {
    .al-curtain, .al-hero-word, .al-hero-shine, .al-flare, .al-accent { animation: none !important; }
    .al-curtain, .al-hero, .al-flare, .al-accent { display: none !important; }
    .app-loader-orb,
    .app-loader-ring, .app-loader-logo,
    .app-loader-word span, .app-loader-dots i {
        animation: none !important; background-position: 0% 50% !important;
    }
    .app-loader-ring { opacity: 1 !important; }
    .app-loader-inner { opacity: 1 !important; animation: none !important; transform: none !important; }
}
</style>

<script>
(function () {
    var el = document.getElementById('appLoader');
    if (!el) return;

    var isApp = false;
    try {
        var isCapacitor = !!(window.Capacitor && window.Capacitor.isNativePlatform && window.Capacitor.isNativePlatform());
        // "Ajouter à l'écran d'accueil" (iOS Safari / Android Chrome) : l'app s'ouvre
        // sans barre de navigateur, exactement comme une app installée.
        var isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
        isApp = isCapacitor || isStandalone;
    } catch (e) {}

    // Navigation classique dans le navigateur : pas d'écran de chargement.
    if (!isApp) {
        el.remove();
        return;
    }

    // Déjà joué récemment (navigation interne, ex. la navbar du bas) : on ne rejoue
    // pas la chorégraphie à chaque page, seulement si l'app a été quittée un moment.
    // localStorage (pas sessionStorage — peu fiable d'une navigation à l'autre dans
    // certaines WebView Android) + fenêtre de temps glissante.
    var ACTIVITY_KEY = 'rhloader_last_active';
    var SESSION_GAP_MS = 20 * 60 * 1000; // 20 min d'inactivité = nouvelle "ouverture"
    var recentlyActive = false;
    try {
        var last = parseInt(localStorage.getItem(ACTIVITY_KEY) || '0', 10);
        recentlyActive = last > 0 && (Date.now() - last) < SESSION_GAP_MS;
        localStorage.setItem(ACTIVITY_KEY, String(Date.now()));
    } catch (e) {}

    if (recentlyActive) {
        el.remove();
        return;
    }

    var shownAt = Date.now();
    var MIN_VISIBLE_MS = 3400; // laisse l'ouverture cinématique se jouer jusqu'au bout
    var MAX_VISIBLE_MS = 7500;
    var hidden = false;

    function hide() {
        if (hidden) return;
        hidden = true;
        el.classList.add('app-loader--hide');
        setTimeout(function () { el.remove(); }, 420);
    }

    function onReady() {
        var elapsed = Date.now() - shownAt;
        setTimeout(hide, Math.max(0, MIN_VISIBLE_MS - elapsed));
    }

    if (document.readyState === 'complete') {
        onReady();
    } else {
        window.addEventListener('load', onReady);
    }

    // Filet de sécurité si l'événement "load" tarde anormalement.
    setTimeout(hide, MAX_VISIBLE_MS);
})();
</script>
