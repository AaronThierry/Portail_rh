<?php

namespace App\Http\Controllers;

/**
 * Génère un profil de configuration iOS (.mobileconfig) qui ajoute une icône
 * "Web Clip" Portail RH+ sur l'écran d'accueil, sans passer par le geste
 * manuel "Partager -> Sur l'écran d'accueil" de Safari.
 *
 * Limites à connaître :
 * - iOS exige toujours une validation manuelle dans Réglages (aucune
 *   installation silencieuse n'est possible, profil ou non).
 * - Le profil n'est pas signé par un certificat Apple payant : iOS affiche
 *   "Non signé" au moment de l'installer. C'est normal, pas une erreur.
 * - Apple ne documente pas si un Web Clip installé par profil bénéficie du
 *   même mode standalone/service worker/push que l'ajout manuel classique.
 *   Le guide manuel (Ajouter à l'écran d'accueil) reste donc la méthode
 *   recommandée pour qui veut les notifications push de façon fiable.
 *
 * Identifiants fixes (pas régénérés à chaque requête) pour qu'un second
 * téléchargement mette à jour le même profil plutôt que d'en créer un autre.
 */
class IosProfileController extends Controller
{
    private const PAYLOAD_UUID_PROFILE  = 'B2B6A6C0-9B2E-4B2C-9B36-6B1E2E8F0A01';
    private const PAYLOAD_UUID_WEBCLIP  = 'B2B6A6C0-9B2E-4B2C-9B36-6B1E2E8F0A02';
    private const PAYLOAD_ID_PROFILE    = 'com.portailrh.profile.install';
    private const PAYLOAD_ID_WEBCLIP    = 'com.portailrh.profile.install.webclip';

    public function download()
    {
        $targetUrl = url('/mon-espace');
        $iconPath  = public_path('assets/images/pwa-192x192.png');
        $iconB64   = is_file($iconPath) ? base64_encode((string) file_get_contents($iconPath)) : '';

        $xml = $this->buildPlist($targetUrl, $iconB64);

        return response($xml, 200, [
            'Content-Type'        => 'application/x-apple-aspen-config',
            'Content-Disposition' => 'attachment; filename="portail-rh.mobileconfig"',
        ]);
    }

    private function buildPlist(string $targetUrl, string $iconB64): string
    {
        $esc = fn (string $v) => htmlspecialchars($v, ENT_XML1 | ENT_QUOTES, 'UTF-8');

        $targetUrlEsc  = $esc($targetUrl);
        $webclipIdEsc  = $esc(self::PAYLOAD_ID_WEBCLIP);
        $webclipUuidEsc = $esc(self::PAYLOAD_UUID_WEBCLIP);
        $profileIdEsc  = $esc(self::PAYLOAD_ID_PROFILE);
        $profileUuidEsc = $esc(self::PAYLOAD_UUID_PROFILE);

        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
    <key>PayloadContent</key>
    <array>
        <dict>
            <key>FullScreen</key>
            <true/>
            <key>Icon</key>
            <data>{$iconB64}</data>
            <key>IsRemovable</key>
            <true/>
            <key>Label</key>
            <string>Portail RH+</string>
            <key>Precomposed</key>
            <true/>
            <key>PayloadDescription</key>
            <string>Ajoute l'icône Portail RH+ sur l'écran d'accueil.</string>
            <key>PayloadDisplayName</key>
            <string>Portail RH+</string>
            <key>PayloadIdentifier</key>
            <string>{$webclipIdEsc}</string>
            <key>PayloadType</key>
            <string>com.apple.webClip.managed</string>
            <key>PayloadUUID</key>
            <string>{$webclipUuidEsc}</string>
            <key>PayloadVersion</key>
            <integer>1</integer>
            <key>TargetURL</key>
            <string>{$targetUrlEsc}</string>
        </dict>
    </array>
    <key>PayloadDescription</key>
    <string>Installe un raccourci vers Portail RH+ sur l'écran d'accueil, sans passer par Safari.</string>
    <key>PayloadDisplayName</key>
    <string>Portail RH+ — Installation rapide</string>
    <key>PayloadIdentifier</key>
    <string>{$profileIdEsc}</string>
    <key>PayloadOrganization</key>
    <string>Portail RH+</string>
    <key>PayloadRemovalDisallowed</key>
    <false/>
    <key>PayloadType</key>
    <string>Configuration</string>
    <key>PayloadUUID</key>
    <string>{$profileUuidEsc}</string>
    <key>PayloadVersion</key>
    <integer>1</integer>
</dict>
</plist>
XML;
    }
}
