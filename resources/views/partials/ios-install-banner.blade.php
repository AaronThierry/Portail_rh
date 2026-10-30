<div id="iosInstallBanner" class="ios-banner" aria-hidden="true">
    <div class="ios-banner-box" role="dialog" aria-label="Installer Portail RH+ sur l'écran d'accueil">
        <button type="button" class="ios-banner-close" id="iosBannerClose" aria-label="Fermer">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 6l12 12M18 6 6 18"/></svg>
        </button>

        <div class="ios-banner-top">
            <img src="{{ asset('assets/images/pwa-64x64.png') }}" alt="" class="ios-banner-icon">
            <div>
                <p class="ios-banner-title">Installer Portail RH+</p>
                <p class="ios-banner-sub">Accès en un tap, plein écran, notifications</p>
            </div>
        </div>

        <ol class="ios-banner-steps">
            <li>
                <span class="ios-banner-step-ico">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 16V4M7 9l5-5 5 5"/><path d="M5 13v6a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6"/></svg>
                </span>
                <span>Appuyez sur <strong>Partager</strong> dans la barre de Safari</span>
            </li>
            <li>
                <span class="ios-banner-step-ico">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="4"/><path d="M12 8v8M8 12h8"/></svg>
                </span>
                <span>Choisissez <strong>Sur l'écran d'accueil</strong></span>
            </li>
        </ol>
    </div>
</div>

<style>
.ios-banner {
    position: fixed; left: 0; right: 0; bottom: 0; z-index: 999990;
    display: flex; justify-content: center;
    padding: 0 12px calc(12px + env(safe-area-inset-bottom, 0px));
    pointer-events: none;
    opacity: 0; transform: translateY(16px);
    transition: opacity .3s ease, transform .3s ease;
}
.ios-banner--show { opacity: 1; transform: translateY(0); pointer-events: auto; }

.ios-banner-box {
    position: relative;
    width: 100%; max-width: 420px;
    background: var(--surface, #fff);
    border: 1px solid var(--line-soft, #e2e8f0);
    border-radius: var(--radius-lg, 20px);
    box-shadow: 0 16px 40px rgba(15, 23, 42, .16);
    padding: 16px 18px;
}

.ios-banner-close {
    position: absolute; top: 10px; right: 10px;
    width: 30px; height: 30px; border-radius: 999px; border: 0;
    background: var(--subtle, #f1f5f9); color: var(--muted, #64748b);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; -webkit-tap-highlight-color: transparent;
}
.ios-banner-close svg { width: 16px; height: 16px; }

.ios-banner-top { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; padding-right: 24px; }
.ios-banner-icon { width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0; box-shadow: 0 2px 8px rgba(15, 23, 42, .12); }
.ios-banner-title { font-family: var(--display, 'Syne', sans-serif); font-weight: 800; font-size: .9375rem; color: var(--ink, #0f172a); margin: 0; }
.ios-banner-sub { font-family: var(--font, 'DM Sans', sans-serif); font-size: .8125rem; color: var(--muted, #64748b); margin: 2px 0 0; }

.ios-banner-steps { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 10px; }
.ios-banner-steps li {
    display: flex; align-items: center; gap: 10px;
    font-family: var(--font, 'DM Sans', sans-serif); font-size: .8125rem; color: var(--ink, #0f172a);
}
.ios-banner-steps strong { font-weight: 700; }
.ios-banner-step-ico {
    width: 30px; height: 30px; border-radius: 10px; flex-shrink: 0;
    background: var(--brand-bg, #eff6ff); color: var(--brand, #2563eb);
    display: flex; align-items: center; justify-content: center;
}
.ios-banner-step-ico svg { width: 16px; height: 16px; }

@media (prefers-reduced-motion: reduce) {
    .ios-banner { transition: none; }
}
</style>

<script>
(function () {
    var el = document.getElementById('iosInstallBanner');
    if (!el) return;

    var DISMISS_KEY = 'rhios_banner_dismissed_at';
    var COOLDOWN_MS = 14 * 24 * 60 * 60 * 1000; // 14 jours avant de reproposer

    try {
        // Déjà dans l'app installée (standalone) ou dans l'app Capacitor : rien à proposer.
        var isCapacitor = !!(window.Capacitor && window.Capacitor.isNativePlatform && window.Capacitor.isNativePlatform());
        var isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
        if (isCapacitor || isStandalone) { el.remove(); return; }

        // iPhone/iPad sous Safari uniquement — Chrome/Firefox iOS n'offrent pas la
        // même installation, et Android a déjà sa propre bannière native.
        var ua = window.navigator.userAgent || '';
        var isIOS = /iPad|iPhone|iPod/.test(ua) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
        var isSafari = /^((?!chrome|android|crios|fxios|edgios).)*safari/i.test(ua);
        if (!isIOS || !isSafari) { el.remove(); return; }

        var dismissedAt = parseInt(localStorage.getItem(DISMISS_KEY) || '0', 10);
        if (dismissedAt > 0 && (Date.now() - dismissedAt) < COOLDOWN_MS) { el.remove(); return; }
    } catch (e) {
        el.remove();
        return;
    }

    function dismiss() {
        try { localStorage.setItem(DISMISS_KEY, String(Date.now())); } catch (e) {}
        el.classList.remove('ios-banner--show');
        setTimeout(function () { el.remove(); }, 320);
    }

    document.getElementById('iosBannerClose').addEventListener('click', dismiss);

    setTimeout(function () { el.classList.add('ios-banner--show'); }, 1200);
})();
</script>
