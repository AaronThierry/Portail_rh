<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Code de vérification</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f4f7fa; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f4f7fa; padding: 40px 0;">
        <tr>
            <td align="center">

                <!-- Main Container -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06); overflow: hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 40px 50px; text-align: center;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <!-- Icon -->
                                        <div style="background-color: rgba(255, 255, 255, 0.2); width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;">
                                            <img src="{{ asset('assets/images/logo.png') }}" alt="">
                                        </div>
                                        <h1 style="margin: 0; font-size: 28px; font-weight: 700; color: #ffffff; line-height: 1.3;">
                                            Code de Vérification
                                        </h1>
                                        <p style="margin: 12px 0 0; font-size: 15px; color: rgba(255, 255, 255, 0.9); line-height: 1.6;">
                                            Utilisez le code ci-dessous pour compléter votre demande
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 50px 40px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td>
                                        <p style="margin: 0 0 24px; font-size: 16px; color: #334155; line-height: 1.7;">
                                            Bonjour <strong>{{ $name ?? 'Utilisateur' }}</strong>,
                                        </p>

                                        <p style="margin: 0 0 32px; font-size: 16px; color: #334155; line-height: 1.7;">
                                            Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.
                                            Veuillez utiliser le code de vérification suivant pour continuer :
                                        </p>

                                        <!-- OTP Code Box -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0 0 32px;">
                                            <tr>
                                                <td align="center" style="background: linear-gradient(135deg, #f0f4ff 0%, #f5f3ff 100%); border: 2px dashed #667eea; border-radius: 12px; padding: 32px 20px;">
                                                    <p style="margin: 0 0 12px; font-size: 13px; font-weight: 600; color: #667eea; text-transform: uppercase; letter-spacing: 1px;">
                                                        Votre Code OTP
                                                    </p>
                                                    <p style="margin: 0; font-size: 42px; font-weight: 700; color: #667eea; letter-spacing: 8px; font-family: 'Courier New', monospace;">
                                                        {{ $code }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Warning Box -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0 0 32px;">
                                            <tr>
                                                <td style="background-color: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 8px; padding: 16px 20px;">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td style="padding-right: 12px; vertical-align: top; width: 24px;">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M12 9V11M12 15H12.01M5.07183 19H18.9282C20.4678 19 21.4301 17.3333 20.6603 16L13.7321 4C12.9623 2.66667 11.0377 2.66667 10.2679 4L3.33975 16C2.56995 17.3333 3.53223 19 5.07183 19Z" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </td>
                                                            <td>
                                                                <p style="margin: 0; font-size: 14px; color: #92400e; line-height: 1.6;">
                                                                    <strong>Important :</strong> Ce code expire dans <strong>{{ $expiryMinutes ?? '10' }} minutes</strong>.
                                                                    Ne partagez jamais ce code avec qui que ce soit.
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <p style="margin: 0 0 16px; font-size: 15px; color: #334155; line-height: 1.7;">
                                            Si vous n'avez pas effectué cette demande, veuillez ignorer cet e-mail et votre mot de passe restera inchangé.
                                        </p>

                                        <p style="margin: 0; font-size: 15px; color: #334155; line-height: 1.7;">
                                            Cordialement,<br>
                                            <strong>L'équipe {{ config('app.name', 'Portail RH') }}</strong>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 32px 40px; border-top: 1px solid #e2e8f0;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <p style="margin: 0 0 12px; font-size: 13px; color: #94a3b8; line-height: 1.6;">
                                            Cet e-mail a été envoyé depuis {{ config('app.name', 'Portail RH') }}
                                        </p>
                                        <p style="margin: 0 0 16px; font-size: 13px; color: #94a3b8; line-height: 1.6;">
                                            © {{ date('Y') }} {{ config('app.name', 'Portail RH') }}. Tous droits réservés.
                                        </p>

                                        <!-- Social Links (Optional) -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
                                            <tr>
                                                <td style="padding: 0 8px;">
                                                    <a href="#" style="color: #94a3b8; text-decoration: none; font-size: 12px;">Aide</a>
                                                </td>
                                                <td style="padding: 0 8px; color: #cbd5e1;">|</td>
                                                <td style="padding: 0 8px;">
                                                    <a href="#" style="color: #94a3b8; text-decoration: none; font-size: 12px;">Confidentialité</a>
                                                </td>
                                                <td style="padding: 0 8px; color: #cbd5e1;">|</td>
                                                <td style="padding: 0 8px;">
                                                    <a href="#" style="color: #94a3b8; text-decoration: none; font-size: 12px;">Contact</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
                <!-- End Main Container -->

            </td>
        </tr>
    </table>

</body>
</html>