# 📱 Guide d'intégration WhatsApp pour le Portail RH

## 📋 Table des matières
1. [Vue d'ensemble](#vue-densemble)
2. [Solutions disponibles](#solutions-disponibles)
3. [Installation avec Twilio](#installation-avec-twilio)
4. [Configuration](#configuration)
5. [Utilisation](#utilisation)
6. [Tarification](#tarification)
7. [Alternatives](#alternatives)
8. [FAQ](#faq)

---

## 🎯 Vue d'ensemble

Ce guide vous explique comment intégrer les notifications WhatsApp dans votre portail RH pour :
- ✅ Notifications de validation de congés
- ✅ Rappels d'événements
- ✅ Création de comptes utilisateurs
- ✅ Alertes de fin de contrat
- ✅ Messages personnalisés

---

## 🔧 Solutions disponibles

### **Option 1 : Twilio (⭐ Recommandée)**

#### ✅ Avantages
- API officielle WhatsApp Business
- Documentation claire en français
- Support technique réactif
- Essai gratuit avec $15 de crédit
- Très fiable et scalable
- Facile à intégrer avec Laravel

#### ❌ Inconvénients
- Nécessite une validation de compte
- Templates à approuver (24-48h)
- Coût par message envoyé

#### 💰 Tarification
| Région | Prix/message |
|--------|-------------|
| Burkina Faso | $0.0160 |
| Côte d'Ivoire | $0.0137 |
| Sénégal | $0.0160 |
| France | $0.0088 |

**Essai gratuit** : $15 de crédit (≈ 940 messages vers le Burkina Faso)

---

### **Option 2 : WhatsApp Business API (Meta)**

#### ✅ Avantages
- Solution officielle Meta
- 1000 messages gratuits/mois
- Pas de coût après les 1000 premiers

#### ❌ Inconvénients
- Configuration complexe
- Nécessite un Meta Business Manager vérifié
- Processus d'approbation long (1-2 semaines)
- Nécessite un numéro dédié

#### 💰 Tarification
- **Gratuit** : 1000 messages/mois
- **Au-delà** : $0.005 - $0.02/message

---

### **Option 3 : Vonage (ex-Nexmo)**

#### ✅ Avantages
- Alternative à Twilio
- Prix compétitifs
- API similaire

#### ❌ Inconvénients
- Moins de documentation en français
- Support moins réactif

#### 💰 Tarification
- Similar à Twilio : $0.01-$0.02/message

---

## 🚀 Installation avec Twilio (Recommandé)

### Étape 1 : Créer un compte Twilio

1. Allez sur [https://www.twilio.com/try-twilio](https://www.twilio.com/try-twilio)
2. Créez un compte (email + mot de passe)
3. Vérifiez votre numéro de téléphone
4. Récupérez vos identifiants :
   - **Account SID** (ex: `ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx`)
   - **Auth Token** (ex: `xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx`)

### Étape 2 : Activer WhatsApp Sandbox (pour tests)

1. Dans le dashboard Twilio, allez dans **Messaging** > **Try it out** > **Send a WhatsApp message**
2. Scannez le QR code ou envoyez le code d'activation depuis WhatsApp
3. Votre numéro sandbox : `whatsapp:+14155238886`

**⚠️ Important** : Le sandbox est UNIQUEMENT pour les tests. Pour la production, vous devez :
- Demander un numéro WhatsApp Business dédié
- Faire approuver vos templates de messages

### Étape 3 : Installer le package Twilio

```bash
composer require twilio/sdk
```

### Étape 4 : Configurer Laravel

Ajoutez dans votre `.env` :

```env
# Configuration Twilio WhatsApp
TWILIO_SID=your_account_sid_here
TWILIO_AUTH_TOKEN=your_auth_token_here
TWILIO_WHATSAPP_FROM=whatsapp:+14155238886
TWILIO_WHATSAPP_ENABLED=true
```

**Pour la production**, remplacez par votre numéro dédié :
```env
TWILIO_WHATSAPP_FROM=whatsapp:+22670123456
```

---

## 💻 Configuration

Le service `WhatsAppService` a déjà été créé dans `app/Services/WhatsAppService.php`.

### Enregistrer le service (optionnel)

Dans `app/Providers/AppServiceProvider.php` :

```php
use App\Services\WhatsAppService;

public function register()
{
    $this->app->singleton(WhatsAppService::class, function ($app) {
        return new WhatsAppService();
    });
}
```

---

## 🎯 Utilisation

### Exemple 1 : Notification de congé

Dans votre contrôleur de congés :

```php
use App\Services\WhatsAppService;

class CongeController extends Controller
{
    protected $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function approve($id)
    {
        $conge = Conge::findOrFail($id);
        $conge->statut = 'approuve';
        $conge->save();

        // Envoyer notification WhatsApp
        if ($conge->personnel->telephone) {
            $phoneNumber = $conge->personnel->telephone_code_pays
                         . $conge->personnel->telephone;

            $this->whatsapp->notifyCongeValidation($conge, $phoneNumber);
        }

        return response()->json([
            'success' => true,
            'message' => 'Congé approuvé et notification envoyée'
        ]);
    }
}
```

### Exemple 2 : Création de compte utilisateur

```php
use App\Services\WhatsAppService;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($temporaryPassword = Str::random(12)),
            // ...
        ]);

        // Envoyer notification WhatsApp
        $whatsapp = app(WhatsAppService::class);
        $phoneNumber = $user->personnel->telephone_code_pays
                     . $user->personnel->telephone;

        $whatsapp->notifyAccountCreation($user, $phoneNumber, $temporaryPassword);

        return response()->json(['success' => true]);
    }
}
```

### Exemple 3 : Message personnalisé

```php
use App\Services\WhatsAppService;

$whatsapp = app(WhatsAppService::class);

$whatsapp->notifyCustom(
    '+22670123456',
    '�� Joyeux Anniversaire',
    "Toute l'équipe vous souhaite un excellent anniversaire !"
);
```

### Exemple 4 : Notifications en masse

```php
use App\Services\WhatsAppService;

$whatsapp = app(WhatsAppService::class);

$recipients = [
    [
        'phone' => '+22670123456',
        'message' => 'Message pour l\'employé 1'
    ],
    [
        'phone' => '+22670234567',
        'message' => 'Message pour l\'employé 2'
    ],
];

$results = $whatsapp->sendBulkNotifications($recipients);

// Résultats :
// [
//     'sent' => 2,
//     'failed' => 0,
//     'details' => [...]
// ]
```

---

## 📅 Tâches programmées (Cron Jobs)

### Rappel de fin de contrat (30 jours avant)

Dans `app/Console/Kernel.php` :

```php
protected function schedule(Schedule $schedule)
{
    // Vérifier les fins de contrat tous les jours à 9h
    $schedule->call(function () {
        $whatsapp = app(WhatsAppService::class);

        $personnels = Personnel::where('type_contrat', 'CDD')
            ->whereNotNull('date_fin_contrat')
            ->whereDate('date_fin_contrat', now()->addDays(30))
            ->get();

        foreach ($personnels as $personnel) {
            if ($personnel->telephone) {
                $phoneNumber = $personnel->telephone_code_pays
                             . $personnel->telephone;

                $whatsapp->notifyContractExpiration($personnel, $phoneNumber, 30);
            }
        }
    })->daily()->at('09:00');
}
```

---

## 🔒 Sécurité et bonnes pratiques

### 1. Ne jamais exposer vos credentials

```php
// ❌ MAUVAIS
$sid = 'AC1234567890abcdef';

// ✅ BON
$sid = config('services.whatsapp.sid');
```

### 2. Valider les numéros de téléphone

```php
$whatsapp = app(WhatsAppService::class);

if ($whatsapp->isValidPhoneNumber($phoneNumber)) {
    $whatsapp->sendNotification($phoneNumber, $message);
} else {
    Log::warning('Numéro de téléphone invalide', ['phone' => $phoneNumber]);
}
```

### 3. Gérer les erreurs

```php
try {
    $whatsapp->sendNotification($phoneNumber, $message);
} catch (\Exception $e) {
    Log::error('Erreur WhatsApp', [
        'phone' => $phoneNumber,
        'error' => $e->getMessage()
    ]);

    // Ne pas bloquer l'application si WhatsApp échoue
    // Continuer le traitement normal
}
```

### 4. Utiliser les queues pour les envois en masse

Dans `CongeStatusNotification.php`, on implémente `ShouldQueue` :

```php
class CongeStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;
    // ...
}
```

Configurer les queues dans `.env` :
```env
QUEUE_CONNECTION=database
```

Puis lancer le worker :
```bash
php artisan queue:work
```

---

## 📊 Templates WhatsApp (Production)

Pour la production, vous devez créer des templates approuvés par WhatsApp.

### Créer un template dans Twilio

1. Allez dans **Messaging** > **Content Editor**
2. Créez un nouveau template
3. Exemple :

**Nom** : `conge_validation`

**Message** :
```
Bonjour {{1}},

Votre demande de congé du {{2}} au {{3}} a été {{4}}.

{{5}}

Cordialement,
Service RH
```

**Variables** :
1. `{{1}}` : Prénom
2. `{{2}}` : Date début
3. `{{3}}` : Date fin
4. `{{4}}` : Statut (approuvée/refusée)
5. `{{5}}` : Motif (si refusé)

### Utiliser le template en code

```php
$this->twilio->messages->create(
    "whatsapp:{$to}",
    [
        'from' => $this->from,
        'contentSid' => 'HX1234567890abcdef', // Template SID
        'contentVariables' => json_encode([
            '1' => $personnel->prenoms,
            '2' => $dateDebut,
            '3' => $dateFin,
            '4' => $status,
            '5' => $motif
        ])
    ]
);
```

---

## 💡 Alternatives gratuites/low-cost

### Option A : WhatsApp Business App (Manuel)

**Gratuit** mais manuel :
- Télécharger WhatsApp Business sur un téléphone dédié
- Utiliser les listes de diffusion
- Utiliser les réponses rapides

**Limites** :
- Pas d'automatisation
- Limité à 256 contacts par diffusion
- Nécessite une intervention manuelle

### Option B : API WhatsApp via services tiers

Services locaux africains :
- **AfricaTalking** (Kenya) : API WhatsApp + SMS
- **Mnotify** (Ghana) : Service local africain
- **TermiiGo** (Nigeria) : Couverture Afrique de l'Ouest

**Avantage** : Support paiement Mobile Money (Orange Money, etc.)

### Option C : Solution DIY avec WhatsApp Web

⚠️ **Non recommandé** : Violation des conditions d'utilisation WhatsApp

---

## 📈 Estimation des coûts

### Exemple pour une entreprise de 50 employés

**Scénario** :
- 10 notifications de congés/mois : 10 × $0.016 = **$0.16**
- 5 rappels d'événements/mois : 5 × $0.016 = **$0.08**
- 3 créations de comptes/mois : 3 × $0.016 = **$0.05**
- 2 rappels de fin de contrat/mois : 2 × $0.016 = **$0.03**

**Total mensuel** : **$0.32 (~200 FCFA)**

**Avec 1000 messages gratuits Meta** : **GRATUIT** 🎉

---

## 🐛 Troubleshooting

### Erreur : "Unable to create record"

**Cause** : Numéro non inscrit au sandbox

**Solution** :
1. Vérifiez que le numéro a bien envoyé le code d'activation
2. Testez avec votre propre numéro d'abord

### Erreur : "Forbidden"

**Cause** : Auth token incorrect

**Solution** :
```bash
php artisan config:clear
php artisan cache:clear
```

### Messages non reçus

**Causes possibles** :
1. Numéro mal formaté → Vérifier avec `isValidPhoneNumber()`
2. WhatsApp désactivé dans `.env` → `TWILIO_WHATSAPP_ENABLED=true`
3. Crédit Twilio épuisé → Vérifier le dashboard

---

## 📚 Ressources

- [Documentation Twilio WhatsApp](https://www.twilio.com/docs/whatsapp)
- [WhatsApp Business API Meta](https://developers.facebook.com/docs/whatsapp)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Twilio PHP SDK](https://github.com/twilio/twilio-php)

---

## ✅ Checklist de mise en production

- [ ] Créer un compte Twilio
- [ ] Installer le package : `composer require twilio/sdk`
- [ ] Configurer `.env` avec les credentials
- [ ] Tester avec le sandbox
- [ ] Demander un numéro WhatsApp Business dédié
- [ ] Créer et faire approuver les templates
- [ ] Configurer les queues Laravel
- [ ] Tester en environnement de staging
- [ ] Monitorer les logs
- [ ] Documenter pour l'équipe
- [ ] Former les administrateurs

---

## 🎓 Formation pour l'équipe

### Pour les développeurs
1. Lire ce guide
2. Tester avec le sandbox
3. Comprendre le `WhatsAppService`
4. Ajouter des méthodes personnalisées

### Pour les administrateurs
1. Activer/désactiver dans `.env`
2. Consulter les logs : `storage/logs/laravel.log`
3. Vérifier le crédit Twilio
4. Gérer les templates

---

**🎉 Vous êtes prêt à envoyer des notifications WhatsApp !**

Pour toute question, consultez les logs ou contactez le support Twilio.
