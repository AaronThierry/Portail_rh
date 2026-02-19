<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Code de v&eacute;rification - Portail RH+</title>

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
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #E8E2DA; }

        @media only screen and (max-width: 620px) {
            .email-container { width: 100% !important; }
            .padding-mobile { padding-left: 24px !important; padding-right: 24px !important; }
            .code-text { font-size: 32px !important; letter-spacing: 8px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #E8E2DA;">

    <!-- Preheader -->
    <div style="display: none; max-height: 0; overflow: hidden;">
        Votre code de v&eacute;rification : {{ $code }} - Valide pendant {{ $expiryMinutes ?? '10' }} minutes.
    </div>

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #E8E2DA;">
        <tr>
            <td style="padding: 40px 10px;">

                <!-- Main Container -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container" style="margin: 0 auto; max-width: 600px; background-color: #ffffff; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">

                    <!-- Gold Top Accent Line -->
                    <tr>
                        <td style="height: 4px; background: linear-gradient(90deg, #9A7A4E 0%, #C9A96E 40%, #E2C78A 60%, #C9A96E 80%, #9A7A4E 100%); font-size: 0; line-height: 0;">&nbsp;</td>
                    </tr>

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #0C1628; padding: 0;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="padding: 36px 44px 40px;">
                                        <!-- Logo + Brand -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="width: 42px; height: 42px; background-color: #C9A96E; border-radius: 10px; text-align: center; vertical-align: middle;">
                                                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='11' width='18' height='11' rx='2' ry='2'%3E%3C/rect%3E%3Cpath d='M7 11V7a5 5 0 0 1 10 0v4'%3E%3C/path%3E%3Ccircle cx='12' cy='16' r='1'%3E%3C/circle%3E%3C/svg%3E" alt="" width="22" height="22" style="display: block; margin: 0 auto;">
                                                </td>
                                                <td style="padding-left: 14px; vertical-align: middle;">
                                                    <span style="font-family: Georgia, 'Times New Roman', Times, serif; font-size: 18px; font-weight: 700; color: #ffffff; letter-spacing: 0.5px;">Portail</span>
                                                    <span style="font-family: Georgia, 'Times New Roman', Times, serif; font-size: 18px; font-weight: 700; color: #C9A96E; letter-spacing: 0.5px;">RH+</span>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Separator -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 24px 0 28px;">
                                            <tr>
                                                <td style="height: 1px; background-color: rgba(184, 151, 106, 0.3); font-size: 0; line-height: 0;">&nbsp;</td>
                                            </tr>
                                        </table>

                                        <!-- Badge -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin-bottom: 20px;">
                                            <tr>
                                                <td style="background-color: rgba(184, 151, 106, 0.15); padding: 6px 16px; border-radius: 4px;">
                                                    <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 11px; font-weight: 600; color: #E2C78A; letter-spacing: 1.5px; text-transform: uppercase;">
                                                        S&eacute;curit&eacute;
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Title -->
                                        <h1 style="margin: 0; font-family: Georgia, 'Times New Roman', Times, serif; font-size: 28px; font-weight: 400; color: #ffffff; line-height: 1.3; letter-spacing: -0.3px;">
                                            Code de V&eacute;rification
                                        </h1>
                                        <p style="margin: 10px 0 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; color: rgba(255, 255, 255, 0.5); line-height: 1.5; letter-spacing: 0.3px;">
                                            R&eacute;initialisation de votre mot de passe
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 44px 44px;" class="padding-mobile">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <!-- Greeting -->
                                <tr>
                                    <td style="padding-bottom: 20px;">
                                        <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 16px; color: #1F2937; line-height: 1.7;">
                                            Bonjour <strong style="color: #0C1628;">{{ $name ?? 'Utilisateur' }}</strong>,
                                        </p>
                                    </td>
                                </tr>

                                <!-- Message -->
                                <tr>
                                    <td style="padding-bottom: 32px;">
                                        <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4B5563; line-height: 1.8;">
                                            Nous avons re&ccedil;u une demande de r&eacute;initialisation de mot de passe pour votre compte. Utilisez le code ci-dessous pour continuer :
                                        </p>
                                    </td>
                                </tr>

                                <!-- OTP Code Box -->
                                <tr>
                                    <td style="padding-bottom: 32px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td style="border: 1px solid #E2E8F0; border-radius: 8px; overflow: hidden;">
                                                    <!-- Code Header -->
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td style="background-color: #F8FAFC; padding: 12px 24px; border-bottom: 1px solid #E2E8F0;">
                                                                <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 1.5px;">
                                                                    Votre code
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- Code Display -->
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td align="center" style="padding: 36px 24px 32px;">
                                                                <p class="code-text" style="margin: 0; font-family: 'SF Mono', 'Fira Code', 'Courier New', monospace; font-size: 44px; font-weight: 800; color: #0C1628; letter-spacing: 12px;">
                                                                    {{ $code }}
                                                                </p>
                                                                <!-- Gold underline accent -->
                                                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin-top: 16px;">
                                                                    <tr>
                                                                        <td style="width: 60px; height: 3px; background: linear-gradient(90deg, #9A7A4E, #C9A96E, #E2C78A); border-radius: 2px;">&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Timer Warning -->
                                <tr>
                                    <td style="padding-bottom: 28px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td style="background-color: #FFFBF5; border-left: 3px solid #C9A96E; padding: 16px 20px;">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td style="width: 36px; vertical-align: top;">
                                                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%23B8976A' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='12' cy='12' r='10'%3E%3C/circle%3E%3Cpolyline points='12 6 12 12 16 14'%3E%3C/polyline%3E%3C/svg%3E" alt="" width="20" height="20">
                                                            </td>
                                                            <td>
                                                                <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 13px; color: #78716C; line-height: 1.6;">
                                                                    <strong style="color: #92400E;">Attention :</strong> Ce code expire dans <strong style="color: #0C1628;">{{ $expiryMinutes ?? '10' }} minutes</strong>. Ne le partagez avec personne.
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
                                                <td style="border: 1px solid #F1F5F9; border-radius: 8px; padding: 20px;">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td style="width: 36px; vertical-align: top;">
                                                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%23B8976A' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z'%3E%3C/path%3E%3Cpolyline points='9 12 11 14 15 10'%3E%3C/polyline%3E%3C/svg%3E" alt="" width="18" height="18">
                                                            </td>
                                                            <td>
                                                                <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 13px; color: #64748B; line-height: 1.6;">
                                                                    Si vous n'avez pas effectu&eacute; cette demande, ignorez cet e-mail. Votre mot de passe restera inchang&eacute; et votre compte s&eacute;curis&eacute;.
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
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td style="border-top: 1px solid #F1F5F9; padding-top: 20px;">
                                                    <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; color: #94A3B8; line-height: 1.7;">
                                                        Cordialement,
                                                    </p>
                                                    <p style="margin: 4px 0 0; font-family: Georgia, 'Times New Roman', Times, serif; font-size: 15px; font-weight: 700; color: #1F2937;">
                                                        L'&eacute;quipe {{ config('app.name', 'Portail RH+') }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 0 44px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="height: 1px; background-color: #E2E8F0; font-size: 0; line-height: 0;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 28px 44px 32px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <!-- Logo -->
                                <tr>
                                    <td style="padding-bottom: 18px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="width: 28px; height: 28px; background-color: #0C1628; border-radius: 6px; text-align: center; vertical-align: middle;">
                                                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23B8976A' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2'%3E%3C/path%3E%3Ccircle cx='12' cy='7' r='4'%3E%3C/circle%3E%3C/svg%3E" alt="" width="16" height="16" style="display: block; margin: 0 auto;">
                                                </td>
                                                <td style="padding-left: 10px;">
                                                    <span style="font-family: Georgia, 'Times New Roman', Times, serif; font-size: 13px; font-weight: 700; color: #334155;">Portail</span>
                                                    <span style="font-family: Georgia, 'Times New Roman', Times, serif; font-size: 13px; font-weight: 700; color: #C9A96E;">RH+</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Links -->
                                <tr>
                                    <td style="padding-bottom: 14px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="padding-right: 20px;">
                                                    <a href="#" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 12px; color: #64748B; text-decoration: none; letter-spacing: 0.3px;">Aide</a>
                                                </td>
                                                <td style="padding-right: 20px;">
                                                    <a href="#" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 12px; color: #64748B; text-decoration: none; letter-spacing: 0.3px;">Confidentialit&eacute;</a>
                                                </td>
                                                <td>
                                                    <a href="#" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 12px; color: #64748B; text-decoration: none; letter-spacing: 0.3px;">Contact</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Copyright -->
                                <tr>
                                    <td>
                                        <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 11px; color: #94A3B8; line-height: 1.5;">
                                            &copy; {{ date('Y') }} {{ config('app.name', 'Portail RH+') }}. Tous droits r&eacute;serv&eacute;s.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Gold Bottom Accent Line -->
                    <tr>
                        <td style="height: 3px; background: linear-gradient(90deg, #9A7A4E 0%, #C9A96E 40%, #E2C78A 60%, #C9A96E 80%, #9A7A4E 100%); font-size: 0; line-height: 0;">&nbsp;</td>
                    </tr>

                </table>
                <!-- End Main Container -->

            </td>
        </tr>
    </table>

</body>
</html>
