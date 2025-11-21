# 🚀 Quick Start : WhatsApp en 15 minutes

## ⚡ Installation ultra-rapide avec Twilio

### Étape 1 : Créer compte Twilio (5 min)

1. Allez sur [https://www.twilio.com/try-twilio](https://www.twilio.com/try-twilio)
2. Créez un compte avec votre email
3. Vérifiez votre numéro de téléphone
4. Récupérez vos credentials dans le [Dashboard](https://console.twilio.com) :
   - **Account SID** : `ACxxxxxxxxx`
   - **Auth Token** : `xxxxxxxxx`

**✅ Vous avez $15 de crédit gratuit (≈940 messages) !**

---

### Étape 2 : Activer WhatsApp Sandbox (2 min)

1. Dans Twilio Console : **Messaging** → **Try it out** → **Send a WhatsApp message**
2. Scannez le QR code **OU** :
   - Ouvrez WhatsApp
   - Envoyez un message à **+1 415 523 8886**
   - Tapez le code affiché (ex: `join abc-def`)
3. Vous recevrez : *"You are all set! Your Sandbox is ready."*

**✅ Votre sandbox est actif !**

---

### Étape 3 : Installer le package (1 min)

Dans votre terminal Laravel :

```bash
composer require twilio/sdk
```

---

### Étape 4 : Configuration (2 min)

Ajoutez dans `.env` :

```env
TWILIO_WHATSAPP_ENABLED=true
TWILIO_SID=ACxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=xxxxxxxxxxxxxxxxx
TWILIO_WHATSAPP_FROM=whatsapp:+14155238886
```

Puis :

```bash
php artisan config:clear
```

---

### Étape 5 : Tester (1 min)

Dans votre terminal :

```bash
php artisan whatsapp:test +22670123456
```

**Remplacez +22670123456 par votre numéro qui a activé le sandbox.**

**✅ Vous devriez recevoir un message WhatsApp !**

---

## 🎯 Utilisation dans votre code

### Envoyer une notification simple

```php
use App\Services\WhatsAppService;

$whatsapp = app(WhatsAppService::class);

$whatsapp->sendNotification(
    '+22670123456',
    "Bonjour ! Ceci est un message de test."
);
```

### Notifier un congé approuvé

```php
use App\Services\WhatsAppService;

$conge = Conge::find($id);
$conge->statut = 'approuve';
$conge->save();

$whatsapp = app(WhatsAppService::class);
$phoneNumber = $conge->personnel->telephone_code_pays
             . $conge->personnel->telephone;

$whatsapp->notifyCongeValidation($conge, $phoneNumber);
```

### Notifier création de compte

```php
use App\Services\WhatsAppService;

$user = User::create([/* ... */]);
$temporaryPassword = Str::random(12);

$whatsapp = app(WhatsAppService::class);
$phoneNumber = $user->personnel->telephone_code_pays
             . $user->personnel->telephone;

$whatsapp->notifyAccountCreation($user, $phoneNumber, $temporaryPassword);
```

---

## 🐛 Problèmes courants

### ❌ "Unable to create record"

**Cause** : Votre numéro n'a pas activé le sandbox

**Solution** :
1. Ouvrez WhatsApp
2. Envoyez `join xxx-xxx` au +1 415 523 8886
3. Attendez la confirmation
4. Réessayez

---

### ❌ "Forbidden" ou "Authentication failed"

**Cause** : Credentials incorrects

**Solution** :
```bash
php artisan config:clear
php artisan cache:clear
```

Vérifiez `.env` :
- `TWILIO_SID` commence par `AC`
- `TWILIO_AUTH_TOKEN` a 32 caractères
- Pas d'espaces avant/après

---

### ❌ Message non reçu

**Causes** :
1. Numéro mal formaté → Doit commencer par `+` (ex: `+22670123456`)
2. WhatsApp désactivé → `.env` : `TWILIO_WHATSAPP_ENABLED=true`
3. Sandbox expiré → Renvoyez le code d'activation

---

## 📋 Checklist complète

- [ ] Compte Twilio créé
- [ ] Sandbox WhatsApp activé (message de confirmation reçu)
- [ ] Package installé : `composer require twilio/sdk`
- [ ] `.env` configuré avec SID et Token
- [ ] Config cleared : `php artisan config:clear`
- [ ] Test réussi : `php artisan whatsapp:test +226XXXXXXXX`
- [ ] Message de test reçu sur WhatsApp ✅

---

## 💡 Étapes suivantes

### Semaine 1 : Phase de test
- Testez avec 5-10 employés volontaires
- Collectez les retours
- Ajustez les messages

### Semaine 2 : Personnalisation
- Créez vos propres messages
- Ajoutez d'autres types de notifications
- Configurez les tâches cron

### Semaine 3 : Production
- Demandez un numéro WhatsApp dédié (si > 100 msg/mois)
- Créez des templates approuvés
- Passez de `TWILIO_WHATSAPP_FROM=whatsapp:+14155238886` à votre numéro

---

## 💰 Coûts

| Phase | Durée | Messages | Coût |
|-------|-------|----------|------|
| **Test (Sandbox)** | 1 mois | ~100 | **GRATUIT** ($15 crédit) |
| **Pilote** | 1-2 mois | ~500 | $8/mois (~5,000 FCFA) |
| **Production** | Illimité | ~2000/mois | $32/mois (~20,000 FCFA) |

**Alternative gratuite** : Meta WhatsApp API (1000 msg/mois gratuits)

---

## 📚 Documentation complète

- [Guide complet](WHATSAPP_INTEGRATION_GUIDE.md) - Tout savoir sur l'intégration
- [Comparatif prix](WHATSAPP_PRICING_COMPARISON.md) - Comparaison détaillée
- [Docs Twilio](https://www.twilio.com/docs/whatsapp) - Documentation officielle

---

## 🆘 Support

### Problème technique
1. Consultez les logs : `storage/logs/laravel.log`
2. Vérifiez le dashboard Twilio
3. Contactez : help@twilio.com

### Question d'intégration
Consultez le fichier [WHATSAPP_INTEGRATION_GUIDE.md](WHATSAPP_INTEGRATION_GUIDE.md)

---

**🎉 Félicitations ! Vous pouvez maintenant envoyer des notifications WhatsApp !**

*Temps total : 15 minutes | Difficulté : ⭐⭐ Facile*
