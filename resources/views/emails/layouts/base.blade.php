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
        body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;}
        table,td{mso-table-lspace:0pt;mso-table-rspace:0pt;}
        img{-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:none;text-decoration:none;}
        body{height:100%!important;margin:0!important;padding:0!important;width:100%!important;}
        a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}
        #MessageViewBody a{color:inherit;text-decoration:none;}
        .ExternalClass{width:100%;}
        .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%;}

        @media only screen and (max-width: 620px) {
            .email-container { width: 100% !important; max-width: 100% !important; }
            .padding-mobile { padding-left: 24px !important; padding-right: 24px !important; }
            .stack-column { display: block !important; width: 100% !important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;word-spacing:normal;background-color:#EEF2FF;">
<div role="article" aria-roledescription="email" lang="fr" style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#EEF2FF;">

    <!-- Preheader -->
    <div style="display:none;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;">
        @yield('preheader', 'Message de Portail RH+')
    </div>

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color:#EEF2FF;">
        <tr>
            <td style="padding:40px 10px;">

                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container" style="margin:0 auto;max-width:600px;background-color:#ffffff;border-radius:2px;overflow:hidden;box-shadow:0 4px 24px rgba(99,102,241,0.10);">

                    <!-- Indigo→Teal top accent -->
                    <tr>
                        <td style="height:4px;background:linear-gradient(90deg,#312e81 0%,#6366f1 40%,#14b8a6 70%,#0d9488 100%);font-size:0;line-height:0;">&nbsp;</td>
                    </tr>

                    <!-- Header : BEGIN -->
                    <tr>
                        <td style="background-color:#1E1B4B;padding:0;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="padding:36px 44px 40px;" class="padding-mobile">

                                        <!-- Brand -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="width:44px;height:44px;background:linear-gradient(135deg,#6366f1 0%,#14b8a6 100%);border-radius:10px;text-align:center;vertical-align:middle;">
                                                    @yield('header-icon', '<img src="data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'22\' height=\'22\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'white\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpath d=\'M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2\'/%3E%3Ccircle cx=\'12\' cy=\'7\' r=\'4\'/%3E%3C/svg%3E" alt="" width="22" height="22" style="display:block;margin:0 auto;">')
                                                </td>
                                                <td style="padding-left:14px;vertical-align:middle;">
                                                    <span style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;font-size:19px;font-weight:800;color:#ffffff;letter-spacing:-0.3px;">Portail</span>
                                                    <span style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;font-size:19px;font-weight:800;color:#5eead4;letter-spacing:-0.3px;">&nbsp;RH+</span>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Separator -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:24px 0 28px;">
                                            <tr>
                                                <td style="height:1px;background:linear-gradient(90deg,rgba(99,102,241,0.4) 0%,rgba(20,184,166,0.2) 100%);font-size:0;line-height:0;">&nbsp;</td>
                                            </tr>
                                        </table>

                                        <!-- Title -->
                                        <h1 style="margin:0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;font-size:28px;font-weight:700;color:#ffffff;line-height:1.3;letter-spacing:-0.5px;">
                                            @yield('header-title')
                                        </h1>
                                        @hasSection('header-subtitle')
                                        <p style="margin:10px 0 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:14px;color:rgba(255,255,255,0.5);line-height:1.6;">
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
                        <td style="padding:40px 44px 44px;background-color:#ffffff;" class="padding-mobile">
                            @yield('content')
                        </td>
                    </tr>
                    <!-- Body : END -->

                    <!-- Footer : BEGIN -->
                    <tr>
                        <td style="padding:0 44px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="height:1px;background-color:#E2E8F0;font-size:0;line-height:0;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 44px 28px;background-color:#F8FAFC;" class="padding-mobile">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <!-- Mini brand -->
                                <tr>
                                    <td style="padding-bottom:14px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="width:28px;height:28px;background:linear-gradient(135deg,#6366f1,#14b8a6);border-radius:6px;text-align:center;vertical-align:middle;">
                                                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2'/%3E%3Ccircle cx='12' cy='7' r='4'/%3E%3C/svg%3E" alt="" width="14" height="14" style="display:block;margin:0 auto;">
                                                </td>
                                                <td style="padding-left:10px;vertical-align:middle;">
                                                    <span style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:13px;font-weight:700;color:#334155;">Portail</span>
                                                    <span style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:13px;font-weight:700;color:#14b8a6;">&nbsp;RH+</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Links -->
                                <tr>
                                    <td style="padding-bottom:12px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="padding-right:20px;"><a href="{{ url('/') }}" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:12px;color:#64748B;text-decoration:none;">Accueil</a></td>
                                                <td style="padding-right:20px;"><a href="{{ url('/aide') }}" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:12px;color:#64748B;text-decoration:none;">Aide</a></td>
                                                <td><a href="{{ url('/contact') }}" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:12px;color:#64748B;text-decoration:none;">Contact</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Copyright -->
                                <tr>
                                    <td>
                                        <p style="margin:0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:11px;color:#94A3B8;line-height:1.6;">
                                            &copy; {{ date('Y') }} {{ config('app.name', 'Portail RH+') }}. Tous droits r&eacute;serv&eacute;s.
                                        </p>
                                        <p style="margin:4px 0 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:11px;color:#CBD5E1;line-height:1.5;">
                                            Ce message est envoy&eacute; automatiquement. Merci de ne pas y r&eacute;pondre directement.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer : END -->

                    <!-- Indigo→Teal bottom accent -->
                    <tr>
                        <td style="height:3px;background:linear-gradient(90deg,#312e81 0%,#6366f1 40%,#14b8a6 70%,#0d9488 100%);font-size:0;line-height:0;">&nbsp;</td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</div>
</body>
</html>
