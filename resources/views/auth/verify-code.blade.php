@extends('layouts.auth')

@section('title', 'Vérifier le code')
@section('heading', 'Saisissez le code reçu')
@section('lead', 'Nous venons d’envoyer un code à 6 chiffres à cette adresse :')

@section('content')
    <form method="POST" action="{{ route('password.verify.code') }}" id="otpForm" class="stack" novalidate data-lock="Vérification…">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="code" id="otpHidden">

        <span class="chip">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            {{ $email }}
        </span>

        @if(session('success'))
            <div class="alert alert-ok" role="status">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-err" role="alert">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <div class="field">
            <span class="label" id="otpLabel">Code de vérification</span>
            <div class="otp" id="otpBoxes" role="group" aria-labelledby="otpLabel">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                           aria-label="Chiffre {{ $i + 1 }} sur 6"
                           autocomplete="{{ $i === 0 ? 'one-time-code' : 'off' }}"
                           {{ $i === 0 ? 'data-autofocus=always' : '' }}>
                @endfor
            </div>
            <span class="hint" id="timerLine">Le code reste valable <strong id="timer">10:00</strong>.</span>
        </div>

        <div class="row" style="justify-content: flex-start; gap: 6px">
            <span class="hint">Rien reçu ?</span>
            <button type="button" class="text-btn" id="resendBtn">Renvoyer un code</button>
        </div>
        <p class="hint" id="resendMsg" role="status" aria-live="polite"></p>

        <div class="spacer"></div>

        <div>
            <button type="submit" class="submit">Vérifier le code</button>
            <p class="center">
                <a href="{{ route('password.request') }}" class="link back">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                    Changer d’adresse e-mail
                </a>
            </p>
        </div>
    </form>
@endsection

@push('scripts')
<script>
(function () {
    var wrap   = document.getElementById('otpBoxes');
    var boxes  = Array.prototype.slice.call(wrap.querySelectorAll('input'));
    var hidden = document.getElementById('otpHidden');
    var form   = document.getElementById('otpForm');

    function sync() {
        hidden.value = boxes.map(function (b) { return b.value; }).join('');
        boxes.forEach(function (b) { b.classList.toggle('filled', b.value !== ''); });
        wrap.classList.remove('error');
    }
    function fill(from, digits) {
        digits.split('').forEach(function (d, j) { if (boxes[from + j]) boxes[from + j].value = d; });
        boxes[Math.min(from + digits.length, 5)].focus();
        sync();
        if (hidden.value.length === 6) form.requestSubmit ? form.requestSubmit() : form.submit();
    }

    boxes.forEach(function (box, i) {
        box.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && !box.value && i > 0) { boxes[i - 1].value = ''; boxes[i - 1].focus(); sync(); }
            if (e.key === 'ArrowLeft' && i > 0) boxes[i - 1].focus();
            if (e.key === 'ArrowRight' && i < 5) boxes[i + 1].focus();
        });
        box.addEventListener('input', function () {
            var digits = box.value.replace(/\D/g, '');
            box.value = '';
            if (digits.length > 1) { fill(i, digits.substring(0, 6 - i)); return; }   // remplissage automatique du code
            box.value = digits;
            if (digits && i < 5) boxes[i + 1].focus();
            sync();
            if (hidden.value.length === 6) form.requestSubmit ? form.requestSubmit() : form.submit();
        });
        box.addEventListener('paste', function (e) {
            e.preventDefault();
            fill(i, (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').substring(0, 6 - i));
        });
    });

    form.addEventListener('submit', function (e) {
        if (hidden.value.length !== 6) {
            e.preventDefault();
            wrap.classList.add('error');
            var empty = boxes.filter(function (b) { return !b.value; })[0] || boxes[0];
            empty.focus();
        }
    });

    // Compte à rebours de validité (10 minutes côté serveur)
    var timerLine = document.getElementById('timerLine');
    var left, tick;
    function startTimer() {
        clearInterval(tick);
        left = 600;
        timerLine.innerHTML = 'Le code reste valable <strong id="timer">10:00</strong>.';
        var timerEl = document.getElementById('timer');
        tick = setInterval(function () {
            left--;
            if (left <= 0) {
                clearInterval(tick);
                timerLine.textContent = 'Ce code a expiré. Demandez-en un nouveau.';
                return;
            }
            timerEl.textContent = Math.floor(left / 60) + ':' + String(left % 60).padStart(2, '0');
        }, 1000);
    }
    startTimer();

    // Renvoyer un code
    var resendBtn = document.getElementById('resendBtn');
    var resendMsg = document.getElementById('resendMsg');
    resendBtn.addEventListener('click', function () {
        resendBtn.disabled = true;
        resendBtn.textContent = 'Envoi…';
        fetch(@json(route('password.resend')), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email: @json($email) })
        })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            resendMsg.textContent = d.success ? 'Un nouveau code vient d’être envoyé.' : (d.message || 'L’envoi a échoué. Réessayez dans un instant.');
            if (d.success) startTimer();
        })
        .catch(function () { resendMsg.textContent = 'L’envoi a échoué. Vérifiez votre connexion et réessayez.'; })
        .finally(function () {
            // Petite pause avant de pouvoir redemander un code
            setTimeout(function () { resendBtn.disabled = false; resendBtn.textContent = 'Renvoyer un code'; }, 30000);
        });
    });
})();
</script>
@endpush
