<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mot de passe oublié — Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
        --ind:    #6366f1; --ind-dk: #4338ca; --ind-dkr: #312e81;
        --teal:   #14b8a6; --teal-dk:#0d9488;
        --tx: #1e293b; --mt: #64748b; --br: #e2e8f0; --bg: #f8fafc;
    }

    body {
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #0F172A 0%, #1E1B4B 55%, #0F172A 100%);
        padding: 1.25rem;
        position: relative; overflow: hidden;
    }
    body::before {
        content: '';
        position: fixed; inset: 0;
        background-image:
            linear-gradient(rgba(99,102,241,.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(99,102,241,.04) 1px, transparent 1px);
        background-size: 44px 44px;
        pointer-events: none; z-index: 0;
    }

    .au-orbs { position: fixed; inset: 0; pointer-events: none; z-index: 0; }
    .au-orb   { position: absolute; border-radius: 50%; filter: blur(90px); }
    .au-orb-1 { width:480px;height:480px;background:var(--ind); opacity:.3; top:-140px;right:-90px;  animation:au-float 22s ease-in-out infinite; }
    .au-orb-2 { width:380px;height:380px;background:var(--teal);opacity:.2; bottom:-110px;left:-70px;animation:au-float 28s ease-in-out infinite reverse; animation-delay:-8s; }
    @keyframes au-float {
        0%,100% { transform:translate(0,0) scale(1); }
        25%      { transform:translate(22px,-22px) scale(1.03); }
        50%      { transform:translate(-16px,16px) scale(.97); }
        75%      { transform:translate(16px,22px) scale(1.01); }
    }

    .au-wrap-outer { width:100%; max-width:440px; position:relative; z-index:1; }

    /* Card */
    .au-card {
        background: #fff; border-radius: 28px;
        box-shadow: 0 30px 90px rgba(0,0,0,.3);
        overflow: hidden;
        animation: au-enter .55s cubic-bezier(.16,1,.3,1);
    }
    @keyframes au-enter {
        from { opacity:0; transform:translateY(32px) scale(.96); }
        to   { opacity:1; transform:translateY(0) scale(1); }
    }

    /* Header */
    .au-head {
        background: linear-gradient(135deg, var(--ind-dkr) 0%, var(--ind-dk) 50%, var(--teal-dk) 100%);
        padding: 2rem 2rem 1.75rem;
        text-align: center;
        position: relative; overflow: hidden;
    }
    .au-head::before {
        content: ''; position:absolute; top:-60%;right:-40%;
        width:80%;height:200%;
        background: radial-gradient(circle, rgba(255,255,255,.14) 0%, transparent 65%);
        pointer-events:none;
    }
    .au-head::after {
        content:''; position:absolute; inset:0;
        background:linear-gradient(105deg,transparent 40%,rgba(255,255,255,.08) 50%,transparent 60%);
        transform:translateX(-100%); animation:au-shimmer 3.5s ease-in-out infinite;
    }
    @keyframes au-shimmer { 0%{transform:translateX(-100%)} 100%{transform:translateX(220%)} }

    .au-icon {
        width:64px;height:64px;
        background:rgba(255,255,255,.18); backdrop-filter:blur(10px);
        border-radius:18px; display:flex; align-items:center; justify-content:center;
        margin:0 auto 1rem; position:relative; z-index:1;
    }
    .au-icon svg { width:32px;height:32px;color:#fff; }
    .au-head h1 {
        font-family:'Syne',sans-serif; font-size:1.375rem; font-weight:700; color:#fff;
        margin-bottom:.35rem; position:relative; z-index:1;
    }
    .au-head p { font-size:.875rem;color:rgba(255,255,255,.88);line-height:1.5;position:relative;z-index:1; }

    /* Body */
    .au-body { padding:2rem; }

    /* Alerts */
    .au-alert {
        display:flex;align-items:center;gap:.75rem;
        padding:1rem;border-radius:12px;margin-bottom:1.25rem;
        font-size:.875rem;font-weight:500;
    }
    .au-alert svg { width:18px;height:18px;flex-shrink:0; }
    .au-alert-ok  { background:#D1FAE5;color:#065F46;border:1px solid #6EE7B7; }
    .au-alert-err { background:#FEE2E2;color:#991B1B;border:1px solid #FCA5A5; }

    /* Info box */
    .au-info {
        display:flex;align-items:flex-start;gap:.75rem;
        padding:1rem;
        background:rgba(99,102,241,.06);
        border:1px solid rgba(99,102,241,.16);
        border-radius:12px; margin-bottom:1.5rem;
    }
    .au-info svg { width:18px;height:18px;color:var(--ind);flex-shrink:0;margin-top:.125rem; }
    .au-info p { font-size:.8125rem;color:var(--ind-dk);line-height:1.55; }

    /* Form */
    .au-group { margin-bottom:1.5rem; }
    .au-label { display:block;font-size:.8125rem;font-weight:600;color:var(--tx);margin-bottom:.5rem; }
    .au-wrap  { position:relative; }
    .au-ico   { position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:#94a3b8;pointer-events:none;transition:color .25s; }
    .au-ico svg { width:18px;height:18px; }
    .au-input {
        width:100%; padding:.9375rem 1rem .9375rem 3rem;
        font-family:'DM Sans',sans-serif; font-size:.9375rem; font-weight:500;
        color:var(--tx); background:var(--bg); border:2px solid var(--br);
        border-radius:13px; outline:none;
        transition:border-color .25s,box-shadow .25s,background .25s;
    }
    .au-input:focus { border-color:var(--ind);background:#fff;box-shadow:0 0 0 4px rgba(99,102,241,.1); }
    .au-wrap:focus-within .au-ico { color:var(--ind); }
    .au-input::placeholder { color:#9ca3af; }

    /* Submit */
    .au-btn {
        width:100%; padding:1rem;
        font-family:'DM Sans',sans-serif; font-size:1rem; font-weight:700; color:#fff;
        background:linear-gradient(135deg,var(--ind) 0%,var(--ind-dk) 100%);
        border:none; border-radius:13px; cursor:pointer;
        display:flex; align-items:center; justify-content:center; gap:.625rem;
        transition:transform .25s,box-shadow .25s;
        box-shadow:0 8px 24px rgba(99,102,241,.35);
        position:relative; overflow:hidden; margin-bottom:1.125rem;
    }
    .au-btn::before { content:'';position:absolute;inset:0;background:linear-gradient(135deg,var(--ind-dk) 0%,var(--ind-dkr) 100%);opacity:0;transition:opacity .3s; }
    .au-btn:hover::before { opacity:1; }
    .au-btn:hover { transform:translateY(-2px);box-shadow:0 12px 32px rgba(99,102,241,.45); }
    .au-btn:active { transform:translateY(0); }
    .au-btn > * { position:relative;z-index:1; }
    .au-btn svg { width:18px;height:18px;transition:transform .25s; }
    .au-btn:hover svg { transform:translateX(4px); }

    /* Back link */
    .au-back {
        display:flex;align-items:center;justify-content:center;gap:.5rem;
        font-size:.875rem;font-weight:600;color:var(--ind);text-decoration:none;
        padding:.75rem;border-radius:11px;transition:background .2s,color .2s;
    }
    .au-back:hover { background:rgba(99,102,241,.07);color:var(--ind-dk); }
    .au-back svg { width:17px;height:17px; }

    /* Footer */
    .au-foot {
        padding:1.25rem 2rem; background:var(--bg);border-top:1px solid var(--br);
        text-align:center; font-size:.8125rem;color:var(--mt);
    }
    .au-foot strong { color:var(--ind);font-weight:700; }

    @media (max-width:480px) {
        .au-card{border-radius:22px;} .au-head{padding:1.5rem 1.5rem 1.25rem;} .au-body{padding:1.5rem;} .au-foot{padding:1rem 1.5rem;}
    }
    </style>
</head>
<body>

    <div class="au-orbs">
        <div class="au-orb au-orb-1"></div>
        <div class="au-orb au-orb-2"></div>
    </div>

    <div class="au-wrap-outer">
        <div class="au-card">

            <div class="au-head">
                <div class="au-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
                <h1>Mot de passe oublié ?</h1>
                <p>Entrez votre e-mail pour recevoir un code de réinitialisation</p>
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

                <div class="au-info">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <p>Un code de vérification sera envoyé à votre adresse e-mail. Vérifiez également vos spams.</p>
                </div>

                <form method="POST" action="{{ route('password.send.code') }}">
                    @csrf
                    <div class="au-group">
                        <label for="email" class="au-label">Adresse e-mail</label>
                        <div class="au-wrap">
                            <input type="email" id="email" name="email" class="au-input"
                                   value="{{ old('email') }}"
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

                    <button type="submit" class="au-btn">
                        <span>Envoyer le code</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                    </button>

                    <a href="{{ route('login') }}" class="au-back">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Retour à la connexion
                    </a>
                </form>
            </div>

            <div class="au-foot">
                &copy; {{ date('Y') }} <strong>Portail RH+</strong> &bull; Tous droits réservés
            </div>
        </div>
    </div>

</body>
</html>
