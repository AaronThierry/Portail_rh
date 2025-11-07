<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos identifiants de connexion</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8fafc;
            padding: 40px 20px;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .email-header h1 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .email-header p {
            font-size: 16px;
            opacity: 0.95;
        }

        .email-body {
            padding: 40px 30px;
            color: #334155;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1e293b;
        }

        .message {
            font-size: 16px;
            margin-bottom: 30px;
            color: #475569;
        }

        .credentials-box {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border: 2px solid #e0e7ff;
            border-radius: 16px;
            padding: 30px;
            margin: 30px 0;
        }

        .credential-item {
            margin-bottom: 20px;
        }

        .credential-item:last-child {
            margin-bottom: 0;
        }

        .credential-label {
            font-size: 14px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .credential-value {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            background: #ffffff;
            padding: 14px 18px;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            font-family: 'Courier New', monospace;
            word-break: break-all;
        }

        .password-value {
            color: #667eea;
            letter-spacing: 1px;
        }

        .btn-login {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            margin: 30px 0;
            text-align: center;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .warning-box {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
            border-left: 4px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
        }

        .warning-box p {
            font-size: 14px;
            color: #92400e;
            margin: 0;
        }

        .warning-box strong {
            color: #78350f;
        }

        .security-tips {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        .security-tips h3 {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 15px;
        }

        .security-tips ul {
            list-style: none;
            padding: 0;
        }

        .security-tips li {
            font-size: 14px;
            color: #475569;
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
        }

        .security-tips li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: bold;
        }

        .email-footer {
            background: #f1f5f9;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .email-footer p {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 10px;
        }

        .company-name {
            font-weight: 700;
            color: #667eea;
        }

        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
            }

            .email-header h1 {
                font-size: 24px;
            }

            .credential-value {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🎉 Bienvenue sur le Portail RH</h1>
            <p>Votre compte a été créé avec succès</p>
        </div>

        <div class="email-body">
            <p class="greeting">Bonjour {{ $user->name }},</p>

            <p class="message">
                Nous sommes ravis de vous accueillir sur notre plateforme de gestion des ressources humaines.
                Votre compte utilisateur a été créé et vous pouvez maintenant accéder au système avec les identifiants ci-dessous.
            </p>

            <div class="credentials-box">
                <div class="credential-item">
                    <div class="credential-label">Adresse Email</div>
                    <div class="credential-value">{{ $user->email }}</div>
                </div>

                <div class="credential-item">
                    <div class="credential-label">Mot de passe temporaire</div>
                    <div class="credential-value password-value">{{ $password }}</div>
                </div>
            </div>

            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="btn-login">
                    Se connecter maintenant
                </a>
            </div>

            <div class="warning-box">
                <p>
                    <strong>⚠️ Important :</strong>
                    Pour des raisons de sécurité, vous serez invité à <strong>changer votre mot de passe</strong>
                    lors de votre première connexion. Veuillez choisir un mot de passe fort et unique.
                </p>
            </div>

            <div class="security-tips">
                <h3>🔒 Conseils de sécurité</h3>
                <ul>
                    <li>Ne partagez jamais vos identifiants avec qui que ce soit</li>
                    <li>Utilisez un mot de passe unique contenant lettres, chiffres et caractères spéciaux</li>
                    <li>Changez votre mot de passe régulièrement</li>
                    <li>Déconnectez-vous toujours après utilisation sur un ordinateur partagé</li>
                </ul>
            </div>

            <p class="message" style="margin-top: 30px;">
                Si vous avez des questions ou besoin d'assistance, n'hésitez pas à contacter l'équipe des ressources humaines.
            </p>

            <p style="font-size: 14px; color: #64748b; margin-top: 20px;">
                Cordialement,<br>
                <strong style="color: #1e293b;">L'équipe RH</strong>
            </p>
        </div>

        <div class="email-footer">
            <p>
                Cet email a été envoyé automatiquement par <span class="company-name">Portail RH</span>
            </p>
            <p>
                Si vous n'avez pas demandé ce compte, veuillez ignorer cet email.
            </p>
            <p style="margin-top: 15px; color: #94a3b8; font-size: 12px;">
                © {{ date('Y') }} Portail RH. Tous droits réservés.
            </p>
        </div>
    </div>
</body>
</html>
