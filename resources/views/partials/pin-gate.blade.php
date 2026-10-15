<div id="pinGate" class="pin-gate" aria-hidden="true" data-email="{{ Auth::user()->email }}">
    <div class="pin-card">
        <div class="pin-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
        </div>
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

        <a href="{{ route('logout.get') }}" class="pin-logout">Se déconnecter</a>
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

.pin-icon {
    width: 52px; height: 52px; border-radius: var(--radius, 16px);
    background: var(--brand-bg, #eff6ff);
    border: 1px solid var(--line-soft, #e2e8f0);
    display: flex; align-items: center; justify-content: center;
    color: var(--brand, #2563eb); margin-bottom: 1rem;
}
.pin-icon svg { width: 24px; height: 24px; }

.pin-title {
    font-family: var(--display, 'Syne', sans-serif); font-weight: 800; font-size: 1.25rem;
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

.pin-logout {
    font-family: var(--font, 'DM Sans', sans-serif); font-size: .8125rem; font-weight: 600;
    color: var(--muted, #64748b); text-decoration: none;
}
.pin-logout:active { color: var(--brand, #2563eb); }

@keyframes pin-shake {
    10%, 90% { transform: translateX(-2px); }
    20%, 80% { transform: translateX(4px); }
    30%, 50%, 70% { transform: translateX(-8px); }
    40%, 60% { transform: translateX(8px); }
}

@media (prefers-reduced-motion: reduce) {
    .pin-card.pin-shake { animation: none !important; }
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

    // Déjà déverrouillé récemment (navigation interne) : on ne redemande pas le code
    // à chaque page, seulement si l'app a été quittée un moment. localStorage (pas
    // sessionStorage — peu fiable d'une navigation à l'autre dans certaines WebView
    // Android) + fenêtre de temps glissante, la même que l'écran de chargement.
    var UNLOCK_AT_KEY = 'rhpin_unlocked_at';
    var UNLOCK_EMAIL_KEY = 'rhpin_unlocked_email';
    var SESSION_GAP_MS = 20 * 60 * 1000;
    try {
        var lastUnlockAt = parseInt(localStorage.getItem(UNLOCK_AT_KEY) || '0', 10);
        var lastUnlockEmail = localStorage.getItem(UNLOCK_EMAIL_KEY) || '';
        if (lastUnlockEmail === email && lastUnlockAt > 0 && (Date.now() - lastUnlockAt) < SESSION_GAP_MS) {
            localStorage.setItem(UNLOCK_AT_KEY, String(Date.now())); // prolonge la fenêtre
            el.remove();
            return;
        }
    } catch (e) {}

    function loadRecord() {
        try { return JSON.parse(localStorage.getItem(STORE_KEY) || 'null'); } catch (e) { return null; }
    }
    function saveRecord(rec) {
        try { localStorage.setItem(STORE_KEY, JSON.stringify(rec)); } catch (e) {}
    }
    function clearRecord() {
        try { localStorage.removeItem(STORE_KEY); } catch (e) {}
    }
    function markUnlocked() {
        try {
            localStorage.setItem(UNLOCK_AT_KEY, String(Date.now()));
            localStorage.setItem(UNLOCK_EMAIL_KEY, email);
        } catch (e) {}
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

    if (mode === 'setup') setupTexts(); else unlockTexts();

    function closeGate() {
        clearAttempts();
        markUnlocked();
        el.classList.add('pin-gate--hide');
        setTimeout(function () { el.remove(); }, 380);
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
                closeGate();
            });
            return;
        }

        hashPin(buffer, record.salt).then(function (hash) {
            if (hash === record.hash) {
                closeGate();
                return;
            }

            var attempts = getAttempts() + 1;
            setAttempts(attempts);

            if (attempts >= MAX_ATTEMPTS) {
                forceLogout();
                return;
            }

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
            renderDots();
            return;
        }
        if (buffer.length >= PIN_LEN) return;
        buffer += key;
        renderDots();
        if (buffer.length === PIN_LEN) {
            busy = true;
            setTimeout(onComplete, 120);
        }
    });

    renderDots();
})();
</script>
