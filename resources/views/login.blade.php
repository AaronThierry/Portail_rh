<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion — Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
        --ind:    #6366f1;
        --ind-dk: #4338ca;
        --ind-dkr:#312e81;
        --teal:   #14b8a6;
        --teal-dk:#0d9488;
        --green:  #10b981;
        --red:    #ef4444;
        --tx:     #1e293b;
        --mt:     #64748b;
        --br:     #e2e8f0;
        --bg:     #f8fafc;
    }

    body {
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
        display: flex;
        background: linear-gradient(135deg, #0F172A 0%, #1E1B4B 55%, #0F172A 100%);
        position: relative;
        overflow-x: hidden;
    }

    /* ── Grid overlay ─────────────────────────────────── */
    body::before {
        content: '';
        position: fixed; inset: 0;
        background-image:
            linear-gradient(rgba(99,102,241,.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(99,102,241,.04) 1px, transparent 1px);
        background-size: 44px 44px;
        pointer-events: none; z-index: 0;
    }

    /* ── Orbs ─────────────────────────────────────────── */
    .au-orbs { position: fixed; inset: 0; pointer-events: none; z-index: 0; }
    .au-orb   { position: absolute; border-radius: 50%; filter: blur(90px); }
    .au-orb-1 { width:520px;height:520px;background:var(--ind);  opacity:.35;top:-160px;right:-100px;  animation:au-float 22s ease-in-out infinite; }
    .au-orb-2 { width:440px;height:440px;background:var(--teal); opacity:.22;bottom:-130px;left:-80px; animation:au-float 28s ease-in-out infinite reverse; animation-delay:-8s; }
    .au-orb-3 { width:280px;height:280px;background:var(--ind-dk);opacity:.14;top:48%;left:38%;       animation:au-float 18s ease-in-out infinite; animation-delay:-4s; }

    @keyframes au-float {
        0%,100% { transform:translate(0,0) scale(1); }
        25%      { transform:translate(25px,-25px) scale(1.04); }
        50%      { transform:translate(-18px,18px) scale(.96); }
        75%      { transform:translate(18px,25px) scale(1.02); }
    }

    /* ══════════════════════════════════════════════════
       LEFT PANEL — Branding
    ══════════════════════════════════════════════════ */
    .lp {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 3rem 2.5rem;
        position: relative; z-index: 1;
    }

    .lp-inner { max-width: 480px; text-align: center; }

    /* Logo */
    .lp-logo {
        width: 96px; height: 96px;
        background: linear-gradient(135deg, var(--ind) 0%, var(--ind-dk) 100%);
        border-radius: 28px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 2rem;
        box-shadow: 0 20px 60px rgba(99,102,241,.45);
        animation: logo-glow 3s ease-in-out infinite;
    }
    .lp-logo svg { width: 52px; height: 52px; color: #fff; }

    @keyframes logo-glow {
        0%,100% { box-shadow: 0 20px 60px rgba(99,102,241,.45); }
        50%      { box-shadow: 0 25px 80px rgba(99,102,241,.65); }
    }

    /* Title */
    .lp-title {
        font-family: 'Syne', sans-serif;
        font-size: 3rem; font-weight: 800;
        color: #fff; margin-bottom: .875rem;
        line-height: 1.1; letter-spacing: -.5px;
    }
    .lp-title span {
        background: linear-gradient(135deg, var(--ind) 0%, var(--teal) 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .lp-sub {
        font-size: 1.0625rem;
        color: rgba(255,255,255,.72);
        line-height: 1.7; margin-bottom: 2.75rem;
    }

    /* Feature items */
    .lp-features { display: flex; flex-direction: column; gap: .875rem; text-align: left; }

    .lp-feat {
        display: flex; align-items: center; gap: 1rem;
        padding: 1rem 1.375rem;
        background: rgba(255,255,255,.05);
        backdrop-filter: blur(12px);
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,.09);
        transition: background .3s, transform .3s;
    }
    .lp-feat:hover { background: rgba(255,255,255,.1); transform: translateX(8px); }

    .lp-feat-icon {
        width: 44px; height: 44px; border-radius: 13px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .lp-feat-icon.ind  { background: linear-gradient(135deg,var(--ind),var(--ind-dk)); }
    .lp-feat-icon.teal { background: linear-gradient(135deg,var(--teal),var(--teal-dk)); }

    .lp-feat-icon svg { width: 22px; height: 22px; color: #fff; }
    .lp-feat-txt { font-size: .9375rem; font-weight: 500; color: rgba(255,255,255,.9); }

    /* ══════════════════════════════════════════════════
       RIGHT PANEL — Card
    ══════════════════════════════════════════════════ */
    .rp {
        width: 520px; min-height: 100vh;
        display: flex; align-items: center; justify-content: center;
        padding: 2rem;
        position: relative; z-index: 1;
    }

    .au-card {
        width: 100%; max-width: 430px;
        background: #fff;
        border-radius: 28px;
        box-shadow: 0 30px 90px rgba(0,0,0,.32);
        overflow: hidden;
        animation: au-enter .55s cubic-bezier(.16,1,.3,1);
    }
    @keyframes au-enter {
        from { opacity:0; transform:translateY(36px) scale(.96); }
        to   { opacity:1; transform:translateY(0) scale(1); }
    }

    /* Card header */
    .au-head {
        background: linear-gradient(135deg, var(--ind-dkr) 0%, var(--ind-dk) 50%, var(--teal-dk) 100%);
        padding: 1.5rem 2rem 1.375rem;
        text-align: center;
        position: relative; overflow: hidden;
    }
    .au-head::before {
        content: '';
        position: absolute; top:-60%; right:-40%;
        width: 80%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,.14) 0%, transparent 65%);
        pointer-events: none;
    }
    .au-head::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,.08) 50%, transparent 60%);
        transform: translateX(-100%);
        animation: au-shimmer 3.5s ease-in-out infinite;
    }
    @keyframes au-shimmer {
        0%   { transform:translateX(-100%); }
        100% { transform:translateX(220%); }
    }

    .au-icon {
        width: 54px; height: 54px;
        background: rgba(255,255,255,.18);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto .75rem;
        position: relative; z-index: 1;
    }
    .au-icon svg { width: 27px; height: 27px; color: #fff; }

    .au-head h1 {
        font-family: 'Syne', sans-serif;
        font-size: 1.375rem; font-weight: 700; color: #fff;
        margin-bottom: .25rem;
        position: relative; z-index: 1;
    }
    .au-head p {
        font-size: .85rem; color: rgba(255,255,255,.88);
        line-height: 1.4; position: relative; z-index: 1;
    }

    /* Card body */
    .au-body { padding: 1.5rem; }

    /* Alerts */
    .au-alert {
        display: flex; align-items: center; gap: .75rem;
        padding: .75rem 1rem; border-radius: 12px;
        margin-bottom: 1rem;
        font-size: .875rem; font-weight: 500;
    }
    .au-alert svg { width: 18px; height: 18px; flex-shrink: 0; }
    .au-alert-ok  { background:#D1FAE5;color:#065F46;border:1px solid #6EE7B7; }
    .au-alert-err { background:#FEE2E2;color:#991B1B;border:1px solid #FCA5A5; }

    /* Form */
    .au-group { margin-bottom: 1rem; }
    .au-label {
        display: block; font-size: .8125rem; font-weight: 600;
        color: var(--tx); margin-bottom: .375rem;
    }
    .au-wrap { position: relative; }
    .au-ico {
        position: absolute; left: 1rem; top: 50%;
        transform: translateY(-50%);
        color: #94a3b8; pointer-events: none;
        transition: color .25s;
    }
    .au-ico svg { width: 18px; height: 18px; }
    .au-input {
        width: 100%;
        padding: .8125rem 1rem .8125rem 3rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .9375rem; font-weight: 500;
        color: var(--tx); background: var(--bg);
        border: 2px solid var(--br);
        border-radius: 13px; outline: none;
        transition: border-color .25s, box-shadow .25s, background .25s;
    }
    .au-input:focus {
        border-color: var(--ind); background: #fff;
        box-shadow: 0 0 0 4px rgba(99,102,241,.1);
    }
    .au-wrap:focus-within .au-ico { color: var(--ind); }
    .au-input::placeholder { color: #9ca3af; }

    .au-eye {
        position: absolute; right: .875rem; top: 50%;
        transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #94a3b8; padding: .25rem;
        border-radius: 6px; transition: color .2s;
    }
    .au-eye:hover { color: var(--ind); }
    .au-eye svg { width: 18px; height: 18px; }

    /* Options row */
    .au-opts {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.125rem;
    }
    .au-check { display: flex; align-items: center; gap: .5rem; cursor: pointer; }
    .au-check input { width: 17px; height: 17px; accent-color: var(--ind); cursor: pointer; }
    .au-check span { font-size: .875rem; color: var(--mt); font-weight: 500; }
    .au-forgot {
        font-size: .875rem; font-weight: 600;
        color: var(--ind); text-decoration: none;
        transition: color .2s;
    }
    .au-forgot:hover { color: var(--ind-dk); }

    /* Submit */
    .au-btn {
        width: 100%; padding: 1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 1rem; font-weight: 700; color: #fff;
        background: linear-gradient(135deg, var(--ind) 0%, var(--ind-dk) 100%);
        border: none; border-radius: 13px; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: .625rem;
        transition: transform .25s, box-shadow .25s;
        box-shadow: 0 8px 24px rgba(99,102,241,.35);
        position: relative; overflow: hidden;
    }
    .au-btn::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(135deg, var(--ind-dk) 0%, var(--ind-dkr) 100%);
        opacity: 0; transition: opacity .3s;
    }
    .au-btn:hover::before { opacity: 1; }
    .au-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(99,102,241,.45); }
    .au-btn:active { transform: translateY(0); }
    .au-btn > * { position: relative; z-index: 1; }
    .au-btn svg { width: 18px; height: 18px; transition: transform .25s; }
    .au-btn:hover svg { transform: translateX(4px); }

    /* Card footer */
    .au-foot {
        padding: .875rem 2rem;
        background: var(--bg); border-top: 1px solid var(--br);
        text-align: center;
        font-size: .8125rem; color: var(--mt);
    }
    .au-foot strong { color: var(--ind); font-weight: 700; }

    /* ── Responsive ───────────────────────────────────── */
    @media (max-width: 1024px) {
        .lp { display: none; }
        .rp { width: 100%; min-height: 100vh; }
    }
    @media (max-width: 480px) {
        .rp { padding: 1rem; }
        .au-card { border-radius: 22px; }
        .au-head { padding: 1.5rem 1.5rem 1.25rem; }
        .au-body { padding: 1.5rem; }
        .au-foot { padding: 1rem 1.5rem; }
    }
    </style>
</head>
<body>

    <!-- Orbs -->
    <div class="au-orbs">
        <div class="au-orb au-orb-1"></div>
        <div class="au-orb au-orb-2"></div>
        <div class="au-orb au-orb-3"></div>
    </div>

    <!-- ── Left Panel ──────────────────────────────────── -->
    <div class="lp">
        <div class="lp-inner">
            <div class="lp-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
            </div>
            <h1 class="lp-title">Portail <span>RH+</span></h1>
            <p class="lp-sub">La solution moderne et complète pour la gestion de vos ressources humaines.</p>
            <div class="lp-features">
                <div class="lp-feat">
                    <div class="lp-feat-icon ind">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <span class="lp-feat-txt">Gestion complète du personnel</span>
                </div>
                <div class="lp-feat">
                    <div class="lp-feat-icon teal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>
                    <span class="lp-feat-txt">Sécurité renforcée avec 2FA</span>
                </div>
                <div class="lp-feat">
                    <div class="lp-feat-icon ind">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <span class="lp-feat-txt">Gestion des congés et absences</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Right Panel — Login card ───────────────────── -->
    <div class="rp">
        <div class="au-card">

            <div class="au-head">
                <div class="au-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <h1>Bienvenue</h1>
                <p>Connectez-vous pour accéder à votre espace</p>
            </div>

            <div class="au-body">

                @if(session('success'))
                <div class="au-alert au-alert-ok">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="au-alert au-alert-err">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="au-group">
                        <label for="courrier" class="au-label">Adresse e-mail</label>
                        <div class="au-wrap">
                            <input type="email" id="courrier" name="courrier" class="au-input"
                                   value="{{ old('courrier') }}"
                                   placeholder="votre.email@entreprise.com"
                                   autocomplete="email" required autofocus>
                            <span class="au-ico">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="au-group">
                        <label for="password" class="au-label">Mot de passe</label>
                        <div class="au-wrap">
                            <input type="password" id="password" name="password" class="au-input"
                                   placeholder="Votre mot de passe"
                                   autocomplete="current-password"
                                   minlength="6" required
                                   style="padding-right:3rem;">
                            <span class="au-ico">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                            </span>
                            <button type="button" class="au-eye" onclick="togglePwd('password','eye-login')" aria-label="Afficher">
                                <svg id="eye-login" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="au-opts">
                        <label class="au-check">
                            <input type="checkbox" name="remember">
                            <span>Se souvenir de moi</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="au-forgot">Mot de passe oublié ?</a>
                    </div>

                    <button type="submit" class="au-btn">
                        <span>Se connecter</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </button>
                </form>
            </div>

            <div class="au-foot">
                &copy; {{ date('Y') }} <strong>Portail RH+</strong> &bull; Tous droits réservés
            </div>
        </div>
    </div>

    <script>
    function togglePwd(inputId, svgId) {
        const inp = document.getElementById(inputId);
        const svg = document.getElementById(svgId);
        const isHidden = inp.type === 'password';
        inp.type = isHidden ? 'text' : 'password';
        svg.innerHTML = isHidden
            ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
            : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
    </script>
</body>
</html>
