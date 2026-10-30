<div id="pinGate" class="pin-gate" aria-hidden="true" data-email="{{ Auth::user()->email }}">
    <div class="pin-card">
        <div class="pin-badge" id="pinBadge">
            <img src="{{ asset('assets/images/logo.png') }}" alt="" class="pin-badge-logo">
            <svg class="pin-badge-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
        </div>
        <p class="pin-brand">Portail RH+</p>
        <h2 class="pin-title" id="pinTitle">Entrez votre code</h2>
        <p class="pin-sub" id="pinSub">{{ Auth::user()->email }}</p>

        <div class="pin-dots" id="pinDots">
            <span></span><span></span><span></span><span></span>
        </div>
        <p class="pin-error" id="pinError">&nbsp;</p>

        <div class="pin-pad" id="pinPad">
            <button type="button" data-key="1">1</button>
            <button type="button" data-key="2">2</button>
            <button type="button" data-key="3">3</button>
            <button type="button" data-key="4">4</button>
            <button type="button" data-key="5">5</button>
            <button type="button" data-key="6">6</button>
            <button type="button" data-key="7">7</button>
            <button type="button" data-key="8">8</button>
            <button type="button" data-key="9">9</button>
            <span class="pin-key-spacer" aria-hidden="true"></span>
            <button type="button" data-key="0">0</button>
            <button type="button" class="pin-key-back" data-key="back" aria-label="Effacer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"/><line x1="18" y1="9" x2="12" y2="15"/><line x1="12" y1="9" x2="18" y2="15"/>
                </svg>
            </button>
        </div>

        <div class="pin-foot">
            <button type="button" class="pin-link pin-link--accent" id="pinForgot" style="display:none">Code oublié ?</button>
            <span class="pin-foot-sep" id="pinFootSep" aria-hidden="true" style="display:none">·</span>
            <a href="{{ route('logout.get') }}" class="pin-link">Se déconnecter</a>
        </div>
    </div>
</div>

<style>
.pin-gate {
    position: fixed; inset: 0; z-index: 999998;
    display: flex; align-items: center; justify-content: center;
    background: var(--page, #f8fafc);
    overflow: hidden;
    transition: opacity .38s ease, transform .38s ease;
}
.pin-gate--hide { opacity: 0; transform: scale(1.02); pointer-events: none; }

.pin-card {
    position: relative; z-index: 1;
    width: 100%; max-width: 320px;
    display: flex; flex-direction: column; align-items: center;
    padding: 0 1.5rem; text-align: center;
}
.pin-card.pin-shake { animation: pin-shake .45s ease; }

.pin-badge {
    position: relative;
    width: 92px; height: 92px; border-radius: 28px;
    background: var(--surface, #fff);
    border: 1px solid var(--line-soft, #e2e8f0);
    box-shadow: 0 10px 28px rgba(37, 99, 235, .14);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1rem;
    transition: background .3s ease, border-color .3s ease;
}
.pin-badge-logo { width: 60px; height: 60px; object-fit: contain; transition: opacity .2s ease, transform .2s ease; }
.pin-badge-check {
    position: absolute; inset: 0; margin: auto; width: 40px; height: 40px;
    opacity: 0; transform: scale(.5);
    transition: opacity .25s ease, transform .25s ease;
}
.pin-badge--ok {
    background: var(--ok-bg, rgba(52, 211, 153, .16));
    border-color: transparent;
    animation: pin-pop .4s ease;
}
.pin-badge--ok .pin-badge-logo { opacity: 0; transform: scale(.6); }
.pin-badge--ok .pin-badge-check { opacity: 1; transform: scale(1); color: var(--ok, #059669); }

.pin-brand {
    font-family: var(--display, 'Syne', sans-serif); font-weight: 800; font-size: 2rem;
    letter-spacing: -.01em; color: var(--ink, #0f172a);
    margin: 0 0 1rem;
}

.pin-title {
    font-family: var(--display, 'Syne', sans-serif); font-weight: 700; font-size: 1.0625rem;
    color: var(--ink, #0f172a); margin: 0 0 .25rem;
}
.pin-sub {
    font-family: var(--font, 'DM Sans', sans-serif); font-size: .8125rem; color: var(--muted, #64748b); margin: 0 0 1.5rem;
}

.pin-dots { display: flex; gap: .875rem; margin-bottom: .5rem; }
.pin-dots span {
    width: 14px; height: 14px; border-radius: 50%;
    border: 2px solid var(--line, #cbd5e1); background: transparent;
    transition: background .15s ease, border-color .15s ease, transform .15s ease;
}
.pin-dots span.filled {
    background: var(--brand, #2563eb);
    border-color: transparent; transform: scale(1.1);
}

.pin-error {
    font-family: var(--font, 'DM Sans', sans-serif); font-size: .8125rem; font-weight: 600;
    color: var(--no, #dc2626); min-height: 1.2em; margin: 0 0 1.25rem;
}

.pin-pad {
    display: grid; grid-template-columns: repeat(3, 64px); gap: .875rem;
    margin-bottom: 1.75rem;
}
.pin-pad button {
    width: 64px; height: 64px; border-radius: 50%;
    border: 1px solid var(--line-soft, #e2e8f0);
    background: var(--surface, #fff);
    font-family: var(--font, 'DM Sans', sans-serif); font-size: 1.375rem; font-weight: 600; color: var(--ink, #0f172a);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; -webkit-tap-highlight-color: transparent;
    transition: transform .12s ease, background .12s ease;
}
.pin-pad button:active { transform: scale(.92); background: var(--brand-bg, #eff6ff); }
.pin-key-spacer { width: 64px; height: 64px; }
.pin-key-back { color: var(--muted, #64748b); }
.pin-key-back svg { width: 20px; height: 20px; }

.pin-foot { display: flex; align-items: center; gap: .5rem; }
.pin-foot-sep { color: var(--line, #cbd5e1); font-size: .75rem; }

.pin-link {
    font-family: var(--font, 'DM Sans', sans-serif); font-size: .8125rem; font-weight: 600;
    color: var(--muted, #64748b); text-decoration: none;
    background: none; border: 0; padding: 0; cursor: pointer; -webkit-tap-highlight-color: transparent;
}
.pin-link:active { color: var(--brand, #2563eb); }
.pin-link--accent { color: var(--brand, #2563eb); }

@keyframes pin-shake {
    10%, 90% { transform: translateX(-2px); }
    20%, 80% { transform: translateX(4px); }
    30%, 50%, 70% { transform: translateX(-8px); }
    40%, 60% { transform: translateX(8px); }
}

@keyframes pin-pop {
    0% { transform: scale(.75); }
    55% { transform: scale(1.07); }
    100% { transform: scale(1); }
}

@media (prefers-reduced-motion: reduce) {
    .pin-card.pin-shake { animation: none !important; }
    .pin-badge--ok { animation: none !important; }
}
</style>

<script>
(function () {
    var el = document.getElementById('pinGate');
    if (!el) return;

    var isApp = false;
    try {
        var isCapacitor = !!(window.Capacitor && window.Capacitor.isNativePlatform && window.Capacitor.isNativePlatform());
        var isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
        isApp = isCapacitor || isStandalone;
    } catch (e) {}

    if (!isApp) { el.remove(); return; }

    var email = el.getAttribute('data-email') || '';
    var STORE_KEY = 'rhpin_v1';
    var PIN_LEN = 4;
    var MAX_ATTEMPTS = 5;
    var LOGOUT_URL = '{{ route("logout.get") }}';

    // ── Reverrouillage dès que l'app quitte le premier plan ─────────────────
    // Pas de délai de grâce : si l'app a été mise en arrière-plan (changement
    // d'app, mise en veille, écran verrouillé...) ne serait-ce qu'un instant
    // depuis le dernier déverrouillage, le code est redemandé — immédiatement
    // au retour au premier plan si l'app est restée en mémoire, ou au prochain
    // chargement de page si le système a tué le processus entre-temps. En
    // revanche, une simple navigation interne (clic sur un lien) ne déclenche
    // jamais 'visibilitychange' : on ne redemande donc pas le code à chaque page.
    var UNLOCK_AT_KEY = 'rhpin_unlocked_at';
    var UNLOCK_EMAIL_KEY = 'rhpin_unlocked_email';
    var BG_AT_KEY = 'rhpin_bg_at';

    function markUnlocked() {
        try {
            localStorage.setItem(UNLOCK_AT_KEY, String(Date.now()));
            localStorage.setItem(UNLOCK_EMAIL_KEY, email);
        } catch (e) {}
    }
    function markBackgrounded() {
        try { localStorage.setItem(BG_AT_KEY, String(Date.now())); } catch (e) {}
    }
    function wasBackgroundedSinceUnlock() {
        try {
            var unlockAt = parseInt(localStorage.getItem(UNLOCK_AT_KEY) || '0', 10);
            var unlockEmail = localStorage.getItem(UNLOCK_EMAIL_KEY) || '';
            var bgAt = parseInt(localStorage.getItem(BG_AT_KEY) || '0', 10);
            if (unlockEmail !== email || unlockAt <= 0) return true;
            return bgAt > unlockAt;
        } catch (e) { return true; }
    }
    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            markBackgrounded();
        } else if (typeof relock === 'function') {
            relock();
        }
    });

    function loadRecord() {
        try { return JSON.parse(localStorage.getItem(STORE_KEY) || 'null'); } catch (e) { return null; }
    }
    function saveRecord(rec) {
        try { localStorage.setItem(STORE_KEY, JSON.stringify(rec)); } catch (e) {}
    }
    function clearRecord() {
        try { localStorage.removeItem(STORE_KEY); } catch (e) {}
    }

    // ── Compteur de tentatives, PERSISTÉ (pas une simple variable JS) ──────────
    // Faille corrigée : un compteur en mémoire se remet à 0 au moindre rechargement
    // de page, ce qui annulait complètement la limite de 5 essais. Le compteur vit
    // maintenant dans localStorage, par compte (email), et survit à toute
    // navigation/rechargement — seule une vraie reconnexion (mot de passe) le reset.
    var ATTEMPTS_KEY = 'rhpin_attempts';
    function attemptsKey() { return ATTEMPTS_KEY + ':' + email; }
    function getAttempts() {
        try { return parseInt(localStorage.getItem(attemptsKey()) || '0', 10); } catch (e) { return 0; }
    }
    function setAttempts(n) {
        try { localStorage.setItem(attemptsKey(), String(n)); } catch (e) {}
    }
    function clearAttempts() {
        try { localStorage.removeItem(attemptsKey()); } catch (e) {}
    }
    function forceLogout() {
        clearRecord();
        clearAttempts();
        window.location.href = LOGOUT_URL;
    }

    function toHex(buffer) {
        return Array.prototype.map.call(new Uint8Array(buffer), function (b) {
            return ('0' + b.toString(16)).slice(-2);
        }).join('');
    }
    function randomHex(len) {
        var arr = new Uint8Array(len);
        (window.crypto || window.msCrypto).getRandomValues(arr);
        return toHex(arr);
    }
    function hashPin(pin, salt) {
        var data = new TextEncoder().encode(pin + ':' + salt);
        return crypto.subtle.digest('SHA-256', data).then(toHex);
    }

    var record = loadRecord();
    var mode = (record && record.email === email) ? 'unlock' : 'setup';

    // Déjà au max de tentatives (ex. l'app a été tuée juste après le 5e échec,
    // avant que la redirection de déconnexion n'ait eu le temps de partir) :
    // on ne montre même pas le clavier, direction déconnexion immédiatement.
    if (mode === 'unlock' && getAttempts() >= MAX_ATTEMPTS) {
        forceLogout();
        return;
    }

    var dotsEl = document.getElementById('pinDots');
    var titleEl = document.getElementById('pinTitle');
    var subEl = document.getElementById('pinSub');
    var errorEl = document.getElementById('pinError');
    var padEl = document.getElementById('pinPad');
    var cardEl = el.querySelector('.pin-card');
    var badgeEl = document.getElementById('pinBadge');
    var forgotEl = document.getElementById('pinForgot');
    var forgotSepEl = document.getElementById('pinFootSep');

    function vibrate(pattern) {
        try { if ('vibrate' in navigator) navigator.vibrate(pattern); } catch (e) {}
    }

    var buffer = '';
    var firstEntry = null;
    var setupStage = 'create'; // 'create' | 'confirm'
    var busy = false;

    function renderDots() {
        var dots = dotsEl.children;
        for (var i = 0; i < dots.length; i++) {
            dots[i].classList.toggle('filled', i < buffer.length);
        }
    }
    function resetBuffer() { buffer = ''; renderDots(); }
    function shake(msg) {
        errorEl.textContent = msg || '';
        cardEl.classList.remove('pin-shake');
        void cardEl.offsetWidth;
        cardEl.classList.add('pin-shake');
    }

    function setupTexts() {
        if (setupStage === 'create') {
            titleEl.textContent = 'Créez votre code';
            subEl.textContent = 'Un code à ' + PIN_LEN + ' chiffres pour accéder rapidement à l\'app';
        } else {
            titleEl.textContent = 'Confirmez votre code';
            subEl.textContent = 'Saisissez à nouveau le même code';
        }
    }
    function unlockTexts() {
        titleEl.textContent = 'Entrez votre code';
        subEl.textContent = email;
    }

    function showGate() {
        el.style.display = '';
        el.classList.remove('pin-gate--hide');
    }
    function hideGate() { el.classList.add('pin-gate--hide'); }

    // État initial : si un code existe déjà pour ce compte et que l'app n'a
    // pas quitté le premier plan depuis le dernier déverrouillage, inutile de
    // montrer l'écran — sans animation de sortie, pour ne rien laisser voir
    // (contrairement à closeGate(), qui conclut une saisie réussie).
    if (mode === 'unlock' && !wasBackgroundedSinceUnlock()) {
        hideGate();
        el.style.display = 'none';
    } else {
        showGate();
        if (mode === 'setup') setupTexts(); else unlockTexts();
    }

    // « Code oublié ? » n'a de sens qu'une fois un code déjà créé.
    if (mode === 'unlock') {
        forgotEl.style.display = '';
        forgotSepEl.style.display = '';
    }
    forgotEl.addEventListener('click', function () {
        forceLogout();
    });

    function closeGate() {
        clearAttempts();
        markUnlocked();
        hideGate();
    }

    function relock() {
        // N'a de sens qu'une fois un code déjà créé, et seulement si l'app a
        // effectivement quitté le premier plan depuis le dernier déverrouillage.
        if (mode !== 'unlock' || !wasBackgroundedSinceUnlock()) return;
        if (getAttempts() >= MAX_ATTEMPTS) { forceLogout(); return; }
        badgeEl.classList.remove('pin-badge--ok');
        resetBuffer();
        errorEl.textContent = ' ';
        unlockTexts();
        busy = false;
        showGate();
    }

    function showSuccessThenClose() {
        vibrate(15);
        badgeEl.classList.add('pin-badge--ok');
        setTimeout(closeGate, 550);
    }

    function onComplete() {
        if (mode === 'setup') {
            if (setupStage === 'create') {
                firstEntry = buffer;
                resetBuffer();
                setupStage = 'confirm';
                setupTexts();
                busy = false;
                return;
            }
            if (buffer !== firstEntry) {
                shake('Les codes ne correspondent pas, recommencez.');
                resetBuffer();
                firstEntry = null;
                setupStage = 'create';
                setTimeout(setupTexts, 550);
                busy = false;
                return;
            }
            var salt = randomHex(16);
            hashPin(buffer, salt).then(function (hash) {
                saveRecord({ email: email, salt: salt, hash: hash });
                showSuccessThenClose();
            });
            return;
        }

        hashPin(buffer, record.salt).then(function (hash) {
            if (hash === record.hash) {
                showSuccessThenClose();
                return;
            }

            var attempts = getAttempts() + 1;
            setAttempts(attempts);

            if (attempts >= MAX_ATTEMPTS) {
                forceLogout();
                return;
            }

            vibrate([15, 40, 15]);
            var left = MAX_ATTEMPTS - attempts;
            shake('Code incorrect — ' + left + ' essai' + (left > 1 ? 's' : '') + ' restant' + (left > 1 ? 's' : ''));
            resetBuffer();
            busy = false;
        });
    }

    padEl.addEventListener('click', function (e) {
        var btn = e.target.closest('button[data-key]');
        if (!btn || busy) return;
        var key = btn.getAttribute('data-key');
        errorEl.textContent = ' ';

        if (key === 'back') {
            buffer = buffer.slice(0, -1);
            vibrate(8);
            renderDots();
            return;
        }
        if (buffer.length >= PIN_LEN) return;
        buffer += key;
        vibrate(8);
        renderDots();
        if (buffer.length === PIN_LEN) {
            busy = true;
            setTimeout(onComplete, 120);
        }
    });

    renderDots();
})();
</script>
