@extends('layouts.app')

@section('title', "Créer un compte Chef d'Entreprise — " . $entreprise->nom)

@section('content')
<div style="max-width:680px; margin:0 auto; padding:2rem 0;">

    {{-- Breadcrumb --}}
    <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.8125rem;color:var(--text-secondary,#64748b);margin-bottom:1.5rem;">
        <a href="{{ route('admin.entreprises.index') }}" style="color:var(--primary,#4A90D9);text-decoration:none;font-weight:500;">Entreprises</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('admin.entreprises.show', $entreprise) }}" style="color:var(--primary,#4A90D9);text-decoration:none;font-weight:500;">{{ $entreprise->nom }}</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span>Créer compte Chef d'Entreprise</span>
    </div>

    {{-- Header card --}}
    <div style="background:linear-gradient(135deg,#0f172a 0%,#1a2744 60%,#0f172a 100%);border-radius:16px;padding:32px;margin-bottom:1.5rem;position:relative;overflow:hidden;">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#e8850c,#f59e0b,#e8850c);"></div>
        <div style="position:relative;z-index:1;">
            <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
                <div style="width:48px;height:48px;background:linear-gradient(135deg,#e8850c,#f59e0b);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 14px rgba(232,133,12,0.3);">
                    <svg width="24" height="24" fill="none" stroke="#0f172a" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                        <path d="M12 11v4m0 0h2m-2 0h-2" stroke-width="2"/>
                    </svg>
                </div>
                <div>
                    <h1 style="font-size:1.375rem;font-weight:700;color:white;line-height:1.2;">Créer un accès Chef d'Entreprise</h1>
                    <p style="font-size:0.875rem;color:rgba(255,255,255,0.55);margin-top:4px;">{{ $entreprise->nom }}</p>
                </div>
            </div>
            <p style="font-size:0.875rem;color:rgba(255,255,255,0.65);line-height:1.6;max-width:520px;">
                Créez un compte administrateur en <strong style="color:rgba(255,255,255,0.9);">lecture seule</strong> pour le chef de cette entreprise. Les identifiants seront envoyés automatiquement par email.
            </p>
        </div>
    </div>

    {{-- Compte existant --}}
    @if($compteExistant)
    <div style="background:#fefce8;border:1px solid #fcd34d;border-radius:12px;padding:20px 24px;margin-bottom:1.5rem;display:flex;gap:16px;align-items:flex-start;">
        <div style="width:40px;height:40px;background:#fef3c7;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="20" height="20" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <div style="flex:1;">
            <p style="font-size:0.875rem;font-weight:700;color:#78350f;margin-bottom:4px;">Compte existant</p>
            <p style="font-size:0.8125rem;color:#92400e;line-height:1.5;">
                Un compte Chef d'Entreprise est déjà associé à <strong>{{ $entreprise->nom }}</strong> :<br>
                <span style="font-family:monospace;background:rgba(0,0,0,0.06);padding:2px 6px;border-radius:4px;">{{ $compteExistant->email }}</span>
                — créé le {{ $compteExistant->created_at->format('d/m/Y') }}
            </p>
            <div style="display:flex;gap:10px;margin-top:12px;flex-wrap:wrap;">
                <form method="POST" action="{{ route('admin.chef-entreprise.renvoyer', $entreprise) }}" onsubmit="return confirm('Réinitialiser le mot de passe et renvoyer les identifiants par email ?')">
                    @csrf
                    <button type="submit" style="display:inline-flex;align-items:center;gap:6px;background:#e8850c;color:white;border:none;padding:8px 16px;border-radius:8px;font-size:0.8125rem;font-weight:600;cursor:pointer;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Réinitialiser et renvoyer
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.chef-entreprise.destroy', $entreprise) }}" onsubmit="return confirm('Supprimer définitivement ce compte Chef d\'Entreprise ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="display:inline-flex;align-items:center;gap:6px;background:transparent;color:#dc2626;border:1px solid #fca5a5;padding:8px 16px;border-radius:8px;font-size:0.8125rem;font-weight:600;cursor:pointer;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6m4-6v6"/><path d="M9 6V4h6v2"/></svg>
                        Supprimer ce compte
                    </button>
                </form>
            </div>
        </div>
    </div>
    @else

    {{-- Formulaire création --}}
    <div style="background:var(--card-bg,#fff);border:1px solid var(--card-border,#e2e8f0);border-radius:16px;overflow:hidden;">
        {{-- Errors --}}
        @if($errors->any())
        <div style="background:#fef2f2;border-bottom:1px solid #fecaca;padding:16px 28px;display:flex;gap:12px;align-items:flex-start;">
            <svg width="20" height="20" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                @foreach($errors->all() as $error)
                    <p style="font-size:0.875rem;color:#b91c1c;margin:0;">{{ $error }}</p>
                @endforeach
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.chef-entreprise.store', $entreprise) }}" style="padding:28px;">
            @csrf

            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                {{-- Nom --}}
                <div>
                    <label style="display:block;font-size:0.8125rem;font-weight:600;color:var(--text-secondary,#475569);margin-bottom:6px;">
                        Nom complet du Chef d'Entreprise <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="Ex : Jean-Pierre Konan"
                           style="width:100%;padding:10px 14px;border:1px solid {{ $errors->has('name') ? '#fca5a5' : 'var(--card-border,#e2e8f0)' }};border-radius:8px;font-size:0.9375rem;color:var(--text-primary,#0f172a);background:var(--card-bg,#fff);outline:none;transition:border-color 0.2s;"
                           onfocus="this.style.borderColor='#3b7dd8'"
                           onblur="this.style.borderColor='{{ $errors->has('name') ? '#fca5a5' : 'var(--card-border,#e2e8f0)' }}'">
                    @error('name')
                        <p style="font-size:0.75rem;color:#dc2626;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label style="display:block;font-size:0.8125rem;font-weight:600;color:var(--text-secondary,#475569);margin-bottom:6px;">
                        Adresse email de connexion <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="Ex : direction@{{ strtolower(preg_replace('/\s+/', '', $entreprise->nom)) }}.com"
                           style="width:100%;padding:10px 14px;border:1px solid {{ $errors->has('email') ? '#fca5a5' : 'var(--card-border,#e2e8f0)' }};border-radius:8px;font-size:0.9375rem;color:var(--text-primary,#0f172a);background:var(--card-bg,#fff);outline:none;transition:border-color 0.2s;"
                           onfocus="this.style.borderColor='#3b7dd8'"
                           onblur="this.style.borderColor='{{ $errors->has('email') ? '#fca5a5' : 'var(--card-border,#e2e8f0)' }}'">
                    @error('email')
                        <p style="font-size:0.75rem;color:#dc2626;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info box --}}
                <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:16px 18px;display:flex;gap:12px;align-items:flex-start;">
                    <svg width="18" height="18" fill="none" stroke="#3b7dd8" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <div style="font-size:0.8125rem;color:#1e40af;line-height:1.5;">
                        <strong>Un mot de passe temporaire sécurisé sera généré automatiquement.</strong><br>
                        L'email avec les identifiants sera envoyé immédiatement à l'adresse ci-dessus. Le Chef d'Entreprise devra changer son mot de passe à la première connexion.
                    </div>
                </div>

                {{-- Actions --}}
                <div style="display:flex;gap:12px;padding-top:8px;border-top:1px solid var(--card-border,#e2e8f0);justify-content:flex-end;">
                    <a href="{{ route('admin.entreprises.show', $entreprise) }}"
                       style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border:1px solid var(--card-border,#e2e8f0);border-radius:8px;font-size:0.875rem;font-weight:600;color:var(--text-secondary,#475569);text-decoration:none;background:transparent;">
                        Annuler
                    </a>
                    <button type="submit"
                            style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:linear-gradient(135deg,#e8850c,#f59e0b);border:none;border-radius:8px;font-size:0.875rem;font-weight:700;color:#0f172a;cursor:pointer;box-shadow:0 4px 12px rgba(232,133,12,0.3);">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                        </svg>
                        Créer le compte et envoyer l'email
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- What they can access --}}
    <div style="background:var(--card-bg,#fff);border:1px solid var(--card-border,#e2e8f0);border-radius:16px;padding:24px;margin-top:1.5rem;">
        <p style="font-size:0.8125rem;font-weight:700;color:var(--text-secondary,#475569);text-transform:uppercase;letter-spacing:1px;margin-bottom:16px;">Ce que le Chef d'Entreprise pourra consulter</p>
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;">
            @foreach([
                ['Tableau de bord', '#3b7dd8', 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                ['Personnel et dossiers', '#059669', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857'],
                ['Bulletins de paie', '#e8850c', 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
                ['Congés et absences', '#7c3aed', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ] as [$label, $color, $icon])
            <div style="display:flex;align-items:center;gap:10px;padding:10px 12px;background:{{ $color }}12;border-radius:8px;border:1px solid {{ $color }}25;">
                <div style="width:32px;height:32px;background:{{ $color }}20;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="16" height="16" fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                </div>
                <span style="font-size:0.8125rem;font-weight:600;color:var(--text-primary,#0f172a);">{{ $label }}</span>
            </div>
            @endforeach
        </div>
        <p style="font-size:0.75rem;color:var(--text-muted,#64748b);margin-top:12px;">
            ⚠️ Accès en <strong>lecture seule</strong> — Aucune modification n'est possible depuis ce compte.
        </p>
    </div>
    @endif

</div>
@endsection
