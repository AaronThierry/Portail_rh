<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>@yield('title', config('app.name', 'Portail RH+'))</title>

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
        /* Reset */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
        a[x-apple-data-detectors] { color: inherit !important; text-decoration: none !important; font-size: inherit !important; font-family: inherit !important; font-weight: inherit !important; line-height: inherit !important; }

        /* Client-specific Resets */
        #MessageViewBody a { color: inherit; text-decoration: none; }
        .ExternalClass { width: 100%; }
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }

        /* Mobile Styles */
        @media only screen and (max-width: 620px) {
            .email-container { width: 100% !important; max-width: 100% !important; }
            .fluid { max-width: 100% !important; height: auto !important; margin-left: auto !important; margin-right: auto !important; }
            .stack-column, .stack-column-center { display: block !important; width: 100% !important; max-width: 100% !important; direction: ltr !important; }
            .stack-column-center { text-align: center !important; }
            .center-on-narrow { text-align: center !important; display: block !important; margin-left: auto !important; margin-right: auto !important; float: none !important; }
            table.center-on-narrow { display: inline-block !important; }
            .padding-mobile { padding-left: 20px !important; padding-right: 20px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; word-spacing: normal; background-color: #E8E0D4;">
    <div role="article" aria-roledescription="email" lang="fr" style="text-size-adjust: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; background-color: #E8E0D4;">

        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all;">
            @yield('preheader', 'Message de Portail RH+')
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #E8E0D4;">
            <tr>
                <td style="padding: 40px 10px;">

                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container" style="margin: 0 auto; max-width: 600px; background-color: #ffffff; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">

                        <!-- Gold Top Accent Line -->
                        <tr>
                            <td style="height: 4px; background: linear-gradient(90deg, #B8976A 0%, #D4B88C 50%, #B8976A 100%); font-size: 0; line-height: 0;">&nbsp;</td>
                        </tr>

                        <!-- Header : BEGIN -->
                        <tr>
                            <td style="background-color: #0F172A; padding: 0;">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td style="padding: 36px 44px 40px;">
                                            <!-- Logo Row -->
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tr>
                                                    <td>
                                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                                            <tr>
                                                                <td style="width: 42px; height: 42px; background-color: #B8976A; border-radius: 10px; text-align: center; vertical-align: middle;">
                                                                    @yield('header-icon')
                                                                </td>
                                                                <td style="padding-left: 14px; vertical-align: middle;">
                                                                    <span style="font-family: Georgia, 'Times New Roman', Times, serif; font-size: 18px; font-weight: 700; color: #ffffff; letter-spacing: 0.5px;">Portail</span>
                                                                    <span style="font-family: Georgia, 'Times New Roman', Times, serif; font-size: 18px; font-weight: 700; color: #B8976A; letter-spacing: 0.5px;">RH+</span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- Thin Separator -->
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 24px 0 28px;">
                                                <tr>
                                                    <td style="height: 1px; background-color: rgba(184, 151, 106, 0.3); font-size: 0; line-height: 0;">&nbsp;</td>
                                                </tr>
                                            </table>

                                            <!-- Title -->
                                            <h1 style="margin: 0; font-family: Georgia, 'Times New Roman', Times, serif; font-size: 28px; font-weight: 400; color: #ffffff; line-height: 1.3; letter-spacing: -0.3px;">
                                                @yield('header-title')
                                            </h1>
                                            @hasSection('header-subtitle')
                                            <p style="margin: 10px 0 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; font-size: 14px; color: rgba(255, 255, 255, 0.55); line-height: 1.5; letter-spacing: 0.3px;">
                                                @yield('header-subtitle')
                                            </p>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- Header : END -->

                        <!-- Body : BEGIN -->
                        <tr>
                            <td style="padding: 40px 44px 44px;" class="padding-mobile">
                                @yield('content')
                            </td>
                        </tr>
                        <!-- Body : END -->

                        <!-- Footer : BEGIN -->
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
                                    <!-- Logo Footer -->
                                    <tr>
                                        <td style="padding-bottom: 20px;">
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                                <tr>
                                                    <td style="width: 28px; height: 28px; background-color: #0F172A; border-radius: 6px; text-align: center; vertical-align: middle;">
                                                        <img src="{{ asset('assets/images/logo-icon-white.png') }}" alt="" width="16" height="16" style="display: block; margin: 0 auto;">
                                                    </td>
                                                    <td style="padding-left: 10px;">
                                                        <span style="font-family: Georgia, 'Times New Roman', Times, serif; font-size: 13px; font-weight: 700; color: #334155;">Portail</span>
                                                        <span style="font-family: Georgia, 'Times New Roman', Times, serif; font-size: 13px; font-weight: 700; color: #B8976A;">RH+</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- Links -->
                                    <tr>
                                        <td style="padding-bottom: 16px;">
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                                <tr>
                                                    <td style="padding-right: 20px;">
                                                        <a href="{{ url('/') }}" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 12px; color: #64748B; text-decoration: none; letter-spacing: 0.3px;">Accueil</a>
                                                    </td>
                                                    <td style="padding-right: 20px;">
                                                        <a href="{{ url('/aide') }}" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 12px; color: #64748B; text-decoration: none; letter-spacing: 0.3px;">Aide</a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('/contact') }}" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 12px; color: #64748B; text-decoration: none; letter-spacing: 0.3px;">Contact</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- Copyright -->
                                    <tr>
                                        <td>
                                            <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 11px; color: #94A3B8; line-height: 1.6;">
                                                &copy; {{ date('Y') }} {{ config('app.name', 'Portail RH+') }}. Tous droits r&eacute;serv&eacute;s.
                                            </p>
                                            <p style="margin: 6px 0 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 11px; color: #CBD5E1; line-height: 1.5;">
                                                Ce message a &eacute;t&eacute; envoy&eacute; automatiquement. Merci de ne pas y r&eacute;pondre directement.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- Footer : END -->

                        <!-- Gold Bottom Accent Line -->
                        <tr>
                            <td style="height: 3px; background: linear-gradient(90deg, #B8976A 0%, #D4B88C 50%, #B8976A 100%); font-size: 0; line-height: 0;">&nbsp;</td>
                        </tr>

                    </table>

                </td>
            </tr>
        </table>

    </div>
</body>
</html>
