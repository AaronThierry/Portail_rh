<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sécurisez votre compte — Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
        --ind:    #6366f1; --ind-dk: #4338ca; --ind-dkr: #312e81;
        --teal:   #14b8a6; --teal-dk:#0d9488;
        --green:  #10b981; --red: #ef4444; --amber: #f59e0b;
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
        content:'';position:fixed;inset:0;
        background-image:linear-gradient(rgba(99,102,241,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(99,102,241,.04) 1px,transparent 1px);
        background-size:44px 44px;pointer-events:none;z-index:0;
    }

    .au-orbs{position:fixed;inset:0;pointer-events:none;z-index:0;}
    .au-orb{position:absolute;border-radius:50%;filter:blur(90px);}
    .au-orb-1{width:500px;height:500px;background:var(--ind);opacity:.32;top:-150px;right:-90px;animation:au-float 22s ease-in-out infinite;}
    .au-orb-2{width:400px;height:400px;background:var(--teal);opacity:.22;bottom:-120px;left:-70px;animation:au-float 28s ease-in-out infinite reverse;animation-delay:-8s;}
    .au-orb-3{width:260px;height:260px;background:var(--ind-dk);opacity:.13;top:45%;left:35%;animation:au-float 18s ease-in-out infinite;animation-delay:-4s;}
    @keyframes au-float{0%,100%{transform:translate(0,0) scale(1);}25%{transform:translate(22px,-22px) scale(1.03);}50%{transform:translate(-16px,16px) scale(.97);}75%{transform:translate(16px,22px) scale(1.01);}}

    .au-wrap-outer{width:100%;max-width:480px;position:relative;z-index:1;}

    .au-card{background:#fff;border-radius:28px;box-shadow:0 30px 90px rgba(0,0,0,.3);overflow:hidden;animation:au-enter .55s cubic-bezier(.16,1,.3,1);}
    @keyframes au-enter{from{opacity:0;transform:translateY(32px) scale(.96);}to{opacity:1;transform:translateY(0) scale(1);}}

    /* Header */
    .au-head{background:linear-gradient(135deg,var(--ind-dkr) 0%,var(--ind-dk) 50%,var(--teal-dk) 100%);padding:2rem 2rem 1.75rem;text-align:center;position:relative;overflow:hidden;}
    .au-head::before{content:'';position:absolute;top:-60%;right:-40%;width:80%;height:200%;background:radial-gradient(circle,rgba(255,255,255,.14) 0%,transparent 65%);pointer-events:none;}
    .au-head::after{content:'';position:absolute;inset:0;background:linear-gradient(105deg,transparent 40%,rgba(255,255,255,.08) 50%,transparent 60%);transform:translateX(-100%);animation:au-shimmer 3.5s ease-in-out infinite;}
    @keyframes au-shimmer{0%{transform:translateX(-100%)}100%{transform:translateX(220%)}}

    /* Badge */
    .au-badge{display:inline-flex;align-items:center;gap:.5rem;background:rgba(255,255,255,.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.25);padding:.3125rem .875rem;border-radius:20px;margin-bottom:1.125rem;position:relative;z-index:1;}
    .au-badge-dot{width:6px;height:6px;border-radius:50%;background:#fff;animation:badge-pulse 2s ease-in-out infinite;}
    @keyframes badge-pulse{0%,100%{opacity:1;}50%{opacity:.35;}}
    .au-badge span{font-family:'DM Mono',monospace;font-size:.6875rem;font-weight:500;color:#fff;letter-spacing:.06em;text-transform:uppercase;}

    .au-icon{width:64px;height:64px;background:rgba(255,255,255,.18);backdrop-filter:blur(10px);border-radius:18px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;position:relative;z-index:1;}
    .au-icon svg{width:32px;height:32px;color:#fff;}
    .au-head h1{font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:700;color:#fff;margin-bottom:.35rem;position:relative;z-index:1;}
    .au-head p{font-size:.875rem;color:rgba(255,255,255,.85);line-height:1.55;position:relative;z-index:1;max-width:320px;margin:0 auto;}

    /* Body */
    .au-body{padding:2rem;}

    .au-alert{display:flex;align-items:center;gap:.75rem;padding:1rem;border-radius:12px;margin-bottom:1.25rem;font-size:.875rem;font-weight:500;}
    .au-alert svg{width:18px;height:18px;flex-shrink:0;}
    .au-alert-warn{background:#FEF3C7;color:#92400E;border:1px solid #FDE68A;}
    .au-alert-err{background:#FEE2E2;color:#991B1B;border:1px solid #FCA5A5;}

    .au-group{margin-bottom:1.25rem;}
    .au-label{display:block;font-size:.8125rem;font-weight:600;color:var(--tx);margin-bottom:.5rem;}
    .au-wrap{position:relative;}
    .au-ico{position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:#94a3b8;pointer-events:none;transition:color .25s;}
    .au-ico svg{width:18px;height:18px;}
    .au-input{width:100%;padding:.9375rem 3rem .9375rem 3rem;font-family:'DM Sans',sans-serif;font-size:.9375rem;font-weight:500;color:var(--tx);background:var(--bg);border:2px solid var(--br);border-radius:13px;outline:none;transition:border-color .25s,box-shadow .25s,background .25s;}
    .au-input:focus{border-color:var(--ind);background:#fff;box-shadow:0 0 0 4px rgba(99,102,241,.1);}
    .au-input.is-error{border-color:var(--red);box-shadow:0 0 0 3px rgba(239,68,68,.08);}
    .au-wrap:focus-within .au-ico{color:var(--ind);}
    .au-input::placeholder{color:#9ca3af;}

    .au-eye{position:absolute;right:.875rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;padding:.25rem;border-radius:6px;transition:color .2s;}
    .au-eye:hover{color:var(--ind);}
    .au-eye svg{width:18px;height:18px;}

    .au-field-err{font-size:.75rem;color:var(--red);margin-top:.375rem;display:none;}
    .au-field-err.show{display:block;}

    /* Strength bar */
    .strength-wrap{margin-top:.625rem;}
    .strength-bar{height:3px;background:rgba(0,0,0,.07);border-radius:2px;overflow:hidden;margin-bottom:.375rem;}
    .strength-fill{height:100%;width:0%;border-radius:2px;transition:width .35s ease,background .35s ease;}
    .strength-lbl{font-family:'DM Mono',monospace;font-size:.6875rem;font-weight:500;letter-spacing:.03em;color:var(--mt);transition:color .3s;}

    /* Requirements */
    .au-reqs{background:var(--bg);border:1px solid var(--br);border-radius:12px;padding:1rem 1.125rem;margin-bottom:1.5rem;}
    .au-reqs-title{font-family:'DM Mono',monospace;font-size:.6875rem;font-weight:600;color:var(--mt);letter-spacing:.08em;text-transform:uppercase;margin-bottom:.875rem;}
    .au-req{display:flex;align-items:center;gap:.75rem;font-size:.8125rem;color:var(--mt);margin-bottom:.625rem;transition:color .25s;}
    .au-req:last-child{margin-bottom:0;}
    .req-dot{width:16px;height:16px;border-radius:50%;border:1.5px solid #cbd5e1;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background .25s,border-color .25s;}
    .req-dot svg{width:9px;height:9px;stroke:transparent;transition:stroke .25s;}
    .au-req.valid{color:var(--tx);}
    .au-req.valid .req-dot{background:rgba(99,102,241,.15);border-color:rgba(99,102,241,.45);}
    .au-req.valid .req-dot svg{stroke:var(--ind);}

    /* Submit */
    .au-btn{width:100%;padding:1rem;font-family:'DM Sans',sans-serif;font-size:1rem;font-weight:700;color:#fff;background:linear-gradient(135deg,var(--ind) 0%,var(--ind-dk) 100%);border:none;border-radius:13px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.625rem;transition:transform .25s,box-shadow .25s;box-shadow:0 8px 24px rgba(99,102,241,.35);position:relative;overflow:hidden;}
    .au-btn::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,var(--ind-dk) 0%,var(--ind-dkr) 100%);opacity:0;transition:opacity .3s;}
    .au-btn:hover::before{opacity:1;}
    .au-btn:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(99,102,241,.45);}
    .au-btn:active{transform:translateY(0);}
    .au-btn:disabled{opacity:.55;cursor:not-allowed;transform:none;box-shadow:0 8px 24px rgba(99,102,241,.2);}
    .au-btn>*{position:relative;z-index:1;}
    .au-btn svg{width:18px;height:18px;flex-shrink:0;}

    /* Footer */
    .au-foot{padding:1.25rem 2rem;text-align:center;}
    .au-logout{display:inline-flex;align-items:center;gap:.5rem;font-size:.875rem;font-weight:500;color:var(--mt);text-decoration:none;padding:.625rem .875rem;border-radius:10px;background:none;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;transition:color .2s,background .2s;}
    .au-logout:hover{color:var(--tx);background:var(--bg);}
    .au-logout svg{width:16px;height:16px;}

    @media(max-width:520px){
        .au-card{border-radius:22px;}.au-head{padding:1.5rem 1.5rem 1.25rem;}.au-body{padding:1.5rem;}.au-foot{padding:1rem 1.5rem;}
    }
    </style>
</head>
<body>

    <div class="au-orbs">
        <div class="au-orb au-orb-1"></div>
        <div class="au-orb au-orb-2"></div>
        <div class="au-orb au-orb-3"></div>
    </div>

    <div class="au-wrap-outer">
        <div class="au-card">

            <div class="au-head">
                <div class="au-badge">
                    <div class="au-badge-dot"></div>
                    <span>Première connexion</span>
                </div>
                <div class="au-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </div>
                <h1>Sécurisez votre compte</h1>
                <p>Vous utilisez un mot de passe temporaire. Définissez votre mot de passe permanent pour accéder à votre espace.</p>
            </div>

            <div class="au-body">

                @if(session('warning'))
                <div class="au-alert au-alert-warn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    <span>{{ session('warning') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="au-alert au-alert-err">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
                </div>
                @endif

                <form action="{{ route('password.update-first') }}" method="POST" id="vaultForm" novalidate>
                    @csrf

                    <!-- Nouveau mot de passe -->
                    <div class="au-group">
                        <label for="new_password" class="au-label">Nouveau mot de passe</label>
                        <div class="au-wrap">
                            <input type="password" id="new_password" name="new_password"
                                   class="au-input @error('new_password') is-error @enderror"
                                   placeholder="Minimum 8 caractères"
                                   autocomplete="new-password" autofocus required>
                            <span class="au-ico">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                            </span>
                            <button type="button" class="au-eye" onclick="togglePwd('new_password','eye-np')" aria-label="Afficher">
                                <svg id="eye-np" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        <span class="au-field-err @error('new_password') show @enderror" id="err-np">
                            @error('new_password'){{ $message }}@enderror
                        </span>
                        <div class="strength-wrap" id="strength-wrap" style="display:none;">
                            <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
                            <span class="strength-lbl" id="strength-lbl"></span>
                        </div>
                    </div>

                    <!-- Confirmation -->
                    <div class="au-group">
                        <label for="new_password_confirmation" class="au-label">Confirmer le mot de passe</label>
                        <div class="au-wrap">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                   class="au-input" placeholder="Retapez votre mot de passe"
                                   autocomplete="new-password" required>
                            <span class="au-ico">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                            </span>
                            <button type="button" class="au-eye" onclick="togglePwd('new_password_confirmation','eye-nc')" aria-label="Afficher">
                                <svg id="eye-nc" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        <span class="au-field-err" id="err-nc"></span>
                    </div>

                    <!-- Requirements -->
                    <div class="au-reqs">
                        <div class="au-reqs-title">Règles du mot de passe</div>
                        <div class="au-req" id="req-length">
                            <div class="req-dot"><svg viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                            <span>Au moins 8 caractères</span>
                        </div>
                        <div class="au-req" id="req-upper">
                            <div class="req-dot"><svg viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                            <span>Une lettre majuscule</span>
                        </div>
                        <div class="au-req" id="req-lower">
                            <div class="req-dot"><svg viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                            <span>Une lettre minuscule</span>
                        </div>
                        <div class="au-req" id="req-digit">
                            <div class="req-dot"><svg viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                            <span>Un chiffre</span>
                        </div>
                        <div class="au-req" id="req-special">
                            <div class="req-dot"><svg viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                            <span>Un caractère spécial (@, #, !, &hellip;)</span>
                        </div>
                    </div>

                    <button type="submit" class="au-btn" id="submitBtn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <span>Définir mon mot de passe permanent</span>
                    </button>
                </form>
            </div>

            <div class="au-foot">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                <button class="au-logout"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Me déconnecter
                </button>
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

    const COLORS = ['#ef4444','#f97316','#eab308','#84cc16','#6366f1','#14b8a6'];
    const LABELS = ['Très faible','Faible','Moyen','Bien','Fort','Excellent'];

    const reqs = [
        { id:'req-length',  test: p => p.length >= 8 },
        { id:'req-upper',   test: p => /[A-Z]/.test(p) },
        { id:'req-lower',   test: p => /[a-z]/.test(p) },
        { id:'req-digit',   test: p => /\d/.test(p) },
        { id:'req-special', test: p => /[^A-Za-z0-9]/.test(p) },
    ];

    function calcScore(p) {
        let s = 0;
        if (p.length >= 8)          s++;
        if (p.length >= 12)         s++;
        if (/[A-Z]/.test(p))        s++;
        if (/[a-z]/.test(p))        s++;
        if (/\d/.test(p))           s++;
        if (/[^A-Za-z0-9]/.test(p)) s++;
        return s;
    }

    const pwdInp  = document.getElementById('new_password');
    const confInp = document.getElementById('new_password_confirmation');
    const fill    = document.getElementById('strength-fill');
    const lbl     = document.getElementById('strength-lbl');
    const wrap    = document.getElementById('strength-wrap');

    pwdInp.addEventListener('input', function() {
        const v = this.value;
        pwdInp.classList.remove('is-error');
        document.getElementById('err-np').classList.remove('show');

        if (!v) { wrap.style.display='none'; reqs.forEach(r => document.getElementById(r.id).classList.remove('valid')); return; }
        wrap.style.display = 'block';

        const score = calcScore(v);
        fill.style.width = Math.max((score/6)*100, 8) + '%';
        fill.style.background = COLORS[Math.min(score,5)];
        lbl.textContent = LABELS[Math.min(score,5)];
        lbl.style.color  = COLORS[Math.min(score,5)];

        reqs.forEach(r => document.getElementById(r.id).classList.toggle('valid', r.test(v)));
        if (confInp.value) checkConfirm();
    });

    function checkConfirm() {
        const err = document.getElementById('err-nc');
        if (confInp.value && pwdInp.value !== confInp.value) {
            confInp.classList.add('is-error');
            err.textContent = 'Les mots de passe ne correspondent pas';
            err.classList.add('show');
        } else {
            confInp.classList.remove('is-error');
            err.classList.remove('show');
        }
    }
    confInp.addEventListener('input', checkConfirm);

    document.getElementById('vaultForm').addEventListener('submit', function(e) {
        let ok = true;
        if (!pwdInp.value || pwdInp.value.length < 8) {
            pwdInp.classList.add('is-error');
            const err = document.getElementById('err-np');
            err.textContent = pwdInp.value ? 'Minimum 8 caractères requis' : 'Le mot de passe est requis';
            err.classList.add('show');
            ok = false;
        }
        if (pwdInp.value && confInp.value && pwdInp.value !== confInp.value) {
            confInp.classList.add('is-error');
            const err = document.getElementById('err-nc');
            err.textContent = 'Les mots de passe ne correspondent pas';
            err.classList.add('show');
            ok = false;
        }
        if (!ok) { e.preventDefault(); return; }
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg><span>Sécurisation en cours…</span>';
    });
    </script>
</body>
</html>
