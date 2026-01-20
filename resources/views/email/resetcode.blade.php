<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Code de vérification - Portail RH+</title>

    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->

    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #F1F5F9; }

        @media only screen and (max-width: 620px) {
            .email-container { width: 100% !important; }
            .padding-mobile { padding-left: 24px !important; padding-right: 24px !important; }
            .code-text { font-size: 32px !important; letter-spacing: 6px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #F1F5F9;">

    <!-- Preheader -->
    <div style="display: none; max-height: 0; overflow: hidden;">
        Votre code de vérification : {{ $code }} - Valide pendant {{ $expiryMinutes ?? '10' }} minutes.
    </div>

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #F1F5F9;">
        <tr>
            <td style="padding: 40px 10px;">

                <!-- Main Container -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container" style="margin: 0 auto; max-width: 600px; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);">

                    <!-- Header avec gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #4A90D9 0%, #2E6BB3 50%, #1E5A9E 100%); padding: 0; position: relative;">
                            <!-- Pattern overlay -->
                            <div style="position: absolute; inset: 0; opacity: 0.1; background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="padding: 50px 40px 60px; text-align: center;">
                                        <!-- Icon Container -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
                                            <tr>
                                                <td style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); width: 80px; height: 80px; border-radius: 20px; text-align: center; vertical-align: middle; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);">
                                                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='11' width='18' height='11' rx='2' ry='2'%3E%3C/rect%3E%3Cpath d='M7 11V7a5 5 0 0 1 10 0v4'%3E%3C/path%3E%3Ccircle cx='12' cy='16' r='1'%3E%3C/circle%3E%3C/svg%3E" alt="" width="40" height="40" style="display: block; margin: 0 auto;">
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Title -->
                                        <h1 style="margin: 28px 0 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; font-size: 28px; font-weight: 700; color: #ffffff; line-height: 1.2; letter-spacing: -0.5px;">
                                            Code de Vérification
                                        </h1>
                                        <p style="margin: 14px 0 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: rgba(255, 255, 255, 0.85); line-height: 1.5;">
                                            Sécurisez votre compte avec ce code unique
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <!-- Wave Bottom -->
                            <div style="height: 24px; background: #ffffff; border-radius: 24px 24px 0 0;"></div>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px 40px 45px;" class="padding-mobile">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <!-- Greeting -->
                                <tr>
                                    <td style="padding-bottom: 24px;">
                                        <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 16px; color: #1F2937; line-height: 1.7;">
                                            Bonjour <strong style="color: #4A90D9;">{{ $name ?? 'Utilisateur' }}</strong>,
                                        </p>
                                    </td>
                                </tr>

                                <!-- Message -->
                                <tr>
                                    <td style="padding-bottom: 32px;">
                                        <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4B5563; line-height: 1.8;">
                                            Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.
                                            Utilisez le code ci-dessous pour continuer :
                                        </p>
                                    </td>
                                </tr>

                                <!-- OTP Code Box -->
                                <tr>
                                    <td style="padding-bottom: 32px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td align="center" style="background: linear-gradient(135deg, #F0F7FF 0%, #E8F4FD 100%); border: 2px solid #4A90D9; border-radius: 16px; padding: 32px 24px;">
                                                    <p style="margin: 0 0 8px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 11px; font-weight: 700; color: #4A90D9; text-transform: uppercase; letter-spacing: 2px;">
                                                        Votre Code
                                                    </p>
                                                    <p class="code-text" style="margin: 0; font-family: 'SF Mono', 'Fira Code', 'Courier New', monospace; font-size: 44px; font-weight: 800; color: #2E6BB3; letter-spacing: 10px; text-shadow: 0 2px 4px rgba(74, 144, 217, 0.2);">
                                                        {{ $code }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Timer Warning -->
                                <tr>
                                    <td style="padding-bottom: 32px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td style="background: linear-gradient(135deg, #FFF7ED 0%, #FFEDD5 100%); border-left: 4px solid #FF9500; border-radius: 0 12px 12px 0; padding: 18px 20px;">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td style="width: 40px; vertical-align: top;">
                                                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23FF9500' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='12' cy='12' r='10'%3E%3C/circle%3E%3Cpolyline points='12 6 12 12 16 14'%3E%3C/polyline%3E%3C/svg%3E" alt="" width="24" height="24">
                                                            </td>
                                                            <td>
                                                                <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; color: #9A3412; line-height: 1.6;">
                                                                    <strong style="color: #C2410C;">Attention :</strong> Ce code expire dans <strong>{{ $expiryMinutes ?? '10' }} minutes</strong>.
                                                                    Ne le partagez avec personne.
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Security Note -->
                                <tr>
                                    <td style="padding-bottom: 28px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td style="background-color: #F8FAFC; border-radius: 12px; padding: 20px;">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td style="width: 40px; vertical-align: top;">
                                                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%2322C55E' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z'%3E%3C/path%3E%3Cpolyline points='9 12 11 14 15 10'%3E%3C/polyline%3E%3C/svg%3E" alt="" width="20" height="20">
                                                            </td>
                                                            <td>
                                                                <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 13px; color: #64748B; line-height: 1.6;">
                                                                    Si vous n'avez pas effectué cette demande, ignorez cet e-mail. Votre mot de passe restera inchangé et votre compte sécurisé.
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Signature -->
                                <tr>
                                    <td>
                                        <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4B5563; line-height: 1.7;">
                                            Cordialement,
                                        </p>
                                        <p style="margin: 6px 0 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; font-weight: 600; color: #1F2937;">
                                            L'équipe {{ config('app.name', 'Portail RH+') }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #F8FAFC; padding: 28px 40px; border-top: 1px solid #E2E8F0;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <!-- Logo -->
                                <tr>
                                    <td align="center" style="padding-bottom: 18px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="background: linear-gradient(135deg, #4A90D9 0%, #2E6BB3 100%); width: 32px; height: 32px; border-radius: 8px; text-align: center; vertical-align: middle;">
                                                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2'%3E%3C/path%3E%3Ccircle cx='12' cy='7' r='4'%3E%3C/circle%3E%3C/svg%3E" alt="" width="18" height="18" style="display: block; margin: 0 auto;">
                                                </td>
                                                <td style="padding-left: 10px;">
                                                    <span style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; font-weight: 700; color: #1F2937;">Portail</span>
                                                    <span style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; font-weight: 700; color: #4A90D9;">RH+</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Links -->
                                <tr>
                                    <td align="center" style="padding-bottom: 14px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="padding: 0 10px;">
                                                    <a href="#" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 12px; color: #64748B; text-decoration: none;">Aide</a>
                                                </td>
                                                <td style="color: #CBD5E1; font-size: 12px;">|</td>
                                                <td style="padding: 0 10px;">
                                                    <a href="#" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 12px; color: #64748B; text-decoration: none;">Confidentialité</a>
                                                </td>
                                                <td style="color: #CBD5E1; font-size: 12px;">|</td>
                                                <td style="padding: 0 10px;">
                                                    <a href="#" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 12px; color: #64748B; text-decoration: none;">Contact</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Copyright -->
                                <tr>
                                    <td align="center">
                                        <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 11px; color: #94A3B8; line-height: 1.5;">
                                            &copy; {{ date('Y') }} {{ config('app.name', 'Portail RH+') }}. Tous droits réservés.
                                        </p>
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
