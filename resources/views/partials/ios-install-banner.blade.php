{{--
    Installation de l'app, déclenchée à la demande depuis un bouton
    [data-ios-install-btn] ailleurs dans la page (ex. "Mon profil") —
    jamais affiché automatiquement.

    - Android/Chrome : installation native en un tap (API beforeinstallprompt),
      ce panneau ne s'affiche pas, le bouton appelle directement prompt().
    - iOS/Safari : aucune API ne peut ouvrir "Partager" à la place de
      l'utilisateur, donc ce panneau affiche le mini-guide 2 étapes.
--}}
<div id="rhInstallNudge" class="rh-install-nudge" aria-hidden="true">
    <span class="rh-install-nudge-ico">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
    </span>
    <span class="rh-install-nudge-text">Recevez vos fiches de paie et alertes instantanément : ajoutez Portail RH+ à l'écran d'accueil.</span>
    <button type="button" class="rh-install-nudge-cta" id="rhInstallNudgeCta">Installer</button>
    <button type="button" class="rh-install-nudge-close" id="rhInstallNudgeClose" aria-label="Plus tard">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 6l12 12M18 6 6 18"/></svg>
    </button>
</div>

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

        <ol class="ios-banner-steps">
            <li>
                <span class="ios-banner-step-ico ios-banner-step-ico--pulse">
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

<div id="installToast" class="install-toast" role="status" aria-live="polite">
    <span class="install-toast-ico">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
    </span>
    <span>Portail RH+ est installé sur votre écran d'accueil</span>
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
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: var(--radius-lg, 20px);
    box-shadow: 0 16px 40px rgba(15, 23, 42, .16);
    padding: 16px 18px;
    opacity: 0; transform: translateY(16px);
    transition: opacity .25s ease, transform .25s ease;
}
.dark .ios-banner-box { background: #202d47; border-color: #2f3e5c; }
.ios-banner--show { pointer-events: auto; }
.ios-banner--show .ios-banner-backdrop { opacity: 1; }
.ios-banner--show .ios-banner-box { opacity: 1; transform: translateY(0); }

.ios-banner-close {
    position: absolute; top: 10px; right: 10px;
    width: 30px; height: 30px; border-radius: 999px; border: 0;
    background: #f1f5f9; color: #64748b;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; -webkit-tap-highlight-color: transparent;
}
.ios-banner-close svg { width: 16px; height: 16px; }
.dark .ios-banner-close { background: #141f33; color: #a8b6ca; }

.ios-banner-top { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; padding-right: 24px; }
.ios-banner-icon { width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0; box-shadow: 0 2px 8px rgba(15, 23, 42, .12); }
.ios-banner-title { font-family: var(--display, 'Syne', sans-serif); font-weight: 800; font-size: .9375rem; color: #0f172a; margin: 0; }
.ios-banner-sub { font-family: var(--font, 'DM Sans', sans-serif); font-size: .8125rem; color: #64748b; margin: 2px 0 0; }
.dark .ios-banner-title { color: #f8fafc; }
.dark .ios-banner-sub { color: #a8b6ca; }

.ios-banner-steps { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 10px; }
.ios-banner-steps li {
    display: flex; align-items: center; gap: 10px;
    font-family: var(--font, 'DM Sans', sans-serif); font-size: .8125rem; color: #0f172a;
}
.dark .ios-banner-steps li { color: #f8fafc; }
.ios-banner-steps strong { font-weight: 700; }
.ios-banner-step-ico {
    width: 30px; height: 30px; border-radius: 10px; flex-shrink: 0;
    background: #eff6ff; color: #2563eb;
    display: flex; align-items: center; justify-content: center;
}
.ios-banner-step-ico svg { width: 16px; height: 16px; }
.dark .ios-banner-step-ico { background: rgba(59, 130, 246, .16); color: #60a5fa; }

@media (prefers-reduced-motion: reduce) {
    .ios-banner-backdrop, .ios-banner-box { transition: none; }
}

.ios-banner-step-ico--pulse { position: relative; }
.ios-banner-step-ico--pulse::after {
    content: ''; position: absolute; inset: -4px; border-radius: 12px;
    border: 2px solid #2563eb;
    animation: iosStepPulse 1.6s ease-out infinite;
}
.dark .ios-banner-step-ico--pulse::after { border-color: #60a5fa; }
@keyframes iosStepPulse {
    0% { transform: scale(.9); opacity: .9; }
    70% { transform: scale(1.35); opacity: 0; }
    100% { opacity: 0; }
}

.install-toast {
    position: fixed; left: 50%; bottom: calc(18px + env(safe-area-inset-bottom, 0px));
    transform: translate(-50%, 16px);
    display: flex; align-items: center; gap: 10px;
    background: #16a34a; color: #fff;
    font-family: var(--font, 'DM Sans', sans-serif); font-size: .875rem; font-weight: 600;
    padding: 12px 18px; border-radius: 999px;
    box-shadow: 0 12px 28px rgba(15, 23, 42, .22);
    z-index: 999999; max-width: calc(100vw - 32px);
    opacity: 0; pointer-events: none;
    transition: opacity .3s ease, transform .3s ease;
}
.install-toast--show { opacity: 1; transform: translate(-50%, 0); }
.install-toast-ico {
    width: 22px; height: 22px; border-radius: 999px; flex-shrink: 0;
    background: rgba(255, 255, 255, .25);
    display: flex; align-items: center; justify-content: center;
}
.install-toast-ico svg { width: 13px; height: 13px; }

@media (prefers-reduced-motion: reduce) {
    .ios-banner-step-ico--pulse::after { animation: none; }
    .install-toast { transition: none; }
}

.rh-install-nudge {
    position: fixed; left: 12px; right: 12px;
    bottom: calc(12px + env(safe-area-inset-bottom, 0px));
    z-index: 999980;
    display: flex; align-items: center; gap: 10px;
    background: #0f172a; color: #fff;
    border-radius: var(--radius-lg, 16px);
    padding: 12px 10px 12px 14px;
    box-shadow: 0 14px 32px rgba(15, 23, 42, .22);
    max-width: 480px; margin: 0 auto;
    opacity: 0; transform: translateY(24px);
    pointer-events: none;
    transition: opacity .3s ease, transform .3s ease;
}
.rh-install-nudge--show { opacity: 1; transform: translateY(0); pointer-events: auto; }
.rh-install-nudge-ico {
    width: 30px; height: 30px; border-radius: 999px; flex-shrink: 0;
    background: rgba(255, 255, 255, .12); color: #fbbf24;
    display: flex; align-items: center; justify-content: center;
}
.rh-install-nudge-ico svg { width: 16px; height: 16px; }
.rh-install-nudge-text {
    flex: 1; font-family: var(--font, 'DM Sans', sans-serif); font-size: .8125rem; line-height: 1.35;
}
.rh-install-nudge-cta {
    flex-shrink: 0; border: 0; border-radius: 999px; padding: 8px 14px;
    background: #2563eb; color: #fff; font-weight: 700; font-size: .8125rem;
    font-family: var(--font, 'DM Sans', sans-serif); cursor: pointer; -webkit-tap-highlight-color: transparent;
}
.rh-install-nudge-close {
    flex-shrink: 0; width: 26px; height: 26px; border-radius: 999px; border: 0;
    background: transparent; color: rgba(255, 255, 255, .6);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; -webkit-tap-highlight-color: transparent;
}
.rh-install-nudge-close svg { width: 14px; height: 14px; }

@media (prefers-reduced-motion: reduce) {
    .rh-install-nudge { transition: none; }
}
</style>

<script>
(function () {
    var el = document.getElementById('iosInstallModal');
    if (!el) return;

    var GUIDE_OPENED_KEY = 'rh_install_guide_opened';
    var CELEBRATED_KEY = 'rh_install_celebrated';

    function celebrate() {
        try { localStorage.removeItem(GUIDE_OPENED_KEY); localStorage.setItem(CELEBRATED_KEY, '1'); } catch (e) {}
        var toast = document.getElementById('installToast');
        if (!toast) return;
        toast.classList.add('install-toast--show');
        setTimeout(function () { toast.classList.remove('install-toast--show'); }, 4000);
    }

    var alreadyInstalled = false;
    var isIOSEligible = false;
    var isAndroid = false;
    var deferredPrompt = null;

    try {
        // Déjà dans l'app installée (standalone) ou dans l'app Capacitor : rien à proposer.
        var isCapacitor = !!(window.Capacitor && window.Capacitor.isNativePlatform && window.Capacitor.isNativePlatform());
        var isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
        alreadyInstalled = isCapacitor || isStandalone;

        // iPhone/iPad sous Safari uniquement — Chrome/Firefox iOS n'offrent pas
        // la même installation.
        var ua = window.navigator.userAgent || '';
        var isIOS = /iPad|iPhone|iPod/.test(ua) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
        var isSafari = /^((?!chrome|android|crios|fxios|edgios).)*safari/i.test(ua);

        isIOSEligible = !alreadyInstalled && isIOS && isSafari;
        isAndroid = !alreadyInstalled && /Android/i.test(ua);
    } catch (e) {}

    // iOS n'a pas d'évènement "installé" : on ne peut détecter le succès qu'au
    // lancement suivant, une fois l'icône posée sur l'écran d'accueil — si le
    // guide avait été ouvert avant cette session standalone, l'installation a
    // forcément réussi entre-temps. Pas de confirmation à demander à l'utilisateur.
    try {
        if (alreadyInstalled && !isCapacitorFlag() && localStorage.getItem(GUIDE_OPENED_KEY) === '1' && !localStorage.getItem(CELEBRATED_KEY)) {
            celebrate();
        }
    } catch (e) {}
    function isCapacitorFlag() {
        return !!(window.Capacitor && window.Capacitor.isNativePlatform && window.Capacitor.isNativePlatform());
    }

    function open() {
        hideNudge();
        el.classList.add('ios-banner--show');
        try { localStorage.setItem(GUIDE_OPENED_KEY, '1'); } catch (e) {}
    }
    function close() { el.classList.remove('ios-banner--show'); }

    function triggerInstall() {
        if (deferredPrompt) {
            var prompt = deferredPrompt;
            deferredPrompt = null;
            prompt.prompt();
        } else if (isIOSEligible) {
            open();
        }
    }

    // Bannière discrète proposant l'installation avec un bénéfice concret
    // (les notifications push, impossibles sur iOS hors mode standalone —
    // voir app.js) plutôt qu'un simple argument esthétique. Respecte un
    // délai avant de se représenter si l'utilisateur l'a déjà fermée.
    var NUDGE_DISMISSED_KEY = 'rh_install_nudge_dismissed_at';
    var NUDGE_COOLDOWN_MS = 10 * 24 * 60 * 60 * 1000;
    var nudge = document.getElementById('rhInstallNudge');

    function hideNudge() {
        if (nudge) nudge.classList.remove('rh-install-nudge--show');
    }

    function maybeShowNudge() {
        if (!nudge || alreadyInstalled) return;
        if (!isIOSEligible && !deferredPrompt) return;
        try {
            var dismissedAt = parseInt(localStorage.getItem(NUDGE_DISMISSED_KEY) || '0', 10);
            if (dismissedAt && (Date.now() - dismissedAt) < NUDGE_COOLDOWN_MS) return;
        } catch (e) {}
        nudge.classList.add('rh-install-nudge--show');
    }

    if (nudge) {
        document.getElementById('rhInstallNudgeCta').addEventListener('click', function () {
            hideNudge();
            triggerInstall();
        });
        document.getElementById('rhInstallNudgeClose').addEventListener('click', function () {
            hideNudge();
            try { localStorage.setItem(NUDGE_DISMISSED_KEY, String(Date.now())); } catch (e) {}
        });
    }

    // Android/Chrome : le navigateur propose lui-même l'installation native
    // via cet évènement, en général quelques secondes après le chargement —
    // on le capture pour pouvoir la déclencher en un tap depuis notre bouton.
    if (!alreadyInstalled) {
        window.addEventListener('beforeinstallprompt', function (e) {
            e.preventDefault();
            deferredPrompt = e;
            wireTriggers();
            maybeShowNudge();
        });

        window.addEventListener('appinstalled', function () {
            celebrate();
            hideNudge();
            deferredPrompt = null;
            document.querySelectorAll('[data-ios-install-btn]').forEach(function (btn) {
                btn.hidden = true;
            });
        });
    }

    // Ce script s'exécute tôt dans la page (avant le contenu de la vue, qui
    // contient le bouton déclencheur) : il faut attendre que le DOM soit
    // complet avant de chercher [data-ios-install-btn], sans quoi il n'existe
    // pas encore. Rappelé une 2e fois si beforeinstallprompt arrive plus tard.
    function wireTriggers() {
        if (isAndroid) {
            document.querySelectorAll('[data-apk-download-link]').forEach(function (link) {
                link.hidden = false;
            });
        }

        var eligible = isIOSEligible || !!deferredPrompt;
        if (!eligible) return;

        var triggers = document.querySelectorAll('[data-ios-install-btn]');
        triggers.forEach(function (btn) {
            btn.hidden = false;
            if (btn.dataset.installWired) return;
            btn.dataset.installWired = '1';
            btn.addEventListener('click', triggerInstall);
        });

        document.getElementById('iosBannerClose').addEventListener('click', close);
        document.getElementById('iosBannerBackdrop').addEventListener('click', close);
    }

    function init() {
        wireTriggers();
        maybeShowNudge();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
