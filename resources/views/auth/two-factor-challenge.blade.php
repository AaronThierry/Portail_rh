<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vérification 2FA — Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
        --ind:    #6366f1; --ind-dk: #4338ca; --ind-dkr: #312e81;
        --teal:   #14b8a6; --teal-dk:#0d9488;
        --green:  #10b981; --red: #ef4444;
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
        content:''; position:fixed; inset:0;
        background-image:linear-gradient(rgba(99,102,241,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(99,102,241,.04) 1px,transparent 1px);
        background-size:44px 44px; pointer-events:none; z-index:0;
    }

    .au-orbs{position:fixed;inset:0;pointer-events:none;z-index:0;}
    .au-orb{position:absolute;border-radius:50%;filter:blur(90px);}
    .au-orb-1{width:480px;height:480px;background:var(--ind);opacity:.3;top:-140px;right:-90px;animation:au-float 22s ease-in-out infinite;}
    .au-orb-2{width:380px;height:380px;background:var(--teal);opacity:.2;bottom:-110px;left:-70px;animation:au-float 28s ease-in-out infinite reverse;animation-delay:-8s;}
    @keyframes au-float{0%,100%{transform:translate(0,0) scale(1);}25%{transform:translate(22px,-22px) scale(1.03);}50%{transform:translate(-16px,16px) scale(.97);}75%{transform:translate(16px,22px) scale(1.01);}}

    .au-page-wrap{width:100%;max-width:440px;position:relative;z-index:1;}

    .au-card{background:#fff;border-radius:28px;box-shadow:0 30px 90px rgba(0,0,0,.3);overflow:hidden;animation:au-enter .55s cubic-bezier(.16,1,.3,1);}
    @keyframes au-enter{from{opacity:0;transform:translateY(32px) scale(.96);}to{opacity:1;transform:translateY(0) scale(1);}}

    /* Header */
    .au-head{background:linear-gradient(135deg,var(--ind-dkr) 0%,var(--ind-dk) 50%,var(--teal-dk) 100%);padding:2rem 2rem 1.75rem;text-align:center;position:relative;overflow:hidden;}
    .au-head::before{content:'';position:absolute;top:-60%;right:-40%;width:80%;height:200%;background:radial-gradient(circle,rgba(255,255,255,.14) 0%,transparent 65%);pointer-events:none;}
    .au-head::after{content:'';position:absolute;inset:0;background:linear-gradient(105deg,transparent 40%,rgba(255,255,255,.08) 50%,transparent 60%);transform:translateX(-100%);animation:au-shimmer 3.5s ease-in-out infinite;}
    @keyframes au-shimmer{0%{transform:translateX(-100%)}100%{transform:translateX(220%)}}

    .au-icon{width:72px;height:72px;background:rgba(255,255,255,.18);backdrop-filter:blur(10px);border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;position:relative;z-index:1;}
    /* Pulsing border ring around icon */
    .au-icon::after{content:'';position:absolute;inset:-5px;border:2px solid rgba(255,255,255,.28);border-radius:25px;animation:ring-pulse 2s ease-in-out infinite;}
    @keyframes ring-pulse{0%,100%{transform:scale(1);opacity:1;}50%{transform:scale(1.08);opacity:.4;}}
    .au-icon svg{width:36px;height:36px;color:#fff;}
    .au-head h1{font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:700;color:#fff;margin-bottom:.35rem;position:relative;z-index:1;}
    .au-head p{font-size:.875rem;color:rgba(255,255,255,.88);line-height:1.55;position:relative;z-index:1;}

    /* Body */
    .au-body{padding:2rem;}

    .au-alert{display:flex;align-items:center;gap:.75rem;padding:1rem;border-radius:12px;margin-bottom:1.5rem;font-size:.875rem;font-weight:500;animation:shake .5s ease;}
    @keyframes shake{0%,100%{transform:translateX(0);}25%{transform:translateX(-5px);}75%{transform:translateX(5px);}}
    .au-alert svg{width:18px;height:18px;flex-shrink:0;}
    .au-alert-err{background:#FEE2E2;color:#991B1B;border:1px solid #FCA5A5;}

    /* OTP section */
    .otp-label{display:block;font-size:.9rem;font-weight:600;color:var(--tx);margin-bottom:.875rem;text-align:center;}

    /* Big single input */
    .otp-big-wrap{position:relative;margin-bottom:.875rem;}
    .otp-big {
        width:100%; padding:1.25rem;
        font-family:'DM Mono',monospace;
        font-size:2rem;font-weight:600;
        text-align:center;letter-spacing:.75rem;
        color:var(--tx); background:var(--bg);
        border:2.5px solid var(--br);
        border-radius:16px; outline:none;
        transition:border-color .25s,box-shadow .25s,background .25s;
        caret-color: var(--ind);
    }
    .otp-big:focus{border-color:var(--ind);background:#fff;box-shadow:0 0 0 4px rgba(99,102,241,.12);}
    .otp-big.valid{border-color:var(--teal);background:rgba(20,184,166,.04);}
    .otp-big.invalid{border-color:var(--red);animation:shake .4s ease;}
    .otp-big::placeholder{color:#cbd5e1;letter-spacing:.5rem;}

    /* Dot indicators */
    .otp-dots{display:flex;justify-content:center;gap:.5rem;margin-bottom:1rem;}
    .otp-dot{width:9px;height:9px;border-radius:50%;background:var(--br);transition:background .2s,transform .2s,box-shadow .2s;}
    .otp-dot.on{background:linear-gradient(135deg,var(--ind),var(--teal));transform:scale(1.25);box-shadow:0 2px 8px rgba(99,102,241,.4);}

    /* Timer hint */
    .otp-hint{display:flex;align-items:center;justify-content:center;gap:.5rem;font-size:.8125rem;color:var(--mt);margin-bottom:1.5rem;}
    .otp-hint svg{width:15px;height:15px;color:var(--teal);}

    /* Submit */
    .au-btn{width:100%;padding:1rem;font-family:'DM Sans',sans-serif;font-size:1rem;font-weight:700;color:#fff;background:linear-gradient(135deg,var(--ind) 0%,var(--ind-dk) 100%);border:none;border-radius:13px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.625rem;transition:transform .25s,box-shadow .25s;box-shadow:0 8px 24px rgba(99,102,241,.35);position:relative;overflow:hidden;margin-bottom:1rem;}
    .au-btn::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,var(--ind-dk) 0%,var(--ind-dkr) 100%);opacity:0;transition:opacity .3s;}
    .au-btn:hover:not(:disabled)::before{opacity:1;}
    .au-btn:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 12px 32px rgba(99,102,241,.45);}
    .au-btn:active{transform:translateY(0);}
    .au-btn:disabled{opacity:.55;cursor:not-allowed;}
    .au-btn>*{position:relative;z-index:1;}
    .au-btn .spinner{width:18px;height:18px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;display:none;flex-shrink:0;}
    @keyframes spin{to{transform:rotate(360deg)}}
    .au-btn.loading .spinner{display:block;}
    .au-btn.loading .btn-txt{display:none;}
    .au-btn svg.check-ic{width:18px;height:18px;}

    /* Footer */
    .au-foot{padding:1.25rem 2rem;background:var(--bg);border-top:1px solid var(--br);text-align:center;}
    .au-foot p{font-size:.8125rem;color:var(--mt);margin-bottom:.625rem;}
    .au-logout-btn{display:inline-flex;align-items:center;gap:.5rem;padding:.625rem 1rem;background:none;border:none;cursor:pointer;color:var(--ind);font-family:'DM Sans',sans-serif;font-size:.875rem;font-weight:600;border-radius:10px;transition:background .2s,color .2s;}
    .au-logout-btn:hover{background:rgba(99,102,241,.07);color:var(--ind-dk);}
    .au-logout-btn svg{width:17px;height:17px;}

    /* Info tip (below card) */
    .au-tip{
        margin-top:1.25rem;
        padding:.875rem 1rem;
        background:rgba(255,255,255,.06);
        backdrop-filter:blur(12px);
        border:1px solid rgba(255,255,255,.1);
        border-radius:14px;
        display:flex;align-items:center;gap:.75rem;
    }
    .au-tip svg{width:18px;height:18px;color:var(--teal);flex-shrink:0;}
    .au-tip span{font-size:.8125rem;color:rgba(255,255,255,.78);line-height:1.5;}

    @media(max-width:480px){
        .au-card{border-radius:22px;}.au-head{padding:1.5rem 1.5rem 1.25rem;}.au-body{padding:1.5rem;}.au-foot{padding:1rem 1.5rem;}
        .otp-big{font-size:1.5rem;letter-spacing:.5rem;}
    }
    </style>
</head>
<body>

    <div class="au-orbs">
        <div class="au-orb au-orb-1"></div>
        <div class="au-orb au-orb-2"></div>
    </div>

    <div class="au-page-wrap">
        <div class="au-card">

            <div class="au-head">
                <div class="au-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="M9 12l2 2 4-4"/>
                    </svg>
                </div>
                <h1>Vérification 2FA</h1>
                <p>Entrez le code à 6 chiffres de votre application d'authentification</p>
            </div>

            <div class="au-body">

                @if(session('error'))
                <div class="au-alert au-alert-err">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('two-factor.verify.login') }}" id="otpForm">
                    @csrf

                    <label class="otp-label">Code de vérification</label>

                    <div class="otp-big-wrap">
                        <input type="text" name="one_time_password" id="otpInput"
                               class="otp-big"
                               maxlength="6" pattern="[0-9]{6}"
                               placeholder="000000"
                               required autofocus autocomplete="off"
                               inputmode="numeric">
                    </div>

                    <div class="otp-dots" id="otpDots">
                        <div class="otp-dot" data-i="0"></div>
                        <div class="otp-dot" data-i="1"></div>
                        <div class="otp-dot" data-i="2"></div>
                        <div class="otp-dot" data-i="3"></div>
                        <div class="otp-dot" data-i="4"></div>
                        <div class="otp-dot" data-i="5"></div>
                    </div>

                    <div class="otp-hint">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span>Le code expire dans 30 secondes</span>
                    </div>

                    <button type="submit" class="au-btn" id="submitBtn" disabled>
                        <div class="spinner"></div>
                        <span class="btn-txt" style="display:flex;align-items:center;gap:.5rem;">
                            <svg class="check-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Vérifier
                        </span>
                    </button>
                </form>
            </div>

            <div class="au-foot">
                <p>Un problème avec le code ?</p>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="au-logout-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Se déconnecter
                    </button>
                </form>
            </div>
        </div>

        <!-- Info tip below card -->
        <div class="au-tip">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            <span>Ouvrez Google Authenticator, Authy ou votre application d'authentification pour obtenir le code.</span>
        </div>
    </div>

    <script>
    (function() {
        const input  = document.getElementById('otpInput');
        const btn    = document.getElementById('submitBtn');
        const form   = document.getElementById('otpForm');
        const dots   = document.querySelectorAll('.otp-dot');

        function updateDots(len) {
            dots.forEach((d, i) => d.classList.toggle('on', i < len));
        }

        input.addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '');
            e.target.value = v;
            updateDots(v.length);
            input.classList.remove('invalid');

            if (v.length === 6) {
                btn.disabled = false;
                input.classList.add('valid');
                // Auto-submit after brief delay
                setTimeout(() => {
                    if (input.value.length === 6) {
                        btn.classList.add('loading');
                        form.submit();
                    }
                }, 350);
            } else {
                btn.disabled = true;
                input.classList.remove('valid');
            }
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const nums = (e.clipboardData || window.clipboardData)
                .getData('text').replace(/\D/g, '').substring(0, 6);
            input.value = nums;
            updateDots(nums.length);
            if (nums.length === 6) {
                btn.disabled = false;
                input.classList.add('valid');
                setTimeout(() => { btn.classList.add('loading'); form.submit(); }, 350);
            }
        });

        input.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'v') return;
            if (['Backspace','Delete','ArrowLeft','ArrowRight','Tab'].includes(e.key)) return;
            if (!/^\d$/.test(e.key)) e.preventDefault();
        });

        form.addEventListener('submit', function(e) {
            if (input.value.length !== 6) {
                e.preventDefault();
                input.classList.add('invalid');
                input.focus();
            } else {
                btn.classList.add('loading');
            }
        });

        input.focus();
    })();
    </script>
</body>
</html>
