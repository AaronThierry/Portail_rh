<div id="pinGate" class="pin-gate" aria-hidden="true" data-email="{{ Auth::user()->email }}">
    <div class="pin-orbs">
        <span class="pin-orb pin-orb-a"></span>
        <span class="pin-orb pin-orb-b"></span>
    </div>

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
    background: linear-gradient(135deg, #F8FAFC 0%, #EFF6FF 50%, #F8FAFC 100%);
    overflow: hidden;
    transition: opacity .38s ease, transform .38s ease;
}
.pin-gate--hide { opacity: 0; transform: scale(1.02); pointer-events: none; }

.pin-orbs { position: absolute; inset: 0; pointer-events: none; }
.pin-orb { position: absolute; border-radius: 50%; filter: blur(70px); }
.pin-orb-a { width: 280px; height: 280px; top: -90px; right: -70px; background: #2563EB; opacity: .14; }
.pin-orb-b { width: 240px; height: 240px; bottom: -70px; left: -60px; background: #14B8A6; opacity: .12; }

.pin-card {
    position: relative; z-index: 1;
    width: 100%; max-width: 320px;
    display: flex; flex-direction: column; align-items: center;
    padding: 0 1.5rem; text-align: center;
}
.pin-card.pin-shake { animation: pin-shake .45s ease; }

.pin-icon {
    width: 52px; height: 52px; border-radius: 16px;
    background: rgba(255,255,255,.6);
    backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,.7);
    box-shadow: 0 10px 26px rgba(37,99,235,.16);
    display: flex; align-items: center; justify-content: center;
    color: #2563EB; margin-bottom: 1rem;
}
.pin-icon svg { width: 24px; height: 24px; }

.pin-title {
    font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.25rem;
    color: #0f172a; margin: 0 0 .25rem;
}
.pin-sub {
    font-family: 'DM Sans', sans-serif; font-size: .8125rem; color: #64748b; margin: 0 0 1.5rem;
}

.pin-dots { display: flex; gap: .875rem; margin-bottom: .5rem; }
.pin-dots span {
    width: 14px; height: 14px; border-radius: 50%;
    border: 2px solid #cbd5e1; background: transparent;
    transition: background .15s ease, border-color .15s ease, transform .15s ease;
}
.pin-dots span.filled {
    background: linear-gradient(135deg, #2563EB, #14B8A6);
    border-color: transparent; transform: scale(1.1);
}

.pin-error {
    font-family: 'DM Sans', sans-serif; font-size: .8125rem; font-weight: 600;
    color: #ef4444; min-height: 1.2em; margin: 0 0 1.25rem;
}

.pin-pad {
    display: grid; grid-template-columns: repeat(3, 64px); gap: .875rem;
    margin-bottom: 1.75rem;
}
.pin-pad button {
    width: 64px; height: 64px; border-radius: 50%;
    border: 1px solid rgba(226,232,240,.9);
    background: #fff;
    font-family: 'DM Sans', sans-serif; font-size: 1.375rem; font-weight: 600; color: #0f172a;
    box-shadow: 0 2px 6px rgba(15,23,42,.06);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; -webkit-tap-highlight-color: transparent;
    transition: transform .12s ease, background .12s ease;
}
.pin-pad button:active { transform: scale(.92); background: #eff6ff; }
.pin-key-spacer { width: 64px; height: 64px; }
.pin-key-back { color: #64748b; }
.pin-key-back svg { width: 20px; height: 20px; }

.pin-logout {
    font-family: 'DM Sans', sans-serif; font-size: .8125rem; font-weight: 600;
    color: #64748b; text-decoration: none;
}
.pin-logout:active { color: #2563EB; }

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
    var SESSION_FLAG = 'rhpin_unlocked';
    var PIN_LEN = 4;
    var MAX_ATTEMPTS = 5;

    // Déjà déverrouillé plus tôt dans cette même session d'app (navigation interne) :
    // on ne redemande pas le code à chaque page, seulement à une nouvelle ouverture de l'app.
    try {
        if (sessionStorage.getItem(SESSION_FLAG) === email) { el.remove(); return; }
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
        try { sessionStorage.setItem(SESSION_FLAG, email); } catch (e) {}
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

    var dotsEl = document.getElementById('pinDots');
    var titleEl = document.getElementById('pinTitle');
    var subEl = document.getElementById('pinSub');
    var errorEl = document.getElementById('pinError');
    var padEl = document.getElementById('pinPad');
    var cardEl = el.querySelector('.pin-card');

    var buffer = '';
    var firstEntry = null;
    var attempts = 0;
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
                attempts = 0;
                closeGate();
                return;
            }
            attempts++;
            if (attempts >= MAX_ATTEMPTS) {
                clearRecord();
                window.location.href = '{{ route("logout.get") }}';
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
        errorEl.textContent = ' ';

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
