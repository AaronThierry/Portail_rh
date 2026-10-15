@extends('layouts.espace-employe')

@section('title', 'Assistance')

@section('styles')
<style>
    .as-grid { display: grid; gap: 28px; }
    @media (min-width: 1024px) { .as-grid { grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 40px; align-items: start; } }

    /* Assistant */
    .as-chat { display: flex; flex-direction: column; padding: 0; overflow: hidden; }
    .as-chat-head { display: flex; align-items: center; gap: 12px; padding: 16px 20px; border-bottom: 1px solid var(--line-soft); }
    .as-chat-head strong { display: block; font-size: 16px; }
    .as-chat-head span { font-size: 13px; color: var(--muted); }
    .as-msgs { display: flex; flex-direction: column; gap: 10px; padding: 16px 20px; height: 360px; overflow-y: auto; background: var(--page); }
    .as-b { max-width: 85%; padding: 10px 14px; border-radius: 18px; font-size: 15px; line-height: 1.5; overflow-wrap: anywhere; }
    .as-b.bot { align-self: flex-start; background: var(--surface, #fff); box-shadow: 0 0 0 1px var(--line-soft); border-bottom-left-radius: 6px; }
    .as-b.user { align-self: flex-end; background: var(--brand); color: #fff; border-bottom-right-radius: 6px; }
    .as-typing { display: none; align-self: flex-start; gap: 4px; padding: 14px; }
    .as-typing.on { display: flex; }
    .as-typing i { width: 7px; height: 7px; border-radius: 999px; background: var(--faint); animation: as-dot 1s infinite ease-in-out; }
    .as-typing i:nth-child(2) { animation-delay: .15s; } .as-typing i:nth-child(3) { animation-delay: .3s; }
    @keyframes as-dot { 0%, 80%, 100% { opacity: .3; } 40% { opacity: 1; } }
    .as-bar { display: flex; gap: 8px; padding: 12px; border-top: 1px solid var(--line-soft); background: var(--surface, #fff); }
    .as-bar textarea { flex: 1; min-height: 48px; max-height: 120px; padding: 12px 16px; resize: none; border-radius: 24px; }
    .as-send { width: 48px; height: 48px; flex-shrink: 0; border: 0; border-radius: 999px; background: var(--brand); color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; }
    .as-send[disabled] { opacity: .5; cursor: default; }
    .as-send svg { width: 20px; height: 20px; }

    /* Tickets */
    .as-ticket { border-top: 1px solid var(--line-soft); }
    .as-ticket:first-child { border-top: 0; }
    .as-ticket summary { list-style: none; cursor: pointer; }
    .as-ticket summary::-webkit-details-marker { display: none; }
    .as-ticket summary .rh-row { border-top: 0; }
    .as-ticket summary .chev { transition: transform .15s; color: var(--faint); }
    .as-ticket[open] summary .chev { transform: rotate(90deg); }
    .as-thread { display: flex; flex-direction: column; gap: 12px; padding: 4px 16px 16px; }
    .as-msg { display: flex; flex-direction: column; gap: 4px; max-width: 92%; }
    .as-msg.rh { align-self: flex-start; }
    .as-msg.moi { align-self: flex-end; text-align: right; }
    .as-msg small { font-size: 12px; color: var(--muted); }
    .as-msg p { margin: 0; padding: 10px 14px; border-radius: 16px; font-size: 14px; line-height: 1.5; white-space: pre-line; text-align: left; overflow-wrap: anywhere; }
    .as-msg.rh p { background: var(--brand-bg); color: #1e3a8a; }
    .as-msg.moi p { background: var(--subtle); }

    /* FAQ */
    .as-faq details { border-top: 1px solid var(--line-soft); }
    .as-faq details:first-child { border-top: 0; }
    .as-faq summary { list-style: none; cursor: pointer; padding: 16px; font-weight: 600; display: flex; justify-content: space-between; gap: 12px; }
    .as-faq summary::-webkit-details-marker { display: none; }
    .as-faq summary::after { content: '+'; color: var(--muted); font-weight: 400; font-size: 20px; line-height: 1; }
    .as-faq details[open] summary::after { content: '–'; }
    .as-faq details p { margin: 0; padding: 0 16px 16px; color: var(--ink-2); font-size: 14px; }
</style>
@endsection

@section('content')
@php
    $nbMessages = fn ($r) => $r->messages->count() + ($r->reponse ? 1 : 0);
@endphp

<div class="rh-page">
    <section class="rh-head">
        <div class="rh-head-txt">
            <h1 class="rh-h1">Assistance</h1>
            <p class="rh-lead">
                Posez votre question à l'assistant, ou écrivez directement au service RH.
                @if($stats['en_attente'] > 0) {{ $stats['en_attente'] }} demande{{ $stats['en_attente'] > 1 ? 's' : '' }} en cours de traitement. @endif
            </p>
        </div>
        <div class="rh-actions">
            <a href="#nouvelle" class="rh-btn ghost">Écrire au service RH</a>
        </div>
    </section>

    <div class="as-grid">
        <div class="rh-page" style="gap: 28px">
            {{-- ── Assistant IA ── --}}
            <section class="rh-card as-chat" aria-labelledby="titreIA">
                <div class="as-chat-head">
                    <span class="rh-ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>
                    <div>
                        <strong id="titreIA">Assistant RH</strong>
                        <span>Répond tout de suite. Si besoin, il transmet au service RH.</span>
                    </div>
                </div>
                <div class="as-msgs" id="chatMessages" role="log" aria-live="polite">
                    <div class="as-b bot">Bonjour {{ $personnel->prenoms ?? '' }}, que puis-je faire pour vous ? Congés, bulletins, attestations, mot de passe… posez votre question.</div>
                    <div class="as-typing" id="typingIndicator" aria-label="L'assistant écrit"><i></i><i></i><i></i></div>
                </div>
                <div class="as-bar">
                    <label for="chatInput" class="rh-sr">Votre question</label>
                    <textarea class="rh-textarea" id="chatInput" rows="1" maxlength="1000" placeholder="Votre question…"></textarea>
                    <button type="button" class="as-send" id="chatSend" aria-label="Envoyer">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 2 11 13M22 2l-7 20-4-9-9-4z"/></svg>
                    </button>
                </div>
            </section>

            {{-- ── FAQ ── --}}
            <section class="rh-section" aria-labelledby="titreFaq">
                <h2 class="rh-h2" id="titreFaq">Questions fréquentes</h2>
                <div class="rh-card-flat as-faq">
                    <details>
                        <summary>Comment poser un congé ?</summary>
                        <p>Dans <a href="{{ route('espace-employe.conges', ['nouveau' => 1]) }}">Congés</a>, choisissez « Poser un congé », le type et les dates. Votre responsable puis le service RH valident la demande ; vous êtes notifié à chaque étape.</p>
                    </details>
                    <details>
                        <summary>Où trouver mes bulletins de paie ?</summary>
                        <p>Dans <a href="{{ route('espace-employe.bulletins') }}">Documents › Bulletins de paie</a>, classés par année. Vous pouvez les consulter ou les télécharger en PDF.</p>
                    </details>
                    <details>
                        <summary>Comment déclarer une absence ?</summary>
                        <p>Dans <a href="{{ route('espace-employe.absences', ['nouveau' => 1]) }}">Absences</a>, choisissez « Déclarer une absence », indiquez la date, la durée et le motif. Vous pouvez joindre un justificatif tout de suite ou plus tard.</p>
                    </details>
                    <details>
                        <summary>Comment changer mon mot de passe ?</summary>
                        <p>Dans <a href="{{ route('espace-employe.parametres') }}">Profil › Sécurité du compte</a>. Il faut votre mot de passe actuel et un nouveau d'au moins 8 caractères.</p>
                    </details>
                    <details>
                        <summary>Combien de jours de congé me reste-t-il ?</summary>
                        <p>Votre solde est affiché sur l'<a href="{{ route('espace-employe.dashboard') }}">accueil</a> et dans <a href="{{ route('espace-employe.conges') }}">Congés</a>. En cas de doute, écrivez au service RH.</p>
                    </details>
                </div>
            </section>
        </div>

        <div class="rh-page" style="gap: 28px">
            {{-- ── Mes demandes ── --}}
            <section class="rh-section" aria-labelledby="titreTickets">
                <h2 class="rh-h2" id="titreTickets">Mes demandes</h2>
                @if($requetes->isEmpty())
                    <p class="rh-lead">Vous n'avez encore rien envoyé au service RH.</p>
                @else
                    <div class="rh-card-flat">
                        @foreach($requetes as $req)
                            <details class="as-ticket" id="ticket-{{ $req->id }}">
                                <summary>
                                    <div class="rh-row">
                                        <span class="rh-row-main">
                                            <span class="rh-row-title">{{ $req->sujet }}</span>
                                            <span class="rh-row-sub">
                                                {{ $req->created_at->format('d/m/Y') }} · {{ \App\Models\Requete::CATEGORIES[$req->categorie] ?? $req->categorie }}
                                                @if($req->priorite === 'urgente') · <strong style="color: var(--orange-tx)">urgente</strong>@endif
                                                @if($nbMessages($req) > 0) · {{ $nbMessages($req) }} réponse{{ $nbMessages($req) > 1 ? 's' : '' }}@endif
                                            </span>
                                        </span>
                                        @include('espace-employe.partials.statut', ['statut' => $req->statut])
                                        <svg class="chev" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                                    </div>
                                </summary>

                                <div class="as-thread">
                                    <div class="as-msg moi"><small>Vous · {{ $req->created_at->format('d/m/Y à H\hi') }}</small><p>{{ $req->message }}</p></div>
                                    @if($req->reponse)
                                        <div class="as-msg rh"><small>Service RH · {{ $req->repondu_le ? $req->repondu_le->format('d/m/Y à H\hi') : '' }}</small><p>{{ $req->reponse }}</p></div>
                                    @endif
                                    @foreach($req->messages as $msg)
                                        @php $isRH = $msg->isFromAdmin(); @endphp
                                        <div class="as-msg {{ $isRH ? 'rh' : 'moi' }}">
                                            <small>{{ $isRH ? 'Service RH' : 'Vous' }} · {{ $msg->created_at->format('d/m/Y à H\hi') }}</small>
                                            <p>{{ $msg->content }}</p>
                                        </div>
                                    @endforeach

                                    @if(!$req->isFermee())
                                        <form action="{{ route('espace-employe.assistance.repondre', $req) }}" method="POST" class="rh-form" data-lock="Envoi…" style="gap: 10px">
                                            @csrf
                                            <label for="reply-{{ $req->id }}" class="rh-sr">Votre réponse</label>
                                            <textarea name="message_reply" id="reply-{{ $req->id }}" class="rh-textarea" rows="3" maxlength="3000" required placeholder="Votre réponse…"></textarea>
                                            <div><button type="submit" class="rh-btn sm">Répondre</button></div>
                                        </form>
                                        @if($req->statut === 'repondue')
                                            <form action="{{ route('espace-employe.assistance.fermer', $req) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="rh-link">Ma question est résolue, fermer la demande</button>
                                            </form>
                                        @endif
                                    @else
                                        <p class="rh-hint">Demande fermée. Pour une nouvelle question, écrivez une nouvelle demande.</p>
                                    @endif
                                </div>
                            </details>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- ── Nouvelle demande ── --}}
            <section class="rh-card rh-section" id="nouvelle" aria-labelledby="titreNouvelle">
                <h2 class="rh-h2" id="titreNouvelle">Écrire au service RH</h2>
                <form action="{{ route('espace-employe.assistance.store') }}" method="POST" class="rh-form" data-lock="Envoi…">
                    @csrf
                    @if($errors->any())
                        <div class="rh-alert err" role="alert">{{ $errors->first() }}</div>
                    @endif
                    <div class="rh-field">
                        <label for="sujet">Sujet</label>
                        <input type="text" name="sujet" id="sujet" class="rh-input" value="{{ old('sujet') }}" required maxlength="255" placeholder="Ex. erreur sur mon bulletin d'août">
                    </div>
                    <div class="rh-grid2">
                        <div class="rh-field">
                            <label for="categorie">Catégorie</label>
                            <select name="categorie" id="categorie" class="rh-select" required>
                                @foreach(\App\Models\Requete::CATEGORIES as $k => $v)
                                    <option value="{{ $k }}" {{ old('categorie', 'question') === $k ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="rh-field">
                            <label for="priorite">Priorité</label>
                            <select name="priorite" id="priorite" class="rh-select" required>
                                @foreach(\App\Models\Requete::PRIORITES as $k => $v)
                                    <option value="{{ $k }}" {{ old('priorite', 'normale') === $k ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="rh-field">
                        <label for="message">Message</label>
                        <textarea name="message" id="message" class="rh-textarea" rows="5" required maxlength="3000">{{ old('message') }}</textarea>
                        <span class="rh-hint" id="charCount" aria-live="polite">0 / 3000</span>
                    </div>
                    <div><button type="submit" class="rh-btn">Envoyer</button></div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    'use strict';
    var csrf = document.querySelector('meta[name="csrf-token"]').content;

    /* ── Compteur de caractères ── */
    var msg = document.getElementById('message'), cnt = document.getElementById('charCount');
    function count() { cnt.textContent = msg.value.length + ' / 3000'; }
    msg.addEventListener('input', count); count();

    /* ── Ouvrir le ticket ciblé (#ticket-12) ── */
    if (location.hash.indexOf('#ticket-') === 0) {
        var t = document.querySelector(location.hash);
        if (t) { t.open = true; setTimeout(function () { t.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 150); }
    }

    /* ── Assistant IA ── */
    var history = [], ticketCreated = false;
    var box = document.getElementById('chatMessages'), typing = document.getElementById('typingIndicator');
    var input = document.getElementById('chatInput'), send = document.getElementById('chatSend');

    function bubble(role, text) {
        var b = document.createElement('div');
        b.className = 'as-b ' + (role === 'user' ? 'user' : 'bot');
        var safe = String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        b.innerHTML = safe.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>').replace(/\n/g, '<br>');
        box.insertBefore(b, typing);
        box.scrollTop = box.scrollHeight;
    }
    function setTyping(on) { typing.classList.toggle('on', on); box.scrollTop = box.scrollHeight; }

    input.addEventListener('input', function () { input.style.height = 'auto'; input.style.height = Math.min(input.scrollHeight, 120) + 'px'; });
    input.addEventListener('keydown', function (e) { if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendChat(); } });
    send.addEventListener('click', sendChat);

    function post(url, body) {
        return fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify(body)
        });
    }

    function createTicket(sujet, categorie, priorite) {
        if (ticketCreated) return;
        ticketCreated = true;
        var message = history.map(function (m) { return (m.role === 'user' ? 'Moi : ' : 'Assistant : ') + m.content; }).join('\n\n').substring(0, 3000);
        post(@json(route('espace-employe.assistance.chat.ticket')), { sujet: sujet || 'Demande via l\'assistant', categorie: categorie, priorite: priorite, message: message })
            .then(function (r) { return r.ok ? r.json() : null; })
            .then(function (d) {
                if (d && d.success) {
                    bubble('assistant', 'J\'ai transmis votre demande au service RH' + (d.reference ? ' (réf. ' + d.reference + ')' : '') + '. Vous recevrez la réponse ici, dans « Mes demandes ».');
                } else {
                    ticketCreated = false;
                    bubble('assistant', 'Je n\'ai pas pu transmettre votre demande. Utilisez le formulaire « Écrire au service RH ».');
                }
            })
            .catch(function () { ticketCreated = false; bubble('assistant', 'La transmission a échoué. Utilisez le formulaire « Écrire au service RH ».'); });
    }

    function sendChat() {
        var text = input.value.trim();
        if (!text) return;
        input.value = ''; input.style.height = 'auto';
        input.disabled = true; send.disabled = true;
        bubble('user', text);
        setTyping(true);
        post(@json(route('espace-employe.assistance.chat')), { message: text, history: history })
            .then(function (r) { if (!r.ok) throw new Error(r.status); return r.json(); })
            .then(function (d) {
                setTyping(false);
                bubble('assistant', d.reply);
                history = d.history || history.concat([{ role: 'user', content: text }]);
                if (d.requires_ticket && !ticketCreated) {
                    setTimeout(function () { createTicket(d.suggested_sujet || text, d.suggested_categorie || 'question', d.suggested_priorite || 'normale'); }, 800);
                }
            })
            .catch(function () {
                setTyping(false);
                bubble('assistant', 'Je ne parviens pas à répondre pour le moment. Réessayez, ou écrivez directement au service RH ci-dessous.');
            })
            .finally(function () { input.disabled = false; send.disabled = false; input.focus(); });
    }
})();
</script>
@endsection
