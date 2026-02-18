<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos identifiants Portail RH</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, 'Segoe UI', Arial, sans-serif; background: #f0f4f8; color: #1e293b; line-height: 1.6; }
        .wrapper { max-width: 600px; margin: 0 auto; padding: 32px 16px; }

        /* Header */
        .header { background: linear-gradient(135deg, #0f172a 0%, #1a2744 60%, #0f172a 100%); border-radius: 16px 16px 0 0; padding: 40px 40px 32px; text-align: center; position: relative; overflow: hidden; }
        .header::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #e8850c, #f59e0b, #e8850c); }
        .brand-logo { display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; background: linear-gradient(135deg, #e8850c, #f59e0b); border-radius: 14px; margin-bottom: 16px; box-shadow: 0 4px 16px rgba(232,133,12,0.35); }
        .brand-logo svg { width: 28px; height: 28px; color: #0f172a; stroke: #0f172a; }
        .brand-name { font-size: 22px; font-weight: 700; color: #ffffff; letter-spacing: -0.5px; }
        .brand-name span { color: #f59e0b; }
        .header-subtitle { font-size: 13px; color: rgba(255,255,255,0.5); margin-top: 4px; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 500; }

        /* Body */
        .body { background: #ffffff; padding: 40px; border: 1px solid #e2e8f0; border-top: none; }
        .greeting { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 8px; }
        .intro { font-size: 15px; color: #475569; margin-bottom: 28px; }

        /* Company badge */
        .company-badge { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #eff6ff, #dbeafe); border: 1px solid #bfdbfe; border-radius: 10px; padding: 10px 16px; margin-bottom: 28px; }
        .company-badge-icon { width: 32px; height: 32px; background: #3b7dd8; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .company-badge-icon svg { width: 16px; height: 16px; stroke: white; }
        .company-badge-name { font-size: 15px; font-weight: 700; color: #1e40af; }
        .company-badge-label { font-size: 11px; color: #64748b; font-weight: 500; }

        /* Credentials box */
        .credentials-box { background: #0f172a; border-radius: 12px; padding: 28px; margin-bottom: 28px; position: relative; overflow: hidden; }
        .credentials-box::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #e8850c, #f59e0b, #e8850c); }
        .credentials-title { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 20px; }
        .credential-row { display: flex; flex-direction: column; gap: 4px; margin-bottom: 16px; }
        .credential-row:last-of-type { margin-bottom: 0; }
        .credential-label { font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; }
        .credential-value { font-size: 16px; font-weight: 700; color: #f1f5f9; font-family: 'Courier New', monospace; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 10px 14px; letter-spacing: 0.5px; }
        .credential-value.password { color: #f59e0b; border-color: rgba(245,158,11,0.2); background: rgba(245,158,11,0.06); }

        /* CTA Button */
        .cta-wrapper { text-align: center; margin-bottom: 28px; }
        .cta-btn { display: inline-block; background: linear-gradient(135deg, #3b7dd8, #2563a0); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 700; padding: 14px 32px; border-radius: 10px; letter-spacing: 0.3px; box-shadow: 0 4px 14px rgba(59,125,216,0.35); }

        /* Warning */
        .warning-box { background: #fffbeb; border: 1px solid #fcd34d; border-radius: 10px; padding: 16px 20px; margin-bottom: 28px; display: flex; gap: 12px; align-items: flex-start; }
        .warning-icon { font-size: 18px; flex-shrink: 0; margin-top: 2px; }
        .warning-text { font-size: 13px; color: #78350f; }
        .warning-text strong { font-weight: 700; display: block; margin-bottom: 4px; }

        /* Info list */
        .info-list { list-style: none; margin-bottom: 28px; }
        .info-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 14px; color: #475569; margin-bottom: 8px; }
        .info-list li::before { content: '✓'; color: #059669; font-weight: 700; flex-shrink: 0; margin-top: 1px; }

        /* Divider */
        .divider { border: none; border-top: 1px solid #e2e8f0; margin: 0 0 24px; }

        /* Footer */
        .footer { background: #f8fafc; border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 16px 16px; padding: 24px 40px; text-align: center; }
        .footer-text { font-size: 12px; color: #94a3b8; }
        .footer-text strong { color: #64748b; }
        .security-note { font-size: 11px; color: #94a3b8; margin-top: 8px; background: #f1f5f9; border-radius: 6px; padding: 8px 12px; }
    </style>
</head>
<body>
<div class="wrapper">

    <!-- Header -->
    <div class="header">
        <div class="brand-logo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                <path d="M21 21v-2a4 4 0 0 0-3-3.87"/>
            </svg>
        </div>
        <div class="brand-name">Portail <span>RH+</span></div>
        <div class="header-subtitle">Accès Chef d'Entreprise</div>
    </div>

    <!-- Body -->
    <div class="body">
        <div class="greeting">Bonjour {{ $user->name }},</div>
        <p class="intro">
            Votre accès au <strong>Portail RH+</strong> vient d'être créé. Vous pouvez désormais consulter les informations RH de votre entreprise en toute sécurité.
        </p>

        <!-- Company badge -->
        <div class="company-badge">
            <div class="company-badge-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <div class="company-badge-name">{{ $entreprise->nom }}</div>
                <div class="company-badge-label">Votre entreprise</div>
            </div>
        </div>

        <!-- Credentials -->
        <div class="credentials-box">
            <div class="credentials-title">Vos identifiants de connexion</div>
            <div class="credential-row">
                <div class="credential-label">Adresse email (login)</div>
                <div class="credential-value">{{ $user->email }}</div>
            </div>
            <div class="credential-row">
                <div class="credential-label">Mot de passe temporaire</div>
                <div class="credential-value password">{{ $motDePasseTemporaire }}</div>
            </div>
        </div>

        <!-- CTA -->
        <div class="cta-wrapper">
            <a href="{{ url('/connexion') }}" class="cta-btn">
                Se connecter au Portail RH+
            </a>
        </div>

        <!-- Warning -->
        <div class="warning-box">
            <div class="warning-icon">⚠️</div>
            <div class="warning-text">
                <strong>Changement de mot de passe obligatoire</strong>
                Lors de votre première connexion, vous serez invité(e) à définir un nouveau mot de passe sécurisé. Ce mot de passe temporaire ne sera plus valide après le premier changement.
            </div>
        </div>

        <!-- What you can access -->
        <p style="font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">Ce que vous pouvez consulter</p>
        <ul class="info-list">
            <li>Tableau de bord avec les statistiques de {{ $entreprise->nom }}</li>
            <li>Liste du personnel et dossiers des agents</li>
            <li>Bulletins de paie de vos collaborateurs</li>
            <li>Demandes et historique des congés</li>
            <li>Rapports et données analytiques</li>
        </ul>

        <hr class="divider">

        <p style="font-size:13px;color:#94a3b8;">
            Si vous n'êtes pas à l'origine de cette demande ou si vous avez des questions, contactez votre administrateur RH.
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p class="footer-text">
            Cet email a été envoyé automatiquement par <strong>Portail RH+</strong><br>
            © {{ date('Y') }} Portail RH+ — Tous droits réservés
        </p>
        <p class="security-note">
            🔒 Ne partagez jamais vos identifiants. Ce message contient des informations confidentielles.
        </p>
    </div>

</div>
</body>
</html>
