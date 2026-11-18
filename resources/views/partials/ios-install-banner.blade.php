{{--
    Panneau d'installation iOS, ouvert à la demande depuis un bouton
    [data-ios-install-btn] ailleurs dans la page (ex. "Mon profil") —
    jamais affiché automatiquement.
--}}
<div id="iosInstallModal" class="ios-banner" aria-hidden="true">
    <div class="ios-banner-backdrop" id="iosBannerBackdrop"></div>
    <div class="ios-banner-box" role="dialog" aria-label="Installer Portail RH+ sur l'écran d'accueil">
        <button type="button" class="ios-banner-close" id="iosBannerClose" aria-label="Fermer">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 6l12 12M18 6 6 18"/></svg>
        </button>

        <div class="ios-banner-top">
            <img src="{{ asset('assets/images/pwa-64x64.png') }}" alt="" class="ios-banner-icon">
            <div>
                <p class="ios-banner-title">Installer Portail RH+</p>
                <p class="ios-banner-sub">Accès en un tap, plein écran</p>
            </div>
        </div>

        <a href="{{ route('ios.profile') }}" class="ios-banner-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15V3M7 9l5-5 5 5"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
            Installer automatiquement
        </a>
        <p class="ios-banner-hint">Réglages confirmera l'installation (profil non signé, c'est normal).</p>

        <div class="ios-banner-or"><span>ou manuellement</span></div>

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
                <span>Choisissez <strong>Sur l'écran d'accueil</strong> — recommandé pour les notifications</span>
            </li>
        </ol>
    </div>
</div>

<style>
.ios-banner {
    position: fixed; inset: 0; z-index: 999990;
    display: flex; align-items: flex-end; justify-content: center;
    padding: 0 12px calc(12px + env(safe-area-inset-bottom, 0px));
    pointer-events: none;
}
.ios-banner-backdrop {
    position: absolute; inset: 0;
    background: rgba(15, 23, 42, .4);
    opacity: 0; transition: opacity .25s ease;
}
.ios-banner-box {
    position: relative; z-index: 1;
    width: 100%; max-width: 420px;
    background: var(--surface, #fff);
    border: 1px solid var(--line-soft, #e2e8f0);
    border-radius: var(--radius-lg, 20px);
    box-shadow: 0 16px 40px rgba(15, 23, 42, .16);
    padding: 16px 18px;
    opacity: 0; transform: translateY(16px);
    transition: opacity .25s ease, transform .25s ease;
}
.ios-banner--show { pointer-events: auto; }
.ios-banner--show .ios-banner-backdrop { opacity: 1; }
.ios-banner--show .ios-banner-box { opacity: 1; transform: translateY(0); }

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

.ios-banner-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 12px; border-radius: var(--radius, 14px);
    background: var(--brand, #2563eb); color: #fff;
    font-family: var(--font, 'DM Sans', sans-serif); font-size: .875rem; font-weight: 700;
    text-decoration: none; -webkit-tap-highlight-color: transparent;
}
.ios-banner-btn svg { width: 17px; height: 17px; }
.ios-banner-btn:active { background: var(--brand-dk, #1d4ed8); }

.ios-banner-hint {
    font-family: var(--font, 'DM Sans', sans-serif); font-size: .75rem; color: var(--muted, #64748b);
    text-align: center; margin: 8px 0 0;
}

.ios-banner-or {
    display: flex; align-items: center; gap: 10px; margin: 14px 0 12px;
    font-family: var(--font, 'DM Sans', sans-serif); font-size: .75rem; color: var(--faint, #94a3b8);
}
.ios-banner-or::before, .ios-banner-or::after { content: ''; flex: 1; height: 1px; background: var(--line-soft, #e2e8f0); }

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
    .ios-banner-backdrop, .ios-banner-box { transition: none; }
}
</style>

<script>
(function () {
    var el = document.getElementById('iosInstallModal');
    if (!el) return;

    var isEligible = false;
    try {
        // Déjà dans l'app installée (standalone) ou dans l'app Capacitor : rien à proposer.
        var isCapacitor = !!(window.Capacitor && window.Capacitor.isNativePlatform && window.Capacitor.isNativePlatform());
        var isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;

        // iPhone/iPad sous Safari uniquement — Chrome/Firefox iOS n'offrent pas la
        // même installation, et Android a déjà sa propre installation native.
        var ua = window.navigator.userAgent || '';
        var isIOS = /iPad|iPhone|iPod/.test(ua) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
        var isSafari = /^((?!chrome|android|crios|fxios|edgios).)*safari/i.test(ua);

        isEligible = !isCapacitor && !isStandalone && isIOS && isSafari;
    } catch (e) {}

    var triggers = document.querySelectorAll('[data-ios-install-btn]');

    if (!isEligible) {
        el.remove();
        triggers.forEach(function (btn) { btn.remove(); });
        return;
    }

    function open() { el.classList.add('ios-banner--show'); }
    function close() { el.classList.remove('ios-banner--show'); }

    triggers.forEach(function (btn) {
        btn.hidden = false;
        btn.addEventListener('click', open);
    });

    document.getElementById('iosBannerClose').addEventListener('click', close);
    document.getElementById('iosBannerBackdrop').addEventListener('click', close);
})();
</script>
