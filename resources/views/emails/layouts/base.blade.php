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
<body style="margin: 0; padding: 0; word-spacing: normal; background-color: #F1F5F9;">
    <div role="article" aria-roledescription="email" lang="fr" style="text-size-adjust: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; background-color: #F1F5F9;">

        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all;">
            @yield('preheader', 'Message de Portail RH+')
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #F1F5F9;">
            <tr>
                <td style="padding: 40px 10px;">

                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container" style="margin: 0 auto; max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">

                        <!-- Header : BEGIN -->
                        <tr>
                            <td style="background: linear-gradient(135deg, #4A90D9 0%, #2E6BB3 100%); padding: 0;">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td style="padding: 40px 40px 45px; text-align: center;">
                                            <!-- Logo -->
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
                                                <tr>
                                                    <td style="background-color: rgba(255, 255, 255, 0.15); width: 70px; height: 70px; border-radius: 18px; text-align: center; vertical-align: middle;">
                                                        @yield('header-icon')
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- Title -->
                                            <h1 style="margin: 24px 0 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; font-size: 26px; font-weight: 700; color: #ffffff; line-height: 1.3;">
                                                @yield('header-title')
                                            </h1>
                                            @hasSection('header-subtitle')
                                            <p style="margin: 12px 0 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; font-size: 15px; color: rgba(255, 255, 255, 0.9); line-height: 1.5;">
                                                @yield('header-subtitle')
                                            </p>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                <!-- Decorative Wave -->
                                <div style="height: 20px; background: #ffffff; border-radius: 20px 20px 0 0;"></div>
                            </td>
                        </tr>
                        <!-- Header : END -->

                        <!-- Body : BEGIN -->
                        <tr>
                            <td style="padding: 35px 40px 40px;" class="padding-mobile">
                                @yield('content')
                            </td>
                        </tr>
                        <!-- Body : END -->

                        <!-- Footer : BEGIN -->
                        <tr>
                            <td style="background-color: #F8FAFC; padding: 30px 40px; border-top: 1px solid #E2E8F0;">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <!-- Logo Footer -->
                                    <tr>
                                        <td align="center" style="padding-bottom: 20px;">
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                                <tr>
                                                    <td style="background: linear-gradient(135deg, #4A90D9 0%, #2E6BB3 100%); width: 36px; height: 36px; border-radius: 10px; text-align: center; vertical-align: middle;">
                                                        <img src="{{ asset('assets/images/logo-icon-white.png') }}" alt="" width="20" height="20" style="display: block; margin: 0 auto;">
                                                    </td>
                                                    <td style="padding-left: 12px;">
                                                        <span style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 16px; font-weight: 700; color: #1F2937;">Portail</span>
                                                        <span style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 16px; font-weight: 700; color: #4A90D9;">RH+</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- Links -->
                                    <tr>
                                        <td align="center" style="padding-bottom: 16px;">
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                                <tr>
                                                    <td style="padding: 0 12px;">
                                                        <a href="{{ url('/') }}" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 13px; color: #64748B; text-decoration: none;">Accueil</a>
                                                    </td>
                                                    <td style="color: #CBD5E1;">|</td>
                                                    <td style="padding: 0 12px;">
                                                        <a href="{{ url('/aide') }}" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 13px; color: #64748B; text-decoration: none;">Aide</a>
                                                    </td>
                                                    <td style="color: #CBD5E1;">|</td>
                                                    <td style="padding: 0 12px;">
                                                        <a href="{{ url('/contact') }}" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 13px; color: #64748B; text-decoration: none;">Contact</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- Copyright -->
                                    <tr>
                                        <td align="center">
                                            <p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 12px; color: #94A3B8; line-height: 1.6;">
                                                &copy; {{ date('Y') }} {{ config('app.name', 'Portail RH+') }}. Tous droits réservés.
                                            </p>
                                            <p style="margin: 8px 0 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 11px; color: #CBD5E1; line-height: 1.5;">
                                                Ce message a été envoyé automatiquement. Merci de ne pas y répondre directement.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- Footer : END -->

                    </table>

                </td>
            </tr>
        </table>

    </div>
</body>
</html>
