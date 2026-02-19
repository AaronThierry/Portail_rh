<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sécurisez votre compte — Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --navy:       #070D1A;
            --navy-card:  #0C1628;
            --navy-input: #0A1422;
            --navy-mid:   #111D35;
            --gold:       #C9A96E;
            --gold-light: #E2C78A;
            --gold-dim:   #9A7A4E;
            --text:       #F0EDE8;
            --text-muted: rgba(240,237,232,0.45);
            --text-sub:   rgba(240,237,232,0.65);
            --border:     rgba(201,169,110,0.15);
            --border-faint: rgba(255,255,255,0.06);
            --danger:     #F87171;
        }

        html { height: 100%; }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--navy);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
        }

        /* Geometric grid background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(201,169,110,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,169,110,0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
            z-index: 0;
        }

        /* Radial glow */
        body::after {
            content: '';
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(201,169,110,0.055) 0%, transparent 68%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── Card ── */
        .vault-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            background: var(--navy-card);
            border: 1px solid var(--border);
            border-radius: 4px;
            overflow: hidden;
            animation: fadeUp 0.55s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Gold top stripe */
        .vault-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold-dim) 0%, var(--gold) 40%, var(--gold-light) 60%, var(--gold) 80%, var(--gold-dim) 100%);
        }

        /* ── Header ── */
        .vh-header {
            padding: 40px 44px 32px;
            border-bottom: 1px solid var(--border-faint);
        }

        .vh-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
        }

        .vh-brand-icon {
            width: 34px;
            height: 34px;
            background: var(--gold);
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .vh-brand-icon svg { width: 16px; height: 16px; stroke: var(--navy-card); }

        .vh-brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 17px;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: var(--text);
        }
        .vh-brand-name span { color: var(--gold); }

        .vh-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(201,169,110,0.1);
            border: 1px solid rgba(201,169,110,0.25);
            padding: 4px 12px;
            border-radius: 3px;
            margin-bottom: 18px;
        }

        .vh-badge-dot {
            width: 5px;
            height: 5px;
            background: var(--gold);
            border-radius: 50%;
            animation: pulse 2.2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.35; }
        }

        .vh-badge span {
            font-size: 10px;
            font-weight: 600;
            color: var(--gold);
            letter-spacing: 1.6px;
            text-transform: uppercase;
        }

        .vh-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 34px;
            font-weight: 400;
            color: var(--text);
            line-height: 1.18;
            letter-spacing: -0.3px;
            margin-bottom: 12px;
        }

        .vh-subtitle {
            font-size: 13.5px;
            color: var(--text-sub);
            line-height: 1.65;
        }

        /* ── Body ── */
        .vh-body {
            padding: 32px 44px 36px;
        }

        .vh-alert {
            padding: 13px 16px;
            border-radius: 3px;
            font-size: 13px;
            line-height: 1.55;
            margin-bottom: 24px;
        }
        .vh-alert.warn {
            background: rgba(251,191,36,0.06);
            border-left: 2px solid #FBBF24;
            color: #FCD34D;
        }
        .vh-alert.err {
            background: rgba(248,113,113,0.06);
            border-left: 2px solid var(--danger);
            color: var(--danger);
        }

        .vh-group { margin-bottom: 22px; }

        .vh-label {
            display: block;
            font-size: 10.5px;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-bottom: 9px;
        }

        .vh-input-wrap { position: relative; }

        .vh-input {
            width: 100%;
            padding: 13px 46px 13px 16px;
            background: var(--navy-input);
            border: 1px solid var(--border-faint);
            border-bottom: 1px solid rgba(201,169,110,0.2);
            border-radius: 3px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
            color: var(--text);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .vh-input::placeholder {
            color: var(--text-muted);
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
        }
        .vh-input:focus {
            border-color: rgba(201,169,110,0.5);
            box-shadow: 0 0 0 3px rgba(201,169,110,0.07), inset 0 0 0 1px rgba(201,169,110,0.1);
        }
        .vh-input.is-error {
            border-color: rgba(248,113,113,0.5);
            box-shadow: 0 0 0 3px rgba(248,113,113,0.05);
        }

        .vh-eye {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            padding: 6px;
            transition: color 0.2s;
            display: flex;
            align-items: center;
        }
        .vh-eye:hover { color: var(--gold); }
        .vh-eye svg { width: 16px; height: 16px; }

        .vh-field-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 6px;
            display: none;
        }
        .vh-field-error.show { display: block; }

        /* Strength meter */
        .vh-strength { margin-top: 12px; display: none; }
        .vh-strength.visible { display: block; }

        .vh-strength-bar-wrap {
            height: 3px;
            background: rgba(255,255,255,0.06);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 6px;
        }
        .vh-strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: width 0.35s ease, background-color 0.35s ease;
        }
        .vh-strength-label {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            transition: color 0.3s;
        }

        /* Requirements list */
        .vh-reqs {
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--border-faint);
            border-radius: 3px;
            padding: 16px 18px;
            margin-bottom: 28px;
        }
        .vh-reqs-title {
            font-size: 10px;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 1.3px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }
        .vh-req-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12.5px;
            color: var(--text-muted);
            margin-bottom: 8px;
            transition: color 0.25s;
        }
        .vh-req-item:last-child { margin-bottom: 0; }
        .req-icon {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background 0.25s, border-color 0.25s;
        }
        .req-icon svg {
            width: 9px;
            height: 9px;
            stroke: transparent;
            transition: stroke 0.25s;
        }
        .vh-req-item.valid { color: var(--text-sub); }
        .vh-req-item.valid .req-icon {
            background: rgba(201,169,110,0.18);
            border-color: rgba(201,169,110,0.4);
        }
        .vh-req-item.valid .req-icon svg { stroke: var(--gold); }

        /* Submit button */
        .vh-submit {
            width: 100%;
            padding: 15px 24px;
            background: var(--gold);
            border: none;
            border-radius: 3px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: var(--navy-card);
            letter-spacing: 0.4px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .vh-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.15) 50%, transparent 60%);
            transform: translateX(-100%);
            transition: transform 0.5s;
        }
        .vh-submit:hover {
            background: var(--gold-light);
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(201,169,110,0.25);
        }
        .vh-submit:hover::after { transform: translateX(100%); }
        .vh-submit:active { transform: translateY(0); }
        .vh-submit:disabled {
            background: rgba(201,169,110,0.3);
            color: rgba(7,13,26,0.45);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .vh-submit svg {
            width: 16px;
            height: 16px;
            stroke: var(--navy-card);
            flex-shrink: 0;
            transition: transform 0.2s;
        }
        .vh-submit:hover:not(:disabled) svg { transform: translateX(2px); }

        /* Footer */
        .vh-footer {
            padding: 0 44px 32px;
            text-align: center;
        }
        .vh-logout-link {
            font-size: 12.5px;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }
        .vh-logout-link:hover { color: var(--text-sub); }

        @media (max-width: 520px) {
            .vh-header, .vh-body, .vh-footer {
                padding-left: 24px;
                padding-right: 24px;
            }
            .vh-title { font-size: 28px; }
        }
    </style>
</head>
<body>

<div class="vault-card">

    {{-- Header --}}
    <div class="vh-header">
        <div class="vh-brand">
            <div class="vh-brand-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="vh-brand-name">Portail <span>RH+</span></div>
        </div>

        <div class="vh-badge">
            <div class="vh-badge-dot"></div>
            <span>Sécurité &mdash; Première connexion</span>
        </div>

        <h1 class="vh-title">Sécurisez<br><em>votre compte</em></h1>
        <p class="vh-subtitle">
            Vous utilisez un mot de passe temporaire. Définissez votre mot de passe permanent pour accéder à votre espace.
        </p>
    </div>

    {{-- Body --}}
    <div class="vh-body">

        @if(session('warning'))
        <div class="vh-alert warn">{{ session('warning') }}</div>
        @endif

        @if($errors->any())
        <div class="vh-alert err">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
        @endif

        <form action="{{ route('password.update-first') }}" method="POST" id="vaultForm" novalidate>
            @csrf

            {{-- Nouveau mot de passe --}}
            <div class="vh-group">
                <label for="new_password" class="vh-label">Nouveau mot de passe</label>
                <div class="vh-input-wrap">
                    <input type="password" id="new_password" name="new_password"
                           class="vh-input @error('new_password') is-error @enderror"
                           placeholder="Minimum 8 caractères"
                           autocomplete="new-password"
                           autofocus required>
                    <button type="button" class="vh-eye" onclick="togglePwd('new_password', this)" aria-label="Afficher">
                        <svg id="eye-np-show" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="eye-np-hide" style="display:none;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>
                <span class="vh-field-error @error('new_password') show @enderror" id="err-np">
                    @error('new_password'){{ $message }}@enderror
                </span>

                <div class="vh-strength" id="strengthWrap">
                    <div class="vh-strength-bar-wrap">
                        <div class="vh-strength-bar" id="strengthBar"></div>
                    </div>
                    <span class="vh-strength-label" id="strengthLabel"></span>
                </div>
            </div>

            {{-- Confirmation --}}
            <div class="vh-group">
                <label for="new_password_confirmation" class="vh-label">Confirmer le mot de passe</label>
                <div class="vh-input-wrap">
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                           class="vh-input"
                           placeholder="Retapez votre mot de passe"
                           autocomplete="new-password"
                           required>
                    <button type="button" class="vh-eye" onclick="togglePwd('new_password_confirmation', this)" aria-label="Afficher">
                        <svg id="eye-nc-show" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="eye-nc-hide" style="display:none;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>
                <span class="vh-field-error" id="err-nc"></span>
            </div>

            {{-- Requirements checklist --}}
            <div class="vh-reqs">
                <div class="vh-reqs-title">Règles du mot de passe</div>

                <div class="vh-req-item" id="req-length">
                    <div class="req-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                    <span>Au moins 8 caractères</span>
                </div>
                <div class="vh-req-item" id="req-upper">
                    <div class="req-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                    <span>Une lettre majuscule</span>
                </div>
                <div class="vh-req-item" id="req-lower">
                    <div class="req-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                    <span>Une lettre minuscule</span>
                </div>
                <div class="vh-req-item" id="req-digit">
                    <div class="req-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                    <span>Un chiffre</span>
                </div>
                <div class="vh-req-item" id="req-special">
                    <div class="req-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                    <span>Un caractère spécial (@, #, !, &hellip;)</span>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="vh-submit" id="submitBtn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                Définir mon mot de passe permanent
            </button>
        </form>
    </div>

    {{-- Footer --}}
    <div class="vh-footer">
        <a href="{{ route('logout') }}"
           class="vh-logout-link"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Me déconnecter
        </a>
    </div>

</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>

<script>
/* Toggle visibility */
function togglePwd(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    // show/hide icons for new_password
    if (fieldId === 'new_password') {
        document.getElementById('eye-np-show').style.display = isHidden ? 'none' : '';
        document.getElementById('eye-np-hide').style.display = isHidden ? '' : 'none';
    } else {
        document.getElementById('eye-nc-show').style.display = isHidden ? 'none' : '';
        document.getElementById('eye-nc-hide').style.display = isHidden ? '' : 'none';
    }
}

/* Strength calculator */
const STRENGTH_COLORS = ['#EF4444','#F97316','#EAB308','#84CC16','#C9A96E','#E2C78A'];
const STRENGTH_LABELS = ['Très faible','Faible','Moyen','Bien','Fort','Excellent'];

function calcScore(pwd) {
    let s = 0;
    if (pwd.length >= 8)            s++;
    if (pwd.length >= 12)           s++;
    if (/[A-Z]/.test(pwd))          s++;
    if (/[a-z]/.test(pwd))          s++;
    if (/\d/.test(pwd))             s++;
    if (/[^A-Za-z0-9]/.test(pwd))   s++;
    return s; // 0–6
}

const reqs = [
    { id: 'req-length',  test: p => p.length >= 8 },
    { id: 'req-upper',   test: p => /[A-Z]/.test(p) },
    { id: 'req-lower',   test: p => /[a-z]/.test(p) },
    { id: 'req-digit',   test: p => /\d/.test(p) },
    { id: 'req-special', test: p => /[^A-Za-z0-9]/.test(p) },
];

const pwdInput  = document.getElementById('new_password');
const confInput = document.getElementById('new_password_confirmation');
const bar       = document.getElementById('strengthBar');
const barLabel  = document.getElementById('strengthLabel');
const sWrap     = document.getElementById('strengthWrap');

function updateUI(val) {
    if (!val) {
        sWrap.classList.remove('visible');
        reqs.forEach(r => document.getElementById(r.id).classList.remove('valid'));
        return;
    }
    sWrap.classList.add('visible');
    const score = calcScore(val);
    bar.style.width           = Math.max((score / 6) * 100, 8) + '%';
    bar.style.backgroundColor = STRENGTH_COLORS[Math.min(score, 5)];
    barLabel.style.color      = STRENGTH_COLORS[Math.min(score, 5)];
    barLabel.textContent      = STRENGTH_LABELS[Math.min(score, 5)];
    reqs.forEach(r => document.getElementById(r.id).classList.toggle('valid', r.test(val)));
}

pwdInput.addEventListener('input', () => {
    updateUI(pwdInput.value);
    // clear error
    pwdInput.classList.remove('is-error');
    document.getElementById('err-np').classList.remove('show');
    // re-check confirm match
    if (confInput.value) checkConfirm();
});

function checkConfirm() {
    const err = document.getElementById('err-nc');
    if (confInput.value && pwdInput.value !== confInput.value) {
        confInput.classList.add('is-error');
        err.textContent = 'Les mots de passe ne correspondent pas';
        err.classList.add('show');
    } else {
        confInput.classList.remove('is-error');
        err.classList.remove('show');
    }
}

confInput.addEventListener('input', checkConfirm);

/* Form submit */
document.getElementById('vaultForm').addEventListener('submit', function(e) {
    let ok = true;

    if (!pwdInput.value) {
        pwdInput.classList.add('is-error');
        const err = document.getElementById('err-np');
        err.textContent = 'Le nouveau mot de passe est requis';
        err.classList.add('show');
        ok = false;
    } else if (pwdInput.value.length < 8) {
        pwdInput.classList.add('is-error');
        const err = document.getElementById('err-np');
        err.textContent = 'Minimum 8 caractères requis';
        err.classList.add('show');
        ok = false;
    }

    if (pwdInput.value && confInput.value && pwdInput.value !== confInput.value) {
        confInput.classList.add('is-error');
        const err = document.getElementById('err-nc');
        err.textContent = 'Les mots de passe ne correspondent pas';
        err.classList.add('show');
        ok = false;
    }

    if (!ok) { e.preventDefault(); return; }

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Sécurisation en cours&hellip;`;
});
</script>
</body>
</html>
